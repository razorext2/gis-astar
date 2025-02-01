<script type="module">
	//button create deduction event
	$('body').on('click', '#btn-delete-deduction', function() {

		let deduction_id = $(this).data('id');
		let token = $("meta[name='csrf-token']").attr("content");

		Swal.fire({
			title: 'Apakah Kamu Yakin?',
			text: "ingin menghapus data ini!",
			icon: 'warning',
			showCancelButton: true,
			cancelButtonText: 'TIDAK',
			confirmButtonText: 'YA, HAPUS!'
		}).then((result) => {
			if (result.isConfirmed) {

				console.log('test');

				//fetch to delete data
				$.ajax({
					url: `${APP_URL}/dashboard/pegawai/deductions/${deduction_id}`,
					type: "DELETE",
					cache: false,
					data: {
						"_token": token
					},
					success: function(response) {

						//show success message
						Swal.fire({
							icon: 'success',
							title: `${response.message}`,
							showConfirmButton: false,
							timer: 3000
						});

						//remove deduction on table
						// $(`#index_${deduction_id}`).remove();
						$('#table-deduction').DataTable().ajax.reload(null, false);
					}
				});


			}
		})

	});
</script>
