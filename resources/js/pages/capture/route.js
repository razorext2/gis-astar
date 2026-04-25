import Swal from "sweetalert2";
import { showAlert, loadingAlert } from "../../utils/alert";
import { getLocation } from "../../utils/geoLocation";

export async function initRecognition() {
    // Ambil elemen DOM
    const video = document.getElementById("video");
    const canvas = document.getElementById("canvas");
    const snap = document.getElementById("snap");

    // Pastikan elemen wajib tersedia sebelum melanjutkan
    if (!video || !canvas || !snap) {
        console.warn("Elemen kamera tidak lengkap di halaman ini.");
        return;
    }

    const ctx = canvas.getContext("2d");
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

        Swal.close();
    } catch (err) {
        locationCords = false;
        showError("Kegagalan Lokasi", "Gagal mengunci kordinat lokasi Anda. Pastikan GPS aktif.");
    }

    // Gunakan addEventListener bukan .onclick (Modern JS standard)
    snap.addEventListener("click", async function () {
        // Cek apakah koordinat tersedia
        if (!locationCords) {
            return showAlert("error", "Gagal", "Lokasi Anda belum ditemukan atau tidak akurat.");
        }

        // Jika kamera sudah nyala, jadikan tombol sebagai trigger "Ambil Foto"
        if (cameraOn) {
            handleSnapshotCapture();
            return;
        }

        // === FASE PERTAMA: MENGAKSES KAMERA === //
        
        // Disable tombol & ganti state agar tidak dispam
        snap.setAttribute("disabled", "disabled");
        const originalText = snap.innerHTML;
        snap.innerHTML = `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline uppercase" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memuat...`;

        video.setAttribute("autoplay", true);

        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            
            cameraOn = true;
            video.srcObject = stream;
            
            // Re-enable tombol dan ganti fungsi sebagai "Snap/Capture"
            snap.removeAttribute("disabled");
            snap.innerHTML = `
                <svg class="h-5 w-5 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                AMBIL FOTO
            `;

        } catch (error) {
            cameraOn = false;
            snap.removeAttribute("disabled");
            snap.innerHTML = originalText;
            
            let errorTitle = 'Akses Ditolak';
            let errorMsg = 'Gagal mengakses kamera.';

            switch (error.name) {
                case 'NotAllowedError':
                case 'PermissionDeniedError':
                    errorMsg = 'Anda menolak izin akses kamera. Harap izinkan akses kamera pada URL bar untuk absensi masuk.';
                    break;
                case 'NotFoundError':
                case 'DevicesNotFoundError':
                    errorTitle = 'Kamera Tidak Ditemukan';
                    errorMsg = 'Tidak ada perangkat kamera yang terdeteksi pada sistem Anda.';
                    break;
                case 'NotReadableError':
                case 'TrackStartError':
                    errorTitle = 'Kamera Sibuk';
                    errorMsg = 'Kamera sedang digunakan oleh aplikasi/tab lain (misal zoom/meet). Tutup aplikasi tersebut terlebih dahulu.';
                    break;
                default:
                    errorMsg = `Kesalahan sistem: ${error.message || error}`;
                    break;
            }

            showError(errorTitle, errorMsg);
        }
    });

    // === Fungsi Handler Pengambilan Gambar & Submit === //
    async function handleSnapshotCapture() {
        // Matikan tombol saat memproses snapshot
        snap.setAttribute("disabled", "disabled");

        // Pastikan dimensi canvas menyamai resolusi real video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // Gambar frame saat ini ke canvas
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Ambil data gambar BASE64
        const imageData = canvas.toDataURL("image/png");

        if (imageData) {
            // Tampilkan Alert Form (Menggunakan Vanilla JS murni)
            const { value: captureRoute } = await Swal.fire({
                title: "Keterangan Absensi",
                html: `
        <form id="captureRouteForm" class="grid gap-4 !text-left">
          <div class="col-span-2">
            <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="swal2-textarea !w-full !m-0 bg-gray-50 border border-zinc-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" rows="4" placeholder="Tulis deskripsi rinci..."></textarea>
          </div>

          <div class="col-span-2">
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status Kedisiplinan</label>
            <select name="status" id="status" class="swal2-input !w-full !m-0 bg-gray-50 border border-zinc-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
              <option value="">-- Pilih Status --</option>
              <option value="1">Dalam Perjalanan (On The Way)</option>
              <option value="2">Stand By</option>
              <option value="3">On Site (Di Lokasi)</option>
            </select>
          </div>
        </form>
      `,
                allowOutsideClick: false,
                confirmButtonText: "Simpan Laporan",
                showCancelButton: true,
                cancelButtonText: "Batal",
                footer: `
              <div style="text-align:left;font-size:12px;white-space:pre-wrap;color:#6b7280;">
                <strong style="color:#ef4444;">Contoh Keterangan:</strong>
                - OTW ke PT Sentosa Jaya, VT-12345
                - Standby di Pelabuhan, menunggu instruksi
                - On site perbaikan server di Lt 3 Gedung A
              </div>
            `,
                didOpen: () => {
                    const txtDesc = document.getElementById("keterangan");
                    if (txtDesc) txtDesc.focus();
                },
                preConfirm: () => {
                    const keteranganValue = document.getElementById("keterangan").value;
                    const statusValue = document.getElementById("status").value;

                    if (!keteranganValue.trim()) {
                        Swal.showValidationMessage("Keterangan perjalanan wajib diisi!");
                        return false;
                    }

                    if (!statusValue.trim()) {
                        Swal.showValidationMessage("Status operasional harus dipilih!");
                        return false;
                    }

                    if (keteranganValue.length < 10) {
                        Swal.showValidationMessage("Keterangan minimal membutuhkan 10 karakter! Berikan detail yang cukup.");
                        return false;
                    }

                    return { keterangan: keteranganValue, status: statusValue };
                },
            });

            // Jika user memilih Cancel atau menutup dialog
            if (!captureRoute) {
                snap.removeAttribute("disabled");
                return;
            }

            // Submit Data jika konfirmasi sukses
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            const imageFile = base64ToFile(imageData, "route_validation.png");
            
            const formData = new FormData();
            formData.append("image", imageFile);
            formData.append("longitude", String(longitude));
            formData.append("latitude", String(latitude));
            formData.append("keterangan", captureRoute.keterangan);
            formData.append("status", captureRoute.status);
            formData.append("timezone", timezone);

            loadingAlert("Memverifikasi Kehadiran...");

            axios.post("/api/facerecognition/verify", formData, {
                headers: { "Content-Type": "multipart/form-data" },
            })
            .then(async (res) => {
                if (res.data.success) {
                    showAlert("success", "Berhasil diverifikasi!", res.data.message);
                    setTimeout(() => {
                        window.location.href = "/dashboard";
                    }, 1500); // 1.5s delay to let user read success message
                } else {
                    showAlert("error", "Verifikasi Gagal", res.data.message);
                    snap.removeAttribute("disabled");
                }
            })
            .catch((error) => {
                Swal.close();
                showAlert("error", "Sistem Error", error.message || error);
                snap.removeAttribute("disabled");
            });
        }
    }

    // --- Helper Functions in local scope --- //

    function showError(title, message) {
        console.warn(`[Route Attendance Error]: ${message}`);
        
        // Mematikan tombol tanpa merubah class theme utamanya
        if (snap) {
            snap.setAttribute("disabled", "disabled");
            // Menggunakan utilitas standard Tailwind daripada class override manual
            snap.classList.add("opacity-50", "cursor-not-allowed", "grayscale");
        }
        
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
}
