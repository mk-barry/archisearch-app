<x-profil-layout title="Mon Profil">
<div class="page-header">
        <div class="page-info">
            <h1>Paramètres du profil</h1>
        </div>
        <div class="admin-info">
            <div class="avatar" style="width: 50px; height: 50px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
                @if(Auth::user()->avatar_path)
                    <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}" alt="Avatar de {{ Auth::user()->name }}"  style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid #1e3a8a;">
                @else
                    <!-- <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar par défaut"> -->
                    {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                @endif
            </div>
            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                <span class="admin-name">{{ Auth::user()->name }}</span>
                <span class="admin-mail">{{ Auth::user()->role }}</span>
            </div>
        </div>
    </div>
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 2rem;">
        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif

        <div class="card"
            style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div
                    style="display: flex; align-items: center; gap: 2rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #e5e7eb;">
                    <div class="avatar" style="width: 70px; height: 70px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1; position: relative;">
                            @if(Auth::user()->avatar_path)
                            <img src="{{ $user->avatar_path ? asset('storage/' . $user->avatar_path) : ''}}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid #1e3a8a;">
                            @else
                                <!-- <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar par défaut"> -->
                                {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                            @endif
                    </div>
                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Changer la
                            photo</label>
                        <input type="file" name="avatar" class="form-control" style="font-size: 0.9rem;">
                        <small style="color: #6b7280; display: block; mt-1">JPG, PNG (Max 2Mo)</small>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Nom complet</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 8px;">
                        @error('name') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Adresse Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 8px;">
                        @error('email') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 2rem 0;">

                <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Sécurité (Laisser vide pour ne pas modifier)</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Nouveau mot de
                            passe</label>
                        <input type="password" name="password"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 8px;">
                        @error('password') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Confirmer le mot de
                            passe</label>
                        <input type="password" name="password_confirmation"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 8px;">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit"
                        style="background: #1e3a8a; color: white; padding: 0.75rem 2rem; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
                        Sauvegarder les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-profil-layout>