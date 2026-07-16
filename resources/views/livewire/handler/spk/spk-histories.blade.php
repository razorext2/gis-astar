 <section x-data="{ open: @entangle('showRiwayatSpk') }"
     class="overflow-hidden rounded-xl border border-zinc-200 shadow-md dark:border-zinc-800 dark:shadow-none"
     x-bind:class="dynamicBg ?
         'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
         'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

     <div class="flex flex-row items-center justify-between p-4 transition-all duration-500 ease-in-out hover:cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800/30 lg:p-6"
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
         <div
             class="flex flex-col divide-y divide-zinc-200 border-t border-zinc-200 dark:divide-zinc-800 dark:border-zinc-800">
             @forelse ($data as $row)
                 <div class="p-4 transition hover:bg-zinc-100 dark:hover:bg-zinc-800/30 lg:p-6">
                     <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-4">
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
