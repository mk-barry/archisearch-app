<x-super-admin-layout active="supervision" sec_css="dashboard.css">
    <x-slot:title>Supervision - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="page-info">
                <div class="breadcrumb-small">Super Admin > Supervision</div>
                <h1>Tableau de bord de supervision</h1>
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

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <span class="stat-label">Administrateurs actifs</span>
                <span class="stat-value">{{ $activeAdmins }}</span>
                <span  class="stat-subtext">sur {{ $totalAdmins }} comptes</span>
                <div  class="stat-trend"><span class="trend up">↑ stable</span> <span
                         class="stat-subtext">vs. mois dernier</span></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2c0 1.1.9 2 2 2h5v5c0 1.1.9 2 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z" />
                    </svg>
                </div>
                <span class="stat-label">Événements</span>
                <span class="stat-value">{{ array_sum($eventStats) }}</span>
                <span  class="stat-subtext">{{ $eventStats['actifs'] }} en cours</span>
                <div  class="stat-trend">
                    <span class="trend up">↑ {{ $eventStats['clotures'] }}</span>
                    <span  class="stat-subtext">clôturés</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z" />
                        <path d="M12 2v20" />
                        <path d="M8 7h6" />
                        <path d="M8 11h6" />
                        <path d="M8 15h6" />
                    </svg>
                </div>
                <span class="stat-label">Documents archivés</span>
                <span class="stat-value">{{ number_format($totalDocs, 0, ',', ' ') }}</span>
                <span  class="stat-subtext">+{{ $docsThisWeek }} cette semaine</span>
                <div  class="stat-trend"><span class="trend up">↑ Actif</span></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-red">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" x2="12" y1="8" y2="12" />
                        <line x1="12" x2="12.01" y1="16" y2="16" />
                    </svg>
                </div>
                <span class="stat-label">Anomalies</span>
                <span class="stat-value">{{ $anomalies }}</span>
                <span  class="stat-subtext">Alerte intégrité</span>
                <div  class="stat-trend"><span
                        class="{{ $anomalies > 0 ? 'trend down' : 'trend up' }}">{{ $anomalies > 0 ? 'Action requise' : 'Système sain' }}</span>
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-title">Activité système — 7 derniers jours</div>
                <div class="chart-container">
                    <canvas id="myPointChart"></canvas>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-title">Répartition des événements</div>
                <div class="chart-circle-wrapper">
                    <div class="donut-chart">
                        <canvas id="moncercle"></canvas>
                        <div class="donut-inner">
                            <span class="donut-val">{{ array_sum($eventStats) }}</span>
                            <span class="donut-label">TOTAL</span>
                        </div>
                    </div>
                    <div class="chart-legend">
                        @foreach($eventStats as $label => $val)
                            <div class="legend-item">
                                <div class="legend-info">
                                    <div
                                         class="legend-color legend-color-{{ $loop->iteration }}">
                                    </div>
                                    {{ ucfirst($label) }}
                                </div>
                                <strong>{{ $val }}</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-title">
                    Activité récente
                    <a href="{{ route('super-admin.logs') }}" class="link-small">Voir tous
                        les journaux</a>
                </div>
                <div class="activity-list">
                    @foreach($recentActivities as $log)
                        <div class="activity-item">
                            <div class="stat-icon icon-blue icon-sm">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 6v6l4 2" />
                                </svg>
                            </div>
                            <div class="activity-info">
                                <div class="activity-msg">{{ $log->message }}</div>
                                <div class="activity-meta">{{ $log->created_at->diffForHumans() }} par
                                    {{ $log->user->name ?? 'Systeme' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-title">Utilisateurs en ligne</div>
                <div class="online-list">
                    @foreach($onlineUsers as $online)
                        <div class="online-user">
                            <div class="avatar-base avatar-sm">
                                {{ collect(explode(' ', $online->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                            </div>
                            <div class="online-info">
                                <div class="online-name">{{ $online->name }}</div>
                                <div class="online-role">{{ ucfirst($online->role) }}</div>
                            </div>
                            <div class="online-indicator"></div>
                        </div>
                    @endforeach
                    <div class="online-total">
                        {{ $onlineUsers->count() }} utilisateur(s) actif(s)
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Graphique Linéaire (Activité)
            const ctx = document.getElementById('myPointChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($days) !!},
                    datasets: [
                        {
                            label: 'Recherches',
                            data: {!! json_encode($searchData) !!},
                            borderColor: '#36A2EB',
                            tension: 0.3,
                            fill: false
                        },
                        {
                            label: 'Téléversements',
                            data: {!! json_encode($uploadData) !!},
                            borderColor: '#FF6384',
                            tension: 0.3,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Graphique Circulaire (Répartition)
            const ctx1 = document.getElementById('moncercle').getContext('2d');
            new Chart(ctx1, {
                type: 'doughnut',
                data: {
                    labels: ['Actifs', 'Clôturés', 'Archivés'],
                    datasets: [{
                        data: [{{ $eventStats['actifs'] }}, {{ $eventStats['clotures'] }}, {{ $eventStats['archives'] }}],
                        backgroundColor: ['#2563eb', '#10b981', '#64748b'],
                        borderWidth: 2
                    }]
                },
                options: {
                    cutout: '75%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        </script>
</x-super-admin-layout>