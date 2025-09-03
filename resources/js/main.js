const themeToggleDarkBtn = document.getElementById("theme-toggle-dark");
const themeToggleLightBtn = document.getElementById("theme-toggle-light");

// toggle tema
function toggleTheme(e) {
  document.documentElement.classList.toggle("dark", e), localStorage.setItem("color-theme", e ? "dark" : "light"),
    themeToggleDarkBtn.classList.toggle("text-gray-300", e), themeToggleDarkBtn.classList.toggle("text-gray-200", !
      e), themeToggleLightBtn.classList.toggle("text-gray-700", e), themeToggleLightBtn.classList.toggle(
        "text-red-400", !e)
}

// preloader
document.addEventListener("livewire:navigated", (() => {
  document.getElementById("preloader").remove();
}))

// darkmode
document.addEventListener('livewire:navigated', function () {
  const isDarkMode = "dark" === localStorage.getItem("color-theme") || !("color-theme" in localStorage) && window
    .matchMedia("(prefers-color-scheme: dark)").matches;
  toggleTheme(isDarkMode), themeToggleDarkBtn.addEventListener("click", (() => toggleTheme(!0))), themeToggleLightBtn
    .addEventListener("click", (() => toggleTheme(!1)));
})

// minta izin notifikasi
document.addEventListener('livewire:navigated', function () {
  Notification.requestPermission().then(permission => {
    if (permission === "granted") {
      console.log("User memberikan izin notifikasi.");
      subscribeUser();
    } else if (permission === "denied") {
      console.log("User menolak perizinan notifikasi.");
    } else {
      console.log("User belum memutuskan (default).");
    }
  })
})

async function subscribeUser() {
  if (!('serviceWorker' in navigator) || !('PushManager' in window)) return;

  // register SW sekali (biarkan browser handle update)
  const reg = await navigator.serviceWorker.register('/serviceworker.js');
  const vapidPublicKey = import.meta.env.VITE_VAPID_PUBLIC_KEY;

  let sub = await reg.pushManager.getSubscription();
  if (!sub) {
    const key = urlBase64ToUint8Array(vapidPublicKey);
    sub = await reg.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: key
    });
  }
  try {
    await axios.post('/push-subscribe', sub);
  } catch (err) {
    console.error('Gagal simpan subscription:', err);
  }
}

function urlBase64ToUint8Array(b64) {
  const pad = '='.repeat((4 - b64.length % 4) % 4);
  const base64 = (b64 + pad).replace(/-/g, '+').replace(/_/g, '/');
  const raw = atob(base64);
  return Uint8Array.from([...raw].map(c => c.charCodeAt(0)));
}