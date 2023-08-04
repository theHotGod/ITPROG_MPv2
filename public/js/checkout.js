document.addEventListener('DOMContentLoaded', (e) => {
    const submit = document.getElementById('submit-btn');
    const cancel = document.getElementById('cancel-btn');
    

    submit.addEventListener('click', (e) => {
        const name = document.getElementById('customerName').value;
        const payment = document.getElementById('payment').value;
    
        if (name.trim() === "" || payment.trim() === "") {
            e.preventDefault(); // Prevent the form from submitting
            alert('Please fill out all the required fields!');
        } else {
            const data = {
                name,
                payment
            };
            fetch('/success', {
                method: 'POST',
                headers: {
                    'Content-type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json()) // Parse the response as JSON
            .then(data => {
                console.log('Form submitted successfully!', data);
            })
            .catch(error => {
                console.error(error);
            });
            // Optionally, you can submit the form here using AJAX or any other method.
        }
    });
    
    cancel.addEventListener('click',(e) => {
        e.preventDefault(); // Prevent the form from submitting
    
        fetch('/cancel', {
            method: 'POST',
        }).then(response => {
            if (response.ok) {
                console.log('Order canceled successfully!');
                window.location = '/'; // Redirect to home page after canceling the order
            } else {
                console.error('Failed to cancel the order');
            }
        });
    });
    
    
});