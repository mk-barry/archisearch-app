<x-super-admin-layout active="evenements">
    <x-slot:title>Autoriser un étudiant - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="page-info">
                <div class="breadcrumb-small">Super Admin > Étudiants > Nouveau</div>
                <h1>Autoriser un nouvel étudiant</h1>
            </div>
            <div class="admin-info">
                <div class="avatar"
                    style="width: 40px; height: 40px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
                    @else
                        {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                    @endif
                </div>
                <div style="display: flex; flex-direction: column; align-items: flex-start;">
                    <span class="admin-name">{{ Auth::user()->name }}</span>
                    <span class="admin-mail">{{ Auth::user()->role }}</span>
                </div>
            </div>
        </div>

        <div class="form-container"
            style="max-width: 800px; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">

            <form action="{{ route('super-admin.students.store') }}" method="POST" id="createStudentForm">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Matricule /
                            Identifiant</label>
                        <input type="text" name="matricule" placeholder="ex: 22B567" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Nom complet</label>
                        <input type="text" name="name" placeholder="ex: Jean Dupont" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Adresse Email
                            (Optionnelle)</label>
                        <input type="email" name="email" placeholder="j.dupont@univ.com"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
                    </div>
                </div>

                <div
                    style="margin-top: 30px; display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                    <a href="{{ route('admin.evenements') }}" class="btn-outline"
                        style="text-decoration: none; display: flex; align-items: center;">
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary"
                        style="cursor: pointer; border: none; display: flex; align-items: center; gap: 8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <line x1="19" y1="8" x2="19" y2="14" />
                            <line x1="16" y1="11" x2="22" y2="11" />
                        </svg>
                        Autoriser l'étudiant
                    </button>
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const form = document.getElementById("createStudentForm");

                form.addEventListener("submit", function (e) {
                    e.preventDefault();
                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                            "Accept": "application/json"
                        },
                        body: formData
                    })
                        .then(async res => {
                            const data = await res.json();
                            if (!res.ok) {
                                // Gestion des erreurs de validation (422)
                                let errorMsg = data.message;
                                if (data.errors) errorMsg = Object.values(data.errors).flat().join("<br>");
                                throw new Error(errorMsg);
                            }
                            return data;
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Succès",
                                    text: data.message,
                                    confirmButtonColor: "#2563eb"
                                }).then(() => {
                                    window.location.href = data.redirect;
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: "error",
                                title: "Erreur",
                                html: error.message || "Une erreur est survenue."
                            });
                        });
                });
            });
        </script>
</x-super-admin-layout>