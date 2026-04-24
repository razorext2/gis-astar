<div class="relative flex w-full flex-col gap-6 rounded-lg md:flex-row lg:flex-col lg:gap-0" data-aos="fade-right"
    data-aos-delay="100">
    <div class="h-full w-full rounded-lg md:rounded-lg lg:w-full lg:object-fill">
        <img class="h-60 w-full rounded-lg border border-zinc-200 object-cover dark:border-zinc-800 md:h-auto lg:h-full lg:object-fill"
            id="{{ $imgID }}" src="{{ asset('assets/img/noImage.webp') }}" alt="" loading="lazy">
        <canvas
            class="absolute left-0 top-0 h-60 w-full rounded-lg border border-zinc-200 object-cover dark:border-zinc-800 md:h-full lg:h-full"
            id="{{ $canvID }}"></canvas>
    </div>
</div>
