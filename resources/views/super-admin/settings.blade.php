<x-super-admin-layout active="parametres">
    <x-slot:title>Paramètres globaux - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="page-info">
                <div class="breadcrumb-small">Super Admin > Paramètres globaux</div>
                <h1>Paramètres globaux du système</h1>
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

        <div class="settings-grid">
            <!-- Left Column: Types de documents -->
            <div class="dashboard-card">
                <div class="card-title">
                    Types de documents & OCR
                    <button onclick="openCreateModal()" class="btn-primary"
                        style="padding: 0.5rem 1rem; font-size: 0.8rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="3">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Nouveau Type
                    </button>
                </div>

                <div class="category-list">
                    @foreach($documentTypes as $type)
                        <div class="category-item">
                            <div class="category-icon" style="background: #f0fdf4; color: #16a34a;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-weight: 700;">{{ $type->label }}</span>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <span style="font-size: 0.85rem; color: #94a3b8;">{{ $type->documents_count }}
                                            docs</span>
                                        <button class="action-btn edit-doc-type-btn" data-id="{{ $type->id }}"
                                            data-label="{{ $type->label }}" data-code="{{ $type->code }}"
                                            data-max-size="{{ round($type->max_size_kb / 1024) }}"
                                            data-min-score="{{ $type->validation_rules['min_score'] ?? 1 }}"
                                            data-required-keywords="{{ implode(', ', $type->validation_rules['required_keywords'] ?? []) }}"
                                            data-forbidden-keywords="{{ implode(', ', $type->validation_rules['forbidden_keywords'] ?? []) }}"
                                            data-required-metadata="{{ implode(', ', $type->validation_rules['required_metadata'] ?? []) }}"
                                            data-expiry-patterns="{{ implode(', ', $type->validation_rules['expiry_patterns'] ?? []) }}"
                                            data-is-perishable="{{ $type->is_perishable ? 1 : 0 }}"
                                            data-extensions='@json($type->allowedExtensions->pluck("id"))'><svg width="14"
                                                height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                            </svg></button>
                                    </div>
                                </div>
                                <span style="font-size: 0.75rem; italic;">Mots a rechercher</span><br>
                                <div class="tag-list">
                                    @if(isset($type->validation_rules['required_keywords']))
                                        @foreach($type->validation_rules['required_keywords'] as $rkw)
                                            <span class="tag" style="background: #f1f5f9; color: #475569;">{{ $rkw }}</span>
                                        @endforeach
                                    @else
                                        <span style="font-size: 0.75rem; color: #cbd5e1; italic;">Aucun mot-clé configuré</span>
                                    @endif
                                </div>

                                <span style="font-size: 0.75rem; italic;">Mots interdits</span><br>
                                <div class="tag-list">
                                    @if(isset($type->validation_rules['forbidden_keywords']))
                                        @foreach($type->validation_rules['forbidden_keywords'] as $fkw)
                                            <span class="tag" style="background: #f1f5f9; color: #475569;">{{ $fkw }}</span>
                                        @endforeach
                                    @else
                                        <span style="font-size: 0.75rem; color: #cbd5e1; italic;">Aucun mot-clé configuré</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <pre>
Store: {{ route('super-admin.document-types.store') }}
Settings: {{ route('super-admin.settings') }}
</pre>

            <!-- Modal simple pour l'ajout (à mettre en bas de page) -->
            <div id="modal-add-type"
                style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center; padding: 20px;">
                <div class="dashboard-card" style="width: 550px; background:white; max-height: 90vh; overflow-y: auto;">
                    <div class="card-title" id="modal-title">Configurer un nouveau type de document</div>

                    <form id="doc-type-form" action="/super-admin/store-doc-type" method="POST">
                        @csrf
                        <div id="method-container"></div>
                        <div style="display:flex; flex-direction:column; gap:1.2rem; margin-top:1rem;">

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div>
                                    <label style="font-size:0.85rem; font-weight: 700;">Libellé complet</label>
                                    <input type="text" id="label" name="label" placeholder="ex: Diplôme de Licence"
                                        required
                                        style="width:100%; padding:0.6rem; border:1px solid #ddd; border-radius:8px; margin-top: 5px;">
                                </div>
                                <div>
                                    <label style="font-size:0.85rem; font-weight: 700;">Code (Unique)</label>
                                    <input type="text" id="code" name="code" placeholder="ex: LICENCE_DIP" required
                                        style="width:100%; padding:0.6rem; border:1px solid #ddd; border-radius:8px; margin-top: 5px;">
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div>
                                    <label style="font-size:0.85rem; font-weight: 700;">Taille Max (Mo)</label>
                                    <input type="number" id="max_size_mb" name="max_size_mb" value="5" required
                                        style="width:100%; padding:0.6rem; border:1px solid #ddd; border-radius:8px; margin-top: 5px;">
                                </div>
                                <div>
                                    <label style="font-size:0.85rem; font-weight: 700;">Score OCR Min.</label>
                                    <input type="number" id="min_score" name="min_score" value="2" required
                                        style="width:100%; padding:0.6rem; border:1px solid #ddd; border-radius:8px; margin-top: 5px;">
                                </div>
                            </div>

                            <div>
                                <label style="font-size:0.85rem; font-weight: 700;">Formats autorisés</label>
                                <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 8px;">
                                    @foreach($fileExtensions as $ext)
                                        <label
                                            style="display: flex; align-items: center; gap: 5px; background: #f8fafc; padding: 5px 10px; border-radius: 6px; cursor: pointer; border: 1px solid #e2e8f0;">
                                            <input type="checkbox" name="extensions[]" value="{{ $ext->id }}">
                                            <span
                                                style="font-size: 0.8rem; font-weight: 600;">{{ strtoupper($ext->name) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <span style="font-size:0.85rem; font-weight: 700;">Pour les informations suivates.
                                    (Séparés par des virgules)</span>
                                <!-- <textarea name="keywords" placeholder="republique, ministere, diplome, session, decerne..." style="width:100%; padding:0.6rem; border:1px solid #ddd; border-radius:8px; height:80px; margin-top: 5px; font-family: sans-serif;"></textarea>
                                <small style="color: #94a3b8; font-size: 0.75rem;">Ces mots seront recherchés par le script Python pour valider l'authenticité.</small> -->
                            </div>

                            <div>
                                <label style="font-size:0.85rem; font-weight:700;">
                                    Mots requis
                                </label>

                                <textarea id="required_keywords" name="required_keywords"
                                    placeholder="baccalauréat, baccalau, diplôme..."
                                    style="width:100%; padding:0.6rem; border:1px solid #ddd; border-radius:8px; height:70px; margin-top:5px;"></textarea>

                                <small style="color:#94a3b8;">
                                    Si absents, le document sera considéré comme suspect.
                                </small>
                            </div>

                            <div>
                                <label style="font-size:0.85rem; font-weight:700;">
                                    Mots interdits
                                </label>

                                <textarea id="forbidden_keywords" name="forbidden_keywords"
                                    placeholder="probatoire, specimen..."
                                    style="width:100%; padding:0.6rem; border:1px solid #ddd; border-radius:8px; height:70px; margin-top:5px;"></textarea>

                                <small style="color:#94a3b8;">
                                    Si détectés, le document sera immédiatement flagué.
                                </small>
                            </div>

                            <div>
                                <label style="font-size:0.85rem; font-weight:700;">
                                    Champs obligatoires
                                </label>

                                <textarea id="required_metadata" name="required_metadata"
                                    placeholder="jury, mention, student_name..."
                                    style="width:100%; padding:0.6rem; border:1px solid #ddd; border-radius:8px; height:70px; margin-top:5px;"></textarea>

                                <small style="color:#94a3b8;">
                                    Si un champ est absent après extraction OCR, le document sera signalé.
                                </small>
                            </div>

                            <div style="display:flex; align-items:center; gap:10px;">
                                <input type="checkbox" id="is_perishable" name="is_perishable" value="1"
                                    id="is_perishable">

                                <label for="is_perishable" style="font-weight:700;">
                                    Document expirable
                                </label>
                            </div>

                            <div>
                                <label style="font-size:0.85rem; font-weight:700;">
                                    Regex date d'expiration
                                </label>

                                <textarea id="expiry_patterns" name="expiry_patterns" placeholder="expire le..."
                                    style="width:100%; padding:0.6rem; border:1px solid #ddd; border-radius:8px; height:70px; margin-top:5px;"></textarea>
                            </div>

                            <div
                                style="display:flex; justify-content:flex-end; gap:1rem; padding-top: 10px; border-top: 1px solid #f1f5f9;">
                                <button type="button" onclick="closeCreateModal()" class="btn-outline">Annuler</button>
                                <button type="submit" class="btn-primary" style="padding: 0.6rem 1.5rem;">Créer et
                                    configurer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Quotas & Rules -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Quotas Card -->
                <div class="dashboard-card">
                    <div class="card-title">Quotas & Limites</div>

                    <div class="progress-container">
                        <div class="progress-label">
                            <span>Stockage total utilisé</span>
                            <span>
                                @if ($currentStorage < 1000)
                                    {{ $currentStorage }} ko / {{ $maxStorage }} Go
                                @elseif ($currentStorage > 1000 && $currentStorage < 1000000)
                                    {{ round($currentStorage / 1024) }} Mo / {{ $maxStorage }} Go
                                @else
                                    {{ round($currentStorage / (1024 * 1024)) }} Go / {{ $maxStorage }} Go
                                @endif
                            </span>
                        </div>
                        @php
                            $percentage = ($currentStorage * 100) / ($maxStorage * 1024 * 1024);
                        @endphp
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: {{ $percentage }}%;"></div>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="progress-container"
                            style="display: flex; justify-content: space-between; font-weight: 700%;"> Formats de
                            fichiers gérés
                            <form action="{{ route('super-admin.extensions.store') }}" method="POST"
                                style="display: flex; gap: 5px;">
                                @csrf
                                <input type="text" name="name" placeholder="ex: PDF"
                                    style="width: 60px; padding: 2px 5px; font-size: 0.7rem; border: 1px solid #ddd; border-radius: 4px; outline: none;">
                                <!-- <button type="submit" class="btn-primary" style="padding: 2px 8px; font-size: 0.7rem;">+</button> -->
                                <input type="submit" value="+" title="Ajouter une extension" class="btn-primary"
                                    style="padding: 2px 8px; font-size: 0.7rem;">
                            </form>
                        </div>
                        <div class="card-ext">
                            @foreach($fileExtensions as $ext)
                                <label
                                    style="display: flex; align-items: center; gap: 5px; background: #f8fafc; padding: 5px 10px; border-radius: 6px; cursor: pointer; border: 1px solid #e2e8f0;">
                                    <span
                                        style="font-size: 0.8rem; font-weight: 600; display: flex; flex-direction: column;">
                                        {{ strtoupper($ext->name) }} <small
                                            style="color: #94a3b8;">({{ $ext->mime_type }})</small>
                                    </span>
                                </label>
                                <form id="del-{{$ext->id}}" action="{{ route('super-admin.extensions.destroy', $ext->id) }}"
                                    method="POST" style="display:inline;">

                                    @csrf
                                    @method('DELETE')
                                    <span class="tag"
                                        style="background: #eff6ff; color: #1e40af; display: flex; justify-content: center; align-items: center; gap: 5px;">
                                        <button type="button" onclick="ASAlerts.confirmAction(
                                                'Supprimer ?',
                                                'Voulez-vous supprimer cette extension ?',
                                                () => this.closest('form').submit()
                                            )"
                                            style="border:none; background:none; cursor:pointer; display: flex; justify-content:center; align-items: center;">
                                            ×
                                        </button>
                                    </span>

                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
                <script>

                    const modal = document.getElementById('modal-add-type');

                    const form = document.getElementById('doc-type-form');

                    const modalTitle = document.getElementById('modal-title');

                    const methodContainer = document.getElementById('method-container');

                    // =========================
                    // MODE EDITION
                    // =========================

                    document.querySelectorAll('.edit-doc-type-btn')
                        .forEach(button => {

                            button.addEventListener('click', function () {

                                modal.style.display = 'flex';

                                modalTitle.innerText =
                                    'Modifier le type de document';

                                // FORM ACTION
                                form.action =
                                    '/super-admin/document-types/' +
                                    this.dataset.id;

                                // PUT METHOD
                                methodContainer.innerHTML =
                                    '@method("PUT")';

                                // FILL INPUTS
                                document.getElementById('label').value =
                                    this.dataset.label;

                                document.getElementById('code').value =
                                    this.dataset.code;

                                document.getElementById('max_size_mb').value =
                                    this.dataset.maxSize;

                                document.getElementById('min_score').value =
                                    this.dataset.minScore;

                                document.getElementById('required_keywords').value =
                                    this.dataset.requiredKeywords;

                                document.getElementById('forbidden_keywords').value =
                                    this.dataset.forbiddenKeywords;

                                document.getElementById('required_metadata').value =
                                    this.dataset.requiredMetadata;

                                document.getElementById('expiry_patterns').value =
                                    this.dataset.expiryPatterns;

                                document.getElementById('is_perishable').checked =
                                    this.dataset.isPerishable == 1;

                                // RESET EXTENSIONS
                                document
                                    .querySelectorAll(
                                        'input[name="extensions[]"]'
                                    )
                                    .forEach(el => el.checked = false);

                                // RECHECK EXTENSIONS
                                const extensions =
                                    JSON.parse(this.dataset.extensions);

                                extensions.forEach(id => {

                                    const checkbox =
                                        document.querySelector(
                                            'input[name="extensions[]"][value="' + id + '"]'
                                        );

                                    if (checkbox) {

                                        checkbox.checked = true;
                                    }
                                });

                            });
                        });

                    // =========================
                    // MODE CREATE
                    // =========================

                    function openCreateModal() {

                        modal.style.display = 'flex';

                        modalTitle.innerText =
                            'Configurer un nouveau type de document';

                        form.reset();

                        form.action =
                            "{{ route('super-admin.document-types.store') }}";

                        methodContainer.innerHTML = '';

                        document
                            .querySelectorAll(
                                'input[name="extensions[]"]'
                            )
                            .forEach(el => el.checked = false);
                    }

                    function closeCreateModal() {
                        modal.style.display = 'none';
                    }

                </script>
</x-super-admin-layout>