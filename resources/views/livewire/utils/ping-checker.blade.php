<div x-data="pingChecker()" x-init="startPolling()" class="p-4">
	<div class="mt-2 space-y-1">
		<p class="{{ $pingClass }} text-sm">
			{{ $latency == 0 ? 'Loading...' : $latency . ' ms' }}
		</p>
	</div>
</div>

<script>
	function pingChecker() {
		return {
			startPolling() {
				// Jalankan pertama kali saat halaman load
				polling();

				// Jalankan polling berulang setiap 5 detik
				setInterval(polling, 10000);
			}
		}
	}

	async function polling() {
		const start = performance.now();

		try {
			await fetch('{{ route('ping.checker') }}');
			const end = performance.now();
			const latency = Math.round(end - start);

			Livewire.dispatch('updateLatency', {
				ms: latency
			});
		} catch (error) {
			console.log(error);
			Livewire.dispatch('updateLatency', {
				ms: 9999
			});
		}
	}
</script>
