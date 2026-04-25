import { showAlert } from "./alert";

export let capturedImages = [];

export function backCameraStream() {
    const captureButton = document.getElementById("capture-button");
    const closeModalButton = document.getElementById("close-button");
    const captureImageButton = document.getElementById("capture-image");
    const cameraModal = document.getElementById("camera-modal");
    const backdrop = document.getElementById("camera-modal-backdrop");
    const videoElement = document.getElementById("video");
    const capturedImagesContainer = document.getElementById("captured-images");

    let stream;

    // Vanilla JS Modal Management
    function showModal() {
        if (backdrop) backdrop.classList.remove("hidden");
        if (cameraModal) {
            cameraModal.classList.remove("hidden");
            cameraModal.classList.add("flex");
        }
    }

    function hideModal() {
        if (backdrop) backdrop.classList.add("hidden");
        if (cameraModal) {
            cameraModal.classList.add("hidden");
            cameraModal.classList.remove("flex");
        }
    }

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
                    errorMsg = "Anda menolak izin akses kamera kamera.";
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

    if (captureButton) {
        captureButton.addEventListener("click", startCamera);
    }

    if (captureImageButton) {
        captureImageButton.addEventListener("click", () => {
            const canvas = document.createElement("canvas");
            canvas.width = videoElement.videoWidth;
            canvas.height = videoElement.videoHeight;
            canvas
                .getContext("2d")
                .drawImage(videoElement, 0, 0, canvas.width, canvas.height);

            const imgData = canvas.toDataURL("image/png");
            capturedImages.push(imgData);

            // Refactored Premium HTML Template
            const imageHTML = `
                <div class="relative me-3 flex-none items-center group transition-transform hover:scale-105">
                    <img src="${imgData}" class="w-32 h-32 object-cover rounded-xl shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-800">
                    <button type="button" class="absolute -top-2 -right-2 flex h-7 w-7 items-center justify-center rounded-full bg-white text-zinc-400 shadow-md ring-1 ring-zinc-200 transition-colors hover:text-red-500 hover:ring-red-500 dark:bg-zinc-900 dark:text-zinc-500 dark:ring-zinc-800 dark:hover:text-red-400 dark:hover:ring-red-500 z-10" title="Hapus gambar">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `;

            capturedImagesContainer.insertAdjacentHTML("beforeend", imageHTML);

            // Remove logic
            const newElement = capturedImagesContainer.lastElementChild;
            const removeButton = newElement.querySelector("button");

            removeButton.addEventListener("click", () => {
                newElement.remove();
                capturedImages = capturedImages.filter(
                    (image) => image !== imgData,
                );

                if (capturedImagesContainer.childElementCount === 0) {
                    capturedImagesContainer.classList.remove("mt-2");
                }
            });

            stopStreamAndHideModal();
        });
    }

    if (closeModalButton) {
        closeModalButton.addEventListener("click", stopStreamAndHideModal);
    }

    // Escape listener
    document.addEventListener("keydown", (e) => {
        if (
            e.key === "Escape" &&
            stream &&
            !cameraModal.classList.contains("hidden")
        ) {
            stopStreamAndHideModal();
        }
    });

    function stopStreamAndHideModal() {
        if (stream) {
            stream.getTracks().forEach((track) => track.stop());
            stream = null;
        }
        hideModal();
    }
}
