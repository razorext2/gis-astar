<script>
	//button create allowance event
	$('body').on('click', '#btn-delete-allowance', function() {

		let allowance_id = $(this).data('id');
		let token = $("meta[name='csrf-token']").attr("content");

		window.Swal.fire({
			title: 'Apakah Kamu Yakin?',
			text: "ingin menghapus data ini!",
			icon: 'warning',
			showCancelButton: true,
			cancelButtonText: 'TIDAK',
			confirmButtonText: 'YA, HAPUS!'
		}).then((result) => {
			if (result.isConfirmed) {
				//fetch to delete data
				$.ajax({
					url: `${APP_URL}/dashboard/pegawai/allowances/${allowance_id}`,
					type: "DELETE",
					cache: false,
					data: {
						"_token": token
					},
					success: function(response) {

						//show success message
						window.Swal.fire({
							icon: 'success',
							title: `${response.message}`,
							showConfirmButton: false,
							timer: 3000
						});

						//remove allowance on table
						// $(`#index_${allowance_id}`).remove();
						$('#table-allowance').DataTable().ajax.reload(null, false);
					}
				});


			}
		})

	});
</script>
