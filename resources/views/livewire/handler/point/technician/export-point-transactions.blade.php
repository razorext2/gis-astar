<div>
    <div class="mt-4 flex items-center justify-end">
        <x-button.primary class="w-fit" wire:click="export">
            <x-slot name="icon">
                <x-icons.bookmark class="icon h-6 w-6" />
            </x-slot>
            Export
        </x-button.primary>
    </div>

    <div wire:show="showModal" wire:transition
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-70">
        @if ($showModal)
            <!-- Modal box -->
            <div
                class="flex max-w-lg flex-col gap-2 rounded-xl bg-white p-2 shadow-2xl dark:bg-gray-800 md:w-1/2 lg:p-4 xl:w-1/3">
                <h2 class="mb-4 text-center text-xl font-semibold text-gray-900 dark:text-white lg:text-2xl">Preview Data
                </h2>

                <div class="flex max-h-96 w-full flex-col gap-2 overflow-y-auto text-gray-800 dark:text-white">
                    @foreach ($data as $row)
                        <table class="my-2 w-full border-spacing-4 border-y border-zinc-800">
                            <tr class="p-2">
                                <td>Periode</td>
                                <td>:</td>
                                <td colspan="2" class="text-right">
                                    {{ Carbon\Carbon::parse($row->from_date)->isoFormat('MMM YYYY') }} -
                                    {{ Carbon\Carbon::parse($row->to_date)->isoFormat('MMM YYYY') }}</td>
                            </tr>
                            <tr>
                                <td>Nama Teknisi</td>
                                <td>:</td>
                                <td colspan="2" class="text-right">
                                    {{ $row->pegawai->full_name ?? 'Teknisi belum terdaftar' }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-center">Point Didapat</td>
                            </tr>
                            <tr>
                                <td class="text-left">Rute Nomor</td>
                                <td class="text-left" colspan="3">:</td>
                            </tr>
                            @foreach ($row->point as $point)
                                <tr>
                                    <td></td>
                                    <td class="text-left" colspan="2">{{ $point->from_vt }}</td>
                                    <td class="text-right">+ {{ $point->point }} Poin</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>Total Point</td>
                                <td>:</td>
                                <td colspan="2" class="text-right"> {{ $row->total_points }} Poin </td>
                            </tr>
                            <tr>
                                <td>Redeemed By</td>
                                <td>:</td>
                                <td colspan="2" class="text-right"> {{ $row->redeemedby->name ?? 'N/A' }} </td>
                            </tr>

                        </table>
                    @endforeach
                </div>

                <div class="flex w-full justify-end gap-2">
                    <x-button.success class="w-fit" wire:click="process">
                        Proses
                    </x-button.success>
                    <x-button.danger class="w-fit" wire:click="$set('showModal', false)">
                        Batal
                    </x-button.danger>
                </div>
            </div>
        @endif
    </div>
</div>
