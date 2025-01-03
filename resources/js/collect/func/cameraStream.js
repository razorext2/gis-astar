export let capturedImages = [];

export function backCameraStream() {
  const captureButton = document.getElementById("capture-button");
  const closeModalButton = document.getElementById("close-button");
  const captureImageButton = document.getElementById("capture-image");
  const cameraModal = document.getElementById('camera-modal');
  const videoElement = document.getElementById("video");
  const capturedImagesContainer = document.getElementById("captured-images");

  const modal = new Modal(cameraModal, { closable: true, backdrop: 'static' });
  let stream;

  async function startCamera() {
    try {
      stream = await navigator.mediaDevices.getUserMedia({
        video: { facingMode: "environment" }
      });
      videoElement.srcObject = stream;
      modal.show();
    } catch (err) {
      console.error("Gagal mengakses kamera:", err);
    }
  }

  if (captureButton) {
    captureButton.addEventListener("click", startCamera);
  }

  captureImageButton.addEventListener("click", () => {
    const canvas = document.createElement("canvas");
    canvas.width = videoElement.videoWidth;
    canvas.height = videoElement.videoHeight;
    canvas.getContext("2d").drawImage(videoElement, 0, 0, canvas.width, canvas.height);

    const imgData = canvas.toDataURL("image/png");
    capturedImages.push(imgData);

    // HTML untuk gambar dan tombol hapus
    const imageHTML = `
        <div class="relative me-2 flex-none items-center gap-4">
            <img src="${imgData}" class="w-36 h-36 object-cover rounded-xl border">
            <button class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-700" title="Hapus gambar">×</button>
        </div>
    `;

    // Sisipkan ke dalam container
    capturedImagesContainer.insertAdjacentHTML("beforeend", imageHTML);
    capturedImagesContainer.classList.add('mt-2');

    // Tambahkan event listener ke tombol hapus
    const removeButton = capturedImagesContainer.lastElementChild.querySelector("button");
    removeButton.addEventListener("click", () => {
      removeButton.parentElement.remove();
      capturedImages = capturedImages.filter(image => image !== imgData);

      if (capturedImagesContainer.childElementCount === 0) {
        capturedImagesContainer.classList.remove('mt-2'); // Hapus kelas jika tidak ada gambar
      }
    });

    stopStreamAndHideModal();
  });

  closeModalButton.addEventListener("click", stopStreamAndHideModal);

  function stopStreamAndHideModal() {
    stream.getTracks().forEach(track => track.stop());
    modal.hide();
  }

}
