<x-admin-layout pri_css="{{  asset('css/dashboard/main.css') }}" active="dashboard">
    <div class="page-header">
        <h1>Tableau de bord</h1>
        <div class="admin-info">
            <div class="avatar"
                style="width: 40px; height: 40px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1; display: flex; align-items: center; justify-content: center; border-radius: 50%; overflow: hidden;">
                @if(Auth::user()->avatar_path)
                    <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}" alt="Avatar"
                        style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}
                @endif
            </div>
            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                <span class="admin-name">{{ Auth::user()->name }}</span>
                <span class="admin-mail" style="text-transform: capitalize;">{{ Auth::user()->role }}</span>
            </div>
        </div>
    </div>

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
            <span class="stat-value">{{ $stats['evenements_actifs'] }}</span>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #f0fdf4; color: #10b981;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
            </svg>
            </div>
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Documents reçus</span>
            <span class="stat-value">{{ $stats['docs_recus_semaine'] }}</span>
            <span style="color: #94a3b8; font-size: 0.8rem;">cette semaine</span>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #fffbeb; color: #f59e0b;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <polyline points="12 6 12 12 16 14" />
            </svg>
            </div>
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">En attente</span>
            <span class="stat-value">{{ $stats['en_attente'] }}</span>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #fef2f2; color: #ef4444;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
            </div>
            <span style="color: #64748b; font-size: 0.9rem; font-weight: 500;">Anomalies</span>
            <span class="stat-value">{{ $stats['anomalies'] }}</span>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <div class="card-title">Téléversements (7 derniers jours)</div>
            <div style="height: 250px; position: relative; margin-top: 1rem;">
                <canvas id="myline"></canvas>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-title">Événements — Statuts</div>
            <div style="margin-top: 2rem;">
                @foreach(['Actifs' => 'actifs', 'Clôturés' => 'clotures', 'Brouillons' => 'brouillons', 'Archivés' => 'archives'] as $label => $key)
                    <div class="compact-progress-row" style="margin-bottom: 1rem;">
                        <div class="compact-progress-label"
                            style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                            <span>{{ $label }}</span>
                            <span>{{ $evenementStats[$key] }}</span>
                        </div>
                        <div class="compact-progress-bg"
                            style="background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden;">
                            <div class="compact-progress-fill"
                                style="width: {{ ($evenementStats[$key] / $evenementStats['total']) * 100 }}%; background: #1e3a8a; height: 100%;">
                            </div>
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
                    <div class="file-item"
                        style="display: flex; gap: 1rem; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9;">
                        <div class="file-icon-box bg-pdf">PDF</div>
                        <!-- <div class="file-icon-box"
                            style="padding: 0.5rem; background: #fee2e2; border-radius: 6px; font-weight: bold; font-size: 0.7rem;">
                            {{ strtoupper(pathinfo($doc->path, PATHINFO_EXTENSION)) }}</div> -->
                        <div style="flex: 1;">
                            <div style="font-weight: 700; font-size: 0.9rem;">{{ Str::limit($doc->title, 25) }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ $doc->student->name ?? 'Anonyme' }}</div>
                        </div>
                        <div style="text-align: right;">
                            <span class="badge"
                                style="padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.7rem; background: #f1f5f9;">{{ $doc->status }}</span>
                            <div style="font-size: 0.7rem; color: #94a3b8;">{{ $doc->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-title">Invités sans soumission</div>
            <div class="user-list">
                @foreach($invitesEnAttente as $invite)
                    <div class="user-item" style="display: flex; gap: 1rem; align-items: center; padding: 0.75rem 0;">
                        <div class="avatar"
                            style="width: 35px; height: 35px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold;">
                            {{ strtoupper(substr($invite->name, 0, 2)) }}
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; font-size: 0.85rem;">{{ $invite->name }}</div>
                            <div style="font-size: 0.7rem; color: #94a3b8;">{{ $invite->email }}</div>
                        </div>
                        <span class="badge"
                            style="color: #f59e0b; background: #fffbeb; font-size: 0.7rem; padding: 0.2rem 0.5rem;">En
                            attente</span>
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
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    </script>
</x-admin-layout>