<x-admin-layout active="documents" title="Documents - ArchiSearch">
    <div class="page-header">
        <div class="breadcrumb-small">Portail Admin > Événements > Collecte Contrats RH > Documents</div>
        <h1>Documents de l'événement</h1>
    </div>

    <!-- Controls Row -->
    <div class="controls-row">
        <div class="search-filter-group" style="flex: 2;">
            <div class="input-wrapper" style="width: 350px;">
                <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" placeholder="Filtrer les documents..." style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 1px solid #e2e8f0; border-radius: 10px; background: white;">
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
                    <th style="width: 350px;">DOCUMENT</th>
                    <th>CATÉGORIE</th>
                    <th>CONTRIBUTEUR</th>
                    <th>DATE</th>
                    <th>STATUT</th>
                    <th style="text-align: right;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <!-- Doc 1 -->
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="file-icon-box bg-pdf" style="width: 38px; height: 38px;">PDF</div>
                            <div>
                                <div style="font-weight: 700; color: #1e293b;">CNI_Dupont_2026.pdf</div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">1.2 Mo</div>
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
                            <div class="file-icon-box bg-pdf" style="width: 38px; height: 38px;">PDF</div>
                            <div>
                                <div style="font-weight: 700; color: #1e293b;">Contrat_Moreau_sign.pdf</div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">2.8 Mo</div>
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
                            <div class="file-icon-box bg-pdf" style="width: 38px; height: 38px;">PDF</div>
                            <div>
                                <div style="font-weight: 700; color: #1e293b;">Facture_Kone_092.pdf</div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">542 Ko</div>
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
                            <div class="file-icon-box bg-jpg" style="width: 38px; height: 38px;">JPG</div>
                            <div>
                                <div style="font-weight: 700; color: #1e293b;">Photo_Pereira.jpg</div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">3.1 Mo</div>
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
                            <div class="file-icon-box bg-xls" style="width: 38px; height: 38px;">XLS</div>
                            <div>
                                <div style="font-weight: 700; color: #1e293b;">Bilan_Diallo_Q1.xlsx</div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">128 Ko</div>
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
