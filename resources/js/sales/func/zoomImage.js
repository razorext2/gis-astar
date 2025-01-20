export function zoomImage() {
  $('body').on('click', '#documentations', function () {
    let url = $(this).data("url");

    Swal.fire({
      showCancelButton: false,
      showConfirmButton: false,
      html: `<img src="${url}" class="w-full mx-auto rounded-xl "/>`,
    })
  })
}