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
                <div class="result-top">
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