import { capturedImages } from "../../../utils/cameraStream"; // import capturedImages array
import { showAlert, loadingAlert } from "../../../utils/alert";
import Swal from "sweetalert2";
import axios from "axios";

export function editDataHandler() {
    const storeButton = document.getElementById("store");

    if (!storeButton) return;

    storeButton.addEventListener("click", async (e) => {
        e.preventDefault();

        storeButton.setAttribute("disabled", "disabled");
        loadingAlert("Menyimpan data...");

        const idElement = document.getElementById("id");
        const id = idElement ? idElement.value : null;

        const paymentAmountVal =
            document.getElementById("payment_amount")?.value || "0";
        const remainVal = document.getElementById("remain")?.value || "0";

        if (parseFloat(paymentAmountVal) > parseFloat(remainVal)) {
            storeButton.removeAttribute("disabled");
            Swal.close();
            return showAlert(
                "error",
                "Gagal melakukan update",
                "<b>Total bayar</b> tidak boleh melebihi <b>sisa tagihan</b>.",
            );
        }

        const formData = new FormData();
        formData.append("title", document.getElementById("title")?.value || "");
        formData.append(
            "keterangan",
            document.getElementById("keterangan")?.value || "",
        );
        formData.append(
            "location",
            document.getElementById("location")?.value || "",
        );
        formData.append(
            "latitude",
            document.getElementById("latitude")?.value || "",
        );
        formData.append(
            "longitude",
            document.getElementById("longitude")?.value || "",
        );
        formData.append(
            "have_paid",
            document.getElementById("have_paid")?.value || "0",
        );
        formData.append(
            "payment_type",
            document.getElementById("payment_type")?.value || "",
        );
        formData.append("payment_amount", paymentAmountVal);
        formData.append(
            "no_giro",
            document.getElementById("no_giro")?.value || "",
        );
        formData.append("_method", "PATCH");

        // Convert dataURI to Blob directly using native JS (Fast & Synchronous)
        for (let i = 0; i < capturedImages.length; i++) {
            const blob = dataURItoBlob(capturedImages[i]);
            formData.append("images[]", blob, `image${i}.png`);
        }

        try {
            const response = await axios.post(
                `/api/collect-api/${id}`,
                formData,
            );

            if (response.data.success) {
                Swal.close();
                showAlert("success", response.data.message);
                setTimeout(() => {
                    window.location.href = `/dashboard/collect`;
                }, 1500);
            } else {
                Swal.close();
                const responseData = response.data.data;
                const firstErrorKey = Object.keys(responseData)[0];
                const firstError = responseData[firstErrorKey][0];

                handleFormErrors(responseData);
                storeButton.removeAttribute("disabled");

                return showAlert(
                    "error",
                    response.data.message,
                    `Validasi data gagal. <br><b>${firstError}</b>`,
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

            return showAlert(
                "error",
                "Terjadi kesalahan.",
                error.message || "Gagal menghubungi server",
            );
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
