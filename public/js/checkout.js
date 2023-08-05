document.addEventListener('DOMContentLoaded', (e) => {
    const cancel = document.getElementById('cancel-btn'); 
    const payment = document.getElementById('payment');
    
    const submit = document.getElementById('submitbtn');
    


    function updateSubmitButton() {
        const paymentValue = parseFloat(payment.value);
        
        if (document.getElementById('totalAfterDiscount') !== null) {
            const totalAfterDiscountElement = document.getElementById('totalAfterDiscount');
            const totalAfterDiscount = parseFloat(totalAfterDiscountElement.textContent);
            if (!isNaN(totalAfterDiscount)) {
                submit.disabled = paymentValue < totalAfterDiscount;
                return;
            }
        }
    
        if (document.getElementById('totalPrice') !== null) {
            const totalPriceElement = document.getElementById('totalPrice');
            const totalPrice = parseFloat(totalPriceElement.textContent);
            if (!isNaN(totalPrice)) {
                submit.disabled = paymentValue < totalPrice;
                return;
            }
        }
    
        // If both totalAfterDiscount and totalPrice are invalid, disable the submit button
        submit.disabled = true;
    }
    

    payment.addEventListener('input', () => {
        updateSubmitButton();
    });

    // Call updateSubmitButton initially to set the initial state of the button
    updateSubmitButton();

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