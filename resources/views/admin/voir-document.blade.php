<x-admin-layout pri_css="{{  asset('css/dashboard/main.css') }}" active="documents" title="Analyse Document - ArchiSearch">
    <div class="page-header">
        <div class="page-info">
            <h1>Expertise : {{ basename($document->file_path) }}</h1>
            <a href="{{ route('admin.documents') }}" class="btn-outline">Retour</a>
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

    <div style="display: grid; grid-template-columns: 1fr 450px; gap: 2rem; align-items: start;">
        
        <!-- Preview du Document -->
        <div class="card" style="padding: 0; overflow: hidden; height: 85vh;">
            <iframe src="{{ asset('storage/' . $document->file_path) }}" 
                    style="width: 100%; height: 100%; border: none;"></iframe>
        </div>

        <!-- Panneau d'Analyse -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <!-- Widget de Score -->
            <div class="card" style="border-left: 5px solid {{ $analysis['name_match'] ? '#10b981' : '#ef4444' }};">
                <h3 style="margin-top: 0;">Analyse d'Intégrité</h3>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>Correspondance Nom :</span>
                    <strong style="font-size: 1.2rem; color: {{ $analysis['name_match'] ? '#10b981' : '#ef4444' }}">
                        {{ $analysis['name_score'] * 100 }}%
                    </strong>
                </div>
                
                @if($analysis['is_expired'])
                    <div style="background: #fef2f2; color: #991b1b; padding: 10px; border-radius: 8px; margin-top: 1rem;">
                        🚩 Document expiré le : {{ $analysis['expiry_date'] }}
                    </div>
                @endif
            </div>

            <!-- Texte Extrait -->
            <div class="card">
                <h4>Texte Extrait (OCR)</h4>
                <div style="background: #f8fafc; padding: 15px; border-radius: 8px; font-family: monospace; font-size: 0.85rem; max-height: 200px; overflow-y: auto;">
                    {{ $document->extracted_text }}
                </div>
            </div>

            <!-- Formulaire de Décision -->
            <div class="card">
                <h4>Décision Finale</h4>
                <form id="decisionForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <textarea id="adminComment" style="width: 100%; min-height: 100px; border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px;" placeholder="Commentaire facultatif..."></textarea>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 1rem;">
                        <button type="button" onclick="submitDecision('valide')" class="btn-primary" style="background: #10b981;">Valider</button>
                        <button type="button" onclick="submitDecision('rejete')" class="btn-primary" style="background: #ef4444;">Rejeter</button>
                    </div>
                    <!-- <button type="button" onclick="submitDecision('archive')" class="btn-outline" style="width: 100%; margin-top: 10px;">Archiver sans valider</button> -->
                </form>
            </div>
        </div>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script>
        function submitDecision(status) {
            const comment = document.getElementById('adminComment').value.trim();
            if (status === 'rejete' && comment.lenght < 5) {
                Swal.fire({
                    title: 'Action requise',
                    text: "Vous devez saisir un motif de rejet plus explicite",
                    icon: 'stop',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444'
                });
                return;
            }
            Swal.fire({
                title: 'Confirmer la décision ?',
                text: "Le statut passera en : " + status,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1e3a8a'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (status === 'valide') {
                        status = 'validated'
                    } else {
                        status = 'rejected'
                    }
                    fetch("{{ route('admin.documents.updateStatus', $document->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status: status,
                            comment: comment
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            Swal.fire('Succès', data.message, 'success').then(() => {
                                window.location.href = "{{ route('admin.documents') }}";
                            });
                        } else {
                            Swal.fire('Erreur', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Erreur', 'Une erreur système est survenue', 'error');
                    });
                }
            });
        }
    </script>
</x-admin-layout>