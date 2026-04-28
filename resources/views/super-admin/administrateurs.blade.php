<x-super-admin-layout active="administrateurs">
    <x-slot:title>Gestion des administrateurs - ArchiSearch</x-slot>
        <div class="page-header">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script defer>
                $(document).ready(function () {
                        $('.js-example-basic-multiple').select2();
                    });
            </script>
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
                <!-- @elseif (session('danger'))
                    <script>
                        Swal.fire({
                            title: 'Succès !',
                            text: "{{ session('danger') }}",
                            icon: 'success',
                            confirmButtonColor: '#0369a1', // Le bleu de ton interface
                            confirmButtonText: 'Ok'
                        });
                    </script> -->
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
                <select class="js-example-basic-multiple" name="states[]" multiple="multiple" id="filtre">
                    <optgroup label="Statut">
                        <option value="tous">Tous</option>
                        <option value="actifs">Actifs</option>
                        <option value="inactifs">Inactifs</option>
                    </optgroup> 
                                    
                    <optgroup label="Nombres de documents">
                        <option value="500+">Plus de 500 documents</option>
                        <option value="500-">Moins de 500 documents</option>
                        <option value="100+">Plus de 100 documents</option>
                        <option value="100-">Moins de 100 documents</option>
                        <option value="50+">Plus de 50 documents</option>
                        <option value="50-">Moins de 50 documents</option>
                        <option value="10+">Plus de 10 documents</option>
                        <option value="10-">Moins de 10 documents</option>
                    </optgroup>

                </select>
                <select class="js-example-basic-multiple" name="states[]" multiple="multiple" id="tri">
                    <option value="default" selected>-- Trier Par --</option>
                    <option value="new">Plus recent d'abord</option>
                    <option value="old">Moins recent d'abord</option>
                    <option value="az">A - Z</option>
                    <option value="WY">Plus de 10 documents</option>
                    <option value="WY">Moins de 10 documents</option>
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
                                    <a href="{{ route('users.edit', $user->id) }}" class="action-btn" title="editer">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                        </svg>
                                    </a>

                                    {{-- Bouton Supprimer --}}
                                    <!-- <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="action-btn btn-delete" data-name="{{ $user->name }}"
                                                    style="color: red; border: none; background: none; cursor: pointer;"  title="supprimer">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path
                                                            d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                    </svg>
                                                </button>
                                            </form> -->
                                    <form action="{{ route('super-admin.toggle-status', $user->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn btn-toggle"
                                            title="{{ $user->is_active ? 'Désactiver le compte' : 'Activer le compte' }}"
                                            style="color: {{ $user->is_active ? '#f97316' : '#22c55e' }}; border: none; background: none; cursor: pointer;" data-name="{{$user->name}}" data-status="{{$user->is_active ? 'Désactiver le compte' : 'Activer le compte'}}">

                                            @if($user->is_active)
                                                {{-- Icône Silhouette + Croix (Désactiver) --}}
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                                    <circle cx="9" cy="7" r="4" />
                                                    <line x1="17" x2="22" y1="8" y2="13" />
                                                    <line x1="22" x2="17" y1="8" y2="13" />
                                                </svg>
                                            @else
                                                {{-- Icône Silhouette + Coche (Activer) --}}
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                                    <circle cx="9" cy="7" r="4" />
                                                    <polyline points="16 11 18 13 22 9" />
                                                </svg>
                                            @endif

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
        <div id="pagination-row" class="pagination-row">
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
                // 1. Définition des sélecteurs (IDs de ton code Blade)
                const searchInput = document.getElementById('search-input');
                const tableBody = document.getElementById('table-body');
                const paginationContainer = document.getElementById('pagination-row');

                let timeout = null;

                /**
                 * FONCTION UNIFIÉE DE MISE À JOUR (AJAX)
                 * Utilisée pour la recherche et pour la pagination
                 */
                function updateContent(url) {
                    fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            // Mise à jour des fragments HTML
                            if (tableBody && doc.getElementById('table-body')) {
                                tableBody.innerHTML = doc.getElementById('table-body').innerHTML;
                            }
                            if (paginationContainer && doc.getElementById('pagination-row')) {
                                paginationContainer.innerHTML = doc.getElementById('pagination-row').innerHTML;
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors du chargement des données:', error);
                        });
                }

                /**
                 * GESTION DE LA RECHERCHE (KEYUP)
                 */
                if (searchInput) {
                    searchInput.addEventListener('keyup', function () {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => {
                            // On construit l'URL de recherche proprement
                            const query = encodeURIComponent(this.value);
                            const url = `{{ route('super-admin.administrateurs') }}?search=${query}`;
                            updateContent(url);
                        }, 300); // Délai de 300ms pour ne pas harceler le serveur
                    });
                }

                /**
                 * GESTION DE LA PAGINATION (CLIC SUR LES LIENS)
                 * Utilisation de la délégation d'événement car les boutons changent
                 */
                if (paginationContainer) {
                    paginationContainer.addEventListener('click', function (e) {
                        const link = e.target.closest('a');
                        if (link && link.getAttribute('href')) {
                            e.preventDefault();
                            const url = link.getAttribute('href');
                            updateContent(url);
                            // Remonter en haut de la liste pour le confort utilisateur
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                    });
                }

                /**
 * GESTION DE LA SUPPRESSION (SWEETALERT2)
 */
                if (tableBody) {
                    tableBody.addEventListener('click', function (e) {
                        // On cherche le bouton
                        const toggleBtn = e.target.closest('.btn-toggle');

                        if (toggleBtn) {
                            e.preventDefault(); // On empêche toute action automatique

                            const adminName = toggleBtn.getAttribute('data-name');
                            // On récupère le formulaire parent du bouton cliqué
                            const form = toggleBtn.parentElement;
                            const status = toggleBtn.getAttribute('data-status');

                            Swal.fire({
                                title: 'Êtes-vous sûr ?',
                                text: `Vous allez ${status} le compte de ${adminName}.`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Oui, confirmer',
                                cancelButtonText: 'Annuler',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Au lieu de form.submit(), on utilise la méthode HTML originale 
                                    // pour éviter les conflits avec d'autres scripts
                                    HTMLFormElement.prototype.submit.call(form);
                                }
                            });
                        }
                    });
                }
            });
        </script>
</x-super-admin-layout>