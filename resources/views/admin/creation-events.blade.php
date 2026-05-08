<x-admin-layout active="evenements">
    <x-slot:title>Ajouter un administrateur - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="page-info">
                <div class="breadcrumb-small">Super Admin > Administrateurs > Nouveau</div>
                <h1>Créer un nouvel administrateur</h1>
            </div>
            <div class="admin-info">
                <div class="avatar"
                    style="width: 40px; height: 40px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
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
        </div>

        <div class="form-container"
            style="max-width: 800px; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">

            <form action="{{ route('admin.events.store') }}" method="POST" id="createEventForm">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Titre de l'événement</label>
                        <input type="text" name="title" placeholder="ex: Collecte Diplômes 2026" required style="...">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" placeholder="Description courte..." required style="...">
                    </div>

                    <div class="form-group">
                        <label>Date de début</label>
                        <input type="date" name="start_date" required style="...">
                    </div>

                    <div class="form-group">
                        <label>Date de fin</label>
                        <input type="date" name="end_date" required style="...">
                    </div>

                    <!-- <div class="form-group">
                        <label>Documents à fournir (séparés par virgules)</label>
                        <input type="text" name="required_docs" placeholder="ex: CNI, Diplôme, Attestation" style="...">
                    </div> -->

                    <div class="form-group" style="grid-column: span 2;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Documents à fournir</label>
                        <select name="required_docs[]" id="docs-select" class="js-basic-multiple" multiple="multiple" style="width: 100%;">
                            <option value="cni">Carte Nationale d'Identité (CNI)</option>
                            <option value="passeport">Passeport</option>
                            <option value="diplome">Diplôme (Bac / Licence)</option>
                            <option value="attestation">Attestation de réussite</option>
                            <option value="photo">Photo d'identité</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Invités</label><br>
                        <input type="radio" name="invite_type" value="tous" checked> Tous
                        <input type="radio" name="invite_type" value="particuliers" style="margin-left:15px;">
                        Particuliers
                    </div>

                    <div class="form-group" id="students-selection-group" style="display: none; grid-column: span 2; margin-top: 15px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Sélectionner les étudiants autorisés</label>
                        <select name="invited_students[]" id="students-select" class="js-basic-multiple" multiple="multiple"
                            style="width: 100%;">
                            @foreach($AuthorizedStudent as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->matricule }} - {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                        <small style="color: #64748b;">Seuls ces étudiants pourront s'identifier pour cet événement.</small>
                    </div>
                </div>

                <div style="margin-top: 30px; display: flex; gap: 12px; justify-content: flex-end;">
                    <button type="submit" class="btn-primary">Confirmer la création</button>
                </div>
            </form>
        </div>
        <script>
            $(document).ready(function () {
                $('#docs-select').select2({
                    placeholder: "Sélectionner un ou plusieurs documents",
                    tags: true, // Permet d'ajouter un document personnalisé s'il n'est pas dans la liste
                    tokenSeparators: [',']
                });
            });

            $(document).ready(function() {
                // 1. Initialisation Select2 pour les étudiants
                $('#students-select').select2({
                    placeholder: "Chercher par matricule ou nom...",
                    allowClear: true,
                    width: '100%'
                });

                // 2. Gestion de l'affichage dynamique
                $('input[name="invite_type"]').on('change', function() {
                    if ($(this).val() === 'particuliers') {
                        $('#students-selection-group').fadeIn();
                    } else {
                        $('#students-selection-group').fadeOut();
                        // Optionnel : vider la sélection si on repasse sur "Tous"
                        $('#students-select').val(null).trigger('change');
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#createEventForm').on('submit', function (e) {
                    e.preventDefault(); // Empêche le rechargement de la page

                    const form = $(this);
                    const submitBtn = form.find('button[type="submit"]');

                    // On désactive le bouton pour éviter les doubles clics
                    submitBtn.prop('disabled', true).text('Enregistrement...');

                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.success) {
                                // Redirection vers la liste des événements
                                window.location.href = "{{ route('admin.evenements') }}";
                            }
                        },
                        error: function (xhr) {
                            submitBtn.prop('disabled', false).text('Créer l\'événement');

                            // Si Laravel renvoie une erreur de validation (422)
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                let message = "Erreur de validation :\n";
                                $.each(errors, function (key, value) {
                                    message += "- " + value[0] + "\n";
                                });
                                alert(message);
                            } else {
                                alert("Une erreur est survenue lors de l'enregistrement.");
                            }
                        }
                    });
                });
            });
        </script>
</x-admin-layout>