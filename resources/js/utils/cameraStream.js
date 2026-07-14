import { showAlert } from "./alert";

/**
 * Goal: Manage back camera stream with captured images state.
 * Pattern: Use a stable array reference (push/splice) so ES module live
 *          bindings remain consistent across all consumers.
 * Deps: alert.js
 */

/** Stable array reference – never reassign, only mutate (push/splice). */
export const capturedImages = [];

/** Reset captured state between page navigations (call on init). */
export function resetCapturedImages() {
    capturedImages.splice(0, capturedImages.length);
}

export function backCameraStream() {
    const captureButton = document.getElementById("capture-button");
    const closeModalButton = document.getElementById("close-button");
    const captureImageButton = document.getElementById("capture-image");
    const cameraModal = document.getElementById("camera-modal");
    const backdrop = document.getElementById("camera-modal-backdrop");
    const videoElement = document.getElementById("video");
    const capturedImagesContainer = document.getElementById("captured-images");

    // Guard: prevent duplicate listeners when called multiple times (e.g. Livewire re-renders).
    if (captureButton?.dataset.listenerInstalled) return;

    let stream = null;

    // ── Modal helpers ────────────────────────────────────────────────────────
    function showModal() {
        backdrop?.classList.remove("hidden");
        if (cameraModal) {
            cameraModal.classList.remove("hidden");
            cameraModal.classList.add("flex");
        }
    }

    function hideModal() {
        backdrop?.classList.add("hidden");
        if (cameraModal) {
            cameraModal.classList.add("hidden");
            cameraModal.classList.remove("flex");
        }
    }

    function stopStreamAndHideModal() {
        if (stream) {
            stream.getTracks().forEach((track) => track.stop());
            stream = null;
        }
        hideModal();
    }

    // ── Camera ───────────────────────────────────────────────────────────────
    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: "environment" },
            });
            videoElement.srcObject = stream;
            showModal();
        } catch (error) {
            let errorTitle = "Akses Ditolak";
            let errorMsg = "Gagal mengakses kamera.";

            switch (error.name) {
                case "NotAllowedError":
                case "PermissionDeniedError":
                    errorMsg = "Anda menolak izin akses kamera.";
                    break;
                case "NotFoundError":
                case "DevicesNotFoundError":
                    errorTitle = "Kamera Tidak Ditemukan";
                    errorMsg = "Perangkat Anda tidak memiliki kamera.";
                    break;
            }

            showAlert("error", errorTitle, errorMsg);
        }
    }

    // ── Capture ──────────────────────────────────────────────────────────────
    function captureImage() {
        const canvas = document.createElement("canvas");
        canvas.width = videoElement.videoWidth;
        canvas.height = videoElement.videoHeight;
        canvas.getContext("2d").drawImage(videoElement, 0, 0, canvas.width, canvas.height);

        const imgData = canvas.toDataURL("image/png");

        // Mutate in-place so ES module live bindings stay consistent.
        capturedImages.push(imgData);
        appendImageThumbnail(imgData);
        stopStreamAndHideModal();
    }

    // ── DOM: thumbnail ───────────────────────────────────────────────────────
    function appendImageThumbnail(imgData) {
        // Use createElement instead of insertAdjacentHTML to avoid parsing overhead.
        const wrapper = document.createElement("div");
        wrapper.className = "relative me-3 flex-none items-center group";

        const img = document.createElement("img");
        img.src = imgData;
        img.className = "w-32 h-32 object-cover rounded-xl shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-800";
        img.alt = "Foto yang diambil";

        const removeBtn = document.createElement("button");
        removeBtn.type = "button";
        removeBtn.title = "Hapus gambar";
        removeBtn.className =
            "absolute top-2 right-2 flex h-7 w-7 items-center justify-center rounded-full " +
            "bg-white text-zinc-400 shadow-md ring-1 ring-zinc-200 transition-colors " +
            "hover:text-red-500 hover:ring-red-500 dark:bg-zinc-900 dark:text-zinc-500 " +
            "dark:ring-zinc-800 dark:hover:text-red-400 dark:hover:ring-red-500 z-10";

        removeBtn.innerHTML =
            `<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">` +
            `<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>` +
            `</svg>`;

        removeBtn.addEventListener("click", () => {
            const index = capturedImages.indexOf(imgData);
            if (index !== -1) {
                // Mutate in-place – preserves the exported reference.
                capturedImages.splice(index, 1);
            }
            wrapper.remove();
        });

        wrapper.appendChild(img);
        wrapper.appendChild(removeBtn);
        capturedImagesContainer.appendChild(wrapper);
    }

    // ── Event listeners ──────────────────────────────────────────────────────
    if (captureButton) {
        captureButton.addEventListener("click", startCamera);
        captureButton.dataset.listenerInstalled = "true";
    }

    captureImageButton?.addEventListener("click", captureImage);
    closeModalButton?.addEventListener("click", stopStreamAndHideModal);

    // Escape key – scoped handler attached once per init.
    const handleKeydown = (e) => {
        if (e.key === "Escape" && stream && !cameraModal?.classList.contains("hidden")) {
            stopStreamAndHideModal();
        }
    };
    document.addEventListener("keydown", handleKeydown);

    // ── Resource cleanup ─────────────────────────────────────────────────────
    // Stop camera stream if user navigates away or closes the tab.
    window.addEventListener("beforeunload", stopStreamAndHideModal, { once: true });

    // Livewire SPA navigation support.
    document.addEventListener("livewire:navigating", () => {
        stopStreamAndHideModal();
        document.removeEventListener("keydown", handleKeydown);
    }, { once: true });
}
