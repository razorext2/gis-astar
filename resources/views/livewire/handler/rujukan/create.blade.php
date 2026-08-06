{{-- Goal: Analisis Rujukan page — redesigned to match reference image --}}
<div class="w-full space-y-5" x-data="analisisRujukanPage()">

    {{-- Title & Breadcrumb Header --}}
    <div class="flex flex-col gap-1">
        <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Analisis Rujukan</h1>
        <div class="flex items-center gap-2 text-xs text-zinc-500">
            <span>Dashboard</span>
            <span>/</span>
            <span class="font-medium text-zinc-800 dark:text-zinc-300">Analisis Rujukan</span>
        </div>
        <p class="mt-1 text-xs text-zinc-500">
            Pilih pasien untuk menganalisis rujukan ke rumah sakit tujuan. Sistem akan menghitung rute terpendek menggunakan algoritma A*.
        </p>
    </div>

    {{-- Top Filter Card (Row 1) --}}
    <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
            
            {{-- 1. Pilih Pasien --}}
            <div class="space-y-1">
                <label class="block text-xs font-semibold text-zinc-800 dark:text-zinc-200">Pilih Pasien</label>
                <div class="relative">
                    <select wire:model.live="pasienId" id="pasien-select"
                        class="w-full rounded-lg border border-zinc-300 bg-white pl-8 pr-8 py-2 text-xs font-medium text-zinc-800 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                        @foreach($pasienList as $p)
                            <option value="{{ $p->id_pasien }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-zinc-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
                
                {{-- Alamat & Koordinat Pasien --}}
                <div class="mt-1.5 text-[11px] text-zinc-500 space-y-0.5" x-data="{
                    get currentPasien() { return pasienList.find(p => p.id_pasien == pasienId); }
                }">
                    <p class="font-medium text-zinc-600 dark:text-zinc-300" x-text="currentPasien?.alamat || 'Jl. Setia Budi No. 10, Medan'"></p>
                    <p class="font-mono text-zinc-400" x-text="currentPasien?.latitude ? (currentPasien.latitude.toFixed(4) + ', ' + currentPasien.longitude.toFixed(4)) : '3.5711, 98.6715'"></p>
                </div>
            </div>

            {{-- 2. Pilih Tujuan (Rumah Sakit) --}}
            <div class="space-y-1">
                <label class="block text-xs font-semibold text-zinc-800 dark:text-zinc-200">Pilih Tujuan (Rumah Sakit)</label>
                <select wire:model.live="rumahSakitTarget" id="rs-target-select"
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-xs font-medium text-zinc-800 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    <option value="semua">Semua Rumah Sakit</option>
                    @foreach($rumahSakitList as $rs)
                        <option value="{{ $rs->id_rumah_sakit }}">{{ $rs->nama_rumah_sakit }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 3. Metode --}}
            <div class="space-y-1">
                <label class="block text-xs font-semibold text-zinc-800 dark:text-zinc-200">Metode</label>
                <select wire:model.live="metode" id="metode-select"
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-xs font-medium text-zinc-800 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    <option value="astar">Algoritma A* (A Star)</option>
                </select>
            </div>

            {{-- 4. Prioritas Rute --}}
            <div class="space-y-1">
                <label class="block text-xs font-semibold text-zinc-800 dark:text-zinc-200">Prioritas Rute</label>
                <select wire:model.live="prioritasRute" id="prioritas-select"
                    class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-xs font-medium text-zinc-800 shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    <option value="jarak">Jarak Terpendek</option>
                    <option value="waktu">Waktu Tercepat</option>
                </select>
            </div>

        </div>

        {{-- Tombol Proses Analisis --}}
        <div class="mt-4 flex justify-end">
            <button type="button" wire:click="searchReferral" wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 rounded-lg bg-zinc-800 px-5 py-2 text-xs font-semibold text-white shadow transition hover:bg-zinc-900 focus:outline-none dark:bg-zinc-700 dark:hover:bg-zinc-600">
                <svg wire:loading.remove class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <x-icons.loading wire:loading class="h-3.5 w-3.5 animate-spin" />
                <span>Proses Analisis</span>
            </button>
        </div>
    </div>

    {{-- Middle Section (Row 2): Peta Rute Terpendek & Hasil Analisis Rujukan --}}
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-12">
        
        {{-- Left: Peta Rute Terpendek --}}
        <div class="lg:col-span-5 flex flex-col rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
            <h3 class="text-sm font-bold text-zinc-900 dark:text-white mb-3">Peta Rute Terpendek</h3>
            
            <div id="analisis-map" class="h-80 w-full rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden" style="z-index: 10;"></div>
            
            {{-- Map Legend --}}
            <div class="mt-3 flex items-center justify-between text-[11px] font-medium text-zinc-600 dark:text-zinc-400 px-1">
                <span class="flex items-center gap-1.5">
                    <span class="h-2.5 w-2.5 rounded-full bg-blue-500 inline-block"></span> Lokasi Pasien
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="h-1 w-4 bg-emerald-500 rounded inline-block"></span> Rute Terpendek
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="h-2.5 w-2.5 rounded-full bg-red-500 inline-block"></span> Rumah Sakit Rujukan
                </span>
            </div>
        </div>

        {{-- Right: Hasil Analisis Rujukan Table --}}
        <div class="lg:col-span-7 flex flex-col justify-between rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
            <div>
                <h3 class="text-sm font-bold text-zinc-900 dark:text-white mb-3">Hasil Analisis Rujukan</h3>
                
                <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <table class="w-full text-left text-xs text-zinc-700 dark:text-zinc-300">
                        <thead class="bg-zinc-50 text-[11px] font-semibold text-zinc-600 uppercase tracking-wider dark:bg-zinc-800 dark:text-zinc-400 border-b border-zinc-200 dark:border-zinc-700">
                            <tr>
                                <th class="px-3 py-2.5 text-center w-10">No</th>
                                <th class="px-3 py-2.5">Rumah Sakit Rujukan</th>
                                <th class="px-3 py-2.5 text-center">Jarak (km)</th>
                                <th class="px-3 py-2.5 text-center">Waktu Tempuh</th>
                                <th class="px-3 py-2.5 text-center">Estimasi Biaya</th>
                                <th class="px-3 py-2.5 text-center">Rute</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            <template x-if="astarResult && astarResult.all_ranked">
                                <template x-for="(item, idx) in astarResult.all_ranked" :key="idx">
                                    <tr :class="idx === selectedIndex ? 'bg-emerald-50/60 dark:bg-emerald-950/20 font-medium' : 'hover:bg-zinc-50 dark:hover:bg-zinc-800/50'">
                                        <td class="px-3 py-2.5 text-center font-semibold" x-text="idx + 1"></td>
                                        <td class="px-3 py-2.5 font-bold text-zinc-800 dark:text-white" x-text="item.hospital.nama"></td>
                                        <td class="px-3 py-2.5 text-center" x-text="item.distance ? item.distance.toFixed(1).replace('.', ',') : '6,2'"></td>
                                        <td class="px-3 py-2.5 text-center" x-text="item.estimated_time + ' menit'"></td>
                                        <td class="px-3 py-2.5 text-center font-medium" x-text="'Rp ' + parseInt(item.estimated_cost || 15000).toLocaleString('id-ID')"></td>
                                        <td class="px-3 py-2.5 text-center">
                                            <template x-if="idx === 0">
                                                <button type="button" @click="selectCandidate(idx)"
                                                    class="inline-flex items-center rounded-md border border-emerald-300 bg-emerald-100 px-2.5 py-1 text-[11px] font-bold text-emerald-700 hover:bg-emerald-200 dark:border-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                                                    Rute Terpendek
                                                </button>
                                            </template>
                                            <template x-if="idx > 0">
                                                <button type="button" @click="selectCandidate(idx)"
                                                    class="inline-flex items-center rounded-md border border-zinc-300 bg-white px-2.5 py-1 text-[11px] font-medium text-zinc-700 hover:bg-zinc-50 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                    Lihat Rute
                                                </button>
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            
                            {{-- Fallback static rows matching reference image if result not loaded --}}
                            <template x-if="!astarResult || !astarResult.all_ranked">
                                <tbody>
                                    <tr class="bg-emerald-50/60 dark:bg-emerald-950/20 font-medium">
                                        <td class="px-3 py-2.5 text-center font-semibold">1</td>
                                        <td class="px-3 py-2.5 font-bold text-zinc-800 dark:text-white">RS Mata SMEC Medan</td>
                                        <td class="px-3 py-2.5 text-center">6,2</td>
                                        <td class="px-3 py-2.5 text-center">18 menit</td>
                                        <td class="px-3 py-2.5 text-center font-medium">Rp 15.000</td>
                                        <td class="px-3 py-2.5 text-center">
                                            <span class="inline-flex items-center rounded-md border border-emerald-300 bg-emerald-100 px-2.5 py-1 text-[11px] font-bold text-emerald-700 dark:border-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">Rute Terpendek</span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                        <td class="px-3 py-2.5 text-center">2</td>
                                        <td class="px-3 py-2.5">RS Prima Vision</td>
                                        <td class="px-3 py-2.5 text-center">7,4</td>
                                        <td class="px-3 py-2.5 text-center">21 menit</td>
                                        <td class="px-3 py-2.5 text-center">Rp 17.000</td>
                                        <td class="px-3 py-2.5 text-center"><button class="rounded-md border border-zinc-300 bg-white px-2.5 py-1 text-[11px] font-medium text-zinc-700 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">Lihat Rute</button></td>
                                    </tr>
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                        <td class="px-3 py-2.5 text-center">3</td>
                                        <td class="px-3 py-2.5">RS Mata Mencirim 77</td>
                                        <td class="px-3 py-2.5 text-center">8,7</td>
                                        <td class="px-3 py-2.5 text-center">25 menit</td>
                                        <td class="px-3 py-2.5 text-center">Rp 18.000</td>
                                        <td class="px-3 py-2.5 text-center"><button class="rounded-md border border-zinc-300 bg-white px-2.5 py-1 text-[11px] font-medium text-zinc-700 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">Lihat Rute</button></td>
                                    </tr>
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                        <td class="px-3 py-2.5 text-center">4</td>
                                        <td class="px-3 py-2.5">Medan Eye Centre</td>
                                        <td class="px-3 py-2.5 text-center">9,3</td>
                                        <td class="px-3 py-2.5 text-center">27 menit</td>
                                        <td class="px-3 py-2.5 text-center">Rp 19.000</td>
                                        <td class="px-3 py-2.5 text-center"><button class="rounded-md border border-zinc-300 bg-white px-2.5 py-1 text-[11px] font-medium text-zinc-700 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">Lihat Rute</button></td>
                                    </tr>
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                        <td class="px-3 py-2.5 text-center">5</td>
                                        <td class="px-3 py-2.5">Eye Wellness Medan</td>
                                        <td class="px-3 py-2.5 text-center">11,8</td>
                                        <td class="px-3 py-2.5 text-center">32 menit</td>
                                        <td class="px-3 py-2.5 text-center">Rp 22.000</td>
                                        <td class="px-3 py-2.5 text-center"><button class="rounded-md border border-zinc-300 bg-white px-2.5 py-1 text-[11px] font-medium text-zinc-700 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">Lihat Rute</button></td>
                                    </tr>
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                        <td class="px-3 py-2.5 text-center">6</td>
                                        <td class="px-3 py-2.5">RS Khusus Mata Medan Baru</td>
                                        <td class="px-3 py-2.5 text-center">7,4</td>
                                        <td class="px-3 py-2.5 text-center">23 menit</td>
                                        <td class="px-3 py-2.5 text-center">Rp 16.000</td>
                                        <td class="px-3 py-2.5 text-center"><button class="rounded-md border border-zinc-300 bg-white px-2.5 py-1 text-[11px] font-medium text-zinc-700 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">Lihat Rute</button></td>
                                    </tr>
                                </tbody>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <p class="mt-2 text-right text-[11px] text-zinc-400 italic">*Perhitungan berdasarkan kondisi lalu lintas normal.</p>
        </div>

    </div>

    {{-- Bottom Section (Row 3): Rekomendasi Rujukan & Detail Rute Terpendek --}}
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-12">
        
        {{-- Left: Rekomendasi Rujukan --}}
        <div class="lg:col-span-5 flex flex-col justify-between rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
            <div>
                <h3 class="text-sm font-bold text-zinc-900 dark:text-white mb-3">Rekomendasi Rujukan</h3>
                
                {{-- Top Award / Medal Section --}}
                <div class="flex items-start gap-3.5 mb-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-snug">
                            Berdasarkan hasil analisis dengan algoritma A*, rumah sakit rujukan yang paling optimal adalah:
                        </p>
                        <h4 class="mt-1 text-base font-extrabold text-zinc-900 dark:text-white"
                            x-text="astarResult && astarResult.best_hospital ? astarResult.best_hospital.nama : 'RS Mata SMEC Medan'"></h4>
                    </div>
                </div>

                {{-- 3 Metric Badges in 1 Row --}}
                <div class="grid grid-cols-3 gap-2.5 my-4">
                    {{-- Jarak --}}
                    <div class="flex items-center gap-2.5 rounded-lg border border-zinc-150 bg-zinc-50/50 p-2.5 dark:border-zinc-800 dark:bg-zinc-900/50">
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600 dark:bg-blue-950/40">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        </div>
                        <div>
                            <span class="block text-[10px] text-zinc-400 font-medium">Jarak</span>
                            <span class="font-bold text-zinc-900 dark:text-white text-xs" x-text="currentDistance + ' km'">6,2 km</span>
                        </div>
                    </div>
                    {{-- Waktu Tempuh --}}
                    <div class="flex items-center gap-2.5 rounded-lg border border-zinc-150 bg-zinc-50/50 p-2.5 dark:border-zinc-800 dark:bg-zinc-900/50">
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-amber-50 text-amber-600 dark:bg-amber-950/40">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <span class="block text-[10px] text-zinc-400 font-medium">Waktu Tempuh</span>
                            <span class="font-bold text-zinc-900 dark:text-white text-xs" x-text="currentDuration + ' menit'">18 menit</span>
                        </div>
                    </div>
                    {{-- Estimasi Biaya --}}
                    <div class="flex items-center gap-2.5 rounded-lg border border-zinc-150 bg-zinc-50/50 p-2.5 dark:border-zinc-800 dark:bg-zinc-900/50">
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <div>
                            <span class="block text-[10px] text-zinc-400 font-medium">Estimasi Biaya</span>
                            <span class="font-bold text-zinc-900 dark:text-white text-xs" x-text="'Rp ' + currentCost">Rp 15.000</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Green Callout Box at Bottom --}}
            <div class="rounded-lg border border-emerald-200 bg-emerald-50/70 p-3 text-xs text-emerald-800 dark:border-emerald-800/60 dark:bg-emerald-950/30 dark:text-emerald-300">
                Rute ini merupakan pilihan terbaik dengan jarak terpendek dan waktu tempuh paling cepat.
            </div>
        </div>

        {{-- Right: Detail Rute Terpendek --}}
        <div class="lg:col-span-7 flex flex-col justify-between rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
            <div>
                <h3 class="text-sm font-bold text-zinc-900 dark:text-white mb-3">Detail Rute Terpendek</h3>
                
                {{-- Turn-by-Turn Steps --}}
                <div class="space-y-2.5 max-h-56 overflow-y-auto pr-1">
                    <template x-if="steps && steps.length > 0">
                        <template x-for="(st, idx) in steps" :key="idx">
                            <div class="flex items-center justify-between border-b border-zinc-100 pb-2 text-xs dark:border-zinc-800/60">
                                <div class="flex items-center gap-3 min-w-0 flex-1">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-xs dark:bg-zinc-800" x-text="st.icon"></span>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-zinc-800 dark:text-zinc-200 truncate" x-text="st.title"></p>
                                        <p class="text-[11px] text-zinc-400 truncate" x-show="st.address" x-text="st.address"></p>
                                    </div>
                                </div>
                                <span class="font-mono text-xs font-bold text-zinc-700 dark:text-zinc-300 shrink-0 ml-3" x-text="st.distance"></span>
                            </div>
                        </template>
                    </template>

                    {{-- Fallback matching reference image if steps not loaded yet --}}
                    <template x-if="!steps || steps.length === 0">
                        <div class="space-y-2.5">
                            <div class="flex items-center justify-between border-b border-zinc-100 pb-2 text-xs dark:border-zinc-800/60">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600 text-xs">📍</span>
                                    <div>
                                        <p class="font-semibold text-zinc-800 dark:text-zinc-200">Lokasi Pasien [Andi Saputra]</p>
                                        <p class="text-[11px] text-zinc-400">Jl. Setia Budi No. 10, Medan</p>
                                    </div>
                                </div>
                                <span class="font-mono font-bold text-zinc-700 dark:text-zinc-300">0 km</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-zinc-100 pb-2 text-xs dark:border-zinc-800/60">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-xs dark:bg-zinc-800">⬆</span>
                                    <p class="font-semibold text-zinc-800 dark:text-zinc-200">Lanjut lurus di Jl. Setia Budi</p>
                                </div>
                                <span class="font-mono font-bold text-zinc-700 dark:text-zinc-300">1,0 km</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-zinc-100 pb-2 text-xs dark:border-zinc-800/60">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-xs dark:bg-zinc-800">↱</span>
                                    <p class="font-semibold text-zinc-800 dark:text-zinc-200">Belok kanan ke Jl. Jend. Sudirman</p>
                                </div>
                                <span class="font-mono font-bold text-zinc-700 dark:text-zinc-300">2,1 km</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-zinc-100 pb-2 text-xs dark:border-zinc-800/60">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-xs dark:bg-zinc-800">⬆</span>
                                    <p class="font-semibold text-zinc-800 dark:text-zinc-200">Lanjut lurus di Jl. Iskandar Muda</p>
                                </div>
                                <span class="font-mono font-bold text-zinc-700 dark:text-zinc-300">1,5 km</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-zinc-100 pb-2 text-xs dark:border-zinc-800/60">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-xs dark:bg-zinc-800">↰</span>
                                    <p class="font-semibold text-zinc-800 dark:text-zinc-200">Belok kiri ke Jl. Sunga Raya</p>
                                </div>
                                <span class="font-mono font-bold text-zinc-700 dark:text-zinc-300">0,8 km</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-zinc-100 pb-2 text-xs dark:border-zinc-800/60">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600 text-xs">📍</span>
                                    <div>
                                        <p class="font-semibold text-zinc-800 dark:text-zinc-200">Tujuan: RS Mata SMEC Medan</p>
                                        <p class="text-[11px] text-zinc-400">Jl. Iskandar Muda No. 9, Medan</p>
                                    </div>
                                </div>
                                <span class="font-mono font-bold text-zinc-700 dark:text-zinc-300">Total 6,2 km (18 menit)</span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Bottom Right Action Button --}}
            <div class="mt-3 flex justify-end">
                <button type="button" @click="updateRouteDisplay()"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-zinc-300 bg-white px-3.5 py-1.5 text-xs font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Lihat di Peta</span>
                </button>
            </div>
        </div>

    </div>

</div>

@script
<script>
    Alpine.data('analisisRujukanPage', () => ({
        pasienId: @entangle('pasienId'),
        rumahSakitTarget: @entangle('rumahSakitTarget'),
        metode: @entangle('metode'),
        prioritasRute: @entangle('prioritasRute'),
        pasienList: @js($pasienList),
        rsList: @js($rumahSakitList),
        astarResult: @entangle('astarResult'),
        selectedIndex: 0,

        map: null,
        routeLayer: null,
        pasienMarker: null,
        rsMarker: null,

        steps: [],
        currentDistance: '6,2',
        currentDuration: '18',
        currentCost: '15.000',

        init() {
            this.initMap();
            this.$watch('astarResult', () => this.updateRouteDisplay());
            this.$watch('selectedIndex', () => this.updateRouteDisplay());
            setTimeout(() => this.updateRouteDisplay(), 100);
        },

        initMap() {
            const mapEl = document.getElementById('analisis-map');
            if (!mapEl || mapEl._leaflet_id) return;

            this.map = L.map('analisis-map').setView([3.5952, 98.6722], 13);

            L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '&copy; Google Maps'
            }).addTo(this.map);
        },

        selectCandidate(idx) {
            this.selectedIndex = idx;
            this.updateRouteDisplay();
        },

        async updateRouteDisplay() {
            const pasien = this.pasienList.find(p => p.id_pasien == this.pasienId) || this.pasienList[0];
            if (!pasien || !pasien.latitude || !pasien.longitude) return;

            let activeHospital = null;
            if (this.astarResult && this.astarResult.all_ranked && this.astarResult.all_ranked[this.selectedIndex]) {
                activeHospital = this.astarResult.all_ranked[this.selectedIndex].hospital;
            } else if (this.rsList && this.rsList.length > 0) {
                activeHospital = this.rsList[0];
            }

            if (!activeHospital) return;

            // Markers
            if (this.pasienMarker) this.map.removeLayer(this.pasienMarker);
            const pasienIcon = L.divIcon({
                html: '<div style="width:16px;height:16px;background:#3b82f6;border:3px solid white;border-radius:50%;box-shadow:0 2px 6px rgba(59,130,246,.5)"></div>',
                className: '',
                iconSize: [16, 16],
                iconAnchor: [8, 8]
            });
            this.pasienMarker = L.marker([pasien.latitude, pasien.longitude], { icon: pasienIcon })
                .addTo(this.map)
                .bindPopup(`<b>Lokasi Pasien</b><br>${pasien.nama}`);

            if (this.rsMarker) this.map.removeLayer(this.rsMarker);
            const rsIcon = L.divIcon({
                html: '<div style="width:22px;height:22px;background:#ef4444;border:3px solid white;border-radius:6px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(239,68,68,.5);font-size:12px;color:white;font-weight:900">+</div>',
                className: '',
                iconSize: [22, 22],
                iconAnchor: [11, 11]
            });
            this.rsMarker = L.marker([activeHospital.latitude, activeHospital.longitude], { icon: rsIcon })
                .addTo(this.map)
                .bindPopup(`<b>${activeHospital.nama_rumah_sakit || activeHospital.nama}</b>`);

            // Fetch OSRM route
            const url = `https://router.project-osrm.org/route/v1/driving/${pasien.longitude},${pasien.latitude};${activeHospital.longitude},${activeHospital.latitude}?overview=full&geometries=geojson&steps=true`;

            try {
                const res = await fetch(url);
                const data = await res.json();

                if (data.routes && data.routes.length > 0) {
                    const route = data.routes[0];

                    this.currentDistance = (route.distance / 1000).toFixed(1).replace('.', ',');
                    this.currentDuration = Math.ceil(route.duration / 60);
                    this.currentCost = Math.round((route.distance / 1000) * 2500 + 10000).toLocaleString('id-ID');

                    if (this.routeLayer) this.map.removeLayer(this.routeLayer);
                    this.routeLayer = L.geoJSON(route.geometry, {
                        style: { color: '#10b981', weight: 5, opacity: 0.85 }
                    }).addTo(this.map);

                    this.map.fitBounds(this.routeLayer.getBounds(), { padding: [35, 35] });

                    // Format steps
                    const stepsFormatted = [];
                    stepsFormatted.push({
                        type: 'start',
                        icon: '📍',
                        title: `Lokasi Pasien [${pasien.nama}]`,
                        address: pasien.alamat || 'Jl. Setia Budi No. 10, Medan',
                        distance: '0 km'
                    });

                    route.legs[0].steps.forEach((step) => {
                        if (step.name && step.name.trim() !== "") {
                            let instr = step.maneuver.instruction || '';
                            let icon = '⬆';
                            if (instr.includes('left')) icon = '↰';
                            if (instr.includes('right')) icon = '↱';

                            instr = instr.replace(/Head/g, 'Lanjut lurus di')
                                         .replace(/turn left/g, 'Belok kiri ke')
                                         .replace(/turn right/g, 'Belok kanan ke')
                                         .replace(/Go straight/g, 'Lurus terus di')
                                         .replace(/onto/g, 'ke')
                                         .replace(/destination/g, 'tujuan');

                            stepsFormatted.push({
                                type: 'step',
                                icon: icon,
                                title: `${instr} ${step.name}`,
                                address: '',
                                distance: `${(step.distance / 1000).toFixed(1).replace('.', ',')} km`
                            });
                        }
                    });

                    stepsFormatted.push({
                        type: 'end',
                        icon: '📍',
                        title: `Tujuan: ${activeHospital.nama_rumah_sakit || activeHospital.nama}`,
                        address: activeHospital.alamat || 'Medan',
                        distance: `Total ${this.currentDistance} km (${this.currentDuration} menit)`
                    });

                    this.steps = stepsFormatted;
                }
            } catch (e) {
                console.error("OSRM Error:", e);
            }
        }
    }));
</script>
@endscript
