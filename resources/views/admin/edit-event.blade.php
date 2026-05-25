<x-admin-layout pri_css="{{  asset('css/dashboard/main.css') }}" active="evenements">
    <x-slot:title>Modifier l'événement - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="page-info">
                <div class="breadcrumb-small">Super Admin > Événements > Modifier</div>
                <h1>Modifier : {{ $event->title }}</h1>
            </div>
            <div class="admin-info">
                <div class="avatar" style="width: 40px; height: 40px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar de {{ Auth::user()->name }}">
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
            style="max-width: 800px; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin: 0 auto;">
            <form id="editEventForm" action="{{ route('admin.evenements.update', $event->uuid) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group" style="grid-column: span 2;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Titre de
                            l'événement</label>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Description</label>
                        <textarea name="description" rows="3"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;">{{ old('description', $event->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Date de début</label>
                        <input type="date" name="start_date"
                            value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Date de fin</label>
                        <input type="date" name="end_date"
                            value="{{ old('end_date', $event->end_date->format('Y-m-d')) }}" required
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Type d'invitation</label>
                        <select name="invite_type"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                            <option value="tous" {{ $event->invite_type == 'tous' ? 'selected' : '' }}>Tous les étudiants
                            </option>
                            <option value="particuliers" {{ $event->invite_type == 'particuliers' ? 'selected' : '' }}>
                                Sélection spécifique</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Statut</label>
                        <select name="status"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                            <option value="actif" {{ $event->status == 'actif' ? 'selected' : '' }}>Actif</option>
                            <option value="cloture" {{ $event->status == 'cloture' ? 'selected' : '' }}>Cloturé</option>
                            <option value="archive" {{ $event->status == 'archive' ? 'selected' : '' }}>Archivé</option>
                            <option value="brouillon" {{ $event->status == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                        </select>
                    </div>
                </div>

                <div
                    style="margin-top: 30px; display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                    <a href="{{ route('admin.evenements') }}" class="btn-primary">Annuler</a>
                    <button type="submit" class="btn-primary"
                        style="background-color: #0369a1; display: flex; align-items: center; gap: 8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
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
            document.getElementById("editEventForm").addEventListener("submit", function (e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);
                formData.append('_method', 'PUT');

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
                            // Au lieu de rediriger, on peut retourner à la liste et laisser le message flash
                            window.location.href = "{{ route('admin.evenements') }}";
                        }
                    })
                    .catch(err => console.error(err));
            });
        </script>
</x-admin-layout>