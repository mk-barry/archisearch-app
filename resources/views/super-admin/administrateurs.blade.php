<x-super-admin-layout active="administrateurs">
    <x-slot:title>Gestion des administrateurs - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="breadcrumb-small">Super Admin > Administrateurs</div>
            <h1>Gestion des administrateurs</h1>
        </div>

        <!-- Controls Row -->
        <div class="controls-row">
            <div class="search-filter-group">
                <div class="input-wrapper"
                    style="display: flex; width: 350px; background: white; justify-content: center; align-items: center; gap: 5px; border-radius: 10px;">
                    <svg class="input-icon" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    <input type="text" placeholder="Rechercher un administrateur..."
                        style="width: 80%; padding: 0.75rem 1rem 0.75rem 1rem; border: none; outline: none;">
                </div>

                <button class="btn-outline">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
                    </svg>
                    Filtrer
                </button>
            </div>

            <a href="{{ route('super-admin.creation-admin') }}" class="btn-primary" style="text-decoration: none;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Créer un administrateur
            </a>
        </div>

        <!-- Data Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Administrateur</th>
                        <!-- <th>Organisation</th> -->
                        <th>Statut</th>
                        <th>Dernière connexion</th>
                        <th>Documents</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <!-- <tbody>
                <tr>
                    <td>
                        <div class="admin-info">
                            <div class="avatar" style="width: 36px; height: 36px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">PD</div>
                            <div>
                                <span class="admin-name">Pierre Dupont</span>
                                <span class="admin-email">p.dupont@admin.gouv</span>
                            </div>
                        </div>
                    </td>
                    <td>Direction RH</td>
                    <td><span class="badge badge-green">Actif</span></td>
                    <td>Aujourd'hui 09:42</td>
                    <td style="font-weight: 500;">1 234</td>
                    <td style="text-align: right; white-space: nowrap;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="admin-info">
                            <div class="avatar" style="width: 36px; height: 36px; font-size: 0.8rem; background: #fef3c7; color: #b45309;">MK</div>
                            <div>
                                <span class="admin-name">Marie Koné</span>
                                <span class="admin-email">m.kone@admin.gouv</span>
                            </div>
                        </div>
                    </td>
                    <td>Direction Finance</td>
                    <td><span class="badge badge-green">Actif</span></td>
                    <td>Hier 16:15</td>
                    <td style="font-weight: 500;">876</td>
                    <td style="text-align: right;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="admin-info">
                            <div class="avatar" style="width: 36px; height: 36px; font-size: 0.8rem; background: #dcfce7; color: #16a34a;">JM</div>
                            <div>
                                <span class="admin-name">Jean Mbatswe</span>
                                <span class="admin-email">j.mbatswe@admin.gouv</span>
                            </div>
                        </div>
                    </td>
                    <td>Direction IT</td>
                    <td><span class="badge badge-green">Actif</span></td>
                    <td>Aujourd'hui 11:02</td>
                    <td style="font-weight: 500;">2 105</td>
                    <td style="text-align: right;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="admin-info">
                            <div class="avatar" style="width: 36px; height: 36px; font-size: 0.8rem; background: #ede9fe; color: #6d28d9;">SN</div>
                            <div>
                                <span class="admin-name">Sophie Ndiaye</span>
                                <span class="admin-email">s.ndiaye@admin.gouv</span>
                            </div>
                        </div>
                    </td>
                    <td>Direction Juridique</td>
                    <td><span class="badge badge-orange">Inactif</span></td>
                    <td>03/03/2026</td>
                    <td style="font-weight: 500;">412</td>
                    <td style="text-align: right;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></button>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom: none;">
                        <div class="admin-info">
                            <div class="avatar" style="width: 36px; height: 36px; font-size: 0.8rem; background: #fee2e2; color: #b91c1c;">LB</div>
                            <div>
                                <span class="admin-name">Luc Bertrand</span>
                                <span class="admin-email">l.bertrand@admin.gouv</span>
                            </div>
                        </div>
                    </td>
                    <td style="border-bottom: none;">Direction Achats</td>
                    <td style="border-bottom: none;"><span class="badge badge-red">Suspendu</span></td>
                    <td style="border-bottom: none;">21/02/2026</td>
                    <td style="border-bottom: none; font-weight: 500;">98</td>
                    <td style="text-align: right; border-bottom: none;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></button>
                    </td>
                </tr>
            </tbody> -->
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="admin-info">
                                    <div class="avatar"
                                        style="width: 36px; height: 36px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <span class="admin-name">{{ $user->name }}</span>
                                        <span class="admin-email">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <!-- <td>{{ $user->organisation ?? 'Non spécifiée' }}</td> -->
                            <td>
                                <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-orange' }}">
                                    {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais' }}</td>
                            <td style="font-weight: 500;">{{ $user->documents_count ?? 0 }}</td>
                            <td style="text-align: right; white-space: nowrap;">
                                {{-- Bouton Modifier --}}
                                <a href="{{ route('users.edit', $user->id) }}" class="action-btn">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                    </svg>
                                </a>

                                {{-- Bouton Supprimer --}}
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;"
                                    onsubmit="return confirm('Supprimer cet admin ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn"
                                        style="color: red; border: none; background: none; cursor: pointer;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path
                                                d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-row">
            <span>
                Affichage {{ $users->firstItem() }}-{{ $users->lastItem() }} sur {{ $users->total() }} administrateurs
            </span>
        
            <div class="page-numbers">
                {{-- Bouton Précédent --}}
                @if ($users->onFirstPage())
                    <button class="page-btn" disabled style="opacity: 0.5; cursor: not-allowed;">Précédent</button>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="page-btn" style="text-decoration: none;">Précédent</a>
                @endif
        
                {{-- Numéros de pages --}}
                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="page-btn {{ ($page == $users->currentPage()) ? 'active' : '' }}"
                        style="text-decoration: none;">
                        {{ $page }}
                    </a>
                @endforeach
        
                {{-- Bouton Suivant --}}
                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="page-btn" style="text-decoration: none;">Suivant</a>
                @else
                    <button class="page-btn" disabled style="opacity: 0.5; cursor: not-allowed;">Suivant</button>
                @endif
            </div>
        </div>
</x-super-admin-layout>