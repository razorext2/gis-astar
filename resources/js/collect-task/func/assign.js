import Swal from "sweetalert2";

export async function singleAssign() {
  $('body').on('click', "#assign-btn", async function () {
    let id = $(this).data("id");
    let token = $("meta[name='csrf-token']").attr("content");

    const {
      value: input
    } = await Swal.fire({
      input: "number",
      title: "Mau assign ke siapa?",
      inputPlaceholder: "Ketik kode jari...",
      inputAttributes: {
        "aria-label": "Ketik kode jari..."
      },
      showCancelButton: true,
      preConfirm: (value) => {
        if (!value) {
          Swal.showValidationMessage("Kode jari tidak boleh kosong!");
          return false;
        }

        return value;
      }
    });

    if (input) {
      $.ajax({
        url: `${APP_URL}/api/collect-task-api/${id}/assign`,
        type: 'PATCH',
        cache: false,
        data: {
          "_token": token,
          "assign_to": input,
          "assign_by": assign_by
        },
        // jika sukses
        success: function (response) {
          Swal.fire(`SR berhasil di assign ke kode jari ${input}`, "", "success");
          $('#dataTable').DataTable().ajax.reload(null, false);
        },
        // jika gagal
        error: function () {
          Swal.fire("Ada kegagalan pada server.", "", "error");
        }
      });
    }
  })
}

export function massAssign() {
  $('#store').click(function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true);

    // ambil data dari field biasa
    let kode_pegawai = $('#kode_pegawai').val();
    let token = $("meta[name='csrf-token']").attr("content");

    // ambil data dari array
    const form = document.getElementById('mass-assign');
    let inputs = form.querySelectorAll('input[name="sr_data[]"]');
    let sr_data = Array.from(inputs).map(
      input => input.value,
    );

    axios.patch(`${APP_URL}/api/collect-task-api/mass-assign`, {
      kode_pegawai: kode_pegawai,
      sr_data: sr_data,
      assign_by: assign_by,
      _token: token
    }).then(function () {

      Swal.fire(`SR berhasil di assign ke kode jari ${kode_pegawai}`, "", "success");
      $('#dataTable').DataTable().ajax.reload(null, false);

      setTimeout(() => window.location.href = `${APP_URL}/dashboard/collect-task`, 1000);
    }).catch(function (error) {
      // Cek apakah ada response error dari server
      if (error.response && error.response.data && error.response.data.errors) {
        handleFormErrors(error.response.data.errors);
      }
      $button.prop('disabled', false); // Mengaktifkan kembali tombol
    })
  })

  // nanti bkin fungsi untuk menghilangkan pesan error jika field sudah ada valuenya.
}

function handleFormErrors(errors) {
  // Menyembunyikan semua alert sebelumnya
  const alertElements = document.querySelectorAll('.alert');
  alertElements.forEach(alert => {
    alert.classList.remove('block');
  });

  // Menampilkan pesan error untuk masing-masing field
  for (let field in errors) {
    const alertElement = document.getElementById(`alert-${field}`);
    if (alertElement) {
      alertElement.classList.remove('hidden');
      alertElement.classList.add('block');
      alertElement.innerHTML = errors[field].join('<br>'); // Menampilkan semua pesan error
    }
  }
}