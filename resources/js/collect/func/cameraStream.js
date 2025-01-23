export let capturedImages = [];

export function backCameraStream() {
  const $captureButton = $("#capture-button");
  const $closeModalButton = $("#close-button");
  const $captureImageButton = $("#capture-image");
  const $cameraModal = $("#camera-modal");
  const $videoElement = $("#video");
  const $capturedImagesContainer = $("#captured-images");

  const modal = new Modal($cameraModal[0], { closable: true, backdrop: 'static' });
  let stream;

  async function startCamera() {
    try {
      stream = await navigator.mediaDevices.getUserMedia({
        video: { facingMode: "environment" }
      });
      $videoElement[0].srcObject = stream;
      modal.show();
    } catch (err) {
      console.error("Gagal mengakses kamera:", err);
    }
  }

  $captureButton.on("click", startCamera);

  $captureImageButton.on("click", () => {
    const $canvas = $("<canvas>");
    $canvas[0].width = $videoElement[0].videoWidth;
    $canvas[0].height = $videoElement[0].videoHeight;
    $canvas[0].getContext("2d").drawImage($videoElement[0], 0, 0, $canvas[0].width, $canvas[0].height);

    const imgData = $canvas[0].toDataURL("image/png");
    capturedImages.push(imgData);

    const $imageHTML = $(`
      <div class="relative me-2 flex-none items-center gap-4">
        <img src="${imgData}" class="w-36 h-36 object-cover rounded-xl border">
        <button class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-700" title="Hapus gambar">×</button>
      </div>
    `);

    $capturedImagesContainer.append($imageHTML);
    $capturedImagesContainer.addClass('mt-2');

    $imageHTML.find("button").on("click", function () {
      $(this).parent().remove();
      capturedImages = capturedImages.filter(image => image !== imgData);

      if ($capturedImagesContainer.children().length === 0) {
        $capturedImagesContainer.removeClass('mt-2');
      }
    });

    stopStreamAndHideModal();
  });

  $closeModalButton.on("click", stopStreamAndHideModal);

  function stopStreamAndHideModal() {
    stream.getTracks().forEach(track => track.stop());
    modal.hide();
  }
}
