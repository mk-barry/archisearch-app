<x-super-admin-layout active="supervision">
    <x-slot:title>Supervision - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="breadcrumb-small">Super Admin > Supervision</div>
            <h1>Tableau de bord de supervision</h1>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Administrateurs actifs</span>
                <span class="stat-value">14</span>
                <span style="color: #94a3b8; font-size: 0.8rem;">sur 18 comptes</span>
                <div style="margin-top: 0.75rem;"><span class="trend up">↑ +2</span> <span
                        style="color: #94a3b8; font-size: 0.8rem;">vs. mois dernier</span></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2c0 1.1.9 2 2 2h5v5c0 1.1.9 2 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z" />
                    </svg>
                </div>
                <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Événements en cours</span>
                <span class="stat-value">38</span>
                <span style="color: #94a3b8; font-size: 0.8rem;">7 clôturés ce mois</span>
                <div style="margin-top: 0.75rem;"><span class="trend up">↑ +5</span> <span
                        style="color: #94a3b8; font-size: 0.8rem;">vs. mois dernier</span></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z" />
                        <path d="M12 2v20" />
                        <path d="M8 7h6" />
                        <path d="M8 11h6" />
                        <path d="M8 15h6" />
                    </svg>
                </div>
                <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Documents archivés</span>
                <span class="stat-value">12 847</span>
                <span style="color: #94a3b8; font-size: 0.8rem;">+342 cette semaine</span>
                <div style="margin-top: 0.75rem;"><span class="trend up">↑ +3.2%</span> <span
                        style="color: #94a3b8; font-size: 0.8rem;">vs. mois dernier</span></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-red">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" x2="12" y1="8" y2="12" />
                        <line x1="12" x2="12.01" y1="16" y2="16" />
                    </svg>
                </div>
                <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Anomalies détectées</span>
                <span class="stat-value">7</span>
                <span style="color: #94a3b8; font-size: 0.8rem;">3 en attente de traitement</span>
                <div style="margin-top: 0.75rem;"><span class="trend down">↓ -2</span> <span
                        style="color: #94a3b8; font-size: 0.8rem;">vs. mois dernier</span></div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-title">Activité système — 7 derniers jours</div>
                <div
                    style="height: 250px; position: relative; border-bottom: 2px solid #f1f5f9; border-left: 2px solid #f1f5f9; margin-top: 2rem;">
                    <!-- Simulated Chart with SVG -->
                    <!-- <svg viewBox="0 0 700 200" style="width: 100%; height: 100%; overflow: visible;"> -->
                    <!-- <path d="M0,150 Q100,100 200,120 T400,50 T600,130 T700,160" fill="none" stroke="#2563eb"
                            stroke-width="3" />
                        <path d="M0,170 Q100,130 200,140 T400,80 T600,150 T700,180" fill="none" stroke="#10b981"
                            stroke-width="3" /> -->
                    <!-- Area under blue line -->
                    <!-- <path d="M0,150 Q100,100 200,120 T400,50 T600,130 T700,160 V200 H0 Z"
                            fill="rgba(37, 99, 235, 0.05)" /> -->
                    <!-- </svg> -->
                    <canvas id="myPointChart"></canvas>
                    <!-- <div
                        style="display: flex; justify-content: space-between; margin-top: 1rem; color: #94a3b8; font-size: 0.75rem;">
                        <span>Lun</span><span>Mar</span><span>Mer</span><span>Jeu</span><span>Ven</span><span>Sam</span><span>Dim</span>
                    </div> -->
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-title">Répartition des événements</div>
                <div
                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
                    <div style="position: relative; width: 150px; height: 150px; margin-bottom: 2rem;">
                        <!-- <svg viewBox="0 0 36 36" style="width: 100%; height: 100%;">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="#e2e8f0" stroke-width="4"></path>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831" fill="none" stroke="#2563eb"
                                stroke-width="4" stroke-dasharray="60, 100"></path>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 15.9155 15.9155" fill="none" stroke="#10b981"
                                stroke-width="4" stroke-dasharray="25, 100" stroke-dashoffset="-60"></path>
                        </svg> -->
                        <canvas id="moncercle"></canvas>
                        <div
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                            <span style="font-size: 1.5rem; font-weight: 800;">84</span>
                            <span style="display: block; font-size: 0.6rem; color: #94a3b8;">TOTAL</span>
                        </div>
                    </div>
                    <div style="width: 100%; font-size: 0.85rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 10px; height: 10px; border-radius: 2px; background: #2563eb;"></div>
                                Actifs
                            </div>
                            <strong>38</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 10px; height: 10px; border-radius: 2px; background: #10b981;"></div>
                                Clôturés
                            </div>
                            <strong>22</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 10px; height: 10px; border-radius: 2px; background: #64748b;"></div>
                                Archivés
                            </div>
                            <strong>15</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Row -->
        <div class="dashboard-grid">
            <div class="dashboard-card" style="margin-bottom: 0;">
                <div class="card-title">
                    Activité récente
                    <a href="#" style="font-size: 0.8rem; font-weight: 500; color: #2563eb; text-decoration: none;">Voir
                        tous les journaux</a>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div
                        style="display: flex; gap: 1rem; align-items: center; padding: 0.75rem; border-radius: 12px; background: #f8fafc;">
                        <div class="stat-icon icon-green" style="width: 36px; height: 36px; margin-bottom: 0;"><svg
                                width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                            </svg></div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.9rem; font-weight: 600;">Admin Dupont connecté depuis 192.168.1.42
                            </div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">il y a 2 min</div>
                        </div>
                    </div>
                    <!-- More items... -->
                    <div style="display: flex; gap: 1rem; align-items: center; padding: 0.75rem;">
                        <div class="stat-icon icon-blue" style="width: 36px; height: 36px; margin-bottom: 0;"><svg
                                width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z" />
                            </svg></div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.9rem; font-weight: 500;">12 documents archivés — Événement
                                #RH-2026-04</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">il y a 8 min</div>
                        </div>
                    </div>
                    <div style="display: flex; gap: 1rem; align-items: center; padding: 0.75rem;">
                        <div class="stat-icon icon-orange" style="width: 36px; height: 36px; margin-bottom: 0;"><svg
                                width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" x2="12" y1="8" y2="12" />
                            </svg></div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.9rem; font-weight: 500;">Anomalie détectée — Document ID #4872
                            </div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">il y a 15 min</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-card" style="margin-bottom: 0;">
                <div class="card-title">Utilisateurs en ligne</div>
                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div class="avatar"
                            style="width: 32px; height: 32px; font-size: 0.8rem; background: #dcfce7; color: #16a34a;">
                            AD</div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.85rem; font-weight: 600;">Admin Dupont</div>
                            <div style="font-size: 0.7rem; color: #94a3b8;">Admin • 2h 14m</div>
                        </div>
                        <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%;"></div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div class="avatar" style="width: 32px; height: 32px; font-size: 0.8rem;">AM</div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.85rem; font-weight: 600;">Admin Mbatswe</div>
                            <div style="font-size: 0.7rem; color: #94a3b8;">Admin • 45m</div>
                        </div>
                        <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%;"></div>
                    </div>
                    <!-- ... -->
                    <div style="text-align: center; margin-top: 1rem; font-size: 0.8rem; color: #94a3b8;">
                        4 utilisateurs connectés
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('myPointChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                    datasets: [
                        {
                            label: 'Recherche',
                            data: [85, 102, 91, 130, 118, 32, 18],
                            borderColor: '#36A2EB', // Couleur de la 2ème ligne
                            backgroundColor: '#36A2EB',
                            tension: 0.2,           // Courbe fluide
                            fill: false
                        },

                        {
                            label: 'Televersement',
                            data: [42, 67, 53, 88, 74, 20, 12],
                            borderColor: '#FF6384', // Couleur de la 1ère ligne
                            backgroundColor: '#FF6384',
                            tension: 0.2,           // Courbe fluide
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,// Le graphique s'adapte à la largeur du parent
                    maintainAspectRatio: false,  // Permet au graphique de s'étirer en largeur sans forcer un ratio fixe
                    // --------------------------------------------
                    scales: {
                        y: {
                            beginAtZero: true,
                            // max: 100 // Comme défini précédemment
                            ticks: {
                                stepSize: 35   // Optionnel : définit l'écart entre chaque graduation
                            }
                        }
                    },
                    interaction: {
                        mode: 'index',     // Affiche tous les points correspondant à l'index (le jour)
                        intersect: false   // Affiche les infos même si la souris n'est pas pile sur le point
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            mode: 'index', // Force le tooltip à regrouper les données des deux lignes
                            intersect: false
                        }
                    }
                }
            });
        </script>
        <script>
            const ctx1 = document.getElementById('moncercle').getContext('2d');

            new Chart(ctx1, {
                type: 'doughnut',
                data: {
                    labels: ['Actifs', 'Cloturés', 'Archivés'], // Noms des 3 sections
                    datasets: [{
                        data: [35, 22, 15], // Les valeurs (ex: pour faire 100% au total)
                        backgroundColor: [
                            '#2563eb', // Couleur Section 1
                            '#10b981', // Couleur Section 2
                            '#64748b'  // Couleur Section 3
                        ],
                        hoverOffset: 10,     // Effet visuel au survol
                        borderWidth: 2       // Espacement blanc entre les sections
                    }]
                },
                options: {
                    cutout: '70%', // Plus le chiffre est grand, plus la bande est fine
                    responsive: true,// Le graphique s'adapte à la largeur du parent
                    maintainAspectRatio: false,  // Permet au graphique de s'étirer en largeur sans forcer un ratio fixe
                    plugins: {
                        legend: {
                            display: false,
                            position: 'bottom' // Place la légende sous le graphique
                        },
                        tooltip: {
                            enabled: true // Garde les bulles d'info au survol (optionnel)
                        }
                    }
                }
            });
        </script>
</x-super-admin-layout>