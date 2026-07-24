{{-- Goal: Website Attributes & Settings Management Page, Livewire: Yes, Alpine: Yes --}}
<div class="space-y-4">
    {{-- Header Banner --}}
    <div>
        <h2 class="text-xl font-bold text-zinc-900 dark:text-white">Pengaturan Atribut Website</h2>
        <p class="text-xs text-zinc-500 dark:text-zinc-400">Kelola identitas sistem, logo, favicon, meta tag SEO, dan informasi kontak</p>
    </div>

    {{-- Tabs Navigation --}}
    <div class="flex border-b border-zinc-200 dark:border-zinc-800">
        <button type="button" wire:click="setTab('branding')"
            class="px-4 py-2.5 text-sm font-semibold transition-colors border-b-2 flex items-center gap-2 {{ $activeTab === 'branding' ? 'border-red-600 text-red-600 dark:text-red-400' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
            <x-icons.user-setting class="h-4 w-4 shrink-0" />
            Branding & Judul
        </button>
        <button type="button" wire:click="setTab('media')"
            class="px-4 py-2.5 text-sm font-semibold transition-colors border-b-2 flex items-center gap-2 {{ $activeTab === 'media' ? 'border-red-600 text-red-600 dark:text-red-400' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
            <x-icons.camera class="h-4 w-4 shrink-0" />
            Logo & Favicon
        </button>
        <button type="button" wire:click="setTab('seo')"
            class="px-4 py-2.5 text-sm font-semibold transition-colors border-b-2 flex items-center gap-2 {{ $activeTab === 'seo' ? 'border-red-600 text-red-600 dark:text-red-400' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
            <x-icons.globe class="h-4 w-4 shrink-0" />
            SEO & Meta Tag
        </button>
        <button type="button" wire:click="setTab('footer')"
            class="px-4 py-2.5 text-sm font-semibold transition-colors border-b-2 flex items-center gap-2 {{ $activeTab === 'footer' ? 'border-red-600 text-red-600 dark:text-red-400' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
            <x-icons.window class="h-4 w-4 shrink-0" />
            Footer & Hak Cipta
        </button>
        <button type="button" wire:click="setTab('contact')"
            class="px-4 py-2.5 text-sm font-semibold transition-colors border-b-2 flex items-center gap-2 {{ $activeTab === 'contact' ? 'border-red-600 text-red-600 dark:text-red-400' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
            <x-icons.phone class="h-4 w-4 shrink-0" />
            Kontak & Sosial Media
        </button>
    </div>

    {{-- Content Card --}}
    <form wire:submit.prevent="save">
        <div x-bind:class="dynamicBg
            ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm'
            : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'"
            class="rounded-2xl border p-6">

            {{-- TAB 1: BRANDING --}}
            @if ($activeTab === 'branding')
                <div class="space-y-4">
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white">Identitas & Judul Website</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-input.basic wire:model="site_name" label="Nama Utama Website (App Name)" placeholder="e.g. Indodacin" />
                        <x-input.basic wire:model="site_title" label="Judul Tab Browser (Default Meta Title)" placeholder="e.g. Dashboard System" />
                        <x-input.basic wire:model="sidebar_title" label="Judul pada Sidebar Navigation" placeholder="e.g. Attendance" />
                        <x-input.basic wire:model="auth_subtitle" label="Tagline Animasi pada Halaman Login" placeholder="e.g. Presisi Utama" />
                        <x-input.basic wire:model="app_version" label="Versi Aplikasi / Sistem" placeholder="e.g. v2.4.0" />
                    </div>

                    <div>
                        <x-input.textarea wire:model="auth_description" label="Deskripsi pada Halaman Login / Auth" rows="3" placeholder="Sistem informasi terpadu..." />
                    </div>
                </div>
            @endif

            {{-- TAB 2: MEDIA --}}
            @if ($activeTab === 'media')
                <div class="space-y-6">
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white">Logo & Favicon Website</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Logo Website --}}
                        <div class="flex flex-col gap-3 rounded-xl border border-zinc-200/80 p-4 dark:border-zinc-800">
                            <label class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Logo Utama / Sidebar</label>
                            <div class="flex items-center justify-center h-28 rounded-lg bg-zinc-100 dark:bg-zinc-900/60 border border-dashed border-zinc-300 dark:border-zinc-700 overflow-hidden">
                                @if ($new_logo)
                                    <img src="{{ $new_logo->temporaryUrl() }}" class="max-h-20 object-contain" />
                                @elseif ($logo_path)
                                    <img src="{{ asset('storage/' . $logo_path) }}" class="max-h-20 object-contain" />
                                @else
                                    <img src="{{ asset('images/brand/logo.png') }}" class="max-h-20 object-contain opacity-70" />
                                @endif
                            </div>
                            <input type="file" wire:model="new_logo" accept="image/*" class="text-xs text-zinc-500 file:mr-2 file:rounded-lg file:border-0 file:bg-red-600 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-red-700" />
                            <span class="text-[11px] text-zinc-400">Format: PNG, SVG, WEBP (Max 2MB)</span>
                            <x-input.error :messages="$errors->get('new_logo')" />
                        </div>

                        {{-- Favicon --}}
                        <div class="flex flex-col gap-3 rounded-xl border border-zinc-200/80 p-4 dark:border-zinc-800">
                            <label class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Favicon Tab Browser</label>
                            <div class="flex items-center justify-center h-28 rounded-lg bg-zinc-100 dark:bg-zinc-900/60 border border-dashed border-zinc-300 dark:border-zinc-700 overflow-hidden">
                                @if ($new_favicon)
                                    <img src="{{ $new_favicon->temporaryUrl() }}" class="h-10 w-10 object-contain" />
                                @elseif ($favicon_path)
                                    <img src="{{ asset('storage/' . $favicon_path) }}" class="h-10 w-10 object-contain" />
                                @else
                                    <img src="{{ asset('images/brand/logo.ico') }}" class="h-10 w-10 object-contain opacity-70" />
                                @endif
                            </div>
                            <input type="file" wire:model="new_favicon" accept=".ico,image/*" class="text-xs text-zinc-500 file:mr-2 file:rounded-lg file:border-0 file:bg-red-600 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-red-700" />
                            <span class="text-[11px] text-zinc-400">Format: ICO, PNG (Max 1MB)</span>
                            <x-input.error :messages="$errors->get('new_favicon')" />
                        </div>

                        {{-- Apple Touch Icon --}}
                        <div class="flex flex-col gap-3 rounded-xl border border-zinc-200/80 p-4 dark:border-zinc-800">
                            <label class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Apple Touch Icon</label>
                            <div class="flex items-center justify-center h-28 rounded-lg bg-zinc-100 dark:bg-zinc-900/60 border border-dashed border-zinc-300 dark:border-zinc-700 overflow-hidden">
                                @if ($new_apple_touch_icon)
                                    <img src="{{ $new_apple_touch_icon->temporaryUrl() }}" class="h-14 w-14 object-contain" />
                                @elseif ($apple_touch_icon_path)
                                    <img src="{{ asset('storage/' . $apple_touch_icon_path) }}" class="h-14 w-14 object-contain" />
                                @else
                                    <img src="{{ asset('images/brand/apple-touch-icon.png') }}" class="h-14 w-14 object-contain opacity-70" />
                                @endif
                            </div>
                            <input type="file" wire:model="new_apple_touch_icon" accept="image/*" class="text-xs text-zinc-500 file:mr-2 file:rounded-lg file:border-0 file:bg-red-600 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-red-700" />
                            <span class="text-[11px] text-zinc-400">Format: PNG (Max 1MB)</span>
                            <x-input.error :messages="$errors->get('new_apple_touch_icon')" />
                        </div>
                    </div>
                </div>
            @endif

            {{-- TAB 3: SEO --}}
            @if ($activeTab === 'seo')
                <div class="space-y-4">
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white">SEO & Meta Tags</h3>

                    <div>
                        <x-input.textarea wire:model="meta_description" label="Meta Description" rows="3" placeholder="Deskripsi ringkas website untuk pencarian..." />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-input.basic wire:model="meta_keywords" label="Meta Keywords (Pisahkan dengan koma)" placeholder="dashboard, system, indodacin" />
                        <x-input.basic wire:model="meta_author" label="Meta Author / Pemilik Hak Cipta" placeholder="PT. Indodacin Presisi Utama" />
                        <x-input.basic wire:model="google_analytics_id" label="Google Analytics Tracking ID (Opsional)" placeholder="e.g. G-XXXXXXXXXX" />
                    </div>
                </div>
            @endif

            {{-- TAB 4: FOOTER --}}
            @if ($activeTab === 'footer')
                <div class="space-y-4">
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white">Informasi Footer & Hak Cipta</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-input.basic wire:model="footer_company" label="Nama Perusahaan di Footer" placeholder="PT. Indodacin Presisi Utama™" />
                        <x-input.basic wire:model="footer_url" label="Tautan URL Perusahaan" placeholder="https://indodacin.com" />
                        <x-input.basic wire:model="footer_copyright" label="Teks Hak Cipta (Copyright)" placeholder="All Rights Reserved." />
                    </div>
                </div>
            @endif

            {{-- TAB 5: KONTAK & SOSMED --}}
            @if ($activeTab === 'contact')
                <div class="space-y-4">
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white">Kontak Support & Sosial Media</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-input.basic wire:model="contact_email" label="Email Support / CS" placeholder="support@indodacin.com" />
                        <x-input.basic wire:model="whatsapp_number" label="Nomor WhatsApp CS (Format Internasional tanpa +)" placeholder="628123456789" />
                        <x-input.basic wire:model="social_facebook" label="Link Facebook" placeholder="https://facebook.com/..." />
                        <x-input.basic wire:model="social_instagram" label="Link Instagram" placeholder="https://instagram.com/..." />
                        <x-input.basic wire:model="social_linkedin" label="Link LinkedIn" placeholder="https://linkedin.com/in/..." />
                    </div>

                    <div>
                        <x-input.textarea wire:model="office_address" label="Alamat Kantor" rows="2" placeholder="Jl. Raya Industri No. 88, Jakarta" />
                    </div>
                </div>
            @endif

            {{-- Save Button Footer --}}
            <div class="mt-6 flex justify-end pt-4 border-t border-zinc-200/80 dark:border-zinc-800">
                <x-button.primary type="submit" wire:loading.attr="disabled" wire:target="save, new_logo, new_favicon, new_apple_touch_icon">
                    <x-slot name="icon">
                        <x-icons.check-circle class="h-4 w-4" />
                    </x-slot>
                    <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </x-button.primary>
            </div>
        </div>
    </form>
</div>
