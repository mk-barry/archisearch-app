<div id="result-count" style="margin-bottom: 1.5rem; color: #64748b;">
    <strong>{{ $results->total() }} résultats</strong> trouvés
</div>

<div class="results-list">

    @foreach($results as $doc)

        <div class="result-card">

            <div class="file-icon-box bg-pdf">

                PDF

            </div>

            <div class="result-info">

                <div class="result-top">

                    <h3 class="result-filename">

                        {{ $doc->title }}

                    </h3>

                    <span class="badge"
                        style="padding: 2px 8px; border-radius: 12px; font-size: 0.7rem; text-transform: uppercase; background: #f1f5f9;">

                        {{ $doc->status }}

                    </span>

                </div>

                <div class="result-meta"
                    style="margin-top: 10px;">

                    <div class="meta-item">

                        <i class="fas fa-user"></i>

                        {{ $doc->student->name ?? 'Inconnu' }}

                    </div>

                    <div class="meta-item">

                        <i class="fas fa-calendar"></i>

                        {{ $doc->created_at->format('d M Y') }}

                    </div>

                    <div class="meta-item">

                        <i class="fas fa-tag"></i>

                        {{ $doc->event->title ?? 'Sans événement' }}

                    </div>

                </div>

            </div>

            <div class="result-actions">

                <button class="action-btn">

                    <i class="fas fa-eye"></i>

                </button>

                <button class="action-btn">

                    <i class="fas fa-download"></i>

                </button>

            </div>

        </div>

    @endforeach

</div>

<div id="pagination-container">

    <div class="pagination-row"
        style="display:flex;justify-content:space-between;align-items:center;margin-top:1rem;">

        <span
            style="font-size:0.85rem;color:#64748b;">

            Affichage

            <strong>
                {{ $results->firstItem() }}
            </strong>

            à

            <strong>
                {{ $results->lastItem() }}
            </strong>

            sur

            <strong>
                {{ $results->total() }}
            </strong>

            documents

        </span>

        <div class="page-numbers"
            style="display:flex;gap:5px;">

            {{-- PREVIOUS --}}

            @if ($results->onFirstPage())

                <button class="page-btn"
                    disabled
                    style="opacity:0.5;cursor:not-allowed;padding:0.5rem 0.75rem;border:1px solid #e2e8f0;border-radius:6px;background:white;">

                    Précédent

                </button>

            @else

                <a href="{{ $results->previousPageUrl() }}"
                    class="page-btn pagination-link"
                    style="text-decoration:none;padding:0.5rem 0.75rem;border:1px solid #e2e8f0;border-radius:6px;background:white;color:#1e293b;font-size:0.85rem;">

                    Précédent

                </a>

            @endif

            {{-- PAGES --}}

            @foreach (
                $results->getUrlRange(
                    max(1, $results->currentPage() - 2),
                    min($results->lastPage(), $results->currentPage() + 2)
                ) as $page => $url
            )

                <a href="{{ $url }}"
                    class="page-btn pagination-link {{ ($page == $results->currentPage()) ? 'active' : '' }}"
                    style="text-decoration:none;padding:0.5rem 0.75rem;border:1px solid {{ ($page == $results->currentPage()) ? '#1e3a8a' : '#e2e8f0' }};
                    border-radius:6px;background:{{ ($page == $results->currentPage()) ? '#1e3a8a' : 'white' }};
                    color:{{ ($page == $results->currentPage()) ? 'white' : '#1e293b' }};
                    font-size:0.85rem;font-weight:600;">

                    {{ $page }}

                </a>

            @endforeach

            {{-- NEXT --}}

            @if ($results->hasMorePages())

                <a href="{{ $results->nextPageUrl() }}"
                    class="page-btn pagination-link"
                    style="text-decoration:none;padding:0.5rem 0.75rem;border:1px solid #e2e8f0;border-radius:6px;background:white;color:#1e293b;font-size:0.85rem;">

                    Suivant

                </a>

            @else

                <button class="page-btn"
                    disabled
                    style="opacity:0.5;cursor:not-allowed;padding:0.5rem 0.75rem;border:1px solid #e2e8f0;border-radius:6px;background:white;">

                    Suivant

                </button>

            @endif

        </div>

    </div>

</div>