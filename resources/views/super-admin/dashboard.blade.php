<x-super-admin-layout active="supervision">
    <x-slot:title>Supervision - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="page-info">
                <div class="breadcrumb-small">Super Admin > Supervision</div>
                <h1>Tableau de bord de supervision</h1>
            </div>
            <div class="admin-info">
                <div class="avatar"
                    style="width: 40px; height: 40px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar ">
                    @else
                    {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                @endif
            </div>
            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                <span class="admin-name">{{ Auth::user()->name }}</span>
                <span class="admin-mail">{{ ucfirst(Auth::user()->role) }}</span>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Administrateurs actifs</span>
            <span class="stat-value">{{ $activeAdmins }}</span>
            <span style="color: #94a3b8; font-size: 0.8rem;">sur {{ $totalAdmins }} comptes</span>
            <div style="margin-top: 0.75rem;"><span class="trend up">↑ stable</span> <span style="color: #94a3b8; font-size: 0.8rem;">vs. mois dernier</span></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-green">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2c0 1.1.9 2 2 2h5v5c0 1.1.9 2 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z"/></svg>
            </div>
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Événements</span>
            <span class="stat-value">{{ array_sum($eventStats) }}</span>
            <span style="color: #94a3b8; font-size: 0.8rem;">{{ $eventStats['actifs'] }} en cours</span>
            <div style="margin-top: 0.75rem;"><span class="trend up">↑ +{{ $eventStats['clotures'] }}</span> <span style="color: #94a3b8; font-size: 0.8rem;">clôturés</span></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M12 2v20"/><path d="M8 7h6"/><path d="M8 11h6"/><path d="M8 15h6"/></svg>
            </div>
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Documents archivés</span>
            <span class="stat-value">{{ number_format($totalDocs, 0, ',', ' ') }}</span>
            <span style="color: #94a3b8; font-size: 0.8rem;">+{{ $docsThisWeek }} cette semaine</span>
            <div style="margin-top: 0.75rem;"><span class="trend up">↑ Actif</span></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-red">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            </div>
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Anomalies</span>
            <span class="stat-value">{{ $anomalies }}</span>
            <span style="color: #94a3b8; font-size: 0.8rem;">Alerte intégrité</span>
            <div style="margin-top: 0.75rem;"><span class="{{ $anomalies > 0 ? 'trend down' : 'trend up' }}">{{ $anomalies > 0 ? 'Action requise' : 'Système sain' }}</span></div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <div class="card-title">Activité système — 7 derniers jours</div>
            <div style="height: 250px; position: relative; margin-top: 2rem;">
                <canvas id="myPointChart"></canvas>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-title">Répartition des événements</div>
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
                <div style="position: relative; width: 150px; height: 150px; margin-bottom: 2rem;">
                    <canvas id="moncercle"></canvas>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                        <span style="font-size: 1.5rem; font-weight: 800;">{{ array_sum($eventStats) }}</span>
                        <span style="display: block; font-size: 0.6rem; color: #94a3b8;">TOTAL</span>
                    </div>
                </div>
                <div style="width: 100%; font-size: 0.85rem;">
                    @foreach($eventStats as $label => $val)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 10px; height: 10px; border-radius: 2px; background: {{ $loop->first ? '#2563eb' : ($loop->iteration == 2 ? '#10b981' : '#64748b') }};"></div>
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
                <a href="{{ route('super-admin.logs') }}" style="font-size: 0.8rem; font-weight: 500; color: #2563eb; text-decoration: none;">Voir tous les journaux</a>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($recentActivities as $log)
                    <div style="display: flex; gap: 1rem; align-items: center; padding: 0.75rem; border-radius: 12px; background: #f8fafc;">
                        <div class="stat-icon icon-blue" style="width: 36px; height: 36px; margin-bottom: 0;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.9rem; font-weight: 600;">{{ $log->message }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ $log->created_at->diffForHumans() }} par {{ $log->user->name ?? 'Systeme' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-title">Utilisateurs en ligne</div>
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                @foreach($onlineUsers as $online)
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div class="avatar" style="width: 32px; height: 32px; font-size: 0.8rem;">
                            {{ collect(explode(' ', $online->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 0.85rem; font-weight: 600;">{{ $online->name }}</div>
                            <div style="font-size: 0.7rem; color: #94a3b8;">{{ ucfirst($online->role) }}</div>
                        </div>
                        <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%;"></div>
                    </div>
                @endforeach
                <div style="text-align: center; margin-top: 1rem; font-size: 0.8rem; color: #94a3b8;">
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