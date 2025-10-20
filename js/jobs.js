document.addEventListener('DOMContentLoaded', function() {
    const applyNowBtn = document.querySelector('.apply-now-btn');
    const applicationModal = document.getElementById('application-modal');
    const closeBtn = applicationModal.querySelector('.close-btn');

    if (applyNowBtn) {
        applyNowBtn.addEventListener('click', function(e) {
            e.preventDefault();
            applicationModal.style.display = 'block';
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            applicationModal.style.display = 'none';
        });
    }

    window.addEventListener('click', function(e) {
        if (e.target == applicationModal) {
            applicationModal.style.display = 'none';
        }
    });
});
