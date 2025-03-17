
document.addEventListener('DOMContentLoaded', function () {
  const video = $('#video')[0];
  const canvas = $('#canvRegist')[0];
  const canvass = $('#canvRegistt')[0];
  const photo1Data = $('#photo1Data')[0];
  const photo2Data = $('#photo2Data')[0];
  const overlay = $('#overlay')[0];
  let stream = null;

  function startCamera() {
    navigator.mediaDevices.getUserMedia({
      video: true
    })
      .then(userStream => {
        stream = userStream;
        video.srcObject = stream;
        video.play();
      })
      .catch(err => console.error('Error accessing camera: ', err));
  }

  function capturePhoto(targetCanvas, targetWidth, targetHeight) {
    const context = targetCanvas.getContext('2d');
    targetCanvas.width = targetWidth;
    targetCanvas.height = targetHeight;
    context.drawImage(video, 0, 0, targetWidth, targetHeight);
    return targetCanvas.toDataURL('image/jpeg');
  }

  function displayTimer(seconds, callback) {
    let remainingTime = seconds;
    overlay.textContent = remainingTime;

    const timerInterval = setInterval(() => {
      remainingTime--;
      overlay.textContent = remainingTime;

      if (remainingTime <= 0) {
        clearInterval(timerInterval);
        overlay.textContent = '';
        if (callback) callback();
      }
    }, 1000);
  }

  function captureTwoPhotos() {
    if (!stream) {
      startCamera();
      setTimeout(() => {
        displayTimer(3, () => {
          const photo1 = capturePhoto(canvas, 1280, 720);
          photo1Data.value = photo1;

          setTimeout(() => {
            displayTimer(3, () => {
              const photo2 = capturePhoto(canvass, 1280, 720);
              photo2Data.value = photo2;
            });
          }, 3000);
        });
      }, 3000);
    } else {
      displayTimer(3, () => {
        const photo1 = capturePhoto(canvas, 1280, 720);
        photo1Data.value = photo1;

        setTimeout(() => {
          displayTimer(3, () => {
            const photo2 = capturePhoto(canvass, 1280, 720);
            photo2Data.value = photo2;
          });
        }, 3000);
      });
    }
  }

  $('#make_user').change(function () {
    let makeUser = $(this).val();
    let roles = $('#rolesSection');

    if (makeUser === 'y') {
      roles.removeClass('hidden opacity-0 max-h-0').addClass('opacity-100 max-h-screen');
    } else {
      roles.addClass('opacity-0 max-h-0').removeClass('opacity-100 max-h-screen');
      setTimeout(() => {
        roles.addClass('hidden');
      }, 500);
    }
  });

  $('#capturePhoto').click(function () {
    captureTwoPhotos();
  });
});