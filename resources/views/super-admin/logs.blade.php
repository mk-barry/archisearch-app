<x-super-admin-layout active="logs">
    <x-slot:title>Journaux système - ArchiSearch</x-slot>

    <div class="page-header">
        <div class="breadcrumb-small">Super Admin > Journaux système</div>
        <h1>Journaux système</h1>
        <div class="admin-info">
            <div class="avatar" style="width: 40px; height: 40px; font-size: 0.8rem; background: #e0f2fe; color: #0369a1;">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar de {{ Auth::user()->name }}">
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
            <div class="input-wrapper" style="width: 300px;">
                <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" placeholder="Filtrer par action, utilisateur..." style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 1px solid #e2e8f0; border-radius: 10px; background: white;">
            </div>
            
            <div class="btn-outline" style="background: white;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                04 Avr 2026
            </div>

            <div class="log-tabs">
                <button class="log-tab active">Tous</button>
                <button class="log-tab">INFO</button>
                <button class="log-tab">WARNING</button>
                <button class="log-tab">ERROR</button>
            </div>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button class="btn-outline">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                Purger les logs
            </button>
            <button class="btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                Exporter
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Horodatage</th>
                    <th>Utilisateur</th>
                    <th>Action</th>
                    <th>Ressource</th>
                    <th>Adresse IP</th>
                    <th style="text-align: right;">Niveau</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="color: #94a3b8;">2026-04-04 11:42:03</td>
                    <td style="font-weight: 600;">admin.dupont</td>
                    <td><span class="action-text">AUTH_LOGIN</span></td>
                    <td>Session #9843</td>
                    <td>192.168.1.42</td>
                    <td style="text-align: right;"><span class="badge badge-blue">INFO</span></td>
                </tr>
                <tr>
                    <td style="color: #94a3b8;">2026-04-04 11:38:17</td>
                    <td style="font-weight: 600;">admin.kone</td>
                    <td><span class="action-text">DOC_ARCHIVE</span></td>
                    <td>Doc #4821</td>
                    <td>10.0.0.14</td>
                    <td style="text-align: right;"><span class="badge badge-blue">INFO</span></td>
                </tr>
                <tr>
                    <td style="color: #94a3b8;">2026-04-04 11:22:45</td>
                    <td style="font-weight: 600;">system</td>
                    <td><span class="action-text">ANOMALY_DETECTED</span></td>
                    <td>Doc #4872</td>
                    <td>—</td>
                    <td style="text-align: right;"><span class="badge badge-orange">WARNING</span></td>
                </tr>
                <tr>
                    <td style="color: #94a3b8;">2026-04-04 10:50:11</td>
                    <td style="font-weight: 600;">admin.bertrand</td>
                    <td><span class="action-text">AUTH_FAILED</span></td>
                    <td>Tentative #3/5</td>
                    <td>172.16.0.8</td>
                    <td style="text-align: right;"><span class="badge badge-red">ERROR</span></td>
                </tr>
                <tr>
                    <td style="color: #94a3b8;">2026-04-04 10:44:42</td>
                    <td style="font-weight: 600;">admin.mbatswe</td>
                    <td><span class="action-text">EVENT_CREATE</span></td>
                    <td>Événement #52</td>
                    <td>192.168.2.1</td>
                    <td style="text-align: right;"><span class="badge badge-blue">INFO</span></td>
                </tr>
                <tr>
                    <td style="color: #94a3b8;">2026-04-04 10:30:00</td>
                    <td style="font-weight: 600;">system</td>
                    <td><span class="action-text">BACKUP_SUCCESS</span></td>
                    <td>MinIO backup #212</td>
                    <td>—</td>
                    <td style="text-align: right;"><span class="badge badge-blue">INFO</span></td>
                </tr>
                <tr>
                    <td style="border-bottom: none; color: #94a3b8;">2026-04-04 09:15:44</td>
                    <td style="border-bottom: none; font-weight: 600;">superadmin</td>
                    <td style="border-bottom: none;"><span class="action-text">SETTINGS_UPDATE</span></td>
                    <td style="border-bottom: none;">Quota: 20Mo→25Mo</td>
                    <td style="border-bottom: none;">192.168.1.1</td>
                    <td style="text-align: right; border-bottom: none;"><span class="badge badge-orange">WARNING</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</x-super-admin-layout>