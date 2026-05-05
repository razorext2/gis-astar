 <section x-data="{ open: @entangle('showRiwayatSpk') }"
     class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">

     <div class="flex flex-row items-center justify-between bg-zinc-50/50 p-4 transition-all duration-500 ease-in-out hover:cursor-pointer hover:bg-zinc-100 dark:bg-zinc-800/50 dark:hover:bg-zinc-800"
         @click="open = !open">
         <h3 class="text-lg font-bold text-zinc-900 dark:text-white">
             Riwayat SPK
         </h3>

         <div>
             <x-button.secondary class="!p-2" @click.stop="open = !open">
                 <x-icons.carred-down class="h-5 w-5 transition-transform duration-300 dark:text-white"
                     ::class="open ? 'rotate-180' : ''" />
             </x-button.secondary>
         </div>
     </div>

     <div x-show="open" x-collapse>
         <div class="flex flex-col divide-y divide-zinc-200 dark:divide-zinc-800">
             @forelse ($data as $row)
                 <div class="p-4 transition hover:bg-zinc-50 dark:hover:bg-zinc-800/30">
                     <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-8">
                         <div class="text-right text-xs text-zinc-500 dark:text-zinc-400 lg:text-left">
                             <p>
                                 Pukul {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('hh:mm:ss') }}</p>
                             <p>
                                 {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, DD MMM YYYY') }}</p>
                         </div>

                         <div>
                             <h4 class="text-base font-semibold text-zinc-900 dark:text-white"> {{ $row->title }}
                             </h4>
                             <p class="text-sm text-zinc-600 dark:text-zinc-400"> {{ $row->keterangan }} </p>
                         </div>
                     </div>

                     <p class="mt-1 text-right text-xs italic text-zinc-500 dark:text-zinc-400">Oleh:
                         {{ $row->addedBy->name }}</p>
                 </div>
             @empty
                 <p class="p-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                     Belum ada riwayat SPK.
                 </p>
             @endforelse

             <div class="p-4">
                 {{ $data->links(data: ['scrollTo' => false]) }}
             </div>
         </div>
     </div>
 </section>
 {{-- end riwayat spk --}}
