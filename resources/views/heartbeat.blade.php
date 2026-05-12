<script>
    setInterval(function () {
        fetch("{{ route('user.heartbeat') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(r => r.json())
            .then(data => {
                // Si l'utilisateur est sur la page de gestion (Super Admin), 
                // on met à jour sa propre cellule immédiatement sans attendre le refresh global
                if (data.status === 'online') {
                    const myId = "{{ auth()->id() }}";
                    const myCell = document.querySelector(`.status-cell[data-user-id="${myId}"]`);
                    if (myCell) {
                        myCell.dataset.seen = new Date().toISOString();
                        if (typeof refreshUserStatuses === 'function') refreshUserStatuses();
                    }
                }
            });
    }, 20000); // 20 secondes
</script>
@if(auth()->user()->role === 'super-admin')
    <script>
        // 1. Rafraîchissement visuel des pastilles (En ligne / Vu il y a...)
        function refreshUserStatuses() {
            document.querySelectorAll('.status-cell').forEach(cell => {
                const lastSeenRaw = cell.dataset.seen;
                if (!lastSeenRaw) {
                    cell.innerHTML = '<span style="color:#94a3b8;">Jamais connecté</span>';
                    return;
                }

                const diffSeconds = dayjs().diff(dayjs(lastSeenRaw), 'second');

                if (diffSeconds < 60) {
                    cell.innerHTML = '<span style="color:#22c55e;font-weight:600;">● En ligne</span>';
                } else {
                    cell.innerHTML = '<span style="color:#64748b;">Vu ' + dayjs(lastSeenRaw).fromNow() + '</span>';
                }
            });
        }

        // 2. Auto-refresh du tableau complet (AJAX)
        // On ne le lance que si le tableau est présent sur la page actuelle
        setInterval(function () {
            const tableBody = document.getElementById('table-body');
            const searchInput = document.getElementById('search-input');

            // Condition : On rafraîchit seulement si on est sur la page de gestion
            // et que l'utilisateur n'est pas en train de taper une recherche
            if (tableBody && (!searchInput || (document.activeElement !== searchInput && searchInput.value === ""))) {
                const currentUrl = window.location.href;

                fetch(currentUrl, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(r => r.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newTable = doc.getElementById('table-body');

                        if (newTable) {
                            tableBody.innerHTML = newTable.innerHTML;
                            refreshUserStatuses(); // Relancer le calcul du temps relatif après l'injection
                        }
                    });
            }
        }, 15000); // Toutes les 15s

        // Initialisation au chargement
        document.addEventListener('DOMContentLoaded', refreshUserStatuses);
        setInterval(refreshUserStatuses, 10000);
    </script>
@endif