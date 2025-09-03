document.addEventListener('livewire:navigated', function () {
  const themeToggleDarkBtn = document.getElementById("theme-toggle-dark");
  const themeToggleLightBtn = document.getElementById("theme-toggle-light");
  const installApp = document.getElementById("installApp");
  const preloader = document.getElementById("preloader");

  // preloader
  preloader.remove();

  // atur darkmode
  const isDarkMode = "dark" === localStorage.getItem("color-theme") || !("color-theme" in localStorage) && window
    .matchMedia("(prefers-color-scheme: dark)").matches;
  toggleTheme(isDarkMode), themeToggleDarkBtn.addEventListener("click", (() => toggleTheme(!0))), themeToggleLightBtn
    .addEventListener("click", (() => toggleTheme(!1)));

  // minta izin notifikasi, subscribeUser
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

  // Only relevant for browsers that support installation.
  if ('BeforeInstallPromptEvent' in window) {
    // Variable to stash the `BeforeInstallPromptEvent`.
    let installEvent = null;

    // Function that will be run when the app is installed.
    const onInstall = () => {
      // Disable the install button.
      installApp.disabled = true;
      // No longer needed.
      installEvent = null;
    };

    window.addEventListener('beforeinstallprompt', (event) => {
      // Do not show the install prompt quite yet.
      event.preventDefault();
      // Stash the `BeforeInstallPromptEvent` for later.
      installEvent = event;
      // Enable the install button.
      installApp.disabled = false;
    });

    installApp.addEventListener('click', async () => {
      // If there is no stashed `BeforeInstallPromptEvent`, return.
      if (!installEvent) {
        return;
      }
      // Use the stashed `BeforeInstallPromptEvent` to prompt the user.
      installEvent.prompt();
      const result = await installEvent.userChoice;
      // If the user installs the app, run `onInstall()`.
      if (result.outcome === 'accepted') {
        onInstall();
      }
    });

    // The user can decide to ignore the install button
    // and just use the browser prompt directly. In this case
    // likewise run `onInstall()`.
    window.addEventListener('appinstalled', () => {
      onInstall();
    });
  }

  // toggle tema
  function toggleTheme(e) {
    document.documentElement.classList.toggle("dark", e), localStorage.setItem("color-theme", e ? "dark" : "light"),
      themeToggleDarkBtn.classList.toggle("text-gray-300", e), themeToggleDarkBtn.classList.toggle("text-gray-200", !
        e), themeToggleLightBtn.classList.toggle("text-gray-700", e), themeToggleLightBtn.classList.toggle(
          "text-red-400", !e)
  }


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
})