<x-admin-layout pri_css="{{  asset('css/dashboard/main.css') }}" active="evenements">
    <x-slot:title>Créer un événement - ArchiSearch</x-slot>

    <div class="page-header">
        <div class="page-info">
            <div class="breadcrumb-small">Super Admin > Événements > Nouveau</div>
            <h1>Créer un nouvel événement</h1>
        </div>
        <div class="admin-info">
            <div class="avatar" style="width: 40px; height: 40px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar de {{ Auth::user()->name }}">
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

    <div class="form-container" style="max-width: 850px; background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-top: 20px;">
        <form action="{{ route('admin.events.store') }}" method="POST" id="createEventForm">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                
                {{-- Titre --}}
                <div class="form-group" style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Titre de l'événement</label>
                    <input type="text" name="title" placeholder="ex: Session de rattrapage DUT2" required 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                </div>

                {{-- Description --}}
                <div class="form-group" style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Description</label>
                    <textarea name="description" rows="2" placeholder="Description de l'événement..." required 
                              style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;"></textarea>
                </div>

                {{-- Dates --}}
                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Date de début</label>
                    <input type="date" name="start_date" required style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Date de fin</label>
                    <input type="date" name="end_date" required style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                </div>

                {{-- DOCUMENTS DYNAMIQUES (Depuis la BD) --}}
                <div class="form-group" style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Documents à fournir</label>
                    <select name="document_types[]" id="docs-select" class="js-basic-multiple" multiple="multiple" style="width: 100%;">
                        @foreach($documentTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->label }} (Max: {{ round($type->max_size_kb / 1024, 1) }} Mo)</option>
                        @endforeach
                    </select>
                </div>

                {{-- Type d'invitation --}}
                <div class="form-group" style="grid-column: span 2;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Type d'invitation</label>
                    <div style="display: flex; gap: 20px; background: #f8fafc; padding: 12px; border-radius: 8px;">
                        <label style="cursor: pointer;"><input type="radio" name="invite_type" value="tous" checked> Tous les étudiants</label>
                        <label style="cursor: pointer;"><input type="radio" name="invite_type" value="particuliers"> Sélection spécifique</label>
                    </div>
                </div>

                {{-- ÉTUDIANTS DYNAMIQUES (Depuis la BD) --}}
                <div class="form-group" id="students-selection-group" style="display: none; grid-column: span 2;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Étudiants autorisés</label>
                    <select name="invited_students[]" id="students-select" class="js-basic-multiple" multiple="multiple" style="width: 100%;">
                        @foreach($authorizedStudents as $student)
                            <option value="{{ $student->id }}">{{ $student->matricule }} - {{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                <button type="submit" class="btn-primary" style="background: #0369a1; color: white; border: none; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Confirmer la création
                </button>
            </div>
        </form>
    </div>

    {{-- Scripts --}}
    <script>
        $(document).ready(function () {
                // Initialisation Select2
                $('#docs-select').select2({ placeholder: "Sélectionner les types de documents" });
                $('#students-select').select2({ placeholder: "Chercher un étudiant..." });

                // Affichage dynamique du groupe de sélection des étudiants
                $('input[name="invite_type"]').on('change', function () {
                    if ($(this).val() === 'particuliers') {
                        $('#students-selection-group').fadeIn();
                    } else {
                        $('#students-selection-group').fadeOut();
                    }
                });

                // Envoi AJAX de création d'événement
                $('#createEventForm').on('submit', function (e) {
                    e.preventDefault();

                    const form = $(this);
                    const submitBtn = form.find('button[type="submit"]');

                    // 1. Afficher le loader ArchiSearch
                    ASAlerts.showLoading("Création de l'événement en cours...");
                    submitBtn.prop('disabled', true);

                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function (response) {
                            if (response.success) {
                                // 2. Alerte de succès avant redirection
                                ASAlerts.success("Événement créé avec succès !");
                                setTimeout(() => {
                                    window.location.href = response.redirect;
                                }, 1000);
                            }
                        },
                        error: function (xhr) {
                            submitBtn.prop('disabled', false);

                            // 3. Gestion d'erreur dynamique (si le contrôleur renvoie des erreurs de validation)
                            let errorMsg = "Vérifiez les champs du formulaire.";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }

                            ASAlerts.error("Échec de création", errorMsg);
                        }
                    });
                });
            });
    </script>
</x-admin-layout>