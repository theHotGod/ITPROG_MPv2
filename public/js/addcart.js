document.addEventListener('DOMContentLoaded', (e) => {

  // buttons
  const addCartBtns = document.querySelectorAll("[id$=Card]");
  const minusBtns = document.querySelectorAll('[id$=Minus]');
  const plusBtns = document.querySelectorAll('[id$=Plus]');
  const removeBtns = document.querySelectorAll('[id$=Remove]');
  const checkoutBtn = document.getElementById('checkoutbtn');


  // other valuables
  const quantities = {}; // quantity for each dish

  // functions
  function updateQuantity(dishID) {
    const quantityInput = document.getElementById(`quantityInput${dishID}`) ;

    if(quantityInput) {
      quantityInput.value = quantities[dishID] || 0;
    }
  }

  function updateTotalPrice() {
    let totalPrice = 0;

    addCartBtns.forEach((addCartBtn) => {
      const btnID = addCartBtn.id;
      const dishID = btnID.replace('Card', '');
      const price = document.getElementById(`price${dishID}`);
      const priceVal = price.innerHTML.replace('Php', '');
      const totalQuantity = document.getElementById(`quantityInput${dishID}`);

      const convertPrice = parseInt(priceVal);
      const convertQty = parseInt(totalQuantity.value);

      if(convertQty >= 1)
        totalPrice += convertPrice * convertQty;
    });
    const total = document.getElementById('total');
    total.innerHTML = totalPrice;
  }

  // button functionalities
  minusBtns.forEach((minusBtn) => {
    minusBtn.addEventListener('click', (e) => {
      const btnID = e.target.id;
      const dishID = btnID.replace('Minus', '');
      if (quantities[dishID] > 0) {
        quantities[dishID]--;
        updateQuantity(dishID);
      }

      console.log('Minus for Dish ID: ', dishID);
      console.log('Total quantity: ', quantities[dishID]);
    });
  });

  plusBtns.forEach((plusBtn) => {
    plusBtn.addEventListener('click', (e) => {
      const btnID = e.target.id;
      const dishID = btnID.replace('Plus', '');
      quantities[dishID] = (quantities[dishID] || 0) + 1;
      updateQuantity(dishID);
      
      console.log('Plus for Dish ID: ', dishID);
      console.log('Total quantity: ', quantities[dishID]);
    });
  });

  addCartBtns.forEach((addCartBtn) => {
    addCartBtn.addEventListener('click', (e) => {
      const btnID = e.target.id;
      const dishID = btnID.replace('Card', '');
      const price = document.getElementById(`price${dishID}`);
      const priceVal = price.innerHTML.replace('Php', '');
      const totalQuantity = document.getElementById(`quantityInput${dishID}`);

      // converting to int
      const convertPrice = parseInt(priceVal);
      const convertQty = parseInt(totalQuantity.value);

      let total = 0;
      if (convertQty >= 1) {
        total = convertPrice * convertQty;
        console.log('Total price for everything: Php ', total);
      }
      else {
        alert('Please enter quantity!');
      }

      console.log('Add to Cart for Dish ID: ', dishID);
      updateTotalPrice();
    });
  });

  removeBtns.forEach((removeBtn) => {
    removeBtn.addEventListener('click', (e) => {
      const btnID = e.target.id;
      const dishID = btnID.replace('Remove', '');
      const totalQuantity = document.getElementById(`quantityInput${dishID}`);
      totalQuantity.value = 0;

      console.log('Remove for Dish ID: ', dishID);
      updateTotalPrice();
    })
  });

  checkoutBtn.addEventListener('click', (e) => {
    console.log('Clicked checkout button');
    // Convert the quantities object into an array of items with dishID, quantity, name, and category
    const cartItems = Object.entries(quantities).map(([dishID, quantity]) => {
      const name = document.querySelector(`.card-title${dishID}`).textContent.trim();
      const category = document.querySelector(`.card-category${dishID}`).textContent;
      const tempPrice = document.querySelector(`#price${dishID}`).textContent;
      const tempTotal = document.querySelector(`#total`).textContent;

      const total = parseInt(tempTotal);
      const stringPrice = tempPrice.replace('Php', '');
      const price = parseInt(stringPrice);
      return {
        dishID,
        quantity,
        name,
        category,
        price,
        total
      };
    });
  
    fetch('/addCart', {
      method: 'POST', 
      headers: {
        'Content-Type': 'application/json', 
      },
      body: JSON.stringify(cartItems),
    }).then((response) => response.text()
    ).then((data) => {
      console.log("data: ", data);
      document.querySelector('.container.dishes').innerHTML = data;
      window.location.href = ('/checkout');
    }).catch((err) => {
      console.error(err);
    });
  });
  

});