@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="mb-16 flex flex-col text-gray-800 dark:text-white">
        <div
            class="flex flex-col gap-4 rounded-xl bg-white p-2 shadow-md ring-1 ring-zinc-200 transition-all duration-500 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 md:p-4 lg:p-6">

            <div class="col-span-2 mb-4 flex w-full flex-row items-center gap-4">
                <div class="max-w-xs">
                    <x-button.link wire:navigate href="{{ route('event.show', $participant->bigEventId->id) }}"
                        class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white">
                        <x-slot name="icon">
                            <x-icons.angle-right class="h-6 w-6 rotate-180 text-red-500 dark:text-white" />
                        </x-slot>
                        Kembali
                    </x-button.link>
                </div>

                <div class="w-full">
                    <h1 class="text-lg font-semibold"> Detail Partisipan Event {{ ucwords($participant->bigEventId->name) }}
                    </h1>
                </div>
            </div>

            <div class="col-span-2 grid w-full grid-cols-2">
                <div
                    class="col-span-2 rounded-t-xl border border-zinc-200 bg-gray-50 p-2.5 text-gray-800 dark:border-zinc-800 dark:bg-gray-700 dark:text-white lg:p-4">
                    <p class="text-xs italic"> Nama Partisipan </p>
                    <p class="break-words font-semibold"> {{ ucwords($participant->userId->name) }}
                        [{{ $participant->userId->kode_pegawai ?? '-' }}]</p>
                </div>
                <div
                    class="col-span-2 flex flex-col border border-zinc-200 bg-gray-50 p-2.5 text-gray-800 dark:border-zinc-800 dark:bg-gray-700 dark:text-white lg:p-4">
                    <p class="text-xs italic"> Visitor Api </p>
                    <p class="break-words font-semibold"> {{ $participant->visitor_api }}</p>
                </div>
                <div
                    class="col-span-2 rounded-b-xl border border-zinc-200 bg-gray-50 p-2.5 text-gray-800 dark:border-zinc-800 dark:bg-gray-700 dark:text-white lg:p-4">
                    <p class="text-xs italic"> Redirect URL </p>
                    <p class="break-words font-semibold"> {{ $participant->redirect_to }}</p>
                </div>

            </div>

            <div class="col-span-2 flex flex-col gap-1">
                <div class="w-full">
                    <h2 class="text-lg font-semibold">Riwayat Visitor</h2>
                    <p class="text-gray-800 dark:text-gray-400"> Berikut adalah riwayat visitor yang mengakses API
                        partisipan:
                        {{ ucwords($participant->userId->name) }} </p>
                </div>

                <div class="flex flex-col rounded-xl bg-gray-50 dark:bg-dark-secondary">
                    {{-- <div class="grid grid-cols-4 gap-1 overflow-x-auto rounded-t-xl border border-b-0 border-zinc-800 p-2 lg:p-4">
						<p class="font-semibold text-gray-800 dark:text-gray-400"> IP </p>
						<p class="font-semibold text-gray-800 dark:text-gray-400"> User Agent </p>
						<p class="font-semibold text-gray-800 dark:text-gray-400"> Second Bucket </p>
						<p class="font-semibold text-gray-800 dark:text-gray-400"> Details </p>
					</div> --}}
                    @forelse ($visitor as $row)
                        @php $info = json_decode($row->real_info ?? '[]', true) ?: []; @endphp
                        <div
                            class="{{ $loop->last ? 'rounded-b-xl' : '' }} {{ $loop->first ? 'rounded-t-xl' : '' }} flex flex-row gap-4 overflow-x-auto border border-zinc-200 p-4 dark:border-zinc-800 lg:p-6">
                            <p class="grow text-gray-800 dark:text-white"> {{ $row->ip }} </p>
                            <p class="grow-0 text-gray-800 dark:text-white"> {{ $row->ua }} </p>
                            <p class="grow text-gray-800 dark:text-white"> {{ $row->second_bucket }} </p>
                            <div class="flex grow flex-col gap-1 text-sm text-gray-600 dark:text-gray-400">
                                <p>host: <span
                                        class="italic text-gray-800 dark:text-white">{{ $info['host'][0] ?? '-' }}</span>
                                </p>
                                <p>x-forwarded-for: <span
                                        class="italic text-gray-800 dark:text-white">{{ $info['x-forwarded-for'][0] ?? '-' }}</span>
                                </p>
                                <p>user-agent: <span
                                        class="italic text-gray-800 dark:text-white">{{ $info['user-agent'][0] ?? '-' }}</span>
                                </p>
                                <p>sec-ch-ua: <span
                                        class="italic text-gray-800 dark:text-white">{{ $info['sec-ch-ua'][0] ?? '-' }}</span>
                                </p>
                                <p>sec-ch-ua-platform: <span
                                        class="italic text-gray-800 dark:text-white">{{ $info['sec-ch-ua-platform'][0] ?? '-' }}</span>
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="p-4 text-center italic text-red-500"> Belum ada yang mengunjungi link
                            {{ ucwords($participant->userId->name) }} </p>
                    @endforelse

                    @if ($visitor instanceof \Illuminate\Pagination\AbstractPaginator && $visitor->hasPages())
                        <div class="border-t border-zinc-200 bg-white p-2 dark:border-zinc-800 dark:bg-dark-primary">
                            {{ $visitor->links() }}
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
@endsection
