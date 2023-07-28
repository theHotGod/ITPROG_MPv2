document.addEventListener('DOMContentLoaded', (event) => {
    // Select all elements with IDs ending with "Card"
    const addCartBtns = document.querySelectorAll('[id$="Card"]');
    const minusBtns = document.querySelectorAll('[id$="Minus"]');
    const plusBtns = document.querySelectorAll('[id$="Plus"]');
    // Initial quantities for each dish (set to 0 initially)
    const quantities = {};
    
    // Selected main dish and its quantity
    let selectedMainDishID = null;
    let selectedMainDishQuantity = 0;
  
    // Function to update the quantity input value
    function updateQuantity(dishID) {
      const quantityInput = document.getElementById(`quantityInput${dishID}`);
      if (quantityInput) {
        quantityInput.value = quantities[dishID] || 0;
      }
    }
  
    // Function to enable/disable Add to Cart buttons
    function toggleAddToCartButtons(disabled) {
      addCartBtns.forEach((addCartBtn) => {
        const dishID = addCartBtn.id.replace('Card', '');
        if (selectedMainDishID && dishID !== selectedMainDishID) {
          addCartBtn.disabled = disabled;
        }
      });
    }
  
    // Event listeners for the minus buttons
    minusBtns.forEach((minusBtn) => {
      minusBtn.addEventListener('click', (e) => {
        const btnID = e.target.id;
        const dishID = btnID.replace('Minus', '');
        if (quantities[dishID] > 0) {
          quantities[dishID]--;
          updateQuantity(dishID);
        }
      });
    });
  
    // Event listeners for the plus buttons
    plusBtns.forEach((plusBtn) => {
      plusBtn.addEventListener('click', (e) => {
        const btnID = e.target.id;
        const dishID = btnID.replace('Plus', '');
        quantities[dishID] = (quantities[dishID] || 0) + 1;
        updateQuantity(dishID);
      });
    });
  
    // Loop through each button and attach the click event listener
    addCartBtns.forEach((addCartBtn) => {
      addCartBtn.addEventListener('click', (e) => {
        const btnID = e.target.id;
        const dishID = btnID.replace('Card', '');
        const price = document.getElementById(`price${dishID}`);

        const phpRemove = price?.innerHTML.replace('Php','');
        let priceValue = parseInt(phpRemove);
        priceValue *= quantities[dishID];
        
        console.log(priceValue);
        console.log('Add to cart clicked for dish ID:', dishID);
        console.log('Quantity:', quantities[dishID] || 0);
        

        const testing = document.getElementById('total');
        testing.innerHTML = priceValue.toString();
        // Update selected main dish and quantity
        selectedMainDishID = dishID;
        selectedMainDishQuantity = quantities[dishID] || 0;
        
        // Disable other "Add to Cart" buttons
        toggleAddToCartButtons(true);
        
        // Re-enable the clicked "Add to Cart" button
        addCartBtn.disabled = false;


      });
    });
  });
  