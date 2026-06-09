// // const blues = [
    
// // ];

// // const color = blues[Math.floor(Math.random() * blues.length)];

// const colors = [
//     '#0369a1',
//     '#059669',
//     '#16a34a',
//     '#1e293b',
//     '#2563eb',
//     '#6366f1',
//     '#60A5FA',
//     '#3B82F6',
//     '#1e3a8a',
//     '#dc2626',
//     '#ef4444',
//     '#fef08a',
//     '#10b981'
// ];

// // const colors = [...];
// console.log(
//     "avatars trouvés :",
//     document.querySelectorAll('.avatar-base').length
// );

// document.querySelectorAll('.avatar-base').forEach(avatar => {
//     const name = avatar.dataset.name;

//     let hash = 0;
//     if (!name) {
//         return
//     }
//     for (let i = 0; i < name.length; i++) {
//         hash += name.charCodeAt(i);
//     }

//     const color = colors[hash % colors.length];

//     avatar.style.backgroundColor = color;
//     // avatar.style.color = '#fff';
// });