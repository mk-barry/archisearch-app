<x-admin-layout active="documents" title="Documents - ArchiSearch">
    <div class="page-header">
        <h1>Documents de l'événement</h1>
        <div class="admin-info">
            <div class="avatar"
                style="width: 40px; height: 40px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
                {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
            </div>
            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                <span class="admin-name">{{ Auth::user()->name }}</span>
                <span class="admin-mail">{{ Auth::user()->role }}</span>
            </div>
        </div>
    </div>

    <div class="controls-row">
        <div class="search-filter-group" style="flex: 2;">
            <div class="input-wrapper"
                style="width: 350px; background: white; display: flex; justify-content: center; align-items: center; border-radius: 10px; gap: 5px;">
                <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input type="text" id="searchInput" placeholder="Filtrer les documents..."
                    style="width: 80%; padding: 0.75rem 1rem; border: none; outline: none;">
            </div>

            <div class="log-tabs" id="typeFilters">
                <button class="log-tab active" data-type="Tous">Tous</button>
                <button class="log-tab" data-type="PDF">PDF</button>
                <button class="log-tab" data-type="JPG">JPG</button>
                <button class="log-tab" data-type="XLS">XLS</button>
            </div>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button class="btn-outline" id="bulkDownload">Tout télécharger</button>
            <button class="btn-primary" id="bulkArchive" style="background: #1e3a8a;">Archiver sélection</button>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;"><input type="checkbox" id="selectAll"></th>
                    <th>DOCUMENT</th>
                    <th>CATÉGORIE</th>
                    <th>CONTRIBUTEUR</th>
                    <th>DATE</th>
                    <th>STATUT</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody id="documents-body">
                @fragment('table-body')
                    @forelse($documents as $doc)
                        <tr>
                            <td><input type="checkbox" class="doc-checkbox" value="{{ $doc->id }}"></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div class="file-icon-box bg-{{ $doc->extension }}">{{ strtoupper($doc->extension) }}</div>
                                    <div class="text-sizes">
                                        <div style="font-weight: 700; color: #1e293b;">{{ basename($doc->file_path) }}</div>
                                        <div class="file-size">{{ $doc->file_size }} Ko</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="tag">{{ $doc->documentType->name ?? $doc->category }}</span></td>
                            <td style="font-weight: 500;">{{ $doc->student->name ?? $doc->identifier }}</td>
                            <td style="color: #64748b;">{{ $doc->created_at->format('d M') }}</td>
                            <td><span class="badge {{ $doc->status_class }}">{{ $doc->status }}</span></td>
                            <td style="display: grid; border-bottom: none; grid-template-columns: repeat(2, 1fr);">
                                <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg></button>
                                <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="7 10 12 15 17 10" />
                                        <line x1="12" x2="12" y1="15" y2="3" />
                                    </svg></button>
                                <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <circle cx="18" cy="5" r="3" />
                                        <circle cx="6" cy="12" r="3" />
                                        <circle cx="18" cy="19" r="3" />
                                        <line x1="8.59" x2="15.42" y1="13.51" y2="17.49" />
                                        <line x1="15.41" x2="8.59" y1="6.51" y2="10.49" />
                                    </svg></button>
                                <button class="action-btn" style="color: #ef4444;"><svg width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 6h18" />
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                    </svg></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px;">Aucun document trouvé.</td>
                        </tr>
                    @endforelse
                @endfragment
            </tbody>
        </table>
    </div>

    <div id="pagination-container" style="margin-top: 20px;">
        @fragment('pagination')
            {{ $documents->links() }}
        @endfragment
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let state = { search: '', type: 'Tous', page: 1 };

            function updateUI(isAuto = false) {
                $.ajax({
                    url: "{{ route('admin.documents') }}",
                    data: state,
                    success: function (res) {
                        $('#documents-body').html(res['table-body']);
                        $('#pagination-container').html(res['pagination']);

                        // Si on coche "Tout sélectionner", on garde l'état après rafraîchissement
                        if ($('#selectAll').is(':checked')) $('.doc-checkbox').prop('checked', true);
                    }
                });
            }

            // Recherche avec délai (Debounce)
            let timer;
            $('#searchInput').on('keyup', function () {
                clearTimeout(timer);
                state.search = $(this).val();
                state.page = 1;
                timer = setTimeout(updateUI, 300);
            });

            // Filtres par type
            $('.log-tab').on('click', function () {
                $('.log-tab').removeClass('active');
                $(this).addClass('active');
                state.type = $(this).data('type');
                state.page = 1;
                updateUI();
            });

            // Pagination (Capter les clics sur les liens de Laravel)
            $(document).on('click', '#pagination-container a', function (e) {
                e.preventDefault();
                state.page = $(this).attr('href').split('page=')[1];
                updateUI();
            });

            // Checkbox Master
            $('#selectAll').on('change', function () {
                $('.doc-checkbox').prop('checked', $(this).prop('checked'));
            });

            // Archiver sélection
            $('#bulkArchive').on('click', function () {
                let ids = $('.doc-checkbox:checked').map(function () { return $(this).val(); }).get();
                if (ids.length === 0) return alert('Sélectionnez au moins un document');

                $.post("{{ route('admin.documents.bulk') }}", {
                    _token: "{{ csrf_token() }}",
                    ids: ids,
                    action: 'archive'
                }, function () {
                    updateUI();
                });
            });

            // Rafraîchissement automatique (Toutes les 10 secondes)
            setInterval(function () {
                updateUI(true);
            }, 10000);
        });
    </script>
</x-admin-layout>