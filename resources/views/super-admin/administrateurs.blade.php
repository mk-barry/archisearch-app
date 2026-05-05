<x-super-admin-layout active="administrateurs">
    <x-slot:title>Gestion des administrateurs - ArchiSearch</x-slot>
        <div class="page-header">
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
            <div class="page-info">
                <div class="breadcrumb-small">Super Admin > Administrateurs</div>
                <h1>Gestion des administrateurs</h1>
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
                <select class="js-basic-multiple" name="filters[]" multiple="multiple" id="filtre">
                    <optgroup label="Statut">
                        <option value="tous">Tous</option>
                        <option value="actifs">Actifs</option>
                        <option value="inactifs">Inactifs</option>
                    </optgroup>

                    <optgroup label="Activité">
                        <option value="online">En ligne</option>
                        <option value="recent">Vu récemment</option>
                        <option value="never">Jamais connecté</option>
                    </optgroup>

                    <optgroup label="Nombres de documents">
                        <option value="500plus">500 documents ou plus</option>
                        <option value="500moins">500 documents ou moins</option>
                        <option value="100plus">100 documents ou plus</option>
                        <option value="100moins">100 documents ou moins</option>
                        <option value="50plus">50 documents ou plus</option>
                        <option value="50moins">50 documents ou moins</option>
                        <option value="10plus">10 documents ou plus</option>
                        <option value="10moins">10 documents ou moins</option>
                    </optgroup>

                </select>
                <select class="js-basic-multiple" name="sort[]" multiple="multiple" id="tri">
                    <optgroup label="Création">
                        <option value="new">Plus recent d'abord</option>
                        <option value="old">Moins recent d'abord</option>
                    </optgroup>
                    <optgroup label="Ordre">
                        <option value="az">A - Z</option>
                        <option value="za">Z - A</option>
                    </optgroup>
                    <optgroup label="Activité">
                        <option value="plusdocs">Plus de documents</option>
                        <option value="moinsdocs">Moins de documents</option>
                    </optgroup>
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
                                <td class="statut-cell" data-login="{{ $user->last_login_at }}"
                                    data-seen="{{ $user->last_seen_at }}">
                                    {!! $user->status !!}
                                </td>
                                <td style="font-weight: 500;">{{ $user->documents_count ?? 0 }}</td>
                                <td style="text-align: right; white-space: nowrap;">
                                    {{-- Bouton Modifier --}}
                                    <a href="{{ route('users.edit', $user->id) }}" class="action-btn" title="editer">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('super-admin.toggle-status', $user->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn btn-toggle"
                                            title="{{ $user->is_active ? 'Désactiver le compte' : 'Activer le compte' }}"
                                            style="color: {{ $user->is_active ? '#f97316' : '#22c55e' }}; border: none; background: none; cursor: pointer;"
                                            data-name="{{$user->name}}"
                                            data-status="{{$user->is_active ? 'Désactiver le compte' : 'Activer le compte'}}">

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
                const searchInput = document.getElementById('search-input');
                const tableBody = document.getElementById('table-body');
                const paginationContainer = document.getElementById('pagination-row');
                const filterSelect = document.getElementById('filtre');
                const sortSelect = document.getElementById('tri');
                let timeout = null;

                // --- FONCTION POUR CONSTRUIRE L'URL ---
                function getFullUrl(baseUrl, page = null) {
                    const url = new URL(baseUrl);

                    // 1. Recherche
                    if (searchInput.value) url.searchParams.set('search', searchInput.value);

                    // 2. Page
                    if (page) url.searchParams.set('page', page);

                    // 3. Filtres (on utilise jQuery car Select2 modifie le DOM)
                    const filters = $(filterSelect).val() || [];
                    filters.forEach(f => url.searchParams.append('filters[]', f));

                    // 4. Tris
                    const sorts = $(sortSelect).val() || [];
                    sorts.forEach(s => url.searchParams.append('sort[]', s));

                    return url.href;
                }

                function updateContent(url) {
                    fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            if (tableBody && doc.getElementById('table-body')) {
                                tableBody.innerHTML = doc.getElementById('table-body').innerHTML;
                            }
                            if (paginationContainer && doc.getElementById('pagination-row')) {
                                paginationContainer.innerHTML = doc.getElementById('pagination-row').innerHTML;
                            }

                            // Mise à jour de l'URL réelle pour le confort
                            window.history.pushState(null, '', url);
                        })
                        .catch(error => console.error('Erreur:', error));
                }

                // --- ÉVÉNEMENTS ---

                // Recherche
                if (searchInput) {
                    searchInput.addEventListener('keyup', function () {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => {
                            updateContent(getFullUrl("{{ route('super-admin.administrateurs') }}"));
                        }, 300);
                    });
                }

                // Filtres & Tris (Select2)
                $(filterSelect).on('change', function () {
                    updateContent(getFullUrl("{{ route('super-admin.administrateurs') }}"));
                });

                $(sortSelect).on('change', function () {
                    updateContent(getFullUrl("{{ route('super-admin.administrateurs') }}"));
                });

                // Pagination
                if (paginationContainer) {
                    paginationContainer.addEventListener('click', function (e) {
                        const link = e.target.closest('a');
                        if (link && link.getAttribute('href')) {
                            e.preventDefault();
                            // On extrait juste le numéro de page du lien cliqué
                            const pageUrl = new URL(link.getAttribute('href'));
                            const page = pageUrl.searchParams.get('page');
                            // On reconstruit l'URL avec TOUS les filtres + la page
                            updateContent(getFullUrl("{{ route('super-admin.administrateurs') }}", page));
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                    });
                }

                // --- TA GESTION SWEETALERT (Gardée à l'identique) ---
                if (tableBody) {
                    tableBody.addEventListener('click', function (e) {
                        const toggleBtn = e.target.closest('.btn-toggle');
                        if (toggleBtn) {
                            e.preventDefault();
                            const adminName = toggleBtn.getAttribute('data-name');
                            const form = toggleBtn.parentElement;
                            const actionUrl = form.getAttribute('action'); // On récupère l'URL de la route

                            Swal.fire({
                                title: 'Êtes-vous sûr ?',
                                text: `Vous allez modifier le statut du compte de ${adminName}.`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Oui, confirmer',
                                cancelButtonText: 'Annuler',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // --- ACTION AJAX AU LIEU DE SUBMIT ---
                                    fetch(actionUrl, {
                                        method: 'POST',
                                        body: new FormData(form), // Envoie les données du formulaire (CSRF inclus)
                                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                                    })
                                    .then(response => {
                                        if (response.ok) {
                                            // On affiche un petit message de succès discret
                                            Swal.fire('Succès !', 'Le statut a été mis à jour.', 'success');
                                            // ON RECHARGE LE TABLEAU SANS RECHARGER LA PAGE
                                            updateContent(getFullUrl("{{ route('super-admin.administrateurs') }}"));
                                        }
                                    })
                                    .catch(error => console.error('Erreur:', error));
                                }
                            });
                        }
                    });
                }

                // -        -- TON AUTO-REFRESH ---
                setInterval(function () {
                    const searchInput = document.getElementById('search-input');
                    if (document.activeElement !== searchInput && searchInput.value === "") {
                        updateContent(getFullUrl("{{ route('super-admin.administrateurs') }}"));
                    }
                }, 15000);
            });
        </script>
        <script>
            // Configuration Day.js
            dayjs.extend(window.dayjs_plugin_relativeTime);
            dayjs.locale('fr');

            function refreshUserStatuses() {
                document.querySelectorAll('.status-cell').forEach(cell => {
                    const lastSeenRaw = cell.getAttribute('data-seen');

                    if (lastSeenRaw) {
                        const lastSeen = dayjs(lastSeenRaw);
                        const now = dayjs();
                        const diffSeconds = now.diff(lastSeen, 'second');

                        // Logique "En ligne" si actif il y a moins de 60 secondes
                        if (diffSeconds < 60) {
                            cell.innerHTML = '<span style="color: #22c55e; font-weight: 600;">● En ligne</span>';
                        } else {
                            cell.innerHTML = '<span style="color: #64748b;">Vu ' + lastSeen.fromNow() + '</span>';
                        }
                    } else {
                        cell.innerHTML = '<span style="color: #94a3b8;">Jamais connecté</span>';
                    }
                });
            }

            // 1. Mettre à jour l'affichage toutes les 10 secondes (plus précis que 30s)
            setInterval(refreshUserStatuses, 10000);
            refreshUserStatuses(); // Lancement immédiat au chargement

            // 2. HEARTBEAT : Signaler ta propre présence au serveur sans recharger
            // On capte les interactions pour savoir si tu es vraiment actif
            let isUserActive = false;
            ['mousedown', 'keydown', 'scroll', 'touchstart'].forEach(type => {
                window.addEventListener(type, () => { isUserActive = true; }, { passive: true });
            });

            setInterval(function () {
                if (isUserActive) {
                    fetch("{{ route('user.heartbeat') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(() => {
                        // Après avoir prévenu le serveur, on met à jour notre propre data-seen 
                        // pour se voir "En ligne" immédiatement
                        const myId = "{{ auth()->id() }}"; // Nécessite que tu puisses identifier ta ligne
                        // Optionnel : updateContent(getFullUrl()); // Pour rafraîchir tout le tableau via ton AJAX précédent
                    });
                    isUserActive = false; // Reset pour le prochain cycle
                }
            }, 30000); // Signal toutes les 30 secondes
        </script>
        <script>
            $(document).ready(function () {
                // Initialisation de tous les selects ayant la classe exclusive
                const $exclusiveSelects = $('.js-basic-multiple').select2({
                    placeholder: "Sélectionner une option",
                    allowClear: true,
                    width: '30%'
                });

                // On écoute l'événement de sélection
                $exclusiveSelects.on('select2:select', function (e) {
                    const $currentSelect = $(this); // Le select précis (Filtre ou Tri)
                    const selectedOption = e.params.data.element; // L'élément cliqué
                    const $group = $(selectedOption).parent('optgroup'); // Son groupe

                    if ($group.length) {
                        // 1. Trouver toutes les options qui appartiennent au même groupe
                        const groupOptions = $group.find('option');

                        // 2. Récupérer les valeurs actuellement sélectionnées dans CE select
                        let currentValues = $currentSelect.val();

                        // 3. Retirer les autres options du même groupe de la sélection
                        groupOptions.each(function () {
                            if (this !== selectedOption) {
                                const index = currentValues.indexOf(this.value);
                                if (index > -1) {
                                    currentValues.splice(index, 1);
                                }
                            }
                        });

                        // 4. Mettre à jour Select2 pour ce menu précis
                        $currentSelect.val(currentValues).trigger('change.select2');
                    }
                });
            });
        </script>
</x-super-admin-layout>