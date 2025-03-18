export function zoomImage() {
  $('body').on('click', '#documentations', function () {
    let url = $(this).data("url");

    Swal.fire({
      showCancelButton: false,
      showConfirmButton: false,
      html: `<img src="${url}" onerror="this.onerror=null; this.src='${APP_URL}/assets/img/noImage.webp';" class="w-full mx-auto rounded-xl" loading="lazy" />`,
    })
  })
}