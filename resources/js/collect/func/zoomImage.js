export function zoomImage() {
  $('body').on('click', '#documentations', function () {
    let url = $(this).data("url");

    Swal.fire({
      showCancelButton: false,
      showConfirmButton: false,
      html: `
      <span class="text-sm font-semibold text-gray-700 mb-4"> Dokumentasi: </span>
      <img src="${url}" class="w-full mx-auto rounded-xl "/>
      `,
    })
  })
}