export function showAlert(type, title, text = null) {
  Swal.fire({
    icon: type,
    title: title,
    text: text,
    showConfirmButton: false,
    timer: 1500
  });
}

export function loadingAlert(title) {
  Swal.fire({
    title: title,
    showConfirmButton: false,
    allowOutsideClick: false,
    willOpen: () => Swal.showLoading()
  });
}