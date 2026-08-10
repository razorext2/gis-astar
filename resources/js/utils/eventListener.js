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

    // livewire confirm delete — scoped per ID to prevent race condition
    Livewire.on("confirmDelete", (data) => {
        confirmationModal(
            "Apa kamu yakin?",
            `Kamu akan menghapus data dengan ID <b>${data.id}</b>`,
            "warning"
        ).then((result) => {
            if (result.isConfirmed) {
                // Dispatch scoped event so only the matching Delete component responds
                Livewire.dispatch(`confirmDeleteAction.${data.id}`, {
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
        const payload = Array.isArray(data) ? data[0] : (data && typeof data === 'object' && '0' in data ? data[0] : data);
        if (!payload) return;

        Swal.fire({
            icon: payload.icon ?? 'success',
            title: payload.title ?? '',
            html: payload.text ?? payload.html ?? '',
            showConfirmButton: payload.showConfirmButton ?? false,
            timer: payload.timer ?? payload.redirect?.delay ?? 2000,
        }).then(() => {
            const redirectUrl = payload.redirect?.url;
            if (redirectUrl && redirectUrl.trim() !== '') {
                if (typeof Livewire !== 'undefined' && typeof Livewire.navigate === 'function') {
                    Livewire.navigate(redirectUrl);
                } else {
                    window.location.href = redirectUrl;
                }
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
