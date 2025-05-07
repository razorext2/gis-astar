import * as faceapi from "face-api.js";
import { showAlert, loadingAlert } from "../../utils/alert";
import Swal from "sweetalert2";

export function initSelfDetect(lat, lng) {
  let videoStream = null,
    webcamStarted = !1,
    detectionInterval = null;

  const video = document.getElementById("video"),
    overlay = document.getElementById("overlay"),
    startButton = document.getElementById("startButton"),
    csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
    canvInfo = document.getElementById("canvAttend"),
    pegawaiInfo = document.getElementById("pegawaiInfo"),
    labels = [],
    kodePegawai = document.getElementById('kodePegawai').value;

  function initializeFaceAPI() {
    // Load necessary models from the specified URI
    Promise.all([
      faceapi.nets.ssdMobilenetv1.loadFromUri(`${APP_URL}/models`),       // Load SSD MobileNet model
      faceapi.nets.faceRecognitionNet.loadFromUri(`${APP_URL}/models`),   // Load Face Recognition model
      faceapi.nets.faceLandmark68Net.loadFromUri(`${APP_URL}/models`)     // Load Face Landmark model
    ])
      .then(() => {
        Swal.close();
        showAlert('success', 'Berhasil', 'Model berhasil diload');
      })
      .catch((error) => {
        return showAlert('error', 'Gagal', `Gagal memuat model: ${error}`);
      });
  }

  function captureImage() {
    const canvas = document.createElement("canvas");

    // Set canvas dimensions to match the video dimensions
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    // Draw the current frame of the video onto the canvas
    canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);

    startButton.innerText = 'Foto dicapture, mengolah...';

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
    const canvasContext = document.getElementById("canvAttend").getContext("2d");

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
        return showAlert('error', 'Terjadi kesalahan.', `Gagal memuat gambar: ${imageSource}`)
      };
    } else {
      return showAlert('error', 'Terjadi kesalahan.', 'Gagal memuat canvas');
    }
  }

  function showAttendanceAlert() {
    showAlert('success', 'Berhasil', 'Berhasil melakukan absensi');

    // Menampilkan elemen yang relevan setelah alert
    startButton.innerText = "Stop";
    startButton.disabled = false;

    setTimeout(() => {
      window.location.href = `${APP_URL}/dashboard/capture`;
    }, 2500);
  }

  async function getEmployeeImagePaths(label) {
    try {
      // Fetch data from the server with the encoded label
      const response = await axios.get(`${APP_URL}/api/pegawai-images/${encodeURIComponent(label)}`);

      // Check if the response was successful
      if (response.status !== 200) throw new Error("Network response was not ok");

      // Parse and return the JSON data
      return response.data;
    } catch (error) {
      // Log error messages and return an empty array
      return showAlert('error', 'Terjadi kesalahan.', 'Daftarkan wajah terlebih dahulu.');
    }
  }

  async function getLabeledFaceDescriptions() {
    startButton.innerText = "Mengambil label...";

    const labeledFaceDescriptors = [];

    // Iterate through all the labels (e.g., employee labels or face IDs)
    for (const label of labels) {
      const faceDescriptors = [];
      const imagePaths = await getEmployeeImagePaths(label);  // Get image paths for each label

      // Process each image path for face recognition
      for (const imagePath of imagePaths) {
        try {
          // Fetch the image and detect face landmarks and descriptors
          const image = await faceapi.fetchImage(imagePath);
          const detectedFace = await faceapi.detectSingleFace(image).withFaceLandmarks().withFaceDescriptor();

          // If face is detected, push the descriptor into the list
          loadingAlert('Fetching images...');

          if (detectedFace) {
            startButton.innerText = "Mendeteksi wajah..."
            faceDescriptors.push(detectedFace.descriptor);
          }
        } catch (error) {
          // Log error if image processing fails
          return showAlert('error', 'Terjadi kesalahan.', `Gagal memuat gambar: ${imagePath}`);
        }
      }

      // If face descriptors were detected, create a LabeledFaceDescriptors object
      if (faceDescriptors.length > 0) {
        labeledFaceDescriptors.push(new faceapi.LabeledFaceDescriptors(label, faceDescriptors));
      }
    }

    return labeledFaceDescriptors;
  }

  async function getEmployeeDataByLabel(label) {
    try {
      // Make an API call to fetch employee data by label
      const response = await axios.get(`${APP_URL}/api/getPegawaiData/${encodeURIComponent(label)}`);

      // Check if the response is okay
      if (response.status !== 200) {
        throw new Error("Network response was not ok");
      }

      // Return the response data as JSON
      return response.data;
    } catch (error) {
      // Log the error and return null if the request fails
      return showAlert('error', 'Terjadi kesalahan.', `Gagal memuat data pegawai: ${error}`);
    }
  }

  async function startFaceDetection() {
    startButton.innerText = "Memulai...";

    if (!detectionInterval) {
      try {
        const labeledFaceDescriptors = await getLabeledFaceDescriptions();
        if (labeledFaceDescriptors.length === 0) {
          return showAlert('error', 'Terjadi kesalahan.', 'Tidak ada wajah yang terdaftar.');
        }

        const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors);
        const videoDimensions = { width: video.width, height: video.height };
        faceapi.matchDimensions(overlay, videoDimensions);

        const canvasContext = overlay.getContext("2d", { willReadFrequently: true });
        if (!canvasContext) {
          return showAlert('error', 'Terjadi kesalahan.', 'Gagal memuat canvas.');
        }

        const detectedFaceLabels = new Set();
        let employeeData = null; // Pastikan employeeData didefinisikan di luar

        detectionInterval = setInterval(async () => {
          try {
            const detectedFaces = await faceapi.detectAllFaces(video)
              .withFaceLandmarks()
              .withFaceDescriptors();
            const resizedFaces = faceapi.resizeResults(detectedFaces, videoDimensions);
            const tempCanvas = document.createElement("canvas");
            tempCanvas.width = overlay.width;
            tempCanvas.height = overlay.height;

            let isFaceMatched = false;
            let matchedLabel = null;
            let employeeCode = null;
            let employeeNik = null;

            for (const face of resizedFaces) {
              const bestMatch = faceMatcher.findBestMatch(face.descriptor);
              const matchDistance = bestMatch.distance;

              if (bestMatch.label !== "unknown" && matchDistance < 0.4 && !detectedFaceLabels.has(bestMatch.label)) {
                const boundingBox = face.detection.box;
                new faceapi.draw.DrawBox(boundingBox, { label: bestMatch.toString() }).draw(tempCanvas);
                isFaceMatched = true;
                matchedLabel = bestMatch.label;
                detectedFaceLabels.add(bestMatch.label);

                // Pindahkan pengambilan data pegawai di sini untuk memastikan selalu diproses
                const employee = await getEmployeeDataByLabel(matchedLabel);
                if (employee) {
                  employeeData = employee;  // Simpan data pegawai jika ditemukan
                  employeeCode = employeeData.kode_pegawai;
                  employeeNik = employeeData.nik_pegawai;
                }
              }
            }

            if (isFaceMatched && employeeData && employeeCode) {
              // Fungsi untuk memastikan gambar sudah ditampilkan sebelum melanjutkan
              await new Promise((resolve) => {
                // Menunggu hingga gambar ter-render pada canvas
                canvasContext.clearRect(0, 0, overlay.width, overlay.height);
                canvasContext.drawImage(tempCanvas, 0, 0);
                requestAnimationFrame(() => resolve()); // Gunakan requestAnimationFrame untuk menunggu rendering selesai
              });

              // Setelah rendering selesai, lanjutkan dengan upload dan penambahan data
              const capturedImage = await captureImage();
              if (capturedImage) {
                await saveImageToServer(capturedImage, matchedLabel);
                await saveAttendance(employeeCode, employeeNik, employeeData);
                canvInfo.style.display = "block";
              } else {
                return showAlert('error', 'Terjadi kesalahan.', 'Gagal mengambil gambar.');
              }
            }

          } catch (error) {
            return showAlert('error', 'Terjadi kesalahan.', `Gagal mengambil gambar: ${error}`);
          }
        }, 2000);

        Swal.close();
      } catch (error) {
        return showAlert('error', 'Terjadi kesalahan.', `Gagal mengisialisasi face recognition: ${error}`);
      }
    }
  }

  async function saveImageToServer(image, label) {
    const formData = new FormData();

    // Menambahkan file gambar dan label ke FormData
    formData.append("image", image, "capturedImg.png");
    formData.append("label", label);

    try {
      startButton.innerText = 'Menyimpan gambar...';

      // Mengirim request POST untuk menyimpan gambar ke server
      const response = await axios.post(`${APP_URL}/api/saveImage`, formData);

      // Jika server merespons dengan status OK
      if (response.status === 200) {
        const data = response.data;

        // Jika URL gambar dikembalikan, tampilkan gambar di canvas
        if (data.imageUrl) {
          displayImageOnCanvas(data.imageUrl);
        }
      } else {
        return showAlert('error', 'Terjadi kesalahan.', 'Gagal menyimpan gambar.');
      }
    } catch (error) {
      return showAlert('error', 'Terjadi kesalahan.', `Terjadi kesalahan saat menyimpan gambar: ${error}`);
    }
  }

  async function saveAttendance(kodePegawai, nikPegawai) {
    try {
      startButton.innerText = "Menyimpan data...";

      // Cek status absensi
      const { data: checkData } = await axios.post(`${APP_URL}/api/check-attendance`, {
        kode_pegawai: kodePegawai,
        nik_pegawai: nikPegawai,
        longitude: lng,
        latitude: lat
      });

      const endpoint = checkData.hasClockedIn
        ? `${APP_URL}/store-attendance-out`
        : `${APP_URL}/store-attendance`;

      const payload = {
        kode_pegawai: kodePegawai,
        nik_pegawai: nikPegawai,
        longitude: lng,
        latitude: lat,
      };

      if (!checkData.hasClockedIn) {
        payload.jam_masuk = new Date().toISOString();
      }

      const { data: attendanceData } = await axios.post(endpoint, payload);

      if (attendanceData.success) {
        showAttendanceAlert();
      } else {
        return showAlert('error', 'Terjadi kesalahan.', attendanceData.message || 'Gagal menyimpan data absensi.');
      }

      // Sinkronisasi ke server pusat
      await axios.post(`${APP_URL}/api/proxy/server/attendance`, {
        kode_jari: kodePegawai,
      });

    } catch (error) {
      return showAlert('error', 'Terjadi kesalahan.', `Gagal memproses absensi: ${error.message || error}`);
    }
  }


  axios.get(`${APP_URL}/api/getPegawai/${kodePegawai}`)
    .then(response => {
      loadingAlert("Initializing application");
      labels.push(...response.data);
      initializeFaceAPI();
    })
    .catch(error => {
      return showAlert('error', 'Terjadi kesalahan.', `Terjadi kesalahan saat memuat data: ${error}`);
    });

  // Event listener untuk start button
  startButton.addEventListener("click", async () => {
    overlay.style.display = "block";
    canvInfo.style.display = "none";
    startButton.innerText = "Loading...";
    startButton.setAttribute("disabled", "disabled");

    try {
      const stream = await navigator.mediaDevices.getUserMedia({
        video: true,
        audio: false
      });
      video.srcObject = stream;
      videoStream = stream;
      webcamStarted = true;
      startFaceDetection();
    } catch (error) {
      return showAlert('error', 'Terjadi kesalahan.', `Terjadi kesalahan saat mengakses kamera: ${error}`);
    }
  });

  // Mengatur dimensi video dan overlay
  video.addEventListener("loadedmetadata", () => {
    video.width = video.videoWidth;
    video.height = video.videoHeight;
    overlay.width = video.width;
    overlay.height = video.height;
  });
}