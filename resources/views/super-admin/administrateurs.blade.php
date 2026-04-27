<x-super-admin-layout active="administrateurs">
    <x-slot:title>Gestion des administrateurs - ArchiSearch</x-slot>
        <div class="page-header">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            @if (session('success'))
                <script>
                    Swal.fire({
                        title: 'Succès !',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonColor: '#0369a1', // Le bleu de ton interface
                        confirmButtonText: 'Génial'
                    });
                </script>
            @elseif (session('danger'))
                <script>
                    Swal.fire({
                        title: 'Succès !',
                        text: "{{ session('danger') }}",
                        icon: 'success',
                        confirmButtonColor: '#0369a1', // Le bleu de ton interface
                        confirmButtonText: 'Ok'
                    });
                </script>
            @endif
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
                    <input type="text" id="search-input" placeholder="Rechercher un administrateur..."
                        style="width: 80%; padding: 0.75rem 1rem 0.75rem 1rem; border: none; outline: none;">
                </div>
                <select name="status" id="status" class="btn-outline">
                    <option value="default" disabled selected>Trier par</option>
                    <option value="all">Tous</option>
                    <option value="active+10">Actif +10 docs</option>
                    <option value="active-10">Actif -10 docs</option>
                    <option value="inactive">Inactif</option>
                </select>
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
                <tbody id="table-body">
                    @fragment('user-table')
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="admin-info">
                                        <div class="avatar"
                                            style="width: 36px; height: 36px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
                                            {{ collect(explode(' ', $user->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                                        </div>
                                        <div style="display: flex; flex-direction: column; align-items: flex-start;">
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
                    @endfragment
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-row">
            @fragment('pagination')
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
            @endfragment
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('search-input');
                const tableBody = document.getElementById('table-body');
                const paginationContainer = document.getElementById('pagination-row');

                let timeout = null;

                searchInput.addEventListener('keyup', function () {
                    clearTimeout(timeout);

                    timeout = setTimeout(() => {
                        let query = this.value;

                        fetch(`{{ route('super-admin.administrateurs') }}?search=${query}`, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                            .then(response => response.text())
                            .then(html => {
                                // On utilise un petit astuce : on crée un élément temporaire pour parser le HTML reçu
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');

                                // On remplace le contenu par les nouveaux fragments
                                tableBody.innerHTML = doc.getElementById('table-body').innerHTML;
                                paginationContainer.innerHTML = doc.getElementById('pagination-row').innerHTML;
                            });
                    }, 300);
                });
            });
        </script>
</x-super-admin-layout>