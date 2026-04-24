@livewireScripts
@livewireChartsScripts
@vite(['resources/js/main.js'])
@if (Route::is('pegawai.sales') ||
    Route::is('collect.*') ||
    Route::is('collect-task.*') ||
    Route::is('collect-task-ppn.*') ||
    Route::is('collect-idy-ppn.*') ||
    Route::is('pegawai.allowances.*') ||
    Route::is('pegawai.deductions.*') ||
    Route::is('pegawai.payroll'))
    <script type="module" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script type="module" src="https://cdn.datatables.net/2.1.8/js/dataTables.tailwindcss.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/luxon@3.5.0/build/global/luxon.min.js"></script>
    <script type="module" src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.min.js"></script>
    <script type="module" src="https://cdn.datatables.net/datetime/1.5.4/js/dataTables.dateTime.min.js"></script>
    <script type="module" src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.min.js"></script>
    <script type="module" src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script type="module" src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
@endif
<script type="module" src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
<script>
    function scrollToggle() {
        return {
            atTop: true,
            atBottom: false,

            init() {
                this.onScroll()
                window.addEventListener('scroll', () => this.onScroll())
            },

            onScroll() {
                const bottomOffset =
                    document.documentElement.scrollHeight - window.innerHeight

                this.atTop = window.scrollY <= 10
                this.atBottom = window.scrollY >= bottomOffset - 10
            },

            handleScroll() {
                if (this.atTop) {
                    // scroll ke PALING BAWAH
                    window.scrollTo({
                        top: document.documentElement.scrollHeight,
                        behavior: 'smooth'
                    })
                } else {
                    // scroll ke PALING ATAS
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    })
                }
            }
        }
    }
</script>
@stack('script')
