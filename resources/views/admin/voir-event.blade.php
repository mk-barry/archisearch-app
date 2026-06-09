<x-admin-layout sec_css="{{ asset('css/admin/voir-event.css') }}" active="evenements">
    <x-slot:title>Détails de l'événement - ArchiSearch</x-slot>

        <div class="page-header">
            <div class="page-info">
                <div class="breadcrumb-small">Admin > Événements > Détails</div>
                <h1>{{ $event->title }}</h1>
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
        <a href="{{ route('admin.edit-events', $event->uuid) }}" class="btn-primary"
            style="background-color: #2563eb; text-decoration: none; padding: 1rem; border-radius: 6px; color: white; width: 25%; display: flex; justify-content: center;">
            Modifier l'événement
        </a>
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-top: 20px;">
            {{-- Colonne Gauche : Infos --}}
            <div
                style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h3 style="margin-bottom: 1rem; color: #1e293b;">Description</h3>
                <p style="color: #64748b; line-height: 1.6;">{{ $event->description }}</p>

                <hr style="margin: 1.5rem 0; border: 0; border-top: 1px solid #f1f5f9;">

                <h3 style="margin-bottom: 1rem; color: #1e293b;">Documents attendus</h3>
                <div style="display: flex; gap: 10px;">
                    @foreach($event->documentTypes as $type)
                        <span style="background: #f1f5f9; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem;">
                            {{ $type->label }}
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- Colonne Droite : Stats --}}
            <div
                style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h3 style="margin-bottom: 1rem; color: #1e293b;">Statistiques</h3>
                <div style="font-size: 0.9rem; color: #64748b;">
                    <p>Début : <strong>{{ $event->start_date->format('d/m/Y') }}</strong></p>
                    <p>Fin : <strong>{{ $event->end_date->format('d/m/Y') }}</strong></p>
                    <p>Type : <strong>{{ ucfirst($event->invite_type) }}</strong></p>
                </div>
            </div>
        </div>
        <div
            style="margin-top: 20px; background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <h3 style="margin-bottom: 1.5rem; color: #1e293b; display: flex; align-items: center; gap: 10px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                Suivi des dépôts par invité
            </h3>

            <div style="overflow-x: auto;">
                <table class="participant-table">
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Documents</th>
                            <th>Dernière activité</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @if($event->authorizedStudent && $event->authorizedStudent->count() > 0)
                            @foreach($event->authorizedStudent as $student)
                                <tr>
                                    {{-- Ton code de ligne ici --}}
                                    <td>
                                        <div style="font-weight: 500; color: #1e293b;">{{ $student->name }}</div>
                                        <div style="font-size: 0.75rem; color: #94a3b8;">{{ $student->matricule }}</div>
                                    </td>
                                    <td>
                                        {{-- Badge dynamique selon le statut --}}
                                        <span style="display: inline-flex; align-items: center; gap: 5px; background: #ecfdf5; color: #059669; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 500;">
                                            <span style="width: 6px; height: 6px; background: #10b981; border-radius: 50%;"></span>
                                        
                                        @if (!$student->documents)
                                            {{ $student->documents
                                            ->where('event_id', $event->id)
                                            ->pluck('title')
                                            ->implode(', ') }}
                                        @else
                                            Aucun document
                                        @endif
                                        </span>
                                    </td>
                                    <td style="color: #64748b;">
                                        @if (!$student->documents)
                                            {{ $student->documents
                                            ->where('event_id', $event->id)
                                            ->pluck('created_at')
                                            ->implode(', ') }}
                                        @else
                                            Aucune activité
                                        @endif
                                    </td>
                                    <td>
                                        <button class="action-btn" title="Consulter le dossier"
                                            style="color: #0369a1; border: none; background: none; cursor: pointer;">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" style="padding: 20px; text-align: center; color: #94a3b8;">
                                    Aucun étudiant n'est encore inscrit à cet événement.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
</x-admin-layout>