document.addEventListener('DOMContentLoaded', function() {
    const buyNowBtn = document.querySelector('.add-to-cart-btn');
    const paymentModal = document.getElementById('payment-modal');
    const closeBtn = paymentModal.querySelector('.close-btn');

    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function(e) {
            e.preventDefault();
            paymentModal.style.display = 'block';
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            paymentModal.style.display = 'none';
        });
    }

    window.addEventListener('click', function(e) {
        if (e.target == paymentModal) {
            paymentModal.style.display = 'none';
        }
    });
});
