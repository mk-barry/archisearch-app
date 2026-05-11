<x-admin-layout active="recherche" title="Recherche de documents - ArchiSearch">
    <div class="page-header">
        <div class="page-info">
            <div class="breadcrumb-small">Portail Admin > Recherche</div>
            <h1>Recherche de documents</h1>
        </div>
        <div class="admin-info">
                <div class="avatar" style="width: 40px; height: 40px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                alt="Avatar de {{ Auth::user()->name }}">
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

    <!-- Search Header Card -->
    <div class="search-header-card">
        <div class="search-input-big">
            <svg style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); color: #3b82f6;" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" value="contrat" placeholder="Tapez votre recherche ici...">
            <button class="search-btn-embed">Rechercher</button>
        </div>

        <div class="quick-filter-row">
            <select class="select-filter"><option>Événement : Tous</option></select>
            <select class="select-filter"><option>Type : Tous</option></select>
            <select class="select-filter"><option>Date : Toutes</option></select>
            <select class="select-filter"><option>Auteur : Tous</option></select>
            <button class="btn-outline" style="border-radius: 10px; padding: 0.6rem 1.25rem; font-size: 0.9rem; border-color: #3b82f6; color: #3b82f6;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                Sauvegarder la recherche
            </button>
        </div>
    </div>

    <div class="search-layout" style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%; margin-top: 1.5rem;">
        <!-- Sidebar Filters -->
        <aside class="filter-sidebar" style="width: 30%; flex-shrink: 0;">
            <h2 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 2rem;">Affiner les résultats</h2>

            <div class="filter-group">
                <div class="filter-group-title">ÉVÉNEMENT</div>
                <label class="checkbox-item"><input type="checkbox" checked> <span>Collecte Contrats RH</span></label>
                <label class="checkbox-item"><input type="checkbox"> <span>Juridique Q4 2025</span></label>
                <label class="checkbox-item"><input type="checkbox"> <span>Finance Q1 2026</span></label>
            </div>

            <div class="filter-group">
                <div class="filter-group-title">TYPE DE FICHIER</div>
                <label class="checkbox-item"><input type="checkbox"> <span>PDF (2)</span></label>
                <label class="checkbox-item"><input type="checkbox"> <span>DOCX (1)</span></label>
                <label class="checkbox-item"><input type="checkbox"> <span>JPEG (0)</span></label>
            </div>

            <div class="filter-group">
                <div class="filter-group-title">STATUT</div>
                <label class="checkbox-item"><input type="checkbox"> <span>Accepté</span></label>
                <label class="checkbox-item"><input type="checkbox"> <span>En traitement</span></label>
                <label class="checkbox-item"><input type="checkbox"> <span>À revoir</span></label>
            </div>
        </aside>

        <!-- Results Column -->
        <div class="results-column" style="width: 65%; flex-shrink: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <div style="color: #64748b; font-size: 1.05rem;">
                    <strong>3 résultats</strong> pour <span style="color: #1e293b; font-weight: 600;">« contrat »</span> · 0.24s
                </div>
                <div style="display: flex; align-items: center; gap: 8px; font-size: 0.95rem; color: #64748b;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 16 4 4 4-4"/><path d="M7 20V4"/><path d="m21 8-4-4-4 4"/><path d="M17 4v16"/></svg>
                    Trier par : <span style="color: #2563eb; font-weight: 700;">Pertinence</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                </div>
            </div>

            <!-- Result Cards List -->
            <div class="results-list">
                <!-- Result 1 -->
                <div class="result-card">
                    <div class="file-icon-box bg-pdf" style="width: 44px; height: 44px;">PDF</div>
                    <div class="result-info">
                        <div class="result-top">
                            <h3 class="result-filename">Contrat_Dupont_2026.pdf</h3>
                            <div class="relevance-group">
                                <span class="relevance-text">98%</span>
                                <div class="relevance-bar-bg"><div class="relevance-bar-fill" style="width: 98%;"></div></div>
                            </div>
                        </div>
                        <p class="result-snippet">...conformément aux dispositions de l'article 3, le présent <span class="highlight">contrat</span> prend effet le 1er janvier 2026...</p>
                        <div class="result-meta">
                            <div class="meta-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg> Collecte Contrats RH</div>
                            <div class="meta-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> J. Dupont</div>
                            <div class="meta-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg> 02 Avr 2026</div>
                        </div>
                    </div>
                    <div class="result-actions">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg></button>
                    </div>
                </div>

                <!-- Result 2 -->
                <div class="result-card">
                    <div class="file-icon-box bg-pdf" style="width: 44px; height: 44px;">PDF</div>
                    <div class="result-info">
                        <div class="result-top">
                            <h3 class="result-filename">Convention_Legrand_2025.pdf</h3>
                            <div class="relevance-group">
                                <span class="relevance-text">84%</span>
                                <div class="relevance-bar-bg"><div class="relevance-bar-fill" style="width: 84%;"></div></div>
                            </div>
                        </div>
                        <p class="result-snippet">...la présente <span class="highlight">convention</span> établit les modalités d'exercice entre les parties signataires...</p>
                        <div class="result-meta">
                            <div class="meta-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg> Juridique Q4 2025</div>
                            <div class="meta-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> T. Legrand</div>
                            <div class="meta-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg> 12 Jan 2026</div>
                        </div>
                    </div>
                    <div class="result-actions">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg></button>
                    </div>
                </div>

                <!-- Result 3 -->
                <div class="result-card">
                    <div class="file-icon-box bg-pdf" style="width: 44px; height: 44px;">PDF</div>
                    <div class="result-info">
                        <div class="result-top">
                            <h3 class="result-filename">Contrat_Moreau_sign.pdf</h3>
                            <div class="relevance-group">
                                <span class="relevance-text">91%</span>
                                <div class="relevance-bar-bg"><div class="relevance-bar-fill" style="width: 91%;"></div></div>
                            </div>
                        </div>
                        <p class="result-snippet">...durée du <span class="highlight">contrat</span> : 24 mois à compter de la date de signature par les deux parties...</p>
                        <div class="result-meta">
                            <div class="meta-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg> Collecte Contrats RH</div>
                            <div class="meta-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> A. Moreau</div>
                            <div class="meta-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg> 02 Avr 2026</div>
                        </div>
                    </div>
                    <div class="result-actions">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
