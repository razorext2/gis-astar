import * as faceapi from "face-api.js";
import { showAlert, loadingAlert } from "../../utils/alert";

export function initSelfDetect(lat, lng) {
    let videoStream = null,
        webcamStarted = !1,
        detectionInterval = null;

    const video = document.getElementById("video"),
        canvas = document.getElementById("canvas"),
        startButton = document.getElementById("startButton"),
        canvInfo = document.getElementById("canvAttend"),
        labels = [],
        kodePegawai = document.getElementById("kodePegawai").value;

    function initializeFaceAPI() {
        // Cek jika model sudah dimuat sebelumnya di memori
        if (
            faceapi.nets.ssdMobilenetv1.isLoaded &&
            faceapi.nets.faceRecognitionNet.isLoaded &&
            faceapi.nets.faceLandmark68Net.isLoaded
        ) {
            Swal.close();
            return; // Skip loading if already loaded
        }

        Promise.all([
            faceapi.nets.ssdMobilenetv1.loadFromUri(`/models`),
            faceapi.nets.faceRecognitionNet.loadFromUri(`/models`),
            faceapi.nets.faceLandmark68Net.loadFromUri(`/models`),
        ])
            .then(() => {
                Swal.close();
            })
            .catch((error) => {
                return showAlert(
                    "error",
                    "Gagal",
                    `Gagal memuat model: ${error}`,
                );
            });
    }

    function captureImage() {
        const canvas = document.createElement("canvas");

        // Set canvas dimensions to match the video dimensions
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // Draw the current frame of the video onto the canvas
        canvas
            .getContext("2d")
            .drawImage(video, 0, 0, canvas.width, canvas.height);

        startButton.innerText = "Foto dicapture, mengolah...";

        // Return a promise to handle the blob creation asynchronously
        return new Promise((resolve) => {
            canvas.toBlob((blob) => {
                resolve(blob || null); // Resolve with the blob or null if no blob is created
            }, "image/png");
        });
    }

    function displayImageOnCanvas(imageSource) {
        // Pastikan elemen canvas untuk informasi tersedia
        canvInfo.style.display = "block";

        // Ambil konteks 2D dari canvas "canvAttend"
        const canvasContext = document
            .getElementById("canvAttend")
            .getContext("2d");

        if (canvasContext) {
            // Buat objek gambar baru
            const image = new Image();
            image.src = imageSource;

            // Tindakan ketika gambar berhasil dimuat
            image.onload = () => {
                // Sesuaikan ukuran canvas dengan ukuran gambar
                canvInfo.width = image.width;
                canvInfo.height = image.height;

                // Gambar gambar ke canvas
                canvasContext.drawImage(image, 0, 0);
            };

            // Tindakan ketika gambar gagal dimuat
            image.onerror = () => {
                return showAlert(
                    "error",
                    "Terjadi kesalahan.",
                    `Gagal memuat gambar: ${imageSource}`,
                );
            };
        } else {
            return showAlert(
                "error",
                "Terjadi kesalahan.",
                "Gagal memuat canvas",
            );
        }
    }

    function showAttendanceAlert() {
        showAlert("success", "Berhasil", "Berhasil melakukan absensi");

        setTimeout(() => {
            window.location.href = `/dashboard`;
        }, 1000);
    }

    async function getEmployeeImagePaths(label) {
        try {
            // Fetch data from the server with the encoded label
            const response = await axios.get(
                `/api/pegawai-images/${encodeURIComponent(label)}`,
            );

            // Check if the response was successful
            if (response.status !== 200)
                throw new Error("Network response was not ok");

            // Parse and return the JSON data
            return response.data;
        } catch (error) {
            // Log error messages and return an empty array
            return showAlert(
                "error",
                "Terjadi kesalahan.",
                "Daftarkan wajah terlebih dahulu.",
            );
        }
    }

    async function getLabeledFaceDescriptions() {
        startButton.innerText = "Mengambil label...";

        const labeledFaceDescriptors = [];

        for (const label of labels) {
            // 1. Cek Data Descriptor di LocalStorage terlebih dahulu (Untuk Bypass Processing 3 Detik)
            const cachedData = localStorage.getItem(`faceDescriptor_${label}`);
            if (cachedData) {
                try {
                    const parsed = JSON.parse(cachedData);
                    // Validasi cache expire dalam 7 hari agar jika ganti foto bisa terupdate
                    const isNotExpired = new Date().getTime() < parsed.expiry;
                    if (isNotExpired) {
                        const Float32Arr = new Float32Array(Object.values(parsed.descriptor));
                        labeledFaceDescriptors.push(
                            new faceapi.LabeledFaceDescriptors(label, [Float32Arr])
                        );
                        continue; 
                    }
                } catch (e) {
                    localStorage.removeItem(`faceDescriptor_${label}`);
                }
            }

            // 2. Jika tidak ada cache, Lakukan Pemrosesan Ekstrak Wajah (Lama)
            const faceDescriptors = [];
            const imagePath = await getEmployeeImagePaths(label);

            try {
                const image = await faceapi.fetchImage(imagePath);
                const detectedFace = await faceapi
                    .detectSingleFace(image)
                    .withFaceLandmarks()
                    .withFaceDescriptor();

                loadingAlert("Memproses Referensi Wajah...");

                if (detectedFace) {
                    startButton.innerText = "Mendeteksi wajah...";
                    faceDescriptors.push(detectedFace.descriptor);

                    // 3. Simpan ke LocalStorage agar kedepannya mem-bypass langkah berat ini
                    const cachePayload = {
                        expiry: new Date().getTime() + (7 * 24 * 60 * 60 * 1000), // Kadaluarsa 7 Hari
                        descriptor: detectedFace.descriptor
                    };
                    localStorage.setItem(`faceDescriptor_${label}`, JSON.stringify(cachePayload));
                }
            } catch (error) {
                return showAlert(
                    "error",
                    "Terjadi kesalahan.",
                    `Gagal memuat gambar: ${imagePath}`,
                );
            }

            if (faceDescriptors.length > 0) {
                labeledFaceDescriptors.push(
                    new faceapi.LabeledFaceDescriptors(label, faceDescriptors),
                );
            }
        }

        return labeledFaceDescriptors;
    }

    async function getEmployeeDataByLabel(label) {
        try {
            // Make an API call to fetch employee data by label
            const response = await axios.get(
                `/api/getPegawaiData/${encodeURIComponent(label)}`,
            );

            // Check if the response is okay
            if (response.status !== 200) {
                throw new Error("Network response was not ok");
            }

            // Return the response data as JSON
            return response.data;
        } catch (error) {
            // Log the error and return null if the request fails
            return showAlert(
                "error",
                "Terjadi kesalahan.",
                `Gagal memuat data pegawai: ${error}`,
            );
        }
    }

    async function startFaceDetection() {
        startButton.innerText = "Memulai...";

        if (!detectionInterval) {
            try {
                const labeledFaceDescriptors =
                    await getLabeledFaceDescriptions();
                if (labeledFaceDescriptors.length === 0) {
                    return showAlert(
                        "error",
                        "Terjadi kesalahan.",
                        "Tidak ada wajah yang terdaftar.",
                    );
                }

                const faceMatcher = new faceapi.FaceMatcher(
                    labeledFaceDescriptors,
                );

                const canvasContext = canvas.getContext("2d", {
                    willReadFrequently: true,
                });
                if (!canvasContext) {
                    return showAlert(
                        "error",
                        "Terjadi kesalahan.",
                        "Gagal memuat canvas.",
                    );
                }

                let hasSubmitted = false;
                const detectedFaceLabels = new Set();

                detectionInterval = setInterval(async () => {
                    if (hasSubmitted) return; // Mencegah interval mengeksekusi dobel submit

                    // Wait until camera fully starts painting pixels and metadata
                    if (!video.videoWidth || !video.videoHeight || video.videoWidth === 0) {
                        return; // Skip this tick
                    }

                    const videoDimensions = {
                        width: video.videoWidth,
                        height: video.videoHeight,
                    };

                    // Sync canvas dynamically to prevent resizing bugs
                    if (canvas.width !== videoDimensions.width || canvas.height !== videoDimensions.height) {
                        faceapi.matchDimensions(canvas, videoDimensions);
                        video.width = videoDimensions.width;
                        video.height = videoDimensions.height;
                    }

                    try {
                        const detectedFaces = await faceapi
                            .detectAllFaces(video)
                            .withFaceLandmarks()
                            .withFaceDescriptors();
                        
                        const resizedFaces = faceapi.resizeResults(
                            detectedFaces,
                            videoDimensions,
                        );
                        
                        const tempCanvas = document.createElement("canvas");
                        tempCanvas.width = canvas.width;
                        tempCanvas.height = canvas.height;

                        let isFaceMatched = false;
                        let matchedLabel = null;
                        let employeeCode = null;

                        for (const face of resizedFaces) {
                            const bestMatch = faceMatcher.findBestMatch(
                                face.descriptor,
                            );
                            const matchDistance = bestMatch.distance;

                            if (
                                bestMatch.label !== "unknown" &&
                                matchDistance < 0.6 &&
                                !detectedFaceLabels.has(bestMatch.label)
                            ) {
                                const boundingBox = face.detection.box;
                                new faceapi.draw.DrawBox(boundingBox, {
                                    label: bestMatch.toString(),
                                }).draw(tempCanvas);
                                isFaceMatched = true;
                                matchedLabel = bestMatch.label;
                                detectedFaceLabels.add(bestMatch.label);
                                
                                employeeCode = matchedLabel; // Sesuai label dari backend
                            }
                        }

                        if (isFaceMatched && employeeCode) {
                            hasSubmitted = true; // Kunci eksekusi
                            
                            if (detectionInterval) {
                                clearInterval(detectionInterval);
                                detectionInterval = null;
                            }

                            // Fungsi untuk memastikan gambar sudah ditampilkan sebelum melanjutkan
                            await new Promise((resolve) => {
                                // Menunggu hingga gambar ter-render pada canvas
                                canvasContext.clearRect(
                                    0,
                                    0,
                                    canvas.width,
                                    canvas.height,
                                );
                                canvasContext.drawImage(tempCanvas, 0, 0);
                                requestAnimationFrame(() => resolve()); // Gunakan requestAnimationFrame untuk menunggu rendering selesai
                            });

                            // Setelah rendering selesai, lanjutkan dengan upload dan penambahan data
                            const capturedImage = await captureImage();
                            if (capturedImage) {
                                await processAttendanceWithImage(
                                    capturedImage,
                                    employeeCode
                                );
                                canvInfo.style.display = "block";
                            } else {
                                hasSubmitted = false;
                                return showAlert(
                                    "error",
                                    "Terjadi kesalahan.",
                                    "Gagal mengambil gambar.",
                                );
                            }
                        }
                    } catch (error) {
                        return showAlert(
                            "error",
                            "Terjadi kesalahan.",
                            `Gagal mengambil gambar: ${error}`,
                        );
                    }
                }, 2000);

                Swal.close();
            } catch (error) {
                return showAlert(
                    "error",
                    "Terjadi kesalahan.",
                    `Gagal mengisialisasi face recognition: ${error}`,
                );
            }
        }
    }

    async function processAttendanceWithImage(imageBlob, employeeCode) {
        try {
            startButton.innerText = "Memeriksa status...";

            // 1. Cek status absensi untuk mengetahui endpoint yang tepat
            const { data: checkData } = await axios.post(
                `/api/check-attendance`,
                {
                    kode_pegawai: employeeCode,
                    longitude: lng,
                    latitude: lat,
                },
            );

            const endpoint = checkData.hasClockedIn
                ? `/store-attendance-out`
                : `/store-attendance`;

            // 2. Siapkan FormData (Unified request: Data + File Image)
            const formData = new FormData();
            formData.append("image", imageBlob, "capturedImg.png");
            // API baru di backend tidak memerlukan kirim 'jam_masuk' dari frontend untuk keamanan
            formData.append("longitude", String(lng !== undefined && lng !== null ? lng : ""));
            formData.append("latitude", String(lat !== undefined && lat !== null ? lat : ""));

            startButton.innerText = "Menyimpan data...";
            loadingAlert("Mengirim ke server...");

            // 3. Eksekusi penyimpanan data & gambar secara bersamaan
            const { data: attendanceData } = await axios.post(
                endpoint,
                formData,
                {
                    headers: { "Content-Type": "multipart/form-data" },
                }
            );

            if (attendanceData.success) {
                if (attendanceData.imageUrl) {
                    displayImageOnCanvas(attendanceData.imageUrl);
                }

                // 4. Sinkronisasi ke server pusat
                await axios
                    .post(`/api/proxy/server/attendance`, {
                        kode_jari: employeeCode,
                    })
                    .then(() => {
                        Swal.close();
                        showAttendanceAlert();
                    })
                    .catch((error) => {
                        Swal.close();
                        // Jangan memutus alur utama sukses hanya karena proxy server gagal
                        showAttendanceAlert();
                        console.warn('Gagal mem-proxy ke pusat: ', error);
                    });
            } else {
                Swal.close();
                return showAlert(
                    "error",
                    "Terjadi kesalahan.",
                    attendanceData.message || "Gagal menyimpan data absensi.",
                );
            }
        } catch (error) {
            Swal.close();
            return showAlert(
                "error",
                "Terjadi kesalahan.",
                `Gagal memproses absensi: ${error.response?.data?.message || error.message || error}`,
            );
        }
    }

    axios
        .get(`/api/getPegawai/${kodePegawai}`)
        .then((response) => {
            loadingAlert("Initializing application");
            labels.push(...response.data);
            initializeFaceAPI();
        })
        .catch((error) => {
            return showAlert(
                "error",
                "Terjadi kesalahan.",
                `Terjadi kesalahan saat memuat data: ${error}`,
            );
        });

    // Event listener untuk start button
    startButton.addEventListener("click", async () => {
        canvas.style.display = "block";
        canvInfo.style.display = "none";
        startButton.innerText = "Loading...";
        startButton.setAttribute("disabled", "disabled");

        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: false,
            });
            video.srcObject = stream;
            videoStream = stream;
            webcamStarted = true;
            startFaceDetection();
        } catch (error) {
            // Kembalikan status tombol agar user bisa menekan ulang (opsional)
            startButton.removeAttribute("disabled");

            let errorTitle = "Akses Ditolak";
            let errorMsg = "Gagal mengakses kamera.";

            // Cek spesifik jenis error dari getUserMedia API
            switch (error.name) {
                case "NotAllowedError":
                case "PermissionDeniedError":
                    errorMsg =
                        "Anda menolak izin akses kamera. Harap izinkan akses kamera pada pengaturan browser/URL bar untuk melakukan absensi.";
                    break;
                case "NotFoundError":
                case "DevicesNotFoundError":
                    errorTitle = "Kamera Tidak Ditemukan";
                    errorMsg =
                        "Tidak ada perangkat kamera yang terdeteksi pada sistem Anda.";
                    break;
                case "NotReadableError":
                case "TrackStartError":
                    errorTitle = "Kamera Sibuk";
                    errorMsg =
                        "Kamera sedang digunakan oleh aplikasi/tab lain. Tutup aplikasi tersebut terlebih dahulu.";
                    break;
                default:
                    errorMsg = `Kesalahan sistem: ${error.message || error}`;
                    break;
            }

            return showAlert("error", errorTitle, errorMsg);
        }
    });

    // Mengatur dimensi video dan canvas
    video.addEventListener("loadedmetadata", () => {
        video.width = video.videoWidth;
        video.height = video.videoHeight;
        canvas.width = video.width;
        canvas.height = video.height;
    });
}
