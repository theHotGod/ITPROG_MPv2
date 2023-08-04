document.addEventListener('DOMContentLoaded', (e) => {
    const cancel = document.getElementById('cancel-btn'); 

    cancel.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent the default click behavior
        fetch('/cancel', {
            method: 'POST',
        })
        .then(response => {
            if (response.ok) {
                console.log('Order canceled successfully!');
                window.location = '/'; // Redirect to home page after canceling the order
            } else {
                console.error('Failed to cancel the order');
            }
        })
        .catch(error => {
            console.error('Failed to cancel the order:', error);
        });
    });
});