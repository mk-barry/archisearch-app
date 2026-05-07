<x-super-admin-layout active="logs">
    <x-slot:title>Journaux système - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="page-info">
                <div class="breadcrumb-small">Super Admin > Journaux système</div>
                <h1>Journaux système</h1>
            </div>
            <div class="admin-info">
                <div class="avatar"
                    style="width: 40px; height: 40px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
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

        <!-- Controls Row -->
        <div class="controls-row">
            <div class="search-filter-group" style="flex: 2;">
                <form method="GET" class="input-wrapper"
                    style="width: 300px; display: flex; align-items: center;  border: 1px solid #e2e8f0; border-radius: 10px; background: white; justify-content: center">
                    <svg class="input-icon" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Filtrer par action, utilisateur..."
                        style="width: 80%; padding: 0.75rem 1rem 0.75rem 0.75rem; outline: none; border: none;">
                </form>

                <!-- <div class="btn-outline" style="background: white;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                        <line x1="16" x2="16" y1="2" y2="6" />
                        <line x1="8" x2="8" y1="2" y2="6" />
                        <line x1="3" x2="21" y1="10" y2="10" />
                    </svg>
                    04 Avr 2026
                </div> -->

                <div class="log-tabs">
                    <a href="{{ route('super-admin.logs') }}" class="log-tab {{ !request('level') ? 'active' : '' }}">
                        Tous
                    </a>
                    <a href="{{ route('super-admin.logs', ['level' => 'info']) }}"
                        class="log-tab {{ request('level') == 'info' ? 'active' : '' }}">
                        INFO
                    </a>
                    <a href="{{ route('super-admin.logs', ['level' => 'alerte']) }}"
                        class="log-tab {{ request('level') == 'warning' ? 'active' : '' }}">
                        WARNING
                    </a>
                    <a href="{{ route('super-admin.logs', ['level' => 'erreur']) }}"
                        class="log-tab {{ request('level') == 'error' ? 'active' : '' }}">
                        ERROR
                    </a>
                </div>
            </div>

            <div style="display: flex; gap: 1rem;">
                <!-- <button class="btn-outline">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18" />
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        <line x1="10" x2="10" y1="11" y2="17" />
                        <line x1="14" x2="14" y1="11" y2="17" />
                    </svg>
                    Purger les logs
                </button> -->
                <button class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" x2="12" y1="15" y2="3" />
                    </svg>
                    Exporter
                </button>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Horodatage</th>
                        <th>Utilisateur</th>
                        <th>Action</th>
                        <th>Cible</th>
                        <th>Adresse IP</th>
                        <th>Niveau</th>
                    </tr>
                </thead>
                <tbody id="logsTable">
                    @foreach ($recentActivities as $log)
                        <tr>
                            <td style="color: #94a3b8;">{{ $log->created_at }}</td>
                            <td style="font-weight: 600;">
                                {{ $log->user->role ?? 'User' }}.{{ $log->user->name ?? 'Systeme' }}</td>
                            <td style="text-transform: uppercase;"><span
                                    class="action-text">{{ $log->actionDescription->slug }}</span></td>
                            <td>{{ $log->target }}</td>
                            <td>{{ $log->ip_address }}</td>
                            <td style="text-align: right; text-transform: uppercase;">
                                <span class="badge
                                    @if ($log->actionDescription->badge === 'info')
                                        badge-blue
                                    @elseif($log->actionDescription->badge === 'alerte')
                                        badge-orange
                                    @elseif($log->actionDescription->badge === 'erreur')
                                        badge-red
                                    @endif
                                ">
                                    {{ $log->actionDescription->badge }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script>
            async function refreshLogs() {

                const response = await fetch("{{ route('super-admin.logs.refresh') }}");

                const logs = await response.json();

                let html = '';

                logs.forEach(log => {

                    let badgeClass = '';

                    if (log.action_description.badge === 'info')
                        badgeClass = 'badge-blue';
                    else if (log.action_description.badge === 'alerte')
                        badgeClass = 'badge-orange';
                    else if (log.action_description.badge === 'erreur')
                        badgeClass = 'badge-red';

                    html += `
        <tr>
            <td>${log.created_at}</td>
            <td>${log.user?.role ?? 'System'}.${log.user?.name ?? ''}</td>
            <td>${log.action_description.slug}</td>
            <td>${log.dynamic_data?.name ?? dynamic_data?.target ?? ''}</td>
            <td>${log.ip_address ?? '-'}</td>
            <td style="text-align:right">
                <span class="badge ${badgeClass}">
                    ${log.action_description.badge}
                </span>
            </td>
        </tr>`;
                });

                document.getElementById('logsTable').innerHTML = html;
            }

            /* refresh toutes les 5 secondes */
            setInterval(refreshLogs, 5000);

            /* premier chargement */
            refreshLogs();
        </script>
</x-super-admin-layout>