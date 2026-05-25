/**
 * Configuration globale des alertes ArchiSearch
 */
const ASAlerts = {
    // Configuration de base pour les petits messages (Toasts)
    toast: Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    }),

    // Message de succès rapide
    success: function (message) {
        this.toast.fire({
            icon: "success",
            title: message,
        });
    },

    // Message d'erreur avec blocage
    error: function (title, message) {
        Swal.fire({
            icon: "error",
            title: title || "Oups...",
            html: message,
            confirmButtonColor: "#2563eb",
        });
    },

    info: function (title, text) {
        Swal.fire({
            icon: "info",
            title: title,
            text: text,
            confirmButtonColor: "#2563eb",
        });
    },

    danger: function (title, text) {
        Swal.fire({
            icon: "info",
            title: title,
            text: text,
            confirmButtonColor: "#f84141",
        });
    },

    // Confirmation de suppression
    confirmDelete: function (callback) {
        Swal.fire({
            title: "Supprimer ce document ?",
            text: "Cette action est irréversible !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ef4444",
            cancelButtonColor: "#64748b",
            confirmButtonText: "Oui, supprimer",
            cancelButtonText: "Annuler",
        }).then((result) => {
            if (result.isConfirmed) {
                callback(); // On exécute l'action passée en paramètre
            }
        });
    },

    confirmAction: function (title, text, callback) {
        Swal.fire({
            title: title,
            text: text,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#0369a1", // Ton bleu super-admin
            cancelButtonColor: "#64748b",
            confirmButtonText: "Confirmer",
            cancelButtonText: "Annuler",
        }).then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    },

    // Loader pendant l'upload
    showLoading: function (text = "Traitement en cours...") {
        Swal.fire({
            title: "Un instant...",
            text: text,
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });
    },
};
