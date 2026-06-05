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

                    <div class="info-cards">
                        <span class="label">statut OCR</span>
                        <span class="data">Indexé</span>
                    </div>

                </div>
            </div>

            <div class="bottom-card actions">
                <div class="title">
                    <span>Actions</span>
                </div>

                <button>Telecharger</button>
                <button>Partager</button>
                <button>Rejeter</button>
                <button>Valider</button>
            </div>

            <div class="bottom-card comments">
                <div class="title">
                    <span>Commentaires</span>
                </div>

                <div class="content">
                    <div class="avatar"></div>

                    <div class="buble me">
                        <span class="info name">{{ $document->name }}</span>
                        <span class="info text">{{ $document->rejection_reason }}</span>
                        <span class="info date">{{ $document->processed_at }}</span>
                    </div>
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
                    <span class="flag red">{{ $analysis['name_match_score'] * 100 }}%</span>
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

</x-admin-layout>