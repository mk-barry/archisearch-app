<x-admin-layout active="evenements" title="Gestion des événements - ArchiSearch">
    <div class="page-header">
        <h1>Gestion des événements</h1>
        <div class="admin-info">
                <div class="avatar" style="width: 40px; height: 40px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                alt="Avatar de {{ Auth::user()->name }}">
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

    <!-- Controls Row -->
    <div class="controls-row">
        <div class="search-filter-group" style="flex: 2;">
            <div class="input-wrapper" style="width: 350px; display: flex; justify-content: center; align-items: center; border: 1px solid #e2e8f0; border-radius: 10px; background: white;">
                <svg class="input-icon" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" placeholder="Rechercher un événement..." style="width: 80%; padding: 0.75rem 1rem 0.75rem 2.75rem; outline: none; border: none;">
            </div>
            
            <div class="log-tabs">
                <button class="log-tab active">Tous</button>
                <button class="log-tab">Actif</button>
                <button class="log-tab">Clôturé</button>
                <button class="log-tab">Archivé</button>
                <button class="log-tab">Brouillon</button>
            </div>
        </div>

        <button class="btn-primary" style="padding: 0.75rem 1.5rem; display: flex; align-items: center; gap: 10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Créer un événement
        </button>
    </div>

    <!-- Events Grid -->
    <div class="event-grid">
        <!-- Event 1 -->
        <div class="event-card">
            <div class="event-header">
                <div>
                    <h3 class="event-title">Collecte Contrats RH — Avr 2026</h3>
                    <p class="event-subtitle">Collecte annuelle des contrats de travail</p>
                </div>
                <span class="badge badge-blue">Actif</span>
            </div>
            
            <div class="event-progress-section">
                <div class="compact-progress-bg" style="height: 10px; background: #f1f5f9;">
                    <div class="compact-progress-fill" style="width: 72%; background: #2563eb;"></div>
                </div>
                <div class="event-stats">
                    <span>18/25 soumissions</span>
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        15 Avr 2026
                    </span>
                </div>
            </div>

            <div class="event-footer">
                <div class="event-meta">3 types requis</div>
                <div class="event-actions">
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                </div>
            </div>
        </div>

        <!-- Event 2 -->
        <div class="event-card">
            <div class="event-header">
                <div>
                    <h3 class="event-title">Dossiers Financiers Q2 2026</h3>
                    <p class="event-subtitle">Factures et devis fournisseurs</p>
                </div>
                <span class="badge badge-blue">Actif</span>
            </div>
            
            <div class="event-progress-section">
                <div class="compact-progress-bg" style="height: 10px;">
                    <div class="compact-progress-fill" style="width: 58%; background: #2563eb;"></div>
                </div>
                <div class="event-stats">
                    <span>7/12 soumissions</span>
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        30 Avr 2026
                    </span>
                </div>
            </div>

            <div class="event-footer">
                <div class="event-meta">2 types requis</div>
                <div class="event-actions">
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                </div>
            </div>
        </div>

        <!-- Event 3 -->
        <div class="event-card">
            <div class="event-header">
                <div>
                    <h3 class="event-title">Identités Personnel 2026</h3>
                    <p class="event-subtitle">Mise à jour des pièces d'identité</p>
                </div>
                <span class="badge badge-blue">Actif</span>
            </div>
            
            <div class="event-progress-section">
                <div class="compact-progress-bg" style="height: 10px;">
                    <div class="compact-progress-fill" style="width: 70%; background: #2563eb;"></div>
                </div>
                <div class="event-stats">
                    <span>42/60 soumissions</span>
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        01 Mai 2026
                    </span>
                </div>
            </div>

            <div class="event-footer">
                <div class="event-meta">2 types requis</div>
                <div class="event-actions">
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                </div>
            </div>
        </div>

        <!-- Event 4 -->
        <div class="event-card">
            <div class="event-header">
                <div>
                    <h3 class="event-title">Bilan Comptable Mars 2026</h3>
                    <p class="event-subtitle">Soumission des bilans mensuels</p>
                </div>
                <span class="badge badge-green">Clôturé</span>
            </div>
            
            <div class="event-progress-section">
                <div class="compact-progress-bg" style="height: 10px;">
                    <div class="compact-progress-fill" style="width: 100%; background: #2563eb;"></div>
                </div>
                <div class="event-stats">
                    <span style="color: #10b981; font-weight: 700;">12/12 soumissions</span>
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        05 Avr 2026
                    </span>
                </div>
            </div>

            <div class="event-footer">
                <div class="event-meta">1 type requis</div>
                <div class="event-actions">
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                </div>
            </div>
        </div>

        <!-- Event 5 -->
        <div class="event-card">
            <div class="event-header">
                <div>
                    <h3 class="event-title">Formation Sécurité Certifs</h3>
                    <p class="event-subtitle">Attestations de formations sécurité</p>
                </div>
                <span class="badge" style="background: #f1f5f9; color: #475569;">Archivé</span>
            </div>
            
            <div class="event-progress-section">
                <div class="compact-progress-bg" style="height: 10px;">
                    <div class="compact-progress-fill" style="width: 100%; background: #2563eb;"></div>
                </div>
                <div class="event-stats">
                    <span style="color: #64748b;">8/8 soumissions</span>
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        20 Mar 2026
                    </span>
                </div>
            </div>

            <div class="event-footer">
                <div class="event-meta">1 type requis</div>
                <div class="event-actions">
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                </div>
            </div>
        </div>

        <!-- Event 6 -->
        <div class="event-card">
            <div class="event-header">
                <div>
                    <h3 class="event-title">Rapport Annuel Directions</h3>
                    <p class="event-subtitle">Rapports d'activité par direction</p>
                </div>
                <span class="badge badge-orange">Brouillon</span>
            </div>
            
            <div class="event-progress-section">
                <div class="compact-progress-bg" style="height: 10px;">
                    <div class="compact-progress-fill" style="width: 0%; background: #2563eb;"></div>
                </div>
                <div class="event-stats">
                    <span style="color: #94a3b8;">0/8 soumissions</span>
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        30 Avr 2026
                    </span>
                </div>
            </div>

            <div class="event-footer">
                <div class="event-meta">1 type requis</div>
                <div class="event-actions">
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                    <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
