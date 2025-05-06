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