<x-admin-layout active="evenements" title="Gestion des événements - ArchiSearch">
    <div class="page-header">
        <h1>Gestion des événements</h1>
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
            <div class="input-wrapper"
                style="width: 350px; display: flex; justify-content: center; align-items: center; border: 1px solid #e2e8f0; border-radius: 10px; background: white;">
                <svg class="input-icon" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" id="event-search" placeholder="Rechercher un événement..."
                    style="width: 80%; padding: 0.75rem 1rem 0.75rem 2.75rem; outline: none; border: none;">
            </div>

            <div class="log-tabs" id="status-tabs">
                <button class="log-tab active" data-status="">Tous</button>
                <button class="log-tab" data-status="actif">Actif</button>
                <button class="log-tab" data-status="cloture">Clôturé</button>
                <button class="log-tab" data-status="archive">Archivé</button>
                <button class="log-tab" data-status="brouillon">Brouillon</button>
            </div>
        </div>

        <a href="{{ route('admin.creation-events') }}" class="btn-primary"
            style="text-decoration: none; padding: 0.75rem 1.5rem; display: flex; align-items: center; gap: 10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Créer un événement
        </a>
    </div>

    <div id="events-ajax-container">
        <div class="event-grid">
            @forelse($events as $event)
                <div class="event-card">
                    <div class="event-header">
                        <div>
                            <h3 class="event-title">{{ $event->title }}</h3>
                            <p class="event-subtitle">{{ Str::limit($event->description, 45) }}</p>
                        </div>
                        <span
                            class="badge {{ $event->status == 'actif' ? 'badge-blue' : ($event->status == 'cloture' ? 'badge-green' : 'badge-orange') }}">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>

                    <div class="event-progress-section">
                        @php
                            $percentage = $event->total_expected > 0
                                ? ($event->submissions_count / $event->total_expected) * 100
                                : 0;
                        @endphp
                        <div class="compact-progress-bg" style="height: 10px; background: #f1f5f9;">
                            <!-- <div class="compact-progress-fill" style="width: {{ $percentage }}%; background: #2563eb;"></div> -->
                            <div class="compass-progress-fill"
                                style="width: {{ $percentage }}%; background: #2563eb; height: 100%; border-radius: 4px;">
                            </div>
                        </div>
                        <div class="event-stats">
                            <!-- <span>0/0 soumissions</span> -->
                            <div class="submission-stats">
                                <span class="count">{{ $event->submissions_count }}</span>
                                <span class="separator">/</span>
                                <span class="total">{{ $event->total_expected }}</span>
                                <span class="label">soumissions</span>
                            </div>
                            <span style="display: flex; align-items: center; gap: 6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                                    <line x1="16" x2="16" y1="2" y2="6" />
                                    <line x1="8" x2="8" y1="2" y2="6" />
                                    <line x1="3" x2="21" y1="10" y2="10" />
                                </svg>
                                {{ $event->end_date->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="event-footer">
                        <div class="event-meta">
                            {{ is_array($event->required_docs) ? count($event->required_docs) : 0 }} types requis
                        </div>
                        <div class="event-actions">
                            {{-- Bouton Voir --}}
                            <button class="action-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>

                            {{-- Bouton Éditer --}}
                            <button class="action-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                </svg>
                            </button>

                            {{-- Bouton Clôture (Remplace les trois points) --}}
                            @if($event->status === 'actif')
                                <form action="{{ route('admin.evenements.cloture-prematuree', $event->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="action-btn" title="Clôturer prématurément"
                                        onclick="return confirm('Clôturer cet événement maintenant ?')"
                                        style="color: #ef4444; border-color: transparent;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="5" y="11" width="14" height="10" rx="2" ry="2"></rect>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                            <line x1="10" y1="16" x2="14" y2="16"></line>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                {{-- Optionnel : une icône grisée si déjà clôturé --}}
                                <button class="action-btn" disabled style="opacity: 0.3; cursor: not-allowed;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <rect x="5" y="11" width="14" height="10" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: #64748b;">
                    Aucun événement trouvé.
                </div>
            @endforelse
        </div>

        <div id="pagination-row" class="pagination-row">
            @fragment('pagination')
                <span>
                    Affichage {{ $events->firstItem() }}-{{ $events->lastItem() }} sur {{ $events->total() }} événements
                </span>

                <div class="page-numbers">
                    {{-- Précédent --}}
                    @if ($events->onFirstPage())
                        <button class="page-btn" disabled style="opacity: 0.5;">Précédent</button>
                    @else
                        <a href="{{ $events->previousPageUrl() }}" class="page-btn">Précédent</a>
                    @endif

                    {{-- Pages --}}
                    @foreach ($events->getUrlRange(max(1, $events->currentPage() - 2), min($events->lastPage(), $events->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}" class="page-btn {{ ($page == $events->currentPage()) ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    {{-- Suivant --}}
                    @if ($events->hasMorePages())
                        <a href="{{ $events->nextPageUrl() }}" class="page-btn">Suivant</a>
                    @else
                        <button class="page-btn" disabled style="opacity: 0.5;">Suivant</button>
                    @endif
                </div>
            @endfragment
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('event-search');
            const statusTabs = document.querySelectorAll('#status-tabs .log-tab');
            const ajaxContainer = document.getElementById('events-ajax-container');

            let currentStatus = "";
            let timeout = null;

            // Fonction unique pour construire l'URL
            function getFullUrl(page = null) {
                const url = new URL("{{ route('admin.evenements') }}");
                if (searchInput.value) url.searchParams.set('search', searchInput.value);
                if (currentStatus) url.searchParams.set('status', currentStatus);
                if (page) url.searchParams.set('page', page);
                return url.href;
            }

            // Mise à jour AJAX
            function updateContent(url, push = true) {
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // On remplace TOUT le contenu du container (Grid + Pagination)
                        const newContent = doc.getElementById('events-ajax-container');
                        if (newContent && ajaxContainer) {
                            ajaxContainer.innerHTML = newContent.innerHTML;
                        }

                        if (push) history.pushState({ url }, '', url);
                    })
                    .catch(err => console.error("Erreur ArchiSearch AJAX:", err));
            }

            // Événement : Recherche (Debounce)
            searchInput.addEventListener('keyup', () => {
                clearTimeout(timeout);
                timeout = setTimeout(() => updateContent(getFullUrl()), 300);
            });

            // Événement : Onglets de Statut
            statusTabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    statusTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    currentStatus = this.dataset.status;
                    updateContent(getFullUrl());
                });
            });

            // Événement : Clic sur Pagination (Délégation d'événement)
            ajaxContainer.addEventListener('click', function (e) {
                const link = e.target.closest('.page-numbers a');
                if (!link) return;

                e.preventDefault();
                const url = new URL(link.href);
                const page = url.searchParams.get('page');

                updateContent(getFullUrl(page));
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('event-search');
            const container = document.getElementById('event-grid-container');
            const tabs = document.querySelectorAll('#status-tabs .log-tab');
            let currentStatus = "{{ request('status') }}";
            let timeout = null;

            // Remplace la partie updateContent de ton JS actuel pour l'adapter aux évènements :
            function updateContent(url, push = true) {
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        const newGrid = doc.querySelector('.event-grid');
                        const newPagination = doc.getElementById('pagination-row');

                        if (newGrid) document.querySelector('.event-grid').innerHTML = newGrid.innerHTML;
                        if (newPagination) document.getElementById('pagination-row').innerHTML = newPagination.innerHTML;

                        if (push) history.pushState({ url }, '', url);
                    });
            }

            function getUrl(page = null) {
                const url = new URL("{{ route('admin.evenements') }}");
                if (searchInput.value) url.searchParams.set('search', searchInput.value);
                if (currentStatus) url.searchParams.set('status', currentStatus);
                if (page) url.searchParams.set('page', page);
                return url.href;
            }

            // Recherche
            searchInput.addEventListener('keyup', () => {
                clearTimeout(timeout);
                timeout = setTimeout(() => updateContent(getUrl()), 300);
            });

            // Tabs (Statuts)
            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    currentStatus = this.dataset.status;
                    updateContent(getUrl());
                });
            });

            // Pagination
            container.addEventListener('click', (e) => {
                const link = e.target.closest('a');
                if (link && link.href.includes('page=')) {
                    e.preventDefault();
                    updateContent(link.href);
                }
            });
        });
    </script>
</x-admin-layout>