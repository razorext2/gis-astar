<div x-data="pingChecker()" x-init="startPolling()">
	<div class="space-y-1">
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

				// Jalankan polling berulang setiap 30 detik
				setInterval(polling, 30000);
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
