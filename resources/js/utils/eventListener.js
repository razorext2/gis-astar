import { loadingAlert } from "./alert";

export async function initEventListener() {
    // swal deletion prompt
    const confirmationModal = (title, html, icon) => {
        return Swal.fire({
            title: title,
            html: html,
            icon: icon,
            showCancelButton: true,
            confirmButtonText: "Ya",
        });
    };

    // livewire confirm delete
    Livewire.on("confirmDelete", (data) => {
        confirmationModal(
            "Apa kamu yakin?",
            `Kamu akan menghapus data dengan ID <b>${data.id}</b>`,
            "warning"
        ).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch("confirmDeleteAction", {
                    id: data.id,
                });
            }
        });
    });

    // livewire bulk delete event
    Livewire.on("confirmBulkDelete", (data) => {
        confirmationModal(
            "Apa kamu yakin?",
            `Kamu akan menghapus data dengan ID <b>${data.id}</b>`,
            "warning"
        ).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch(`confirmBulkDeleteAction.${data.tableName}`, {
                    id: data.id,
                });
            }
        });
    });

    // livewire swal event
    Livewire.on("swal", (data) => {
        Swal.fire({
            icon: data.icon,
            title: data.title,
            html: data.text,
            showConfirmButton: false,
            timer: data.redirect?.delay ?? 3000,
        }).then(() => {
            if (data.redirect && data.redirect.url) {
                window.location.href = data.redirect.url;
            }
        });
    });

    Livewire.on("confirmation", (data) => {
        confirmationModal(
            "Apa kamu yakin?",
            `Kamu akan memverifikasi data dengan ID <b>${data.id}</b>`,
            "warning"
        ).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch(`${data.action}.${data.tableName}`, {
                    id: data.id,
                    tableName: data.tableName,
                });
            }
        });
    });

    Livewire.on("loadingProgress", (data) => {
        loadingAlert(data.message);
    });

    Livewire.on("loadingClose", () => {
        window.Swal.close();
    });
}
