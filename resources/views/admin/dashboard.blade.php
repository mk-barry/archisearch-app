<x-admin-layout active="dashboard">
    <div class="page-header">
        <h1>Tableau de bord</h1>
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

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #eff6ff; color: #2563eb;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                    <line x1="16" x2="16" y1="2" y2="6" />
                    <line x1="8" x2="8" y1="2" y2="6" />
                    <line x1="3" x2="21" y1="10" y2="10" />
                </svg>
            </div>
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Événements actifs</span>
            <span class="stat-value">8</span>
            <span style="color: #94a3b8; font-size: 0.8rem;">2 expirent bientôt</span>
            <div style="margin-top: 0.75rem;"><span class="trend up">↑ +1</span> <span
                    style="color: #94a3b8; font-size: 0.8rem;">vs. mois dernier</span></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #f0fdf4; color: #10b981;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                </svg>
            </div>
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Documents reçus</span>
            <span class="stat-value">342</span>
            <span style="color: #94a3b8; font-size: 0.8rem;">cette semaine</span>
            <div style="margin-top: 0.75rem;"><span class="trend up">↑ +47</span> <span
                    style="color: #94a3b8; font-size: 0.8rem;">vs. mois dernier</span></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #fffbeb; color: #f59e0b;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
            </div>
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">En attente de traitement</span>
            <span class="stat-value">23</span>
            <span style="color: #94a3b8; font-size: 0.8rem;">invités n'ont pas soumis</span>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #fef2f2; color: #ef4444;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
            </div>
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Anomalies détectées</span>
            <span class="stat-value">3</span>
            <span style="color: #94a3b8; font-size: 0.8rem;">à vérifier</span>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="dashboard-grid">
        <div class="dashboard-card">
            <div class="card-title">Téléversements récents (7j)</div>
            <div style="height: 250px; position: relative; margin-top: 2rem;">
                <!-- Dotted Grid Lines -->
                <!-- <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                    <div style="border-top: 1px dashed #e2e8f0; width: 100%;"></div>
                    <div style="border-top: 1px dashed #e2e8f0; width: 100%;"></div>
                    <div style="border-top: 1px dashed #e2e8f0; width: 100%;"></div>
                    <div style="border-top: 1px dashed #e2e8f0; width: 100%;"></div>
                    <div style="border-top: 1px dashed #e2e8f0; width: 100%;"></div>
                </div> -->
                <!-- Simulated Chart with SVG -->
                <!-- <svg viewBox="0 0 700 200" style="width: 100%; height: 100%; overflow: visible; position: relative; z-index: 2;"> -->
                <!-- <path d="M0,180 Q100,160 200,170 T400,120 T600,150 T700,100" fill="none" stroke="#2563eb" stroke-width="3" stroke-dasharray="0" /> -->
                <!-- Points -->
                <!-- <circle cx="200" cy="170" r="4" fill="#2563eb" />
                    <circle cx="400" cy="120" r="4" fill="#2563eb" />
                    <circle cx="700" cy="100" r="4" fill="#2563eb" /> -->
                <!-- </svg> -->
                <!-- <div style="display: flex; justify-content: space-between; margin-top: 1rem; color: #94a3b8; font-size: 0.75rem;">
                    <span>Lun</span><span>Mar</span><span>Mer</span><span>Jeu</span><span>Ven</span><span>Sam</span><span>Dim</span>
                </div> -->
                    <canvas id="myline">

                    </canvas>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-title">Événements — Statuts</div>
            <div style="margin-top: 2rem;">
                <div class="compact-progress-row">
                    <div class="compact-progress-label">
                        <span>Actifs</span>
                        <span>8</span>
                    </div>
                    <div class="compact-progress-bg">
                        <div class="compact-progress-fill" style="width: 65%; background: #1e3a8a;"></div>
                    </div>
                </div>
                <div class="compact-progress-row">
                    <div class="compact-progress-label">
                        <span>Clôturés</span>
                        <span>5</span>
                    </div>
                    <div class="compact-progress-bg">
                        <div class="compact-progress-fill" style="width: 45%; background: #10b981;"></div>
                    </div>
                </div>
                <div class="compact-progress-row">
                    <div class="compact-progress-label">
                        <span>Brouillons</span>
                        <span>3</span>
                    </div>
                    <div class="compact-progress-bg">
                        <div class="compact-progress-fill" style="width: 30%; background: #f59e0b;"></div>
                    </div>
                </div>
                <div class="compact-progress-row">
                    <div class="compact-progress-label">
                        <span>Archivés</span>
                        <span>1</span>
                    </div>
                    <div class="compact-progress-bg">
                        <div class="compact-progress-fill" style="width: 15%; background: #64748b;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="dashboard-grid">
        <div class="dashboard-card">
            <div class="card-title">
                Derniers téléversements
                <a href="#" style="font-size: 0.8rem; font-weight: 500; color: #2563eb; text-decoration: none;">Voir
                    tout</a>
            </div>

            <div class="file-list">
                <div class="file-item">
                    <div class="file-icon-box bg-pdf">PDF</div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.95rem; font-weight: 700; color: #1e293b;">Contrat_Dupont_2026.pdf</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">RH-Contrats-Avr • J. Dupont</div>
                    </div>
                    <div style="text-align: right;">
                        <span class="badge" style="background: #f1f5f9; color: #475569;">Soumis</span>
                        <div class="status-time">il y a 5 min</div>
                    </div>
                </div>

                <div class="file-item">
                    <div class="file-icon-box bg-pdf">PDF</div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.95rem; font-weight: 700; color: #1e293b;">Facture_Fournisseur_12.pdf
                        </div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">Finance-Q2-2026 • M. Koné</div>
                    </div>
                    <div style="text-align: right;">
                        <span class="badge badge-blue">Indexé</span>
                        <div class="status-time">il y a 12 min</div>
                    </div>
                </div>

                <div class="file-item">
                    <div class="file-icon-box bg-jpg">JPG</div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.95rem; font-weight: 700; color: #1e293b;">Photo_ID_Mbatswe.jpg</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">RH-Identités-2026 • B. Mbatswe</div>
                    </div>
                    <div style="text-align: right;">
                        <span class="badge" style="background: #f1f5f9; color: #475569;">Soumis</span>
                        <div class="status-time">il y a 38 min</div>
                    </div>
                </div>

                <div class="file-item">
                    <div class="file-icon-box bg-xls">XLS</div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.95rem; font-weight: 700; color: #1e293b;">Bilan_Mars_2026.xlsx</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">Finance-Q1-2026 • S. Ndiaye</div>
                    </div>
                    <div style="text-align: right;">
                        <span class="badge badge-green">Accepté</span>
                        <div class="status-time">il y a 1h</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-title" style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.8rem; font-weight: bold;">Invités en attente de soumission</span>
                <button class="btn-primary"
                    style="padding: 0.2rem 0.2rem; font-size: 0.6rem; display: flex; justify-content: center; align-items: center; gap: 8px; width: 45%;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m22 2-7 20-4-9-9-4Z" />
                        <path d="M22 2 11 13" />
                    </svg>
                    <span>Envoyer rappels</span>
                </button>
            </div>

            <div class="user-list">
                <div class="user-item">
                    <div class="avatar" style="background: #e2e8f0; color: #64748b;">AM</div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.9rem; font-weight: 700;">Alice Moreau</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">a.moreau@ext.fr</div>
                    </div>
                    <div class="user-status-group">
                        <span class="badge badge-orange">En attente</span>
                        <span class="status-time">Depuis 3j</span>
                    </div>
                </div>

                <div class="user-item">
                    <div class="avatar" style="background: #e2e8f0; color: #64748b;">TL</div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.9rem; font-weight: 700;">Thomas Legrand</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">t.legrand@partner.com</div>
                    </div>
                    <div class="user-status-group">
                        <span class="badge badge-orange">En attente</span>
                        <span class="status-time">Depuis 1j</span>
                    </div>
                </div>

                <div class="user-item">
                    <div class="avatar" style="background: #e2e8f0; color: #64748b;">FD</div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.9rem; font-weight: 700;">Fatou Diallo</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">f.diallo@ext.sn</div>
                    </div>
                    <div class="user-status-group">
                        <span class="badge badge-orange">En attente</span>
                        <span class="status-time">Depuis 5j</span>
                    </div>
                </div>

                <div class="user-item">
                    <div class="avatar" style="background: #e2e8f0; color: #64748b;">MP</div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.9rem; font-weight: 700;">Marc Pereira</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">m.pereira@consult.eu</div>
                    </div>
                    <div class="user-status-group">
                        <span class="badge badge-orange">En attente</span>
                        <span class="status-time">Depuis 2j</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myline').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    label: 'Documents',
                    data: [12, 24, 18, 35, 28, 8, 5],

                    // --- RÉGLAGES DE LA COURBE ---
                    borderColor: '#36A2EB',    // Couleur de la ligne
                    tension: 0.4,              // L'arrondi (0 = lignes droites, 0.5 = très courbe)
                    fill: false,               // Ne pas remplir sous la ligne
                    pointRadius: 5,            // Taille des points
                    pointBackgroundColor: '#36A2EB'
                }]
            },
            options: {
                responsive: true, // Le graphique s'adapte à la largeur du parent
                maintainAspectRatio: false,  // Permet au graphique de s'étirer en largeur sans forcer un ratio fixe
                // --------------------------------------------
                plugins: {
                    legend: {
                        display: false         // On cache la légende comme demandé avant
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,    // Commence l'axe à 0
                        max: 100,          // --- VALEUR MAXIMALE FORCÉE ---
                        ticks: {
                            stepSize: 10   // Optionnel : définit l'écart entre chaque graduation
                        }
                    }
                }
            }
        });

    </script>
</x-admin-layout>