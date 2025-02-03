let videoStream = null,
  webcamStarted = !1,
  detectionInterval = null;

const video = document.getElementById("video"),
  overlay = document.getElementById("overlay"),
  startButton = document.getElementById("startButton"),
  csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
  canvInfo = document.getElementById("canvAttend"),
  pegawaiKosong = document.getElementById("pegawaiKosong"),
  pegawaiInfo = document.getElementById("pegawaiInfo"),
  lokasi = "-",
  labels = [],
  originalConsoleLog = console.log,
  detectedFaces = new Set;

function initializeFaceAPI() {
  // Load necessary models from the specified URI
  Promise.all([
    faceapi.nets.ssdMobilenetv1.loadFromUri(`${APP_URL}/models`),       // Load SSD MobileNet model
    faceapi.nets.faceRecognitionNet.loadFromUri(`${APP_URL}/models`),   // Load Face Recognition model
    faceapi.nets.faceLandmark68Net.loadFromUri(`${APP_URL}/models`)     // Load Face Landmark model
  ])
    .then(() => {
      console.log("Models loaded successfully.");
    })
    .catch((error) => {
      console.error("Error loading FaceAPI models:", error);
    });
}

function stopFaceDetection() {
  if (detectionInterval) {
    clearInterval(detectionInterval); // Hentikan interval deteksi wajah
    detectionInterval = null; // Reset variabel interval
    console.log("Face detection has been stopped.");
  } else {
    console.log("Face detection is not active."); // Log jika interval sudah tidak berjalan
  }
}

function stopWebcam() {
  if (videoStream) {
    console.log("Stopping webcam...");

    // Hentikan deteksi wajah jika sedang aktif
    stopFaceDetection();

    // Hentikan semua track dari video stream
    videoStream.getTracks().forEach((track) => track.stop());

    // Hapus referensi stream dari elemen video
    video.srcObject = null;
    videoStream = null;

    // Perbarui status webcam
    webcamStarted = false;

    console.log("Webcam has been stopped successfully.");
  } else {
    console.log("No active webcam stream to stop.");
  }
}


function captureImage() {
  const canvas = document.createElement("canvas");

  // Set canvas dimensions to match the video dimensions
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;

  // Draw the current frame of the video onto the canvas
  canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);

  // Return a promise to handle the blob creation asynchronously
  return new Promise((resolve) => {
    canvas.toBlob((blob) => {
      resolve(blob || null); // Resolve with the blob or null if no blob is created
    }, "image/png");

    console.log("Image captured...");
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
      console.log("Image displayed successfully on the canvas.");
    };

    // Tindakan ketika gambar gagal dimuat
    image.onerror = () => {
      console.error("Failed to load image:", imageSource);
    };
  } else {
    console.error("Failed to get canvas context.");
  }
}

function customConsoleLog(message) {
  // Cari elemen output konsol di halaman
  const consoleOutputElement = document.getElementById("consoleOutput");

  if (consoleOutputElement) {
    // Tambahkan pesan log ke elemen
    consoleOutputElement.textContent += `${message}\n`;

    // Gulung tampilan ke bawah agar pesan terbaru terlihat
    consoleOutputElement.scrollTop = consoleOutputElement.scrollHeight;
  } else {
    console.error("Console output element not found.");
  }

  // Panggil metode asli untuk mencatat di konsol
  originalConsoleLog(message);
}

function displayPegawaiData(employeeData) {
  // Sembunyikan elemen "pegawaiKosong" karena data tersedia
  pegawaiKosong.style.display = "none";

  // Referensi elemen informasi pegawai
  const pegawaiInfoElement = pegawaiInfo;

  // Validasi keberadaan elemen informasi pegawai
  if (!pegawaiInfoElement) {
    console.error("Element with ID 'pegawaiInfo' not found");
    return;
  }

  // Tampilkan elemen informasi pegawai
  pegawaiInfoElement.style.display = "block";

  // Isi informasi pegawai
  pegawaiInfoElement.innerHTML = `
    <ul class="space-y-4 text-left text-gray-500">
        <li class="flex items-center space-x-3 rtl:space-x-reverse">
            <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
            </svg>
            <span>Lokasi: ${lokasi}</span>
        </li>
        <li class="flex items-center space-x-3 rtl:space-x-reverse">
            <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
            </svg>
            <span>Kode Pegawai: ${employeeData.kode_pegawai}</span>
        </li>
        <li class="flex items-center space-x-3 rtl:space-x-reverse">
            <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
            </svg>
            <span>NIK: ${employeeData.nik_pegawai}</span>
        </li>
        <li class="flex items-center space-x-3 rtl:space-x-reverse">
            <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
            </svg>
            <span>Nama: ${employeeData.full_name}</span>
        </li>
        <li class="flex items-center space-x-3 rtl:space-x-reverse">
            <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
            </svg>
            <span id="waktu-masuk">Waktu Masuk: </span>
        </li>
        <li class="flex items-center space-x-3 rtl:space-x-reverse">
            <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
            </svg>
            <span id="waktu-keluar">Waktu Keluar: </span>
        </li>
    </ul>`;
}

function updateJamMasuk() {
  // Mendapatkan waktu saat ini dengan format lokal Indonesia
  const currentTime = new Date().toLocaleString("id-ID", {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "numeric",
    minute: "numeric",
    second: "numeric",
    hour12: false,
    timeZone: "Asia/Jakarta"
  });

  // Mendapatkan elemen DOM dengan ID "waktu-masuk"
  const waktuMasukElement = document.getElementById("waktu-masuk");

  if (waktuMasukElement) {
    // Memperbarui konten elemen dengan waktu masuk
    waktuMasukElement.textContent = `Waktu Masuk: ${currentTime}`;
  } else {
    // Log kesalahan jika elemen tidak ditemukan
    console.error("Element with ID 'waktu-masuk' not found.");
  }
}

function updateJamKeluar() {
  // Mendapatkan waktu saat ini dengan format lokal Indonesia
  const currentTime = new Date().toLocaleString("id-ID", {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "numeric",
    minute: "numeric",
    second: "numeric",
    hour12: false,
    timeZone: "Asia/Jakarta"
  });

  // Mendapatkan elemen DOM dengan ID "waktu-keluar"
  const waktuKeluarElement = document.getElementById("waktu-keluar");

  if (waktuKeluarElement) {
    // Memperbarui konten elemen dengan waktu keluar
    waktuKeluarElement.textContent = `Waktu Keluar: ${currentTime}`;
  } else {
    // Log kesalahan jika elemen tidak ditemukan
    console.error("Element with ID 'waktu-keluar' not found.");
  }
}

function formatDatabaseDate(dateString) {
  // Membuat objek Date dari string tanggal yang diterima
  const date = new Date(dateString);

  // Memeriksa apakah tanggal valid
  if (isNaN(date)) {
    console.error("Invalid date string provided:", dateString);
    return null; // Mengembalikan null jika format tanggal tidak valid
  }

  // Mengembalikan tanggal dalam format lokal Indonesia
  return date.toLocaleString("id-ID", {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "numeric",
    minute: "numeric",
    second: "numeric",
    hour12: false,
    timeZone: "Asia/Jakarta"
  });
}

function showAttendanceAlert() {
  Swal.fire({
    title: "Sukses!",
    html: "Berhasil melakukan absensi.",
    timer: 1500,
    icon: "success",
    showConfirmButton: false
  }).then(() => {
    // Menampilkan elemen yang relevan setelah alert
    pegawaiKosong.style.display = "block";  // Menampilkan informasi pegawai kosong
    pegawaiInfo.style.display = "none";     // Menyembunyikan info pegawai yang sedang diproses
    canvInfo.style.display = "none";        // Menyembunyikan informasi canvas

    // Reload halaman untuk memulai proses baru
    location.reload();
  });
}

async function getEmployeeImagePaths(label) {
  try {
    // Fetch data from the server with the encoded label
    const response = await fetch(`${APP_URL}/api/pegawai-images/${encodeURIComponent(label)}`);

    // Check if the response was successful
    if (!response.ok) throw new Error("Network response was not ok");

    // Parse and return the JSON data
    return await response.json();
  } catch (error) {
    // Log error messages and return an empty array
    console.log("The folder for this employee is empty.");
    console.log("Please register their face first.");
    return [];
  }
}

async function getLabeledFaceDescriptions() {
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
        console.log("Fetching image paths...");
        if (detectedFace) {
          faceDescriptors.push(detectedFace.descriptor);
        }
      } catch (error) {
        // Log error if image processing fails
        console.error(`Error processing image ${imagePath}:`, error);
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
    const response = await fetch(`${APP_URL}/api/getPegawaiData/${encodeURIComponent(label)}`);

    // Check if the response is okay
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    // Return the response data as JSON
    return await response.json();
  } catch (error) {
    // Log the error and return null if the request fails
    console.error("Error fetching employee data:", error);
    return null;
  }
}

async function startFaceDetection() {
  if (!detectionInterval) {
    try {
      const labeledFaceDescriptors = await getLabeledFaceDescriptions();
      if (labeledFaceDescriptors.length === 0) {
        console.error("No labeled face descriptors found.");
        return;
      }

      const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors);
      const videoDimensions = { width: video.width, height: video.height };
      faceapi.matchDimensions(overlay, videoDimensions);

      const canvasContext = overlay.getContext("2d", { willReadFrequently: true });
      if (!canvasContext) {
        console.error("Failed to get canvas context.");
        return;
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
                displayPegawaiData(employeeData);  // Menampilkan data pegawai
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
              console.error("Failed to capture image");
            }
          }

        } catch (error) {
          console.error("Error during face detection or matching:", error);
        }
      }, 2000);

      console.log("Face detection started");
    } catch (error) {
      console.error("Error initializing face recognition:", error);
    }
  }
}

async function saveImageToServer(image, label) {
  const formData = new FormData();
  // Menambahkan file gambar dan label ke FormData
  formData.append("image", image, "capturedImg.png");
  formData.append("label", label);

  try {
    // Mengirim request POST untuk menyimpan gambar ke server
    const response = await fetch(`${APP_URL}/api/saveImage`, {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": csrfToken // Token CSRF untuk keamanan
      },
      body: formData
    });

    // Jika server merespons dengan status OK
    if (response.ok) {
      const data = await response.json();

      // Jika URL gambar dikembalikan, tampilkan gambar di canvas
      if (data.imageUrl) {
        displayImageOnCanvas(data.imageUrl);
        console.log("Image saved and displayed on canvas");
      }
    } else {
      console.error("Failed to save image");
    }
  } catch (error) {
    console.error("Error saving image:", error);
  }
}

async function saveAttendance(kodePegawai, nikPegawai, lokasi) {
  try {
    // Mengecek apakah pegawai sudah melakukan absensi masuk (clock-in)
    const response = await fetch(`${APP_URL}/api/check-attendance`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken
      },
      body: JSON.stringify({
        kode_pegawai: kodePegawai,
        nik_pegawai: nikPegawai,
        longitude: lng,
        latitude: lat
      })
    });
    const data = await response.json();

    // Jika pegawai sudah clock-in, proses clock-out
    if (data.hasClockedIn) {
      const jamMasuk = formatDatabaseDate(data.jam_masuk);
      document.getElementById("waktu-masuk").textContent = `Waktu Masuk: ${jamMasuk}`;
      updateJamKeluar();

      // Mengirim data absensi keluar (clock-out)
      const clockOutResponse = await fetch(`${APP_URL}/store-attendance-out`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({
          kode_pegawai: kodePegawai,
          nik_pegawai: nikPegawai,
          longitude: lng,
          latitude: lat
        })
      });
      const clockOutData = await clockOutResponse.json();

      // Jika absensi keluar berhasil
      if (clockOutData.success) {
        console.log(clockOutData.message);
        showAttendanceAlert();
      } else {
        console.error("Failed to record clock-out:", clockOutData.message);
      }
    } else {
      // Jika pegawai belum clock-in, catat jam masuk
      const currentTime = new Date();
      const formattedTime = currentTime.toLocaleString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
        second: "numeric",
        hour12: false,
        timeZone: "Asia/Jakarta"
      });

      document.getElementById("waktu-masuk").textContent = `Waktu Masuk: ${formattedTime}`;
      document.getElementById("waktu-keluar").textContent = "Jam Keluar: Belum ada data";

      // Mengirim data absensi masuk (clock-in)
      const clockInResponse = await fetch(`${APP_URL}/store-attendance`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({
          kode_pegawai: kodePegawai,
          nik_pegawai: nikPegawai,
          jam_masuk: currentTime.toISOString(),
          longitude: lng,
          latitude: lat
        })
      });
      const clockInData = await clockInResponse.json();

      // Jika absensi masuk berhasil
      if (clockInData.success) {
        console.log(clockInData.message);
        showAttendanceAlert();
      } else {
        console.error("Failed to record clock-in:", clockInData.message);
      }
    }

    const mainServerResponse = await fetch(`${APP_URL}/api/proxy/server/attendance`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken
      },
      body: JSON.stringify({
        kode_jari: kodePegawai,
      })
    }),
      mainServerData = await mainServerResponse.json();
    console.log("Server: " + mainServerData.message);
  } catch (error) {
    console.error("Error checking or saving attendance:", error);
  }
}

fetch(`${APP_URL}/api/getPegawai/${kodePegawai}`)
  .then(response => response.json())
  .then(data => {
    console.log("Initializing application");
    labels.push(...data);
    initializeFaceAPI();
  })
  .catch(error => console.error("Error fetching data", error));

// Custom console log
console.log = customConsoleLog;

canvInfo.style.display = "none";

// Event listener untuk start button
startButton.addEventListener("click", async () => {
  overlay.style.display = "block";
  canvInfo.style.display = "none";
  // startButton.setAttribute("disabled", "disabled");

  try {
    const stream = await navigator.mediaDevices.getUserMedia({
      video: true,
      audio: false
    });
    video.srcObject = stream;
    videoStream = stream;
    webcamStarted = true;
    console.log("Webcam started successfully");
    startFaceDetection();
  } catch (error) {
    console.error("Error accessing webcam:", error);
  }

});

// Mengatur dimensi video dan overlay
video.addEventListener("loadedmetadata", () => {
  video.width = video.videoWidth;
  video.height = video.videoHeight;
  overlay.width = video.width;
  overlay.height = video.height;
});
