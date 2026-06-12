<x-super-admin-layout active="logs"  sec_css="tables.css">
    <x-slot:title>Journaux système - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="page-info">
                <div class="breadcrumb-small">Super Admin > Journaux système</div>
                <h1>Journaux système</h1>
            </div>
            <div class="admin-info header">
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

        <!-- Controls Row -->
        <div class="controls-row">
            <div class="search-filter-group" style="flex: 2;">
                <div class="input-wrapper"
                    style="width: 300px; display: flex; align-items: center; border: 1px solid #e2e8f0; border-radius: 10px; background: white;">
                    <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-left: 10px; color: #94a3b8;">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    <input type="text" id="log-search" placeholder="Filtrer..."
                        style="width: 100%; padding: 0.75rem; outline: none; border: none; background: transparent;">
                </div>

                <div class="log-tabs" id="level-filters">
                    <button data-level="" value="" class="log-tab active">Tous</button>
                    <button data-level="info" value="info" class="log-tab">INFO</button>
                    <button data-level="alerte" value="alerte" class="log-tab">ALERTE</button>
                    <button data-level="erreur" value="erreur" class="log-tab">ERREUR</button>
                </div>
            </div>
        </div>

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
                    @fragment('logs-table')
                        @foreach ($recentActivities as $log)
                            <tr>
                                <td style="color: #94a3b8;" data-label="horodatage">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                <td style="font-weight: 600;" data-label="utilisateur">{{ $log->user->role ?? 'System' }}.{{ $log->user->name ?? '' }}
                                </td>
                                <td data-label="action"><span class="action-text">{{ $log->actionDescription->slug ?? 'ACTION' }}</span></td>
                                <td data-label="cible">{{ $log->target }}</td>
                                <td data-label="adresse ip">{{ $log->ip_address }}</td>
                                <td style="text-align: right;" data-label="categorie">
                                    <span class="badge 
                                            @if(($log->actionDescription->badge ?? '') === 'info') badge-blue 
                                            @elseif(($log->actionDescription->badge ?? '') === 'alerte') badge-orange 
                                            @else badge-red @endif">
                                        {{ strtoupper($log->actionDescription->badge ?? 'INFO') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endfragment
                </tbody>
            </table>
        </div>

        <div id="pagination-row" class="pagination-row"
            style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
            @fragment('pagination')
                <span style="color: #64748b; font-size: 0.9rem;">
                    Affichage {{ $recentActivities->firstItem() ?? 0 }}-{{ $recentActivities->lastItem() ?? 0 }} sur
                    {{ $recentActivities->total() }} logs
                </span>

                <div class="page-numbers" style="display: flex; gap: 5px;">
                    @if (!$recentActivities->onFirstPage())
                        <a href="{{ $recentActivities->previousPageUrl() }}" class="page-btn">Précédent</a>
                    @endif

                    @foreach ($recentActivities->getUrlRange(1, $recentActivities->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="page-btn {{ ($page == $recentActivities->currentPage()) ? 'active' : '' }}">{{ $page }}</a>
                    @endforeach

                    @if ($recentActivities->hasMorePages())
                        <a href="{{ $recentActivities->nextPageUrl() }}" class="page-btn">Suivant</a>
                    @endif
                </div>
            @endfragment
        </div>
</x-super-admin-layout>