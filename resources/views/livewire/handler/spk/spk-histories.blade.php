 {{-- riwayat spk --}}
 <section class="rounded-lg text-gray-800 ring-1 ring-gray-200 dark:text-white dark:ring-gray-700 lg:gap-4">

     <div
         class="{{ $showRiwayatSpk ? 'rounded-t-lg' : 'rounded-lg' }} flex flex-row items-center justify-between p-2.5 transition-all duration-500 ease-in-out hover:cursor-pointer hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-800">
         <h3 class="text-lg font-[900] text-red-600 dark:text-white">
             Riwayat SPK
         </h3>

         <div>
             <x-button.primary class="w-fit" wire:click="$toggle('showRiwayatSpk')">
                 <x-icons.carred-down
                     class="{{ $showRiwayatSpk ? 'rotate-180' : '' }} h-5 w-5 transition-all duration-300 ease-in-out dark:text-white" />
             </x-button.primary>
         </div>
     </div>

     @if ($showRiwayatSpk)
         <div class="flex flex-col gap-2 p-2 lg:gap-4 lg:p-4">
             @forelse ($data as $row)
                 <div class="border-b border-gray-200 p-1 text-gray-800 dark:border-gray-600 dark:text-white">
                     <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-8">
                         <div class="text-right text-xs lg:text-left">
                             <p>
                                 Pukul {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('hh:mm:ss') }}</p>
                             <p>
                                 {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, DD MMM YYYY') }}</p>
                         </div>

                         <div>
                             <h4 class="text-base font-semibold"> {{ $row->title }} </h4>
                             <p class="text-sm"> {{ $row->keterangan }} </p>
                         </div>
                     </div>

                     <p class="text-right text-xs italic">Oleh: {{ $row->addedBy->name }}</p>
                 </div>
             @empty
                 <p class="text-center text-sm">
                     Belum ada riwayat SPK.
                 </p>
             @endforelse

             {{ $data->links(data: ['scrollTo' => false]) }}
         </div>
     @endif
 </section>
 {{-- end riwayat spk --}}
