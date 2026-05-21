<x-admin-layout sec_css="{{ asset('css/profile/profile.css') }}" active="profil" title="Mon Profil">
    <div class="page-header">
        <div class="page-info">
            <div class="breadcrumb-small">Portail {{ ucfirst(Auth::user()->role) }} > Profil</div>
            <h1>Paramètres du profil</h1>
        </div>
        <div class="admin-info">
            <div class="avatar-base avatar-md">
                @if(Auth::user()->avatar_path)
                    <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}" alt="Avatar">
                @else
                    {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                @endif
            </div>
            <div class="flex-col-start">
                <span class="admin-name">{{ Auth::user()->name }}</span>
                <span class="admin-mail">{{ Auth::user()->role }}</span>
            </div>
        </div>
    </div>

    <div class="profile-container">
        @if(session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-card">
            @csrf
            @method('patch')

            <div class="profile-avatar-row">
                <div class="avatar-base avatar-lg">
                    @if(Auth::user()->avatar_path)
                        <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}" id="avatarPreview">
                    @else
                        <span>{{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}</span>
                    @endif
                </div>
                <div class="flex-col-start">
                    <h3 class="profile-section-title">Photo de profil</h3>
                    <input type="file" name="avatar" class="form-control" accept="image/*">
                    <span class="form-help">JPG, PNG ou GIF. Max 2Mo.</span>
                </div>
            </div>

            <div class="profile-grid">
                <div class="form-group">
                    <label class="form-label">Nom complet</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}">
                    @error('name') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Adresse Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}">
                    @error('email') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <hr class="profile-divider">

            <h3 class="profile-section-title">Sécurité</h3>
            <div class="profile-grid">
                <div class="form-group">
                    <label class="form-label">Nouveau mot de passe</label>
                    <input type="password" name="password" class="form-control">
                    @error('password') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>

            <div class="profile-actions">
                <button type="submit" class="btn-primary">Sauvegarder les modifications</button>
            </div>
        </form>
    </div>
</x-admin-layout>