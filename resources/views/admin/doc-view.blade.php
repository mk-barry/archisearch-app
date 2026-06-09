<x-admin-layout sec_css="{{ asset('css/admin/view-docs.css') }}" active="documents" title="Vue Document - ArchiSearch">
    <div class="page-header">
        <div class="page-info">
            <h1>Expertise : {{ $document->title }}</h1>
        </div>

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

    <div class="section-container">

        <section class="left card">
            <iframe src="{{ asset('storage/' . $document->file_path) }}"></iframe>
        </section>

        <section class="right">

            <div class="metadatas">
                <div class="title">
                    <span>Métadonnées</span>
                </div>

                <div class="info-list">

                    <div class="info-cards">
                        <span class="label">Nom du fichier</span>
                        <span class="data">{{ basename($document->file_path) }}</span>
                    </div>

                    <div class="info-cards">
                        <span class="label">Mime</span>
                        <span class="data">{{ $document->file_type }}</span>
                    </div>

                    <div class="info-cards">
                        <span class="label">Taille</span>
                        <span class="data">{{ $document->file_size }} ko</span>
                    </div>

                    <div class="info-cards">
                        <span class="label">Auteur</span>
                        <span class="data">{{ $document->student->name }}</span>
                    </div>

                    <div class="info-cards">
                        <span class="label">date de soumission</span>
                        <span class="data">{{ $document->created_at }}</span>
                    </div>

                    <div class="info-cards">
                        <span class="label">événement</span>
                        <span class="data">{{ $document->event->title }}</span>
                    </div>

                    <div class="info-cards">
                        <span class="label">type</span>
                        <span class="data">{{ $document->documentType->label }}</span>
                    </div>

                    @if($document->status !== "pending")
                        <div class="info-cards">
                            <span class="label">Traité par</span>
                            <span class="data">{{ $document->admin->name }}</span>
                        </div>
                    @endif

                    <div class="info-cards">
                        <span class="label">statut</span>
                        <span class="data">{{ ucfirst($document->status) }}</span>
                    </div>

                </div>
            </div>

            @if($document->status === "pending")
                <div class="bottom-card actions">
                    <div class="title">
                        <span>Actions</span>
                    </div>

                    <!-- <button>Telecharger</button>
                    <button>Partager</button> -->
                    <button class="bg-reject">Rejeter</button>
                    <button class="bg-validate">Valider</button>
                </div>
            @endif

            <div class="bottom-card comments">
                <div class="title">
                    <span>Commentaires</span>
                </div>

                <div class="content">
                    @if($document->status === "validated")
                        <p style="text-align: center; width: 100%;">Aucun commentaire disponible</p>
                    @elseif($document->status === "pending")
                        <input type="text" id="rejectionComment" placeholder="commentez ici">
                    @else
                        <div class="buble-row me">
                            <div class="avatar-base avatar-md">
                                @if($document->admin?->avatar_path)
                                    <img src="{{ asset('storage/' . $document->admin->avatar_path) }}" alt="Avatar">
                                @else
                                    {{ collect(explode(' ', $document->admin?->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}
                                @endif
                            </div>
                            <span class="info name">{{ $document->admin->name }}</span>
                        </div>

                        <div class="buble me">
                            <span class="info text">{{ $document->rejection_reason }}</span>
                            <span class="info date">{{ $document->processed_at }}</span>
                        </div>
                    @endif
                </div>
            </div>

        </section>

        <section class="bottom">

            <div class="bottom-card extraction">
                <div class="title">
                    <span>Texte OCR</span>
                </div>

                <div class="ocr-text">
                    {{ $document->extracted_text }}
                </div>
            </div>

            <div class="bottom-card results">
                <div class="title">
                    <span>Analyses</span>
                </div>

                <div class="result name-check">
                    Correspondance :
                    <span class="flag red">{{ $analysis['name_match_score']}}%</span>
                </div>

                @if($analysis['is_expired'])
                    <div class="result expiration-check">
                        Conclusion :
                        <span class="flag green">{{ $analysis['expiry_date'] }}</span>
                    </div>
                @endif
            </div>

        </section>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const validateBtn = document.querySelector('.bg-validate');
            const rejectBtn = document.querySelector('.bg-reject');

            const url = "{{ route('admin.documents.updateStatus', $document) }}";

            const csrfToken = document.querySelector(
                'meta[name="csrf-token"]'
            ).getAttribute('content');

            // ==========================
            // VALIDATION
            // ==========================

            validateBtn?.addEventListener('click', () => {

                ASAlerts.confirmAction(
                    'Valider ce document ?',
                    'Le document sera marqué comme validé.',
                    async () => {

                        try {

                            const response = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    status: 'validated'
                                })
                            });

                            const data = await response.json();

                            if (data.success) {

                                ASAlerts.success(
                                    data.message || 'Document validé avec succès.'
                                );

                                setTimeout(() => {
                                    location.reload();
                                }, 1000);

                            } else {

                                ASAlerts.warning(
                                    data.message || 'La validation a échoué.'
                                );
                            }

                        } catch (error) {

                            console.error(error);

                            ASAlerts.error(
                                'Une erreur est survenue lors de la validation.'
                            );
                        }
                    }
                );

            });

            // ==========================
            // REJET
            // ==========================

            rejectBtn?.addEventListener('click', async () => {

                const comment = document
                    .getElementById('rejectionComment')
                    .value
                    .trim();

                if (comment.length < 5) {
                    ASAlerts.info(
                        '',
                        'Veuillez préciser un motif de rejet (minimum 5 caractères).'
                    );
                    return;
                }

                try {

                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            status: 'rejected',
                            comment: comment
                        })
                    });

                    const data = await response.json();

                    alert(data.message);

                    if (data.success) {
                        location.reload();
                    }

                } catch (error) {

                    console.error(error);
                    ASAlerts.error('Erreur lors du rejet.');
                }
            });

        });
    </script>
</x-admin-layout>