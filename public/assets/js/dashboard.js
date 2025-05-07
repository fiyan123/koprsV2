// Function untuk mengatur active class pada navbar berdasarkan hash URL
function overrideActiveForHash() {
    const currentHash = window.location.hash;

    if (currentHash && document.querySelector(`a[href="${currentHash}"]`)) {
        const dashboardLink = document.querySelector('.nav-dashboard');
        if (dashboardLink) {
            dashboardLink.classList.remove('active');
        }
    }
}

window.addEventListener('load', overrideActiveForHash);
window.addEventListener('hashchange', overrideActiveForHash);

document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.querySelector('.navbar-toggler');
    const topDashboard = document.querySelector('#topDashboard'); // Pastikan ID ini sesuai
    const navbarDashboard = document.querySelector('#navbarDashboard');

    toggleButton.addEventListener('click', function () {
        topDashboard.classList.toggle('show');
        navbarDashboard.classList.toggle('show');
    });
});
