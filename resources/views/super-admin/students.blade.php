<x-super-admin-layout active="evenements">
    <x-slot:title>Gestion des étudiants - ArchiSearch</x-slot>

        <div class="page-header">
            @if (session('success'))
                <script>
                    Swal.fire({
                        title: 'Succès !',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonColor: '#2563eb',
                        confirmButtonText: 'Ok'
                    });
                </script>
            @endif

            <div class="page-info">
                <div class="breadcrumb-small">Super Admin > Étudiants</div>
                <h1>Étudiants autorisés</h1>
            </div>

            <div class="admin-info">
                <div class="avatar"
                    style="width: 40px; height: 40px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar de {{ Auth::user()->name }}">
                    @else
                        {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                    @endif
                </div>
                <div style="display: flex; flex-direction: column; align-items: flex-start;">
                    <span class="admin-name">{{ Auth::user()->name }}</span>
                    <span class="admin-mail">{{ Auth::user()->role }}</span>
                </div>
            </div>
        </div>

        <div class="controls-row">
            <div class="search-filter-group">
                <div class="input-wrapper"
                    style="display: flex; width: 350px; background: white; align-items: center; gap: 5px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <svg style="margin-left: 10px; color: #94a3b8;" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    <input type="text" id="search-input" placeholder="Rechercher par nom ou matricule..."
                        style="width: 100%; padding: 0.75rem; border: none; outline: none; background: transparent;">
                </div>

                <select class="" name="filters" id="filtre">
                    <optgroup label="Participation">
                        <option value="">Tous</option>
                        <option value="has_uploads">Ayant déjà déposé</option>
                        <option value="no_uploads">Aucun dépôt</option>
                    </optgroup>
                </select>
            </div>

            <a href="{{ route('super-admin.students.create') }}" class="btn-primary"
                style="text-decoration: none; display: flex; align-items: center; gap: 8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Créer un étudiant
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Étudiant</th>
                        <th>Matricule</th>
                        <th>Email</th>
                        <th style="text-align: center;">Dépôts effectués</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @fragment('student-table')
                        @foreach ($students as $student)
                            <tr>
                                <td>
                                    <div class="admin-info">
                                        <div class="avatar"
                                            style="width: 32px; height: 32px; font-size: 0.75rem; background: #f1f5f9; color: #475569;">
                                            {{ collect(explode(' ', $student->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                                        </div>
                                        <span class="admin-name">{{ $student->name }}</span>
                                    </div>
                                </td>
                                <td><code
                                        style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px;">{{ $student->matricule }}</code>
                                </td>
                                <td style="color: #64748b;">{{ $student->email ?? '—' }}</td>
                                <td style="text-align: center; font-weight: 600;">{{ $student->documents_count ?? 0 }}</td>
                                <td style="text-align: right;">
                                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                        <a href="#" class="action-btn" title="Modifier">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                            </svg>
                                        </a>
                                        <button class="action-btn red btn-delete" data-id="{{ $student->id }}"
                                            data-name="{{ $student->name }}"
                                            style="border:none; background:none; cursor:pointer; color: #ef4444;">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path
                                                    d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endfragment
                </tbody>
            </table>
        </div>

        <div id="pagination-row" class="pagination-row">
            @fragment('pagination')
                <span>
                    Affichage {{ $students->firstItem() }}-{{ $students->lastItem() }} sur {{ $students->total() }} étudiants
                </span>

                <div class="page-numbers">
                    {{-- Bouton Précédent --}}
                    @if ($students->onFirstPage())
                        <button class="page-btn" disabled style="opacity: 0.5; cursor: not-allowed;">Précédent</button>
                    @else
                        <a href="{{ $students->previousPageUrl() }}" class="page-btn" style="text-decoration: none;">Précédent</a>
                    @endif

                    {{-- Numéros de pages --}}
                    @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                        <a href="{{ $url }}" class="page-btn {{ ($page == $students->currentPage()) ? 'active' : '' }}"
                            style="text-decoration: none;">
                            {{ $page }}
                        </a>
                    @endforeach

                    {{-- Bouton Suivant --}}
                    @if ($students->hasMorePages())
                        <a href="{{ $students->nextPageUrl() }}" class="page-btn" style="text-decoration: none;">Suivant</a>
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
                    // const sortSelect = document.getElementById('tri');

                    let timeout = null;

                    /* ===============================
                       CONSTRUCTION URL (Filtres & Tri inclus)
                    =============================== */
                    function getFullUrl(baseUrl, page = null) {
                        const url = new URL(baseUrl);

                        if (searchInput?.value)
                            url.searchParams.set('search', searchInput.value);

                        if (page)
                            url.searchParams.set('page', page);

                        // Récupération des filtres Select2 (Participation : has_uploads, no_uploads)
                        const filters = $(filterSelect).val();
                        filters.forEach(f => url.searchParams.append('filters', f));

                        // // Récupération du tri (A-Z, Nombre de docs, etc.)
                        // const sorts = $(sortSelect).val() || [];
                        // sorts.forEach(s => url.searchParams.append('sort[]', s));

                        return url.href;
                    }

                    /* ===============================
                       MISE À JOUR AJAX
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

                                if (newPagination && paginationContainer)
                                    paginationContainer.innerHTML = newPagination.innerHTML;

                                if (push)
                                    history.pushState({ url }, '', url);
                            })
                            .catch(err => console.error('Erreur AJAX:', err));
                    }

                    /* ===============================
                       ÉCOUTEURS D'ÉVÉNEMENTS
                    =============================== */

                    // Recherche (Debounce 300ms)
                    if (searchInput) {
                        searchInput.addEventListener('keyup', function () {
                            clearTimeout(timeout);
                            timeout = setTimeout(() => {
                                updateContent(getFullUrl("{{ route('super-admin.students') }}"));
                            }, 300);
                        });
                    }

                    // Changement de Filtres
                    $(filterSelect).on('change', function () {
                        updateContent(getFullUrl("{{ route('super-admin.students') }}"));
                    });

                    // // Changement de Tri (si tu as un select #tri)
                    // if (sortSelect) {
                    //     $(sortSelect).on('change', function () {
                    //         updateContent(getFullUrl("{{ route('super-admin.students') }}"));
                    //     });
                    // }

                    // Pagination
                    paginationContainer?.addEventListener('click', function (e) {
                        const link = e.target.closest('a');
                        if (!link) return;
                        e.preventDefault();

                        const pageUrl = new URL(link.href);
                        const page = pageUrl.searchParams.get('page');

                        updateContent(getFullUrl("{{ route('super-admin.students') }}", page));
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });

                    // Gestion du bouton retour navigateur
                    window.addEventListener('popstate', function (event) {
                        if (event.state?.url) {
                            updateContent(event.state.url, false);
                        } else {
                            updateContent(window.location.href, false);
                        }
                    });
                });
        </script>
</x-super-admin-layout>