<x-dashboard-layout active="administrateurs">
    <x-slot:title>Gestion des administrateurs - ArchiSearch</x-slot>

    <div class="page-header">
        <div class="breadcrumb-small">Super Admin > Administrateurs</div>
        <h1>Gestion des administrateurs</h1>
    </div>

    <!-- Controls Row -->
    <div class="controls-row">
        <div class="search-filter-group">
            <div class="input-wrapper" style="width: 350px;">
                <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" placeholder="Rechercher un administrateur..." style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 1px solid #e2e8f0; border-radius: 10px; background: white;">
            </div>
            
            <button class="btn-outline">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                Filtrer
            </button>
        </div>

        <button class="btn-primary">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Créer un administrateur
        </button>
    </div>

    <!-- Data Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Administrateur</th>
                    <th>Organisation</th>
                    <th>Statut</th>
                    <th>Dernière connexion</th>
                    <th>Documents</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="admin-info">
                            <div class="avatar" style="width: 36px; height: 36px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">PD</div>
                            <div>
                                <span class="admin-name">Pierre Dupont</span>
                                <span class="admin-email">p.dupont@admin.gouv</span>
                            </div>
                        </div>
                    </td>
                    <td>Direction RH</td>
                    <td><span class="badge badge-green">Actif</span></td>
                    <td>Aujourd'hui 09:42</td>
                    <td style="font-weight: 500;">1 234</td>
                    <td style="text-align: right; white-space: nowrap;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="admin-info">
                            <div class="avatar" style="width: 36px; height: 36px; font-size: 0.8rem; background: #fef3c7; color: #b45309;">MK</div>
                            <div>
                                <span class="admin-name">Marie Koné</span>
                                <span class="admin-email">m.kone@admin.gouv</span>
                            </div>
                        </div>
                    </td>
                    <td>Direction Finance</td>
                    <td><span class="badge badge-green">Actif</span></td>
                    <td>Hier 16:15</td>
                    <td style="font-weight: 500;">876</td>
                    <td style="text-align: right;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="admin-info">
                            <div class="avatar" style="width: 36px; height: 36px; font-size: 0.8rem; background: #dcfce7; color: #16a34a;">JM</div>
                            <div>
                                <span class="admin-name">Jean Mbatswe</span>
                                <span class="admin-email">j.mbatswe@admin.gouv</span>
                            </div>
                        </div>
                    </td>
                    <td>Direction IT</td>
                    <td><span class="badge badge-green">Actif</span></td>
                    <td>Aujourd'hui 11:02</td>
                    <td style="font-weight: 500;">2 105</td>
                    <td style="text-align: right;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="admin-info">
                            <div class="avatar" style="width: 36px; height: 36px; font-size: 0.8rem; background: #ede9fe; color: #6d28d9;">SN</div>
                            <div>
                                <span class="admin-name">Sophie Ndiaye</span>
                                <span class="admin-email">s.ndiaye@admin.gouv</span>
                            </div>
                        </div>
                    </td>
                    <td>Direction Juridique</td>
                    <td><span class="badge badge-orange">Inactif</span></td>
                    <td>03/03/2026</td>
                    <td style="font-weight: 500;">412</td>
                    <td style="text-align: right;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></button>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom: none;">
                        <div class="admin-info">
                            <div class="avatar" style="width: 36px; height: 36px; font-size: 0.8rem; background: #fee2e2; color: #b91c1c;">LB</div>
                            <div>
                                <span class="admin-name">Luc Bertrand</span>
                                <span class="admin-email">l.bertrand@admin.gouv</span>
                            </div>
                        </div>
                    </td>
                    <td style="border-bottom: none;">Direction Achats</td>
                    <td style="border-bottom: none;"><span class="badge badge-red">Suspendu</span></td>
                    <td style="border-bottom: none;">21/02/2026</td>
                    <td style="border-bottom: none; font-weight: 500;">98</td>
                    <td style="text-align: right; border-bottom: none;">
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg></button>
                        <button class="action-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-row">
        <span>Affichage 1-5 sur 18 administrateurs</span>
        <div class="page-numbers">
            <button class="page-btn">Précédent</button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">Suivant</button>
        </div>
    </div>
</x-dashboard-layout>
