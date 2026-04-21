<x-admin-layout active="cloud" title="Sauvegarde Cloud - ArchiSearch">
    <div class="page-header">
        <div class="breadcrumb-small">Portail Admin > Sauvegarde Cloud</div>
        <h1>Configuration de la sauvegarde cloud</h1>
    </div>

    <div
        style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%; margin-top: 1.5rem;">

        <!-- Left: Configuration (30%) -->
        <div style="width: 30%; flex-shrink: 0; display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Backup Mode -->
            <div class="card" style="padding: 1.5rem;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 1.25rem;">Mode de
                    sauvegarde</h3>

                <div class="selection-card active" onclick="selectCard(this)">
                    <input type="radio" name="backup_mode" checked style="display:none;">
                    <div class="icon-inner">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 2v6h-6" />
                            <path d="M3 12a9 9 0 0 1 15-6.7L21 8" />
                            <path d="M3 22v-6h6" />
                            <path d="M21 12a9 9 0 0 1-15 6.7L3 16" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: #1e293b; font-size: 0.95rem;">Temps réel</div>
                        <div style="font-size: 0.8rem; color: #94a3b8;">Sauvegarde à chaque archivage</div>
                    </div>
                </div>

                <div class="selection-card" onclick="selectCard(this)">
                    <input type="radio" name="backup_mode" style="display:none;">
                    <div class="icon-inner">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: #1e293b; font-size: 0.95rem;">Planifiée</div>
                        <div style="font-size: 0.8rem; color: #94a3b8;">Quotidienne à une heure configurable</div>
                    </div>
                </div>

                <div class="selection-card" onclick="selectCard(this)">
                    <input type="radio" name="backup_mode" style="display:none;">
                    <div class="icon-inner">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 2v20" />
                            <path d="m17 17-5 5-5-5" />
                            <path d="m17 7-5-5-5 5" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: #1e293b; font-size: 0.95rem;">Manuelle</div>
                        <div style="font-size: 0.8rem; color: #94a3b8;">Déclenchée à la demande</div>
                    </div>
                </div>
            </div>

            <!-- Cloud Destination -->
            <div class="card" style="padding: 1.5rem;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 1.25rem;">Destination cloud
                </h3>

                <div class="selection-card active" onclick="selectCard(this)">
                    <input type="radio" name="cloud_dest" checked>
                    <div>
                        <div style="font-weight: 700; color: #1e293b; font-size: 0.95rem;">Stockage local sécurisé
                            (MinIO)</div>
                        <div style="font-size: 0.8rem; color: #94a3b8;">Par défaut · Auto-hébergé</div>
                    </div>
                </div>

                <div class="selection-card" onclick="selectCard(this)">
                    <input type="radio" name="cloud_dest">
                    <div>
                        <div style="font-weight: 700; color: #1e293b; font-size: 0.95rem;">Google Drive</div>
                        <div style="font-size: 0.8rem; color: #94a3b8;">Via Rclone (optionnel)</div>
                    </div>
                </div>

                <div class="selection-card" onclick="selectCard(this)">
                    <input type="radio" name="cloud_dest">
                    <div>
                        <div style="font-weight: 700; color: #1e293b; font-size: 0.95rem;">OneDrive</div>
                        <div style="font-size: 0.8rem; color: #94a3b8;">Via Rclone (optionnel)</div>
                    </div>
                </div>
            </div>

            <button class="btn-primary"
                style="width: 100%; height: 50px; border-radius: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 10px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path
                        d="M17.5 19A5.5 5.5 0 0 0 18 8.02a1 1 0 0 1-.89-.66 7 7 0 0 0-12.22 0 1 1 0 0 1-.89.66A5.5 5.5 0 0 0 4.5 19Z" />
                    <path d="M12 12v9" />
                    <path d="m15 18-3 3-3-3" />
                </svg>
                Déclencher une sauvegarde
            </button>
        </div>

        <!-- Right: Status (65%) -->
        <div style="width: 65%; flex-shrink: 0; display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Stats -->
            <div style="display: flex; gap: 1.5rem;">
                <div class="cloud-stat-box bg-green-light">
                    <div class="number">12 841</div>
                    <div class="label">Sauvegardés</div>
                </div>
                <div class="cloud-stat-box bg-orange-light">
                    <div class="number">6</div>
                    <div class="label">Non sauvegardés</div>
                </div>
                <div class="cloud-stat-box bg-red-light">
                    <div class="number">2</div>
                    <div class="label">Échecs</div>
                </div>
            </div>

            <!-- Activity Chart -->
            <div class="card" style="padding: 1.5rem;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 2rem;">Activité de
                    sauvegarde — 7 derniers jours</h3>
                <div
                    style="height: 250px; border: 1px dashed #e2e8f0; border-radius: 10px;">
                    <canvas id="myBarChart"></canvas>
                </div>
            </div>

            <!-- Status Table -->
            <div class="card" style="padding: 1.5rem;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 1.5rem;">Dernière
                    sauvegarde — Statut par document</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 1px solid #f1f5f9;">
                            <th style="padding: 1rem 0; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase;">
                                DOCUMENT</th>
                            <th style="padding: 1rem 0; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase;">
                                CATÉGORIE</th>
                            <th style="padding: 1rem 0; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase;">
                                STATUT</th>
                            <th style="padding: 1rem 0; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase;">
                                DERNIÈRE TENTATIVE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 1.25rem 0; font-weight: 600; color: #475569;">Contrat_Dupont_2026.pdf
                            </td>
                            <td style="padding: 1.25rem 0; color: #64748b;">RH</td>
                            <td style="padding: 1.25rem 0;"><span class="badge badge-green">Sauvegardé</span></td>
                            <td style="padding: 1.25rem 0; color: #94a3b8;">04 Avr · 00:00</td>
                        </tr>
                        <tr>
                            <td style="padding: 1.25rem 0; font-weight: 600; color: #475569;">Facture_Kone_092.pdf</td>
                            <td style="padding: 1.25rem 0; color: #64748b;">Finance</td>
                            <td style="padding: 1.25rem 0;"><span class="badge badge-green">Sauvegardé</span></td>
                            <td style="padding: 1.25rem 0; color: #94a3b8;">04 Avr · 00:00</td>
                        </tr>
                        <tr>
                            <td style="padding: 1.25rem 0; font-weight: 600; color: #475569;">Photo_Pereira.jpg</td>
                            <td style="padding: 1.25rem 0; color: #64748b;">Identité</td>
                            <td style="padding: 1.25rem 0;"><span class="badge badge-red">Échec</span></td>
                            <td style="padding: 1.25rem 0; color: #94a3b8;">04 Avr · 00:00</td>
                        </tr>
                        <tr style="border-bottom: none;">
                            <td style="padding: 1.25rem 0; font-weight: 600; color: #475569;">Bilan_Diallo_Q1.xlsx</td>
                            <td style="padding: 1.25rem 0; color: #64748b;">Finance</td>
                            <td style="padding: 1.25rem 0;"><span class="badge badge-orange">Non sauvegardé</span></td>
                            <td style="padding: 1.25rem 0; color: #94a3b8;">—</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @push('scripts')
                <script>
                    function selectCard(element) {
                        const parent = element.parentElement;
                        const cards = parent.querySelectorAll('.selection-card');
                        cards.forEach(card => card.classList.remove('active'));
                        element.classList.add('active');
                        const radio = element.querySelector('input[type="radio"]');
                        if (radio) radio.checked = true;
                    }

                </script>
                <script>
                    const ctx = document.getElementById('myBarChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    data: ['42', '67', '53', '88', '74', '20', '12'],

                    // --- COULEUR UNIQUE ---
                    backgroundColor: 'rgba(16, 185, 129, 0.5)', // Bleu transparent
                    borderColor: 'rgb(16, 185, 129)',         // Bleu plein
                    borderWidth: 1,
                    borderRadius: 8,       // Optionnel : barres arrondies
                    barThickness: 50       // Optionnel : fixe la largeur des barres
                }]
            },
            options: {
                responsive: true,           // Le graphique s'adapte à la largeur du parent
                maintainAspectRatio: false,  // Permet au graphique de s'étirer en largeur sans forcer un ratio fixe
                // --------------------------------------------
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
                </script>
    @endpush
</x-admin-layout>