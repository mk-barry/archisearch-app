<x-admin-layout sec_css="{{ asset('css/admin/dashboard.css') }}" active="dashboard">
    <div class="page-header">
        <h1>Tableau de bord</h1>
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
            <div class="stat-icon badge-blue"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2" /><line x1="16" x2="16" y1="2" y2="6" /><line x1="8" x2="8" y1="2" y2="6" /><line x1="3" x2="21" y1="10" y2="10" /></svg></div>
            <span class="stat-label">Événements actifs</span>
            <span class="stat-value">{{ $stats['evenements_actifs'] }}</span>
            <div style="margin-top: 0.75rem;">
                <span class="trend up">↑ +1</span> 
                <span class="trend-text">vs. mois dernier</span></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon badge-green"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><polyline points="14 2 14 8 20 8" /></svg></div>
            <span class="stat-label">Documents reçus</span>
            <span class="stat-value">{{ $stats['docs_recus_semaine'] }}</span>
            <span class="stat-subtext">cette semaine</span>
            <div style="margin-top: 0.75rem;">
                <span class="trend up">↑ +47</span>
                <span class="trend-text">vs. mois dernier</span></div>
        </div>

        <div class="stat-card">
            <div class="stat-icon badge-orange"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" /><polyline points="12 6 12 12 16 14" /></svg></div>
            <span class="stat-label">En attente</span>
            <span class="stat-value">{{ $stats['en_attente'] }}</span>
        </div>

        <div class="stat-card">
            <div class="stat-icon badge-red"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg></div>
            <span class="stat-label">Anomalies</span>
            <span class="stat-value">{{ $stats['anomalies'] }}</span>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <div class="card-title">Téléversements (7 derniers jours)</div>
            <div class="chart-container">
                <canvas id="myline"></canvas>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-title">Événements — Statuts</div>
            <div class="chart-container">
                @foreach(['Actifs' => 'actifs', 'Clôturés' => 'clotures', 'Brouillons' => 'brouillons', 'Archivés' => 'archives'] as $label => $key)
                    <div class="compact-progress-row">
                        <div class="compact-progress-label">
                            <span>{{ $label }}</span>
                            <span>{{ $evenementStats[$key] }}</span>
                        </div>
                        <div class="compact-progress-bg">
                            <div class="compact-progress-fill" style="width: {{ ($evenementStats['total'] > 0 ? ($evenementStats[$key] / $evenementStats['total']) * 100 : 0) }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <div class="card-title">Derniers téléversements</div>
            <div class="file-list">
                @foreach($derniersDocs as $doc)
                    <div class="file-item">
                        <div class="file-icon-box bg-pdf">PDF</div>
                        <div class="file-info">
                            <div class="file-title">{{ Str::limit($doc->title, 25) }}</div>
                            <div class="file-author">{{ $doc->student->name ?? 'Anonyme' }}</div>
                        </div>
                        <div class="file-meta">
                            <span class="badge" style="background: #f1f5f9;">{{ $doc->status }}</span>
                            <div class="file-time">{{ $doc->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-title">Invités sans soumission</div>
            <div class="user-list">
                @foreach($invitesEnAttente as $invite)
                    <div class="user-item">
                        <div class="avatar-base avatar-sm" style="background: #e2e8f0; color: #1e293b;">
                            {{ strtoupper(substr($invite->name, 0, 2)) }}
                        </div>
                        <div class="file-info">
                            <div class="file-title">{{ $invite->name }}</div>
                            <div class="file-author">{{ $invite->email }}</div>
                        </div>
                        <span class="badge badge-orange">En attente</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myline').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($last7Days->pluck('label')) !!},
                datasets: [{
                    label: 'Téléversements',
                    data: {!! json_encode($last7Days->pluck('count')) !!},
                    borderColor: '#2563eb',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    </script>
</x-admin-layout>