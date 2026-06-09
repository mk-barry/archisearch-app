<x-admin-layout sec_css="{{ asset('css/admin/documents.css') }}" active="documents" title="Documents - ArchiSearch">
    <div class="page-header">
        <div class="page-info">
            <div class="breadcrumb-small">Portail Admin > Documents</div>
            <h1>Documents de l'événement</h1>
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

    <div class="controls-row">
        <div class="search-filter-group documents-search-group">
            <div class="input-wrapper documents-search-wrapper">
                <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>

                <input type="text" id="searchInput" placeholder="Filtrer les documents...">
            </div>

            <div class="log-tabs" id="typeFilters">
                <button class="log-tab active" data-type="Tous">Tous</button>
                <button class="log-tab" data-type="PDF">PDF</button>
                <button class="log-tab" data-type="JPG">JPG</button>
                <button class="log-tab" data-type="XLS">XLS</button>
            </div>
        </div>

        <div class="documents-actions-group">
            <button class="btn-outline" id="bulkDownload">
                Tout télécharger
            </button>

            <button class="btn-primary documents-archive-btn" id="bulkArchive">
                Archiver sélection
            </button>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th class="documents-checkbox-th">
                        <input type="checkbox" id="selectAll">
                    </th>

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
                            <td>
                                <input type="checkbox" class="doc-checkbox" value="{{ $doc->id }}">
                            </td>

                            <td>
                                <div class="document-file-info">
                                    <div class="file-icon-box bg-{{ $doc->extension }}">
                                        {{ strtoupper($doc->extension) }}
                                    </div>

                                    <div class="text-sizes">
                                        <div class="document-name">
                                            {{ basename($doc->file_path) }}
                                        </div>

                                        <div class="file-size">
                                            {{ $doc->file_size }} Ko
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="tag">
                                    {{ $doc->documentType->name ?? $doc->category }}
                                </span>
                            </td>

                            <td class="document-contributor">
                                {{ $doc->student->name ?? $doc->identifier }}
                            </td>

                            <td class="document-date">
                                {{ $doc->created_at->format('d M') }}
                            </td>

                            <td>
                                <span class="badge {{ $doc->status_class }}">
                                    {{ $doc->status }}
                                </span>
                            </td>

                            <td>
                                <div class="document-actions-grid">
                                    <a href="{{ route('admin.doc.show', $doc->id) }}" class="action-btn">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('admin.documents.download', $doc->id) }}" class="action-btn">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                            <polyline points="7 10 12 15 17 10" />
                                            <line x1="12" x2="12" y1="15" y2="3" />
                                        </svg>
                                    </a>

                                    <button class="action-btn"
                                        onclick="shareDocument('{{ basename($doc->file_path) }}', '{{ Storage::url($doc->file_path) }}')"
                                        title="Partager le document">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <circle cx="18" cy="5" r="3" />
                                            <circle cx="6" cy="12" r="3" />
                                            <circle cx="18" cy="19" r="3" />
                                            <line x1="8.59" x2="15.42" y1="13.51" y2="17.49" />
                                            <line x1="15.41" x2="8.59" y1="6.51" y2="10.49" />
                                        </svg>
                                    </button>

                                    <button class="action-btn delete-doc-btn delete-document-btn" data-id="{{ $doc->id }}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M3 6h18" />
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="documents-empty-state">
                                Aucun document trouvé.
                            </td>
                        </tr>
                    @endforelse

                @endfragment
            </tbody>
        </table>
    </div>

    <div id="pagination-container">
        @fragment('pagination')

            <div class="pagination-row documents-pagination-row">
                <span class="documents-pagination-info">
                    Affichage <strong>{{ $documents->firstItem() }}</strong>
                    à <strong>{{ $documents->lastItem() }}</strong>
                    sur <strong>{{ $documents->total() }}</strong> documents
                </span>

                <div class="page-numbers">
                    @if ($documents->onFirstPage())
                        <button class="page-btn" disabled>
                            Précédent
                        </button>
                    @else
                        <a href="{{ $documents->previousPageUrl() }}" class="page-btn">
                            Précédent
                        </a>
                    @endif

                    @foreach ($documents->getUrlRange(max(1, $documents->currentPage() - 2), min($documents->lastPage(), $documents->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}" class="page-btn {{ ($page == $documents->currentPage()) ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if ($documents->hasMorePages())
                        <a href="{{ $documents->nextPageUrl() }}" class="page-btn">
                            Suivant
                        </a>
                    @else
                        <button class="page-btn" disabled>
                            Suivant
                        </button>
                    @endif
                </div>
            </div>

        @endfragment
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            let state = {
                search: '',
                type: 'Tous',
                page: 1
            };

            function updateUI(isAuto = false) {
                // console.log("Envoi des données :", state);

                $.ajax({
                    url: "{{ route('admin.documents') }}",
                    data: state,

                    success: function (res) {
                        // console.log("Réponse reçue :", res);
                        $('#documents-body').html(res['table-body']);
                        $('#pagination-container').html(res['pagination']);
                    },

                    error: function (err) {
                        console.error("Erreur AJAX :", err);
                    }
                });
            }

            let timer;

            $('#searchInput').on('keyup', function () {
                clearTimeout(timer);
                state.search = $(this).val();
                state.page = 1;
                timer = setTimeout(updateUI, 300);
            });

            $('.log-tab').on('click', function () {
                $('.log-tab').removeClass('active');
                $(this).addClass('active');
                state.type = $(this).data('type');
                state.page = 1;
                updateUI();
            });

            $(document).on('click', '#pagination-container a', function (e) {
                e.preventDefault();
                state.page = $(this).attr('href').split('page=')[1];
                updateUI();
            });

            $('#selectAll').on('change', function () {
                $('.doc-checkbox').prop('checked', $(this).prop('checked'));
            });

            $('#bulkArchive').on('click', function () {
                let ids = $('.doc-checkbox:checked').map(function () {
                    return $(this).val();
                }).get();

                if (ids.length === 0) {
                    return ASAlerts.error('Archivage impossible','Sélectionnez au moins un document');
                }

                $.post("{{ route('admin.documents.bulk') }}", {
                    _token: "{{ csrf_token() }}",
                    ids: ids,
                    action: 'archive'
                }, function () {
                    updateUI();
                });
            });

            $(document).on('click', '.delete-doc-btn', function () {

                const id = $(this).data('id');

                ASAlerts.confirmAction(
                    'Suppression du document',
                    'Voulez-vous vraiment supprimer ce document ?',
                    () => {

                        $.ajax({
                            url: "/admin/document/" + id,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },

                            success: function () {

                                ASAlerts.success("Document supprimé avec succès");
                                updateUI();
                            },

                            error: function () {
                                ASAlerts.error("Erreur lors de la suppression");
                            }
                        });
                    }
                );
            });

            $('#bulkDownload').on('click', function () {
                let ids = $('.doc-checkbox:checked').map(function () {
                    return $(this).val();
                }).get();

                if (ids.length === 0) {
                    return ASAlerts.error('Telechargement impossible','Sélectionnez au moins un document');
                }

                let form = $('<form>', {
                    action: "{{ route('admin.documents.bulk') }}",
                    method: 'POST'
                });

                form.append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: "{{ csrf_token() }}"
                }));

                form.append($('<input>', {
                    type: 'hidden',
                    name: 'action',
                    value: 'download'
                }));

                ids.forEach(id => form.append($('<input>', {
                    type: 'hidden',
                    name: 'ids[]',
                    value: id
                })));

                $('body').append(form);
                form.submit().remove();
            });

            function shareDocument(title, url) {

                const fullUrl = window.location.origin + url;

                if (navigator.share) {
                    // console.log("yo")

                    navigator.share({
                        title: 'Document ArchiSearch : ' + title,
                        text: 'Voici un document partagé depuis ArchiSearch',
                        url: fullUrl,
                    });

                } else {

                    navigator.clipboard.writeText(fullUrl);
                    ASAlerts.success('Lien copié.');
                }
            }

            setInterval(function () {
                updateUI(true);
            }, 10000);
        });
    </script>
</x-admin-layout>