export function showAlert(type, title, text = null) {
  Swal.fire({
    icon: type,
    title: title,
    text: text,
    showConfirmButton: false,
    timer: 1500
  });
}