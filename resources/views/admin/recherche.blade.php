<x-admin-layout pri_css="{{  asset('css/dashboard/main.css') }}" active="recherche" title="Recherche de documents - ArchiSearch">
    <div class="page-header">
        <div class="page-info">
            <div class="breadcrumb-small">Portail Admin > Recherche</div>
            <h1>Recherche de documents</h1>
        </div>
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
                <span class="admin-mail">{{ Auth::user()->role }}</span>
            </div>
        </div>
    </div>

    <div class="search-header-card">
        <form action="{{ route('admin.recherche') }}" method="GET" id="searchForm">
            <div class="search-input-big" style="position: relative;">
                <svg style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); color: #3b82f6;"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>

                <input type="text" name="q" id="searchInput" autocomplete="off" value="{{ request('q') }}"
                    placeholder="Nom de l'étudiant ou titre du document...">

                <button type="submit" class="search-btn-embed">Rechercher</button>

                <div id="savedSearchesMenu"
                    style="display: none; position: absolute; top: 110%; left: 0; width: 100%; background: white; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); z-index: 100; max-height: 300px; overflow-y: auto; border: 1px solid #e2e8f0;">
                    <div
                        style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: bold; color: #94a3b8; text-transform: uppercase; border-bottom: 1px solid #f1f5f9;">
                        Vos recherches sauvegardées
                    </div>
                    @forelse($savedSearches as $search)
                        <a href="{{ route('admin.search', ['q' => $search->keyword] + ($search->filters ?? [])) }}"
                            style="display: block; padding: 0.75rem 1.25rem; color: #1e293b; text-decoration: none; border-bottom: 1px solid #f8fafc; transition: background 0.2s;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"
                                style="margin-right: 8px;">
                                <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                            </svg>
                            {{ Str::limit($search->keyword, 40) }}
                        </a>
                    @empty
                        <div style="padding: 1rem; text-align: center; color: #94a3b8; font-size: 0.9rem;">Aucune recherche
                            sauvegardée</div>
                    @endforelse
                </div>
            </div>

            <div class="quick-filter-row" style="margin-top: 1rem; display: flex; gap: 10px; align-items: center;">
                <select name="event" class="select-filter" onchange="this.form.submit()">
                    <option>Événement : Tous</option>
                </select>
                <select name="type" class="select-filter" onchange="this.form.submit()">
                    <option>Type : Tous</option>
                </select>
                <select name="date" class="select-filter" onchange="this.form.submit()">
                    <option>Date : Toutes</option>
                </select>
                <select name="uploader" class="select-filter" onchange="this.form.submit()">
                    <option>Auteur : Tous</option>
                </select>
                <select name="status" class="select-filter" onchange="this.form.submit()">
                    <option value="">Statuts : Tous</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Soumis</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="validated" {{ request('status') == 'validated' ? 'selected' : '' }}>Validé</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                    <option value="error" {{ request('status') == 'error' ? 'selected' : '' }}>Erreur</option>
                </select>

                <button type="button" id="saveSearchBtn" class="btn-outline"
                     style="border-radius: 10px; padding: 0.6rem 1.25rem; font-size: 0.9rem; border-color: #3b82f6; color: #3b82f6;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        style="margin-right: 8px;">
                        <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                    </svg>
                    Sauvegarder
                </button>
            </div>
        </form>
    </div>

    <div class="results-column" style="width: 100%; margin-top: 2rem;">
        <div id="result-count" style="margin-bottom: 1.5rem; color: #64748b;">
            <strong>{{ $results->total() }} résultats</strong> trouvés
        </div>

        <div class="results-list">
            @foreach($results as $doc)
                <div class="result-card">
                    <div class="file-icon-box bg-pdf">PDF</div>
                    <!-- <div class="file-icon-box bg-pdf" style="width: 44px; height: 44px;">
                        {{ strtoupper(pathinfo($doc->path, PATHINFO_EXTENSION)) }}</div> -->
                    <div class="result-info">
                        <div class="result-top" >
                            <h3 class="result-filename">{{ $doc->title }}</h3>
                            <span class="badge"
                                style="padding: 2px 8px; border-radius: 12px; font-size: 0.7rem; text-transform: uppercase; background: #f1f5f9;">
                                {{ $doc->status }}
                            </span>
                        </div>
                        <div class="result-meta" style="margin-top: 10px;">
                            <div class="meta-item"><i class="fas fa-user"></i> {{ $doc->student->name ?? 'Inconnu' }}</div>
                            <div class="meta-item"><i class="fas fa-calendar"></i> {{ $doc->created_at->format('d M Y') }}
                            </div>
                            <div class="meta-item"><i class="fas fa-tag"></i>
                                {{ $doc->event->title ?? 'Sans événement' }}</div>
                        </div>
                    </div>
                    <div class="result-actions">
                        <button class="action-btn"><i class="fas fa-eye"></i></button>
                        <button class="action-btn"><i class="fas fa-download"></i></button>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem;">
            {{ $results->appends(request()->query())->links() }}
        </div>
    </div>

    <script>
        // Gestion du menu des recherches sauvegardées
        const searchInput = document.getElementById('searchInput');
        const savedMenu = document.getElementById('savedSearchesMenu');

        searchInput.addEventListener('focus', () => {
            savedMenu.style.display = 'block';
        });

        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !savedMenu.contains(e.target)) {
                savedMenu.style.display = 'none';
            }
        });

        // Sauvegarde via AJAX
        document.getElementById('saveSearchBtn').addEventListener('click', function () {
            const query = searchInput.value;
            if (!query) return alert('Tapez quelque chose à sauvegarder !');

            fetch("{{ route('admin.recherche.save') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ q: query })
            }).then(() => {
                this.innerHTML = "✅ Sauvegardé";
                setTimeout(() => location.reload(), 500); // Recharger pour voir la nouvelle recherche dans le menu
            });
        });
    </script>
</x-admin-layout>