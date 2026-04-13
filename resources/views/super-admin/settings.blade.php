<x-dashboard-layout active="parametres">
    <x-slot:title>Paramètres globaux - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="breadcrumb-small">Super Admin > Paramètres globaux</div>
            <h1>Paramètres globaux du système</h1>
        </div>

        <div class="settings-grid">
            <!-- Left Column: Categories -->
            <div class="dashboard-card">
                <div class="card-title">
                    Catégories de documents
                    <button class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.8rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="3">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Ajouter
                    </button>
                </div>

                <div class="category-list">
                    @php
                        $categories = [
                            ['name' => 'Ressources Humaines', 'count' => '2 341', 'tags' => ['Contrat', 'Bulletins de paie', 'Évaluations']],
                            ['name' => 'Finances & Comptabilité', 'count' => '1 876', 'tags' => ['Factures', 'Devis', 'Bilans']],
                            ['name' => 'Juridique', 'count' => '937', 'tags' => ['Contrats', 'Conventions', 'Décisions']],
                            ['name' => 'Direction Générale', 'count' => '543', 'tags' => ['Circulaires', 'Rapports', 'CR Réunions']],
                        ];
                    @endphp

                    @foreach($categories as $cat)
                        <div class="category-item">
                            <div class="category-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                                </svg>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-weight: 700;">{{ $cat['name'] }}</span>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <span style="font-size: 0.85rem; color: #94a3b8;">{{ $cat['count'] }} docs</span>
                                        <button class="action-btn"><svg width="14" height="14" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                            </svg></button>
                                    </div>
                                </div>
                                <div class="tag-list">
                                    @foreach($cat['tags'] as $tag)
                                        <span class="tag">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Column: Quotas & Rules -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Quotas Card -->
                <div class="dashboard-card">
                    <div class="card-title">Quotas & Limites</div>

                    <div class="progress-container">
                        <div class="progress-label">
                            <span>Taille maximale par fichier</span>
                            <span>20 Mo</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: 60%;"></div>
                        </div>
                    </div>

                    <div class="progress-container">
                        <div class="progress-label">
                            <span>Stockage total utilisé</span>
                            <span>45.2 Go / 200 Go</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: 25%;"></div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.9rem; font-weight: 600;">Formats acceptés</span>
                        <a href="#"
                            style="font-size: 0.8rem; color: #2563eb; font-weight: 600; text-decoration: none;">Modifier</a>
                    </div>
                    <div class="tag-list" style="margin-top: 1rem;">
                        @foreach(['PDF', 'JPEG', 'PNG', 'DOCX', 'XLSX'] as $format)
                            <span class="tag" style="background: #eff6ff; color: #1e40af;">{{ $format }}</span>
                        @endforeach
                    </div>
                </div>

                <!-- Rules Card -->
                <div class="dashboard-card">
                    <div class="card-title">Règles d'archivage</div>

                    <div class="settings-row-item">
                        <div>
                            <div style="font-size: 0.9rem; font-weight: 700;">Convention de nommage</div>
                            <div style="font-size: 0.75rem; color: #94a3b8; font-family: monospace;">ÉVÉNEMENT_DATE_NOM
                            </div>
                        </div>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                            </svg></button>
                    </div>

                    <div class="settings-row-item">
                        <div>
                            <div style="font-size: 0.9rem; font-weight: 700;">Indexation OCR automatique</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">À la soumission, asynchrone</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="settings-row-item" style="margin-bottom: 0;">
                        <div>
                            <div style="font-size: 0.9rem; font-weight: 700;">Tentatives de ré-indexation</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">Maximum 3 tentatives</div>
                        </div>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                            </svg></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Actions -->
        <div
            style="position: fixed; bottom: 0; right: 0; left: 260px; padding: 1.5rem 2rem; background: white; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 1rem; z-index: 80;">
            <button class="btn-outline">Annuler</button>
            <button class="btn-primary" style="padding: 0.75rem 2rem;">Enregistrer les paramètres</button>
        </div>
</x-dashboard-layout>