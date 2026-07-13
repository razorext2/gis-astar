{{-- Goal: Full-page chatbot UI like ChatGPT, Livewire: Chatbot, Alpine: Yes --}}

@section('title', 'AI Chatbot')

<div x-data="{ showSidebar: window.innerWidth >= 1024 }"
    :class="dynamicBg
        ? 'bg-white/60 dark:bg-dark-primary/60 backdrop-blur-md'
        : 'bg-white dark:bg-dark-primary'"
    class="relative flex h-full w-full overflow-hidden rounded-xl border border-zinc-200 shadow-md dark:border-zinc-800">

    {{-- Conversation Sidebar --}}
    <div x-show="showSidebar" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="-translate-x-full opacity-0"
        :class="dynamicBg
            ? 'bg-zinc-50/40 dark:bg-zinc-900/20 backdrop-blur-md'
            : 'bg-zinc-50 dark:bg-zinc-900'"
        class="absolute z-[80] flex h-full w-80 flex-shrink-0 flex-col border-r border-zinc-200 dark:border-zinc-800 lg:relative lg:z-auto">

        {{-- Sidebar Header --}}
        <div class="flex items-center justify-between border-b border-zinc-200 p-4 dark:border-zinc-800">
            <h2 class="flex items-center gap-2 text-lg font-bold text-zinc-900 dark:text-white">
                <x-icons.chat class="h-5 w-5 text-red-500" />
                Dacin AI
            </h2>
            <button wire:click="createConversation"
                class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 text-white shadow-sm transition-all hover:bg-blue-700 hover:shadow-md active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900"
                title="Chat Baru">
                <x-icons.plus class="h-4 w-4" />
            </button>
        </div>

        {{-- Search --}}
        <div class="p-3">
            <div class="group relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-icons.search
                        class="h-4 w-4 text-zinc-400 transition-colors group-focus-within:text-blue-500" />
                </div>
                <input type="text" wire:model.live.debounce.300ms="searchConversation"
                    class="block w-full rounded-lg border-0 bg-zinc-50/50 py-2.5 pl-10 pr-3 text-sm text-zinc-900 ring-1 ring-zinc-200 placeholder:text-zinc-400 focus:bg-white/80 focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800/30 dark:text-white dark:ring-zinc-800 dark:placeholder:text-zinc-500 dark:focus:bg-zinc-800/50"
                    placeholder="Cari percakapan...">
            </div>
        </div>

        {{-- Conversation List --}}
        <div data-lenis-prevent class="custom-scrollbar flex-1 space-y-1 overflow-y-auto px-3 pb-3">
            @forelse ($this->conversations as $conv)
                <div wire:key="conv-{{ $conv->id }}"
                    class="{{ $activeConversationId === $conv->id ? 'bg-red-50/80 ring-1 ring-red-200 dark:bg-red-500/10 dark:ring-red-900/30' : 'hover:bg-zinc-100/50 dark:hover:bg-zinc-800/30' }} group flex cursor-pointer items-center gap-3 rounded-xl p-3 transition-all duration-200"
                    wire:click="selectConversation({{ $conv->id }})">
                    <div class="flex-1 overflow-hidden">
                        <p
                            class="{{ $activeConversationId === $conv->id ? 'text-red-700 dark:text-red-400 font-semibold' : 'text-zinc-700 dark:text-zinc-300' }} truncate text-sm">
                            {{ $conv->title ?? 'Percakapan Baru' }}
                        </p>
                        <p class="mt-0.5 text-xs text-zinc-400 dark:text-zinc-500">
                            {{ $conv->updated_at->diffForHumans() }}
                        </p>
                    </div>
                    <button wire:click.stop="deleteConversation({{ $conv->id }})"
                        class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-md text-zinc-400 opacity-0 transition-all hover:bg-red-100 hover:text-red-600 group-hover:opacity-100 dark:hover:bg-red-900/30 dark:hover:text-red-400"
                        title="Hapus">
                        <x-icons.trash class="h-3.5 w-3.5" />
                    </button>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <x-icons.chat class="mb-3 h-10 w-10 text-zinc-300 dark:text-zinc-600" />
                    <p class="text-sm text-zinc-400 dark:text-zinc-500">Belum ada percakapan</p>
                    <button wire:click="createConversation"
                        class="mt-3 text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                        Mulai Chat Baru
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Sidebar Overlay (mobile/tablet) --}}
    <div x-show="showSidebar" x-transition.opacity @click="showSidebar = false"
        class="absolute inset-0 z-[70] bg-black/30 backdrop-blur-sm lg:hidden">
    </div>

    {{-- Main Chat Area --}}
    <div class="flex min-h-0 flex-1 flex-col overflow-hidden">

        {{-- Chat Header --}}
        <div
            :class="dynamicBg
                ? 'bg-white/40 dark:bg-zinc-900/20 backdrop-blur-md'
                : 'bg-white dark:bg-zinc-900'"
            class="flex items-center gap-3 border-b border-zinc-200 px-4 py-3 dark:border-zinc-800">
            <button @click="showSidebar = !showSidebar"
                class="flex h-9 w-9 items-center justify-center rounded-lg text-zinc-500 transition-colors hover:bg-zinc-100/50 hover:text-zinc-700 dark:hover:bg-zinc-800/50 dark:hover:text-zinc-300">
                <x-icons.bar class="h-5 w-5" />
            </button>

            <div class="flex-1">
                @if ($activeConversationId)
                    @php
                        $activeConv = $this->conversations->firstWhere('id', $activeConversationId);
                    @endphp
                    <h3 class="truncate text-sm font-semibold text-zinc-900 dark:text-white">
                        {{ $activeConv?->title ?? 'Percakapan Baru' }}
                    </h3>
                    <p class="text-xs text-zinc-400">Dacin AI — Asisten Kerja Indodacin</p>
                @else
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Dacin AI</h3>
                    <p class="text-xs text-zinc-400">Siap membantu Anda! 🚀</p>
                @endif
            </div>

            {{-- Persona Switcher --}}
            <div class="hidden items-center gap-1 rounded-xl border border-zinc-200 bg-zinc-50/50 p-1 dark:border-zinc-800 dark:bg-zinc-900/40 lg:flex">
                <button wire:click="setPersona('professional')"
                    title="Profesional — sopan, to-the-point"
                    class="{{ $persona === 'professional' ? 'bg-white shadow-sm text-zinc-900 dark:bg-zinc-800 dark:text-white' : 'text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300' }} rounded-lg px-2.5 py-1 text-xs font-medium transition-all duration-200">
                    💼 Profesional
                </button>
                <button wire:click="setPersona('cheerful')"
                    title="Ceria — ramah, penuh semangat"
                    class="{{ $persona === 'cheerful' ? 'bg-white shadow-sm text-zinc-900 dark:bg-zinc-800 dark:text-white' : 'text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300' }} rounded-lg px-2.5 py-1 text-xs font-medium transition-all duration-200">
                    😊 Ceria
                </button>
                <button wire:click="setPersona('strict')"
                    title="Tegas — lugas, formal"
                    class="{{ $persona === 'strict' ? 'bg-white shadow-sm text-zinc-900 dark:bg-zinc-800 dark:text-white' : 'text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300' }} rounded-lg px-2.5 py-1 text-xs font-medium transition-all duration-200">
                    🔒 Tegas
                </button>
            </div>

            {{-- Powered by badge --}}
            <div
                class="hidden items-center gap-1.5 rounded-full bg-gradient-to-r from-blue-50 to-indigo-50 px-3 py-1.5 dark:from-blue-900/20 dark:to-indigo-900/20 lg:flex">
                <svg class="h-3.5 w-3.5 text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M12 2L1 21h22L12 2zm0 4l7.53 13H4.47L12 6z M11 10v4h2v-4h-2zm0 6v2h2v-2h-2z" />
                </svg>
                <span class="text-xs font-medium text-blue-600 dark:text-blue-400">Gemini</span>
            </div>
        </div>

        {{-- Messages Area --}}
        <div id="chat-messages"
            @if ($isProcessing) wire:poll.750ms="checkProcessingStatus" @endif
            data-lenis-prevent
            class="custom-scrollbar flex-1 overflow-y-auto scroll-smooth"
            x-data
            x-init="
                const el = $el;
                const scrollToBottom = () => { el.scrollTop = el.scrollHeight; };
                scrollToBottom();
                Livewire.on('message-sent', () => setTimeout(scrollToBottom, 100));
                const observer = new MutationObserver(scrollToBottom);
                observer.observe(el, { childList: true, subtree: true });
            ">

            @if ($this->messages->isEmpty())
                {{-- Welcome Screen --}}
                <div class="flex min-h-full flex-col items-center justify-start pt-6 lg:justify-center lg:pt-0 px-3 pb-3 md:px-4 md:pb-8">
                    <div
                        class="mb-3 lg:mb-6 flex h-14 w-14 lg:h-20 lg:w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-red-500 to-red-600 shadow-lg shadow-red-500/25">
                        <x-icons.chat class="h-7 w-7 lg:h-10 lg:w-10 text-white" />
                    </div>
                    <h2 class="mb-1 lg:mb-2 text-xl lg:text-2xl font-bold text-zinc-900 dark:text-white">Halo! Saya Dacin AI 👋</h2>
                    <p class="mb-4 lg:mb-8 max-w-md text-center text-xs lg:text-sm text-zinc-500 dark:text-zinc-400">
                        Asisten kerja Indodacin yang siap membantu Anda mencari data, membuat ringkasan, dan
                        memberikan saran.
                    </p>

                    {{-- Quick Prompts --}}
                    <div class="grid w-full max-w-lg grid-cols-1 gap-2 lg:gap-3 sm:grid-cols-2">
                        @foreach ([['📊', 'Tampilkan ringkasan absensi hari ini'], ['👥', 'Siapa saja pegawai yang belum absen?'], ['💰', 'Berapa total piutang yang belum dibayar?'], ['📋', 'Daftar SPK yang sedang berjalan']] as $prompt)
                            <button wire:click="$set('newMessage', '{{ $prompt[1] }}')"
                                class="flex items-start gap-2 lg:gap-3 rounded-xl border border-zinc-200 bg-white/60 px-3 py-2.5 lg:p-4 text-left transition-all duration-200 hover:-translate-y-0.5 hover:border-zinc-300 hover:bg-zinc-50/50 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900/40 dark:hover:border-zinc-700 dark:hover:bg-zinc-850/50">
                                <span class="text-lg lg:text-xl">{{ $prompt[0] }}</span>
                                <span
                                    class="text-xs lg:text-sm text-zinc-600 dark:text-zinc-300">{{ $prompt[1] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="mx-auto max-w-3xl space-y-6 px-4 py-6">
                    @foreach ($this->messages as $msg)
                        <div wire:key="msg-{{ $msg->id }}"
                            class="{{ $msg->role === 'user' ? 'flex justify-end' : 'flex justify-start' }}">
                            <div class="{{ $msg->role === 'user' ? 'max-w-[85%]' : 'max-w-[90%]' }} flex gap-3">
                                @if ($msg->role === 'model')
                                    <div
                                        class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-red-500 to-red-600 shadow-sm">
                                        <x-icons.chat class="h-4 w-4 text-white" />
                                    </div>
                                @endif

                                @if ($msg->role === 'user')
                                    <div class="bg-blue-600 text-white rounded-2xl rounded-tr-none shadow-sm px-4 py-3">
                                @else
                                    <div class="rounded-2xl rounded-tl-none border border-zinc-200 dark:border-zinc-800 shadow-sm px-4 py-3"
                                        :class="dynamicBg
                                            ? 'bg-white/80 dark:bg-zinc-800/80 text-zinc-900 dark:text-zinc-100 backdrop-blur-sm'
                                            : 'bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100'">
                                @endif
                                    @if ($msg->role === 'model')
                                        <div class="chat-prose prose prose-sm prose-zinc max-w-none dark:prose-invert prose-headings:text-zinc-900 dark:prose-headings:text-white prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-code:rounded prose-code:bg-zinc-100 prose-code:px-1 prose-code:py-0.5 dark:prose-code:bg-zinc-700 prose-pre:rounded-xl prose-pre:border prose-pre:border-zinc-200 dark:prose-pre:border-zinc-800 prose-table:border-collapse prose-th:border prose-th:border-zinc-300 prose-th:bg-zinc-100 prose-th:px-3 prose-th:py-1.5 dark:prose-th:border-zinc-600 dark:prose-th:bg-zinc-700 prose-td:border prose-td:border-zinc-300 prose-td:px-3 prose-td:py-1.5 dark:prose-td:border-zinc-600">
                                            {!! \Illuminate\Support\Str::markdown($msg->content) !!}
                                        </div>
                                        @if ($msg->status === 'failed')
                                            <div class="mt-3 flex items-center border-t border-zinc-100 pt-2.5 dark:border-zinc-800/80">
                                                <button wire:click="retryMessage({{ $msg->id }})"
                                                    class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30 transition-colors">
                                                    <x-icons.clockwise class="h-3.5 w-3.5" />
                                                    Coba Lagi
                                                </button>
                                            </div>
                                        @endif
                                    @else
                                        <p class="whitespace-pre-wrap text-sm">{{ $msg->content }}</p>
                                    @endif
                                </div>

                                @if ($msg->role === 'user')
                                    <div
                                        class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-zinc-200 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700">
                                        <x-icons.user class="h-4 w-4 text-zinc-600 dark:text-zinc-300" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- Loading Indicator --}}
                    @if ($isProcessing)
                        <div class="flex justify-start">
                            <div class="flex max-w-[90%] gap-3">
                                <div
                                    class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-red-500 to-red-600 shadow-sm">
                                    <x-icons.chat class="h-4 w-4 text-white" />
                                </div>
                                <div
                                    :class="dynamicBg
                                        ? 'bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm'
                                        : 'bg-white dark:bg-zinc-800'"
                                    class="rounded-2xl rounded-tl-none border border-zinc-200 px-5 py-4 shadow-sm dark:border-zinc-800">
                                    <div class="flex items-center gap-1.5">
                                        <span
                                            class="inline-block h-2.5 w-2.5 animate-bounce rounded-full bg-red-400 [animation-delay:-0.3s]"></span>
                                        <span
                                            class="inline-block h-2.5 w-2.5 animate-bounce rounded-full bg-red-500 [animation-delay:-0.15s]"></span>
                                        <span
                                            class="inline-block h-2.5 w-2.5 animate-bounce rounded-full bg-red-600"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- Input Area --}}
        <div
            :class="dynamicBg
                ? 'bg-white/40 dark:bg-zinc-900/20 backdrop-blur-md'
                : 'bg-white dark:bg-zinc-900'"
            class="border-t border-zinc-200 p-4 dark:border-zinc-800">
            <form wire:submit="sendMessage" class="mx-auto max-w-3xl"
                x-data="{ message: '' }"
                x-init="
                    $watch('$wire.isProcessing', value => {
                        if (!value) {
                            $nextTick(() => { $refs.chatInput.focus(); });
                        }
                    });
                "
                @submit="$nextTick(() => { message = ''; $refs.chatInput.style.height = 'auto'; })">
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <textarea wire:model="newMessage" x-ref="chatInput" id="chat-input" rows="1"
                            class="block max-h-32 w-full resize-none rounded-xl border-0 bg-zinc-50/50 px-4 py-3 text-sm text-zinc-900 ring-1 ring-zinc-200 placeholder:text-zinc-400 transition-colors focus:bg-white focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800/30 dark:text-white dark:ring-zinc-800 dark:placeholder:text-zinc-500 dark:focus:bg-zinc-800/50 disabled:cursor-not-allowed disabled:opacity-60"
                            placeholder="Ketik pesan atau tanya apapun..."
                            @input="message = $el.value; $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                            @keydown.enter.prevent="
                                if (!event.shiftKey && !$wire.isProcessing && message.trim()) {
                                    $wire.sendMessage();
                                    $nextTick(() => { message = ''; $el.style.height = 'auto'; });
                                } else if (event.shiftKey) {
                                    const start = $el.selectionStart;
                                    const end = $el.selectionEnd;
                                    $el.value = $el.value.substring(0, start) + '\n' + $el.value.substring(end);
                                    $el.selectionStart = $el.selectionEnd = start + 1;
                                    message = $el.value;
                                    $el.style.height = 'auto';
                                    $el.style.height = $el.scrollHeight + 'px';
                                }
                            "
                            :disabled="$wire.isProcessing"></textarea>
                    </div>

                    {{-- Send Button --}}
                    <button type="submit"
                        class="flex h-[46px] w-[46px] flex-shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm transition-all hover:bg-blue-700 hover:shadow-md active:scale-95 disabled:cursor-not-allowed disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900"
                        :disabled="$wire.isProcessing || !message.trim()">
                        @if ($isProcessing)
                            <x-icons.loading-circle class="h-5 w-5 animate-spin" />
                        @else
                            <x-icons.send-right class="h-5 w-5" />
                        @endif
                    </button>
                </div>
                <p class="mt-2 text-center text-xs text-zinc-400 dark:text-zinc-500">
                    Dacin AI bisa membuat kesalahan. Periksa kembali informasi yang diberikan.
                </p>
            </form>
        </div>

    </div>
</div>
