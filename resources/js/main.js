document.addEventListener("livewire:navigated", function () {
    const themeToggleDarkBtn = document.getElementById("theme-toggle-dark");
    const themeToggleLightBtn = document.getElementById("theme-toggle-light");
    const installApp = document.getElementById("installApp");
    const preloader = document.getElementById("preloader");

    // preloader
    preloader.remove();

    // atur darkmode
    const isDarkMode =
        "dark" === localStorage.getItem("color-theme") ||
        (!("color-theme" in localStorage) &&
            window.matchMedia("(prefers-color-scheme: dark)").matches);
    (toggleTheme(isDarkMode),
        themeToggleDarkBtn.addEventListener("click", () => toggleTheme(!0)),
        themeToggleLightBtn.addEventListener("click", () => toggleTheme(!1)));

    // minta izin notifikasi, subscribeUser
    Notification.requestPermission().then((permission) => {
        if (permission === "granted") {
            console.log("User memberikan izin notifikasi.");
            subscribeUser();
        } else if (permission === "denied") {
            console.log("User menolak perizinan notifikasi.");
        } else {
            console.log("User belum memutuskan (default).");
        }
    });

    // ==== INSTALL HANDLER + FALLBACK UI KECIL ====

    // Helper: toast kecil di pojok bawah
    function showInstallHint(text, ms = 6500) {
        // buat container sekali
        let box = document.getElementById("install-toast");
        if (!box) {
            box = document.createElement("div");
            box.id = "install-toast";
            box.setAttribute("role", "status");
            Object.assign(box.style, {
                position: "fixed",
                zIndex: 9999,
                right: "16px",
                bottom: "16px",
                maxWidth: "360px",
                padding: "12px 14px",
                borderRadius: "12px",
                background: "rgba(10, 20, 36, .92)",
                color: "#cfe0ff",
                font: "600 14px/1.4 Inter, system-ui, sans-serif",
                boxShadow:
                    "0 10px 30px rgba(0,0,0,.35), inset 0 0 0 1px #23334f",
            });
            document.body.appendChild(box);
        }
        box.textContent = text;
        box.style.opacity = "1";
        clearTimeout(box._t);
        box._t = setTimeout(() => {
            box.style.opacity = "0";
        }, ms);
    }

    // Deteksi ringan
    const ua = navigator.userAgent || navigator.vendor || window.opera;
    const isStandalone =
        window.matchMedia("(display-mode: standalone)").matches ||
        window.navigator.standalone === true;
    const isIOS =
        /iPad|iPhone|iPod/i.test(ua) ||
        (navigator.platform === "MacIntel" && navigator.maxTouchPoints > 1);
    const isAndroid = /Android/i.test(ua);
    const isSafari =
        /^((?!chrome|android).)*safari/i.test(ua) && !/crios|fxios/i.test(ua);
    const isMac = /Macintosh|Mac OS X/.test(ua);
    const isFirefox = /firefox|fxios/i.test(ua);
    const isInApp =
        /(FBAN|FBAV|Instagram|Line|WhatsApp|TikTok|Twitter|WeChat|Snapchat)/i.test(
            ua,
        );

    // Jika sudah terpasang, sembunyikan tombol install
    if (isStandalone && installApp) {
        document.getElementById("installAppContainer").style.display = "none";
    }

    // Browser dengan `beforeinstallprompt` (Chromium)
    if ("BeforeInstallPromptEvent" in window) {
        let installEvent = null;

        const onInstall = () => {
            if (installApp) installApp.disabled = true;
            installEvent = null;
            showInstallHint("Aplikasi terpasang. Terima kasih!");
        };

        if (installApp) {
            installApp.addEventListener("click", async () => {
                if (!installEvent) return;
                installEvent.prompt();
                const result = await installEvent.userChoice;
                if (result.outcome === "accepted") onInstall();
            });
        }

        window.addEventListener("appinstalled", onInstall);
    }
    // Fallback: tampilkan instruksi sesuai browser
    else if (installApp) {
        // Jangan disable tombol — kita pakai untuk memunculkan hint
        installApp.disabled = false;

        // Tentukan pesan
        let msg =
            "Gunakan menu browser → “Install app” / “Add to Home screen”.";
        if (isInApp) {
            msg =
                "Buka halaman ini di browser sistem (Chrome/Safari), lalu pilih “Add to Home Screen/Install”.";
        } else if (isIOS) {
            msg =
                "iOS: buka ikon Share (⬆️) → “Tambahkan ke Layar Utama” untuk memasang aplikasi.";
        } else if (isSafari && isMac) {
            msg =
                "Safari (macOS): menu “File” → “Add to Dock” untuk memasang PWA.";
        } else if (isFirefox && isAndroid) {
            msg = "Firefox Android: menu ⋮ → “Tambahkan ke Layar Utama”.";
        } else if (isFirefox) {
            msg =
                "Firefox belum mendukung prompt install. Gunakan “Install Site”/“Create shortcut” atau coba Chrome/Edge.";
        } else if (isSafari) {
            msg =
                "Safari belum mendukung prompt install. Gunakan “Install Site”/“Create shortcut” atau coba Chrome/Edge.";
        }

        // Saat tombol di-klik, tampilkan hint
        installApp.addEventListener("click", (e) => {
            e.preventDefault();
            showInstallHint(msg);
        });

        // Tampilkan sekali saat halaman siap
        setTimeout(() => showInstallHint(msg, 8000), 400);
    }

    // toggle tema
    function toggleTheme(e) {
        (document.documentElement.classList.toggle("dark", e),
            localStorage.setItem("color-theme", e ? "dark" : "light"),
            themeToggleDarkBtn.classList.toggle("text-gray-300", e),
            themeToggleDarkBtn.classList.toggle("text-gray-200", !e),
            themeToggleLightBtn.classList.toggle("text-gray-700", e),
            themeToggleLightBtn.classList.toggle("text-red-400", !e));
    }

    async function subscribeUser() {
        if (!("serviceWorker" in navigator) || !("PushManager" in window))
            return;

        // register SW sekali (biarkan browser handle update)
        const reg = await navigator.serviceWorker.register("/serviceworker.js");
        const vapidPublicKey = import.meta.env.VITE_VAPID_PUBLIC_KEY;

        let sub = await reg.pushManager.getSubscription();
        if (!sub) {
            const key = urlBase64ToUint8Array(vapidPublicKey);
            sub = await reg.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: key,
            });
        }
        try {
            await axios.post("/push-subscribe", sub);
        } catch (err) {
            console.error("Gagal simpan subscription:", err);
        }
    }

    function urlBase64ToUint8Array(b64) {
        const pad = "=".repeat((4 - (b64.length % 4)) % 4);
        const base64 = (b64 + pad).replace(/-/g, "+").replace(/_/g, "/");
        const raw = atob(base64);
        return Uint8Array.from([...raw].map((c) => c.charCodeAt(0)));
    }
});
