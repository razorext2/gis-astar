@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="flex h-auto items-center justify-center">
        <div
            class="grid w-full gap-2 rounded-xl bg-white p-2 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 md:gap-4 md:p-6">

            <div id="notificationHeader">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Semua Notifikasi</h2>
                    <form id="mark-all-as-read" action="{{ route('notifications.mark-all-as-read') }}">@csrf</form>

                    <div class="max-w-xs">
                        <x-button.primary id="add-button" form="mark-all-as-read" type="submit">
                            <x-slot name="icon">
                                <x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
                            </x-slot>
                            Mark All as Read
                        </x-button.primary>
                    </div>
                </div>
            </div>

            <div class="grid gap-2 md:gap-4" id="notificationCenterContainer">
                @forelse($notifications as $notification)
                    <div
                        class="{{ $notification->read_at == null ? 'bg-gray-100 dark:bg-gray-800' : '' }} flex rounded-lg transition-all duration-300 hover:scale-[1.01] hover:bg-gray-100 dark:hover:bg-gray-700">

                        <div class="w-full px-3.5 py-3 md:p-4">
                            <div class="grid gap-1 text-sm text-gray-500 dark:text-gray-400">
                                <div class="grid grid-cols-2 text-xs font-medium text-gray-700 dark:text-gray-400">
                                    <div class="text-left">
                                        {{ $notification->data['created_at'] }}
                                    </div>
                                </div>

                                {{-- show notification message --}}
                                <div
                                    class="font-base {{ $notification->read_at == null ? 'font-semibold' : '' }} mb-1 text-gray-800 dark:text-white">
                                    {{ $notification->data['message'] }}
                                </div>

                                <div class="inline-flex">
                                    {{-- show notification additional button --}}

                                    <form id="formNotification-{{ $notification->id }}"
                                        action="{{ $notification->data['button']['url'] }}">
                                    </form>
                                    <button
                                        class="me-4 rounded-md bg-blue-200 px-2 py-0.5 font-semibold text-blue-600 hover:bg-blue-400"
                                        id="btnNotification" form="formNotification-{{ $notification->id }}" type="submit">
                                        {{ $notification->data['button']['label'] }}
                                    </button>

                                    {{-- mark as read --}}
                                    @if ($notification->read_at == null)
                                        <form id="markAsRead-{{ $notification->id }}"
                                            action="{{ route('notification.mark-as-read', $notification->id) }}"></form>
                                        <button class="font-semibold text-blue-600" id="btnMarkAsRead"
                                            form="markAsRead-{{ $notification->id }}" type="submit">
                                            Mark as Read
                                        </button>
                                    @endif
                                </div>

                            </div>

                        </div>
                    </div>
                @empty
                    <div class="w-full px-3.5 text-center text-sm text-gray-800 dark:text-white md:p-32"
                        id="notificationEmpty">
                        Tidak ada notifikasi.
                    </div>
                @endforelse
            </div>
            {{ $notifications->withPath('/dashboard/notifications')->links() }}
        </div>
    </div>
@endsection
