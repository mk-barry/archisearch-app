<x-super-admin-layout active="administrateurs" sec_css="forms.css">
    <x-slot:title>Ajouter un administrateur - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="page-info">
                <div class="breadcrumb-small">Super Admin > Administrateurs > Nouveau</div>
                <h1>Créer un nouvel administrateur</h1>
            </div>
            <div class="admin-info header">
                <div class="avatar-base avatar-md">
                    @if(Auth::user()->avatar_path)
                        <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}" alt="Avatar">
                    @else
                        {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}
                    @endif
                </div>
                <div class="flex-col-start">
                    <span class="admin-name">{{ Auth::user()->name }}</span>
                    <span class="admin-mail">{{ Auth::user()->role }}</span>
                </div>
            </div>
        </div>

        <div class="form-container">

            <form action="{{ route('users.store') }}" method="POST" id="createAdminForm">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label clas="form-label">Nom complet</label>
                        <input type="text" name="name" placeholder="ex: Pierre Dupont" required class="form-input">
                        @error('name') <span style="color: red; font-size: 0.8rem;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label clas="form-label">Adresse Email</label>
                        <input type="email" name="email" placeholder="p.dupont@admin.gouv" required class="form-input">
                        @error('email') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label clas="form-label">Role</label>
                        <select name="role" id="role" class="form-control" class="form-select">

                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ old('role', 'admin') === $role ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('-', ' ', $role)) }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group">
                        <label clas="form-label">Mot de passe</label>
                        <input type="password" name="password" required class="form-input">
                        @error('password') <span style="color: red; font-size: 0.8rem;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-footer">
                    <a href="{{ route('users.index') }}" class="btn-outline">
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12l5 5L20 7" />
                        </svg>
                        Confirmer la création
                    </button>
                </div>
            </form>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", () => {

                const form = document.getElementById("createAdminForm");

                form.addEventListener("submit", function (e) {

                    e.preventDefault();

                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json"
                        },
                        body: formData
                    })
                        .then(res => res.json())
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
                            console.error(error);

                            Swal.fire({
                                icon: "error",
                                title: "Erreur",
                                text: "Une erreur est survenue."
                            });
                        });

                });

            });
        </script>
</x-super-admin-layout>