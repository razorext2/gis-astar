import Swal from "sweetalert2";
import { showAlert, loadingAlert } from "../../utils/alert";
import { getLocation } from "../../utils/geoLocation";

export async function initRecognition() {
    // Ambil elemen video dan canvas
    const video = document.getElementById("video");
    const canvas = document.getElementById("canvas");
    const ctx = canvas.getContext("2d");
    const snap = document.getElementById("snap");

    let cameraOn = false;
    let locationCords = false;
    let longitude = null;
    let latitude = null;

    try {
        // Tampilkan Swal loading saat proses pengambilan lokasi
        loadingAlert("Mengambil lokasi...");

        // Ambil lokasi secara asinkron
        const coords = await getLocation("route");

        // Isi form dengan lokasi yang diperoleh
        document.getElementById("longitude").textContent = coords.longitude;
        document.getElementById("latitude").textContent = coords.latitude;
        longitude = coords.longitude;
        latitude = coords.latitude;
        locationCords = true;

        // Tutup Swal loading setelah selesai
        Swal.close();
    } catch (err) {
        locationCords = false;
        showError("Terjadi Kegagalan", err);
    }

    // Saat tombol "snap" diklik
    snap.onclick = async function () {
        // Cek lokasinya ada ga
        if (!locationCords) {
            showAlert("error", "Gagal", "Lokasi tidak ditemukan");
        }

        // Aktifkan stream
        video.setAttribute("autoplay", true);

        // Akses kamera
        navigator.mediaDevices
            .getUserMedia({ video: true })
            .then((stream) => {
                cameraOn = true;
                snap.innerText = "Ambil Selfie";
                video.srcObject = stream;
                video.classList.add("bg-dark-primary");
            })
            .catch((err) => {
                cameraOn = false;
                showError("Terjadi Kegagalan", err);
            });

        if (cameraOn) {
            // Pastikan ukuran canvas disamakan dengan resolusi stream video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            // Gambar frame ke canvas
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Ambil data gambar dalam format base64
            const imageData = canvas.toDataURL("image/png");

            if (imageData) {
                const { value: captureRoute } = await Swal.fire({
                    title: "Keterangan absensi",
                    html: `
            <form id="captureRouteForm" class="grid gap-4 !text-left">
              <div class="col-span-2">
                <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="swal2-textarea !w-full !m-0 bg-gray-50 border border-zinc-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" rows="4" placeholder="Tulis deskripsi..."></textarea>
              </div>

              <div class="col-span-2">
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                <select name="status" id="status" class="swal2-input !w-full !m-0 bg-gray-50 border border-zinc-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                  <option value="">Pilih Status</option>
                  <option value="1">Dalam Perjalanan</option>
                  <option value="2">Stand By</option>
                  <option value="3">On Site</option>
                </select>
              </div>
            </form>
          `,
                    allowOutsideClick: false,
                    confirmButtonText: "Simpan",
                    footer: `
                  <div style="text-align:left;font-size:12px;white-space:pre-wrap;">
                    Contoh:
                    - otw ke pt a, vt-123123123
                    - standby di pt a, vt-123123
                    - standby di pt a, vt - belum ada
                    - otw ke pt a, vt - belum ada
                  </div>
                `,
                    didOpen: () => {
                        $("#keterangan").focus();
                    },
                    preConfirm: () => {
                        const $form = $("#captureRouteForm");
                        const keterangan = $form.find("#keterangan").val();
                        const status = $form.find("#status").val();

                        if (!keterangan.trim()) {
                            Swal.showValidationMessage(
                                "Keterangan harus diisi!",
                            );
                            return false;
                        }

                        if (!status.trim()) {
                            Swal.showValidationMessage("Status harus diisi!");
                            return false;
                        }

                        if (keterangan.length < 10) {
                            Swal.showValidationMessage(
                                "Keterangan minimal 10 karakter!",
                            );
                            return false;
                        }

                        return { keterangan, status };
                    },
                });

                if (captureRoute) {
                    const timezone =
                        Intl.DateTimeFormat().resolvedOptions().timeZone;
                    const imageFile = base64ToFile(imageData, "face.png");
                    const formData = new FormData();

                    formData.append("image", imageFile);
                    formData.append("longitude", String(longitude));
                    formData.append("latitude", String(latitude));
                    formData.append("keterangan", captureRoute.keterangan);
                    formData.append("status", captureRoute.status);
                    formData.append("timezone", timezone);

                    loadingAlert("Memproses...");

                    axios
                        .post("/api/facerecognition/verify", formData, {
                            headers: { "Content-Type": "multipart/form-data" },
                        })
                        .then(async (res) => {
                            if (res.data.success) {
                                showAlert(
                                    "success",
                                    res.data.message,
                                    res.data.data,
                                );
                                return setTimeout(() => {
                                    window.location.href = "/dashboard";
                                }, 500);
                            } else {
                                showAlert(
                                    "error",
                                    res.data.message,
                                    res.data.data,
                                );
                            }
                        })
                        .catch((error) => {
                            Swal.close();
                            return showAlert(
                                "error",
                                error.message,
                                error.data,
                            );
                        });
                }
            }
        }
    };
}

function showError(title, message) {
    console.log(message);
    snap.setAttribute("disabled", true);
    snap.innerText = message;
    snap.classList.add(
        "hover:bg-red-700",
        "dark:bg-red-800",
        "bg-red-400",
        "dark:hover:bg-red-900",
        "ring-red-200",
        "dark:text-white",
        "dark:ring-red-700",
    );
    snap.classList.remove(
        "hover:bg-blue-700",
        "dark:bg-blue-800",
        "bg-blue-400",
        "dark:hover:bg-blue-900",
        "ring-zinc-200",
        "dark:text-white",
        "dark:ring-zinc-800",
    );
    showAlert("error", title, message);
}

function base64ToFile(base64, filename) {
    const arr = base64.split(",");
    const mime = arr[0].match(/:(.*?);/)[1];
    const bstr = atob(arr[1]);
    let n = bstr.length;
    const u8arr = new Uint8Array(n);
    while (n--) u8arr[n] = bstr.charCodeAt(n);
    return new File([u8arr], filename, { type: mime });
}
