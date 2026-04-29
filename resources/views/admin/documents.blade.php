<x-admin-layout active="documents" title="Documents - ArchiSearch">
    <div class="page-header">
        <!-- <div class="breadcrumb-small">Portail Admin > Événements > Collecte Contrats RH > Documents</div> -->
        <h1>Documents de l'événement</h1>
        <div class="admin-info">
                <div class="avatar" style="width: 40px; height: 40px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                alt="Avatar de {{ Auth::user()->name }}">
                        @else
                            <!-- <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar par défaut"> -->
                            {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('') }}
                        @endif
                </div>
                <div style="display: flex; flex-direction: column; align-items: flex-start;">
                    <span class="admin-name">{{ Auth::user()->name }}</span>
                    <span class="admin-mail">{{ Auth::user()->role }}</span>
                </div>
            </div>
    </div>

    <!-- Controls Row -->
    <div class="controls-row">
        <div class="search-filter-group" style="flex: 2;">
            <div class="input-wrapper" style="width: 350px; background: white; display: flex; justify-content: center; align-items: center; border-radius: 10px; gap: 5px;">
                <svg class="input-icon" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" placeholder="Filtrer les documents..." style="width: 80%; padding: 0.75rem 1rem 0.75rem 1rem; border: none; outline: none;">
            </div>
            
            <div class="log-tabs">
                <button class="log-tab active">Tous</button>
                <button class="log-tab">PDF</button>
                <button class="log-tab">JPG</button>
                <button class="log-tab">XLS</button>
            </div>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button class="btn-outline">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                Tout télécharger
            </button>
            <button class="btn-primary" style="background: #1e3a8a; display: flex; align-items: center; gap: 10px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="21 8 21 21 3 21 3 8"/><rect width="22" height="5" x="1" y="3"/><line x1="10" x2="14" y1="12" y2="12"/></svg>
                Archiver sélection
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>DOCUMENT</th>
                    <th>CATÉGORIE</th>
                    <th>CONTRIBUTEUR</th>
                    <th>DATE</th>
                    <th>STATUT</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <!-- Doc 1 -->
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="file-icon-box bg-pdf">PDF</div>
                            <div class="text-sizes">
                                <div style="font-weight: 700; color: #1e293b;">CNI_Dupont_2026.pdf</div>
                                <div class="file-size">1.2 Mo</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="tag" style="background: #f1f5f9; color: #475569;">Identité</span></td>
                    <td style="font-weight: 500;">J. Dupont</td>
                    <td style="color: #64748b;">02 Avr</td>
                    <td><span class="badge badge-green">Accepté</span></td>
                    <td style="text-align: right;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg></button>
                        <button class="action-btn" style="color: #ef4444;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg></button>
                    </td>
                </tr>

                <!-- Doc 2 -->
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="file-icon-box bg-pdf">PDF</div>
                            <div class="text-sizes">
                                <div style="font-weight: 700; color: #1e293b;">Contrat_Moreau_sign.pdf</div>
                                <div class="file-size">2.8 Mo</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="tag" style="background: #f1f5f9; color: #475569;">Contrat</span></td>
                    <td style="font-weight: 500;">A. Moreau</td>
                    <td style="color: #64748b;">02 Avr</td>
                    <td><span class="badge badge-green">Accepté</span></td>
                    <td style="text-align: right;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg></button>
                        <button class="action-btn" style="color: #ef4444;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg></button>
                    </td>
                </tr>

                <!-- Doc 3 -->
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="file-icon-box bg-pdf">PDF</div>
                            <div class="text-sizes">
                                <div style="font-weight: 700; color: #1e293b;">Facture_Kone_092.pdf</div>
                                <div class="file-size">542 Ko</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="tag" style="background: #f1f5f9; color: #475569;">Finance</span></td>
                    <td style="font-weight: 500;">M. Koné</td>
                    <td style="color: #64748b;">03 Avr</td>
                    <td><span class="badge badge-blue">En traitement</span></td>
                    <td style="text-align: right;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg></button>
                        <button class="action-btn" style="color: #ef4444;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg></button>
                    </td>
                </tr>

                <!-- Doc 4 -->
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="file-icon-box bg-jpg">JPG</div>
                            <div class="text-sizes">
                                <div style="font-weight: 700; color: #1e293b;">Photo_Pereira.jpg</div>
                                <div class="file-size">3.1 Mo</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="tag" style="background: #f1f5f9; color: #475569;">Identité</span></td>
                    <td style="font-weight: 500;">M. Pereira</td>
                    <td style="color: #64748b;">03 Avr</td>
                    <td><span class="badge badge-orange">À revoir</span></td>
                    <td style="text-align: right;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg></button>
                        <button class="action-btn" style="color: #ef4444;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg></button>
                    </td>
                </tr>

                <!-- Doc 5 -->
                <tr>
                    <td style="border-bottom: none;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="file-icon-box bg-xls">XLS</div>
                            <div class="text-sizes">
                                <div style="font-weight: 700; color: #1e293b;">Bilan_Diallo_Q1.xlsx</div>
                                <div class="file-size">128 Ko</div>
                            </div>
                        </div>
                    </td>
                    <td style="border-bottom: none;"><span class="tag" style="background: #f1f5f9; color: #475569;">Finance</span></td>
                    <td style="border-bottom: none; font-weight: 500;">F. Diallo</td>
                    <td style="border-bottom: none; color: #64748b;">04 Avr</td>
                    <td style="border-bottom: none;"><span class="badge badge-blue">Indexé</span></td>
                    <td style="text-align: right; border-bottom: none;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg></button>
                        <button class="action-btn" style="color: #ef4444;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-admin-layout>
