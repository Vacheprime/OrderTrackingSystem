// const button = document.getElementById('button');
// const sidebar = document.getElementById('sidebar');

// button.addEventListener('click', function() {
//     button.classList.toggle('rotate');
//     sidebar.classList.toggle('shrink');
// });

document.addEventListener('DOMContentLoaded', () => {
    const button = document.getElementById('button');
    const sidebar = document.getElementById('sidebar');

    button.addEventListener('click', () => {
        button.classList.toggle('rotate');
        sidebar.classList.toggle('shrink');
        document.querySelectorAll('.title').forEach((p) => p.classList.toggle('remove'));
    });
});