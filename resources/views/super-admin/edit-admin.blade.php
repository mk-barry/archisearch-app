<x-super-admin-layout active="administrateurs">
    <x-slot:title>Modifier l'administrateur - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="page-info">
                <div class="breadcrumb-small">Super Admin > Administrateurs > Modifier</div>
                <h1>Modifier le profil de {{ $user->name }}</h1>
            </div>
            <div class="admin-info">
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

        <div class="form-container"
            style="max-width: 800px; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">

            <form id="editAdminForm" action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- CRUCIAL : HTML ne supporte pas PUT, Laravel le simule ici --}}

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Nom complet</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
                        @error('name') <span style="color: red; font-size: 0.8rem;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Adresse Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
                        @error('email') <span style="color: red; font-size: 0.8rem;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Organisation /
                            Direction</label>
                        <input type="text" name="organisation" value="{{ old('organisation', $user->organisation) }}"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Role</label>
                        <select name="role" id="role" class="form-control"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('-', ' ', $role)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">Mot de passe</label>
                    <input type="password" name="password" placeholder="Laisser vide pour ne pas changer"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;">
                    <small style="color: #64748b;">Ne remplir que pour modifier le mot de passe actuel.</small>
                </div> -->
                </div>

                <div
                    style="margin-top: 30px; display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                    <a href="{{ route('super-admin.administrateurs') }}" class="btn-outline"
                        style="text-decoration: none; display: flex; align-items: center;">
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary"
                        style="cursor: pointer; border: none; display: flex; align-items: center; gap: 8px; background-color: #0369a1;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {

                const form = document.getElementById("editAdminForm");

                form.addEventListener("submit", function (e) {

                    e.preventDefault();

                    const formData = new FormData(form);

                    // 🔥 TRÈS IMPORTANT
                    formData.append('_method', 'PUT');

                    fetch(form.action, {
                        method: "POST", // ← Laravel attend POST spoofé
                        headers: {
                            "X-CSRF-TOKEN":
                                document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json"
                        },
                        body: formData
                    })
                        .then(res => res.json())
                        .then(data => {

                            if (data.success) {
                                window.location.href = data.redirect;
                            }

                        })
                        .catch(err => console.error(err));

                });

            });
        </script>
</x-super-admin-layout>