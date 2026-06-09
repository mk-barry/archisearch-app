// const blues = [
    
// ];

// const color = blues[Math.floor(Math.random() * blues.length)];

const colors = [
    '#0369a1',
    '#059669',
    '#16a34a',
    '#1e293b',
    '#2563eb',
    '#6366f1',
    '#60A5FA',
    '#3B82F6',
    '#1e3a8a',
    '#dc2626',
    '#ef4444',
    '#fef08a',
    '#10b981'
];

const avatars = document.querySelectorAll('.avatar-md');

avatars.forEach(avatar => {
    const color = colors[Math.floor(Math.random() * colors.length)];
    avatar.style.backgroundColor = color + "!important";
});