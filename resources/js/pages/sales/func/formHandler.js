import { capturedImages } from "../../../utils/cameraStream";
import { showAlert, loadingAlert } from "../../../utils/alert";
import Swal from "sweetalert2";
import axios from "axios";

export function addDataHandler() {
    const storeButton = document.getElementById("store");

    if (!storeButton) return;

    storeButton.addEventListener("click", async (e) => {
        e.preventDefault();

        storeButton.setAttribute("disabled", "disabled");
        loadingAlert("Menyimpan...");

        const formData = new FormData();

        formData.append(
            "kode_pegawai",
            document.getElementById("kode_pegawai")?.value || "",
        );
        formData.append("title", document.getElementById("title")?.value || "");
        formData.append(
            "customer_name",
            document.getElementById("customer_name")?.value || "",
        );
        formData.append(
            "customer_telp",
            document.getElementById("customer_telp")?.value || "",
        );
        formData.append(
            "keterangan",
            document.getElementById("keterangan")?.value || "",
        );
        formData.append(
            "lokasi",
            document.getElementById("lokasi")?.value || "",
        );
        formData.append(
            "latitude",
            document.getElementById("latitude")?.value || "",
        );
        formData.append(
            "longitude",
            document.getElementById("longitude")?.value || "",
        );

        // Convert dataURI to Blob directly using native JS (Fast & Synchronous)
        for (let i = 0; i < capturedImages.length; i++) {
            const blob = dataURItoBlob(capturedImages[i]);
            formData.append("images[]", blob, `image${i}.png`);
        }

        try {
            const response = await axios.post(`/api/sales-api`, formData);

            if (response.data.success) {
                Swal.close();
                showAlert("success", response.data.message);
                setTimeout(
                    () => (window.location.href = `/dashboard/sales`),
                    1500,
                );
            } else {
                Swal.close();
                storeButton.removeAttribute("disabled");

                const responseData = response.data.data;
                handleFormErrors(responseData);

                let err = null;
                if (typeof responseData === "object" && responseData !== null) {
                    const firstKey = Object.keys(responseData)[0];
                    if (firstKey && Array.isArray(responseData[firstKey])) {
                        err = responseData[firstKey][0];
                    }
                } else {
                    err = responseData;
                }
                return showAlert(
                    "error",
                    response.data.message,
                    `Validasi data gagal. <br><b>${err || ""}</b>`,
                );
            }
        } catch (error) {
            Swal.close();
            storeButton.removeAttribute("disabled");

            if (
                error.response &&
                error.response.data &&
                error.response.data.errors
            ) {
                handleFormErrors(error.response.data.errors);
            }

            console.error("Error:", error);
            return showAlert(
                "error",
                "Terjadi kesalahan.",
                error.message || "Gagal menghubungi server",
            );
        }
    });
}

export function editDataHandler() {
    const storeButton = document.getElementById("store");

    if (!storeButton) return;

    storeButton.addEventListener("click", async (e) => {
        e.preventDefault();

        storeButton.setAttribute("disabled", "disabled");
        loadingAlert("Menyimpan...");

        const id = document.getElementById("id")?.value;
        const payload = {
            id: id,
            title: document.getElementById("title")?.value || "",
            customer_name:
                document.getElementById("customer_name")?.value || "",
            customer_telp:
                document.getElementById("customer_telp")?.value || "",
            lokasi: document.getElementById("lokasi")?.value || "",
            keterangan: document.getElementById("keterangan")?.value || "",
        };

        try {
            const response = await axios.patch(`/api/sales-api/${id}`, payload);

            Swal.close();
            showAlert("success", response.data.message);
            setTimeout(() => (window.location.href = `/dashboard/sales`), 1500);
        } catch (error) {
            Swal.close();
            storeButton.removeAttribute("disabled");

            if (
                error.response &&
                error.response.data &&
                error.response.data.errors
            ) {
                handleFormErrors(error.response.data.errors);
            }
            console.error("Error:", error);
        }
    });
}

function handleFormErrors(errors) {
    if (typeof errors === "object") {
        Object.entries(errors).forEach(([field, errorMessages]) => {
            const alertElement = document.getElementById(`alert-${field}`);

            if (alertElement) {
                if (errorMessages && errorMessages.length > 0) {
                    alertElement.classList.remove("hidden");
                    alertElement.innerHTML = errorMessages[0];
                } else {
                    alertElement.classList.remove("block");
                    alertElement.classList.add("hidden");
                }
            }
        });
    }
}

/**
 * Fast synchronous Base64 string to Blob converter
 * Menghilangkan latensi dari axios interceptors
 */
function dataURItoBlob(dataURI) {
    const byteString = atob(dataURI.split(",")[1]);
    const mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];

    const arrayBuffer = new ArrayBuffer(byteString.length);
    const int8Array = new Uint8Array(arrayBuffer);

    for (let i = 0; i < byteString.length; i++) {
        int8Array[i] = byteString.charCodeAt(i);
    }

    return new Blob([arrayBuffer], { type: mimeString });
}
