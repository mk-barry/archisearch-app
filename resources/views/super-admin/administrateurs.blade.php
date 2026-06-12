<x-super-admin-layout active="administrateurs"  sec_css="tables.css">
    <x-slot:title>Gestion des administrateurs - ArchiSearch</x-slot>
        <div class="page-header">
            <div class="page-info">
                <div class="breadcrumb-small">Super Admin > Administrateurs</div>
                <h1>Gestion des administrateurs</h1>
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

        <!-- Controls Row -->
        <div class="controls-row">
            <div class="search-filter-group">
                <div class="input-wrapper">
                    <svg class="input-icon" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    <input type="text" id="search-input" placeholder="Rechercher un administrateur...">
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

            <a href="{{ route('super-admin.creation-admin') }}" class="btn-primary last">
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
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @fragment('user-table')
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    @php
                                            $colors = [
                                                '#0369a1',
                                                '#059669',
                                                '#16a34a',
                                                '#1e293b',
                                                '#2563eb',
                                                '#6366f1',
                                                '#dc2626'
                                            ];

                                            $color = $colors[$user->id % count($colors)];
                                        @endphp
                                    <div class="admin-info-mobile">
                                        <div class="avatar-base avatar-sm" style="background-color: {{ $color }}; color: #fff;" data-name="{{ $user->name }}">
                                            @if($user->avatar_path)
                                                <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="Avatar">
                                            @else
                                                {{ collect(explode(' ', $user->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}
                                            @endif
                                        </div>
                                        <div class="flex-col-start">
                                            <span class="admin-name">{{ $user->name }}</span>
                                            <span class="admin-email">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <!-- <td>{{ $user->organisation ?? 'Non spécifiée' }}</td> -->
                                <td data-label="statut">
                                    <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-orange' }}">
                                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td class="statut-cell" data-login="{{ $user->last_login_at }}"
                                    data-seen="{{ $user->last_seen_at }}" data-label="connexion">
                                    {!! $user->status !!}
                                </td>
                                <td class="text-center fw-600" data-label="documents">{{ $user->documents_count ?? 0 }}</td>
                                <td class="text-right whitespace-nowrap" data-label="actions"  style="">
                                    {{-- Bouton Modifier --}}
                                    <a href="{{ route('users.edit', $user->id) }}" class="action-btn no-ajax" title="editer">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('super-admin.toggle-status', $user->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            title="{{ $user->is_active ? 'Désactiver le compte' : 'Activer le compte' }}"
                                             class="action-btn btn-toggle {{ $user->is_active ? 'text-warning' : 'text-success' }}"
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

                /* ===============================
                   CONSTRUCTION URL
                =============================== */
                function getFullUrl(baseUrl, page = null) {

                    const url = new URL(baseUrl);

                    if (searchInput?.value)
                        url.searchParams.set('search', searchInput.value);

                    if (page)
                        url.searchParams.set('page', page);

                    const filters = $(filterSelect).val() || [];
                    filters.forEach(f => url.searchParams.append('filters[]', f));

                    const sorts = $(sortSelect).val() || [];
                    sorts.forEach(s => url.searchParams.append('sort[]', s));

                    return url.href;
                }

                /* ===============================
                   AJAX UPDATE
                =============================== */
                function updateContent(url, push = true) {

                    fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                        .then(r => r.text())
                        .then(html => {

                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            const newTable = doc.getElementById('table-body');
                            const newPagination = doc.getElementById('pagination-row');

                            if (newTable && tableBody)
                                tableBody.innerHTML = newTable.innerHTML;

                            refreshUserStatuses();

                            if (newPagination && paginationContainer)
                                paginationContainer.innerHTML = newPagination.innerHTML;

                            if (push)
                                history.pushState({ url }, '', url);
                        })
                        .catch(err => console.error(err));
                }

                /* ===============================
                   RECHERCHE
                =============================== */
                if (searchInput) {
                    searchInput.addEventListener('keyup', function () {

                        clearTimeout(timeout);

                        timeout = setTimeout(() => {
                            updateContent(
                                getFullUrl("{{ route('super-admin.administrateurs') }}")
                            );
                        }, 300);
                    });
                }

                /* ===============================
                   FILTRES
                =============================== */
                $(filterSelect).on('change', function () {
                    updateContent(
                        getFullUrl("{{ route('super-admin.administrateurs') }}")
                    );
                });

                /* ===============================
                   TRI
                =============================== */
                $(sortSelect).on('change', function () {
                    updateContent(
                        getFullUrl("{{ route('super-admin.administrateurs') }}")
                    );
                });

                /* ===============================
                   PAGINATION AJAX
                =============================== */
                paginationContainer?.addEventListener('click', function (e) {

                    const link = e.target.closest('a');

                    if (!link) return;

                    e.preventDefault();

                    const pageUrl = new URL(link.href);
                    const page = pageUrl.searchParams.get('page');

                    updateContent(
                        getFullUrl(
                            "{{ route('super-admin.administrateurs') }}",
                            page
                        )
                    );

                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });

                /* ===============================
                   ⭐ CORRECTION PRINCIPALE
                   BOUTON RETOUR NAVIGATEUR
                =============================== */
                window.addEventListener('popstate', function (event) {

                    if (event.state?.url) {
                        updateContent(event.state.url, false);
                    } else {
                        updateContent(window.location.href, false);
                    }
                });

                /* =======================================
                    SWEETALERT TOGGLE STATUS (Optimisé)
                ======================================= */
                tableBody?.addEventListener('click', function (e) {

                    const toggleBtn = e.target.closest('.btn-toggle');

                    if (!toggleBtn) return;

                    e.preventDefault();

                    const form = toggleBtn.closest('form');
                    const adminName = toggleBtn.dataset.name;
                    const actionText = toggleBtn.dataset.status;

                    ASAlerts.confirmAction(
                        'Confirmer la modification ?',
                        `Voulez-vous vraiment ${actionText.toLowerCase()} le compte de ${adminName} ?`,
                        async () => {

                            try {

                                ASAlerts.showLoading(
                                    'Mise à jour du statut...'
                                );

                                const response = await fetch(
                                    form.action,
                                    {
                                        method: 'POST',
                                        body: new FormData(form),
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest'
                                        }
                                    }
                                );

                                const data = await response.json();

                                if (!response.ok) {

                                    ASAlerts.danger('Oups...',
                                        data.message ||
                                        'Impossible de modifier le statut.'
                                    );

                                    return;
                                }

                                ASAlerts.success(
                                    data.message ||
                                    'Statut mis à jour avec succès.'
                                );

                                updateContent(
                                    getFullUrl(
                                        "{{ route('super-admin.administrateurs') }}"
                                    )
                                );

                            } catch (error) {

                                console.error(error);

                                ASAlerts.error(
                                    'Erreur réseau',
                                    'Impossible de contacter le serveur.'
                                );
                            }
                        }
                    );
                });
                // -        -- TON AUTO-REFRESH ---
                setInterval(function () {

                    const searchInput = document.getElementById('search-input');

                    if (!searchInput) return;

                    if (document.activeElement !== searchInput && searchInput.value === "") {

                        const currentUrl = new URL(window.location.href);

                        updateContent(currentUrl.toString(), false);
                    }

                }, 15000);

            });
        </script>
        <script>
            dayjs.extend(window.dayjs_plugin_relativeTime);
            dayjs.locale('fr');

            /* ===============================
               AFFICHAGE ONLINE / OFFLINE
            =================================*/
            function refreshUserStatuses() {

                document.querySelectorAll('.status-cell').forEach(cell => {

                    const lastSeenRaw = cell.dataset.seen;

                    if (!lastSeenRaw) {
                        cell.innerHTML =
                            '<span style="color:#94a3b8;">Jamais connecté</span>';
                        return;
                    }

                    const diffSeconds =
                        dayjs().diff(dayjs(lastSeenRaw), 'second');

                    if (diffSeconds < 60) {
                        cell.innerHTML =
                            '<span style="color:#22c55e;font-weight:600;">● En ligne</span>';
                    } else {
                        cell.innerHTML =
                            '<span style="color:#64748b;">Vu ' +
                            dayjs(lastSeenRaw).fromNow() + '</span>';
                    }
                });
            }

            setInterval(refreshUserStatuses, 10000);
            refreshUserStatuses();



            /* ===============================
               HEARTBEAT (PAGE OUVERTE = ONLINE)
            =================================*/
            setInterval(function () {

                fetch("{{ route('user.heartbeat') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(r => r.json())
                    .then(data => {

                        if (data.status === 'online') {

                            const myId = "{{ auth()->id() }}";
                            const myCell =
                                document.querySelector(`.status-cell[data-user-id="${myId}"]`);

                            if (myCell) {
                                myCell.dataset.seen = dayjs().toISOString();
                                refreshUserStatuses();
                            }
                        }
                    });

            }, 20000); // toutes les 20s
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