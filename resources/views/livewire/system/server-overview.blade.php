<div>
    @if($servers->isEmpty())
        <div class="rounded-2xl border border-zinc-200 bg-white p-8 text-center dark:border-zinc-800 dark:bg-dark-primary">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Belum ada server yang dikonfigurasi.</p>
        </div>
    @else
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($servers as $server)
                <x-server.card :server="$server" />
            @endforeach
        </div>
    @endif
</div>
