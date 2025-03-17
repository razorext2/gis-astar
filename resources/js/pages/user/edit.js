document.addEventListener("DOMContentLoaded", function () {
  const isActive = document.getElementById('is_active');
  const container = document.getElementById('deactivation_reason_container');

  if (!isActive || !container) return; // Hindari error jika elemen tidak ditemukan

  // Cek nilai awal saat halaman dimuat
  toggleContainer(isActive.value);

  // Tambahkan event listener untuk perubahan nilai
  isActive.addEventListener('change', function () {
    toggleContainer(this.value);
  });

  function toggleContainer(value) {
    if (value == 0) {
      container.classList.remove('hidden');
    } else {
      container.classList.add('hidden');
    }
  }
});