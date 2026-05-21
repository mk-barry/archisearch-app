<x-admin-layout pri_css="{{  asset('css/dashboard/main.css') }}" sec_css="{{  asset('css/admin/view-docs.css') }}" active="documents" title="Vue Document - ArchiSearch">

    <!-- <style>
        .section-container{
            display: grid;
            grid-template-columns: minmax(0, 1fr) 340px;
            grid-template-areas:
                "viewer right"
                "bottom right";
            gap: 1.5rem;
            align-items: start;
        }

        .left{
            grid-area: viewer;
            height: 720px;
            overflow: hidden;
            border-radius: 20px;
        }

        .left iframe{
            width: 100%;
            height: 100%;
            border: none;
        }

        .right{
            grid-area: right;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            position: sticky;
            top: 1rem;
        }

        .bottom{
            grid-area: bottom;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .bottom-card{
            width: 100%;
        }

        .metadatas,
        .bottom-card{
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            overflow: hidden;
        }

        .title{
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #eef2f7;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .info-list{
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 1.25rem;
        }

        .info-cards{
            display: flex;
            flex-direction: column;
            gap: .25rem;
        }

        .info-cards .label{
            font-size: .85rem;
            color: #94a3b8;
            text-transform: capitalize;
        }

        .info-cards .data{
            font-size: .95rem;
            font-weight: 500;
            color: #0f172a;
        }

        .ocr-text{
            padding: 1.25rem;
            line-height: 1.7;
            color: #334155;
            max-height: 300px;
            overflow-y: auto;
        }

        .results{
            padding-bottom: 1rem;
        }

        .result{
            padding: 0 1.25rem;
            margin-top: 1rem;
            font-size: .95rem;
            color: #334155;
        }

        .flag{
            padding: .25rem .6rem;
            border-radius: 999px;
            font-size: .8rem;
            font-weight: 600;
        }

        .flag.red{
            background: #fee2e2;
            color: #dc2626;
        }

        .flag.green{
            background: #dcfce7;
            color: #15803d;
        }

        .actions{
            padding-bottom: 1.25rem;
        }

        .actions button{
            width: calc(100% - 2.5rem);
            margin: .6rem 1.25rem 0;
            height: 48px;
            border-radius: 12px;
            border: 1px solid #dbe3ef;
            background: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: .2s ease;
        }

        .actions button:hover{
            transform: translateY(-1px);
        }

        .actions button:last-child{
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
        }

        .comments{
            padding-bottom: 1.25rem;
        }

        .comments .content{
            padding: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .comments .avatar{
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #2563eb;
            flex-shrink: 0;
        }

        .buble{
            background: #f1f5f9;
            border-radius: 16px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: .4rem;
            width: 100%;
        }

        .buble .name{
            font-weight: 600;
            color: #0f172a;
        }

        .buble .text{
            color: #475569;
            line-height: 1.5;
        }

        .buble .date{
            font-size: .8rem;
            color: #94a3b8;
        }

        @media screen and (max-width: 1100px){

            .section-container{
                grid-template-columns: 1fr;
                grid-template-areas:
                    "viewer"
                    "right"
                    "bottom";
            }

            .right{
                position: relative;
                top: unset;
            }

            .left{
                height: 600px;
            }
        }

        @media screen and (max-width: 768px){

            .left{
                height: 500px;
            }

            .actions button{
                width: calc(100% - 2rem);
                margin: .5rem 1rem 0;
            }

            .info-list,
            .ocr-text,
            .comments .content{
                padding: 1rem;
            }
        }
    </style> -->

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
                    <span class="flag red">{{ $analysis['name_score'] * 100 }}%</span>
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