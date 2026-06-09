<x-admin-layout sec_css="{{ asset('css/admin/evenements.css') }}" active="evenements" title="Gestion des événements - ArchiSearch">
    <div class="page-header">
        <div class="page-info">
            <div class="breadcrumb-small">Admin > Événements</div>
            <h1>Gestion des événements</h1>
        </div>
        <div class="admin-info">
            {{-- Utilisation des classes communes pour l'avatar --}}
            <div class="avatar-base avatar-md">
                @if(Auth::user()->avatar_path)
                    <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}" alt="Avatar de {{ Auth::user()->name }}">
                @else
                    {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                @endif
            </div>
            <div class="flex-col-start">
                <span class="admin-name">{{ Auth::user()->name }}</span>
                <span class="admin-mail">{{ Auth::user()->role }}</span>
            </div>
        </div>
    </div>

    <div class="controls-row">
        <div class="search-filter-group flex-2">
            <div class="input-wrapper search-bar-width">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" /><path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" id="event-search" placeholder="Rechercher un événement...">
            </div>

            <div class="log-tabs" id="status-tabs">
                <button class="log-tab active" data-status="">Tous</button>
                <button class="log-tab" data-status="actif">Actif</button>
                <button class="log-tab" data-status="cloture">Clôturé</button>
                <button class="log-tab" data-status="archive">Archivé</button>
                <button class="log-tab" data-status="brouillon">Brouillon</button>
            </div>
        </div>

        <a href="{{ route('admin.creation-events') }}" class="btn-primary no-underline flex-center gap-1">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                <line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Créer un événement
        </a>
    </div>

    <div id="events-ajax-container">
        <div class="event-grid">
            @forelse($events as $event)
                <div class="event-card">
                    <div class="event-header">
                        <div class="event-info-main">
                            <h3 class="event-title">{{ $event->title }}</h3>
                            <p class="event-subtitle">{{ Str::limit($event->description, 45) }}</p>
                        </div>
                        
                        <span class="badge {{ $event->status == 'actif' ? 'badge-blue' : ($event->status == 'cloturé' ? 'badge-orange' : ($event->status == 'archivé' ? 'badge-green' : 'badge-red')) }}">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>

                    <div class="event-progress-section">
                        @php
                            $percentage = $event->total_expected > 0 ? ($event->submissions_count / $event->total_expected) * 100 : 0;
                        @endphp
                        {{-- La classe compact-progress-bg doit être définie dans common.css pour la couleur de fond --}}
                        <div class="compact-progress-bg">
                            <div class="compass-progress-fill" style="width: {{ $percentage }}%;"></div>
                        </div>
                        <div class="event-stats">
                            <div class="submission-stats">
                                <span class="count">{{ $event->submissions_count ?? 0 }}</span>
                                <span class="separator">/</span>
                                <span class="total">{{ $event->total_expected > 0 ? $event->total_expected : '--' }}</span>
                                <span class="label">soumissions</span>
                            </div>
                            <span class="flex-center gap-1">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                                    <line x1="16" x2="16" y1="2" y2="6" /><line x1="8" x2="8" y1="2" y2="6" />
                                    <line x1="3" x2="21" y1="10" y2="10" />
                                </svg>
                                {{ $event->end_date->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="event-footer">
                        <div class="event-meta">
                            {{ $event->documentTypes->count() }} {{ Str::plural('type', $event->documentTypes->count()) }} requis
                        </div>
                        <div class="event-actions">
                            <a href="{{ route('admin.voir-events', $event->uuid) }}" class="action-btn flex-center action-btn-view" title="Voir l'événement">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" /><circle cx="12" cy="12" r="3" />
                                </svg>
                                <span class="action-span">Voir</span>
                            </a>

                            @if($event->status === 'actif')
                                <a href="{{ route('admin.edit-events', $event->uuid) }}" class="action-btn action-btn-edit" title="Modifier l'événement">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                    </svg>
                                    <span class="action-span">Editer</span>
                                </a>
                            @else
                                <button class="action-btn opacity-30 cursor-not-allowed" disabled>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                    </svg>
                                </button>
                                <span class="action-span span-disabled">Editer</span>
                            @endif

                            <button class="action-btn btn-copy action-btn-link" onclick="copyEventLink('{{ $event->uuid }}')" title="Copier le lien">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                </svg>
                                <span class="action-span">Lien</span>
                            </button>

                            @if($event->status === 'actif')
                                <form action="{{ route('admin.evenements.cloture-prematuree', $event->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="action-btn action-btn-danger" title="Clôturer" onclick="return confirm('Clôturer cet événement maintenant ?')">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <rect x="5" y="11" width="14" height="10" rx="2" ry="2"></rect>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                            <line x1="10" y1="16" x2="14" y2="16"></line>
                                        </svg>
                                        <span class="action-span">Cloturer</span>
                                    </button>
                                </form>
                            @else
                                <button class="action-btn opacity-30 cursor-not-allowed" disabled>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="5" y="11" width="14" height="10" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <span class="action-span span-disabled">Cloturer</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state-full">Aucun événement trouvé.</div>
            @endforelse
        </div>

        <div id="pagination-row" class="pagination-row">
            @fragment('pagination')
                <div class="pagination-info">
                    Affichage {{ $events->firstItem() }}-{{ $events->lastItem() }} sur {{ $events->total() }} événements
                </div>

                <div class="page-numbers">
                    @if ($events->onFirstPage())
                        <button class="page-btn opacity-50" disabled>Précédent</button>
                    @else
                        <a href="{{ $events->previousPageUrl() }}" class="page-btn">Précédent</a>
                    @endif

                    @foreach ($events->getUrlRange(max(1, $events->currentPage() - 2), min($events->lastPage(), $events->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}" class="page-btn {{ ($page == $events->currentPage()) ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if ($events->hasMorePages())
                        <a href="{{ $events->nextPageUrl() }}" class="page-btn">Suivant</a>
                    @else
                        <button class="page-btn opacity-50" disabled>Suivant</button>
                    @endif
                </div>
            @endfragment
        </div>
    </div>

    @push('scripts')
    <script>
        function copyEventLink(uuid) {
            const cleanUrl = window.location.origin + "/invitation/" + uuid;
            navigator.clipboard.writeText(cleanUrl).then(() => {
                ASAlerts.success("Lien d'invitation copié avec succès !");
            }).catch(err => {
                console.error('Erreur lors de la copie :', err);
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('event-search');
            const statusTabs = document.querySelectorAll('#status-tabs .log-tab');
            const ajaxContainer = document.getElementById('events-ajax-container');
            let currentStatus = "";
            let timeout = null;

            function getFullUrl(page = null) {
                const url = new URL("{{ route('admin.evenements') }}");
                if (searchInput.value) url.searchParams.set('search', searchInput.value);
                if (currentStatus) url.searchParams.set('status', currentStatus);
                if (page) url.searchParams.set('page', page);
                return url.href;
            }

            function updateContent(url, push = true) {
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.getElementById('events-ajax-container');
                        if (newContent && ajaxContainer) {
                            ajaxContainer.innerHTML = newContent.innerHTML;
                        }
                        if (push) history.pushState({ url }, '', url);
                    })
                    .catch(err => console.error("Erreur AJAX:", err));
            }

            searchInput.addEventListener('keyup', () => {
                clearTimeout(timeout);
                timeout = setTimeout(() => updateContent(getFullUrl()), 300);
            });

            statusTabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    statusTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    currentStatus = this.dataset.status;
                    updateContent(getFullUrl());
                });
            });

            ajaxContainer.addEventListener('click', function (e) {
                const link = e.target.closest('.page-numbers a');
                if (!link) return;
                e.preventDefault();
                updateContent(getFullUrl(new URL(link.href).searchParams.get('page')));
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>
    @endpush
</x-admin-layout>