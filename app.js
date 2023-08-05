const express = require('express');
const app = express();
const port = 3000;
const exphbs = require('express-handlebars');
var mysql = require('mysql');
const bodyParser = require('body-parser');
const session = require('express-session');
const path = require('path');

var con = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "p@ssword",
  database: "dbclient_side",
  port: 3306
});

con.connect(function (err) {
  if (err) throw err;
  console.log("Connected!");
});


app.use(bodyParser.urlencoded({ extended: true }));

app.use(express.static('public'));
app.set('view engine', 'hbs');
app.use(bodyParser.json());
app.engine('hbs', exphbs.engine({
  extname: 'hbs'
}));

app.use(session({
  secret: 'hello-world',
  resave: false,
  saveUninitialized: true
}))


app.get('/', (req, res) => {
  const getDishMain = `SELECT * 
                         FROM dish
                         ORDER BY
                         CASE 
                            WHEN dishCategory = 'Mains' THEN 1
                            WHEN dishCategory = 'Sides' THEN 2
                            WHEN dishCategory = 'Drinks' THEN 3
                            ELSE 4
                        END ASC`;
  con.query(getDishMain, (err, result) => {
    if (err)
      throw err;
    //console.log(result);
    res.render('home', {
      dish: result
    });
  });

});

app.post('/addCart', (req, res) => {
  const cartItems = req.body;

  // store results
  const results = [];

  req.session.cartItems = cartItems;
  console.log('cart: ', cartItems);

  console.log(req.body.price);


  // const fetchDish = (dishID, dishQty) => {
  //   return new Promise((resolve, reject) => {
  //     const query = `SELECT * FROM dish WHERE dishID = ?`;
  //     con.query(query, [dishID], (err, rows) => {
  //       if (err) {
  //         reject(err);
  //       } else {
  //         if (rows.length > 0) {
  //           const dishData = { ...rows[0], quantity: dishQty };
  //           resolve(dishData);
  //         } else {
  //           reject(new Error('No dish'));
  //         }
  //       }
  //     });
  //   });
  // };

  // (async () => {
  //   try {
  //     for (const cartItem of cartItems) {
  //       const dishID = cartItem.dishID;
  //       const dishQty = cartItem.quantity;
  //       const dishData = await fetchDish(dishID, dishQty);
  //       results.push(dishData);
  //     }
  //     // Send the results back to the frontend
  //     res.render('checkout', {
  //       cart: results
  //     })
  //   } catch (err) {
  //     console.error(err);
  //     res.status(500).json({ error: 'Something went wrong' });
  //   }
  // })(); // <-- Call the IIFE here 


  res.redirect('/checkout')
});

app.get('/checkout', (req, res) => {
  const cartItems = req.session.cartItems || [];

  console.log('get checkout: ', cartItems);

  const mainDishName = cartItems.find(item => item.category === 'Mains')?.name;
  const sideDishName = cartItems.find(item => item.category === 'Sides')?.name;
  const drinkDishName = cartItems.find(item => item.category === 'Drinks')?.name;

  // console.log('mainDishName: ', mainDishName);
  // console.log('sideDishName: ', sideDishName);
  // console.log('drinkDishName: ', drinkDishName);

  discountCheck(mainDishName, sideDishName, drinkDishName, (error, result) => {
    if (error) {
      console.error(error);
    } else {
      const comboName = result.comboName;
      const discount = result.discount;

      // console.log('comboName: ', comboName);
      // console.log('discount: ', discount);

      const formattedDiscount = discount ? (discount * 100).toFixed(2) + '%' : null;
      const totalPrice = cartItems.reduce((acc, item) => acc + item.price * item.quantity, 0);
      const totalPriceAfterDiscount = discount ? (totalPrice * (1 - discount)).toFixed(2) : totalPrice;

      console.log('formattedDiscount: ', formattedDiscount);
      console.log('totalPrice: ', totalPrice);
      console.log('totalPriceAfterDiscount: ', totalPriceAfterDiscount);



      req.session.totalPrice = totalPrice;
      req.session.totalPriceAfterDiscount = discount ? totalPriceAfterDiscount : null;


      res.render('checkout', {
        cart: cartItems,
        comboName: discount ? comboName : null,
        discount: formattedDiscount,
        totalPrice: totalPrice.toFixed(2),
        totalPriceAfterDiscount: discount ? totalPriceAfterDiscount : null,
      });
    }
  });
});

app.post('/cancel', (req, res) => {
  req.session.destroy((err) => {
    if (err) {
      console.error(err);
      res.status(500).send('Failed to cancel the order');
    } else {
      console.log('Order canceled successfully');
      res.sendStatus(200);
    }
  });
});

app.post('/submitOrder', (req, res) => {
  const cartItems = req.session.cartItems || [];

  const custName = req.body.customerName;
  const payment = req.body.payment;

  const totalPriceAfterDiscount = req.session.totalPriceAfterDiscount;

  // Check if totalPriceAfterDiscount is present in the session
  // If not, calculate the total price as done in the /checkout route
  let totalPrice;
  if (totalPriceAfterDiscount) {
    // If there is a discount, we already have totalPriceAfterDiscount in the session
    // So, no need to recalculate it
    // delete req.session.totalPriceAfterDiscount;
    totalPrice = req.session.totalPrice;
  } else {
    // If there is no discount, retrieve the totalPrice from the session
    totalPrice = req.session.totalPrice;
    // delete req.session.totalPrice; // Remove totalPrice from the session
  }

  let totalDiscount = totalPriceAfterDiscount ? totalPrice - totalPriceAfterDiscount : 0;



  console.log("totalPriceAfterDiscount: ", totalPriceAfterDiscount);
  console.log("totalPrice: ", totalPrice);
  console.log("custName: ", custName);
  console.log("totalDiscount: ", totalDiscount);

  const priceToInsert = totalPriceAfterDiscount || totalPrice;

  // Insert order into the 'orders' table
  const date = new Date();
  con.query("INSERT INTO orders (totalPrice, discountedPrice, orderBy, orderedAt) VALUES (?, ?, ?, ?)", [totalPriceAfterDiscount || totalPrice, totalDiscount, custName, date], (err, result) => {
    if (err) throw err;

    // Get the last inserted order ID
    con.query("SELECT MAX(orderID) AS orderID FROM orders", (err, result) => {
      if (err) throw err;
      const orderID = result[0].orderID;

      // Prepare data for inserting into 'order_items' table
      const orderItems = cartItems
        .filter(item => item.quantity > 0)
        .map(item => [orderID, item.name, item.quantity]);

      // Insert order items into 'order_items' table
      const insertOrderItemsQuery = "INSERT INTO order_item (orderID, dishName, quantity) VALUES ?";
      con.query(insertOrderItemsQuery, [orderItems], (err, result) => {
        if (err) throw err;

        console.log("Order items inserted!");
      });
    });

    console.log("Order data inserted!");

    // Clear the cart after successful order submission
    // req.session.cartItems = [];

    // Redirect to the success page or any other page as desired
    res.redirect('/success');
  });
});

app.get('/success', (req, res) => {
  const cartItems = req.session.cartItems || [];
  const totalPrice = req.session.totalPrice || 0;
  const totalPriceAfterDiscount = req.session.totalPriceAfterDiscount || null;

  const mainDishName = cartItems.find(item => item.category === 'Mains')?.name;
  const sideDishName = cartItems.find(item => item.category === 'Sides')?.name;
  const drinkDishName = cartItems.find(item => item.category === 'Drinks')?.name;

  discountCheck(mainDishName, sideDishName, drinkDishName, (error, result) => {
    if (error) {
      console.error(error);
    } else {
      const comboName = result.comboName;
      const discount = result.discount;

      const formattedDiscount = discount ? (discount * 100) + '%' : null;
      const totalPriceAfterDiscountFormatted = totalPriceAfterDiscount !== null ? totalPriceAfterDiscount : null;

      console.log("SUCCESS");
      console.log('cart: ', cartItems);
      console.log("totalPrice: ", totalPrice);
      console.log("totalPriceAfterDiscount: ", totalPriceAfterDiscount);

      console.log("mainDishName: ", mainDishName);
      console.log("sideDishName: ", sideDishName);
      console.log("drinkDishName: ", drinkDishName);

      console.log("comboName: ", comboName);
      console.log("discount: ", discount);
      console.log("formattedDiscount: ", formattedDiscount);
      console.log("totalPriceAfterDiscountFormatted: ", totalPriceAfterDiscountFormatted);

      res.render('success', {
        cart: cartItems,
        comboName: discount ? comboName : null,
        discount: formattedDiscount,
        totalPrice: totalPrice.toFixed(2),
        totalPriceAfterDiscount: totalPriceAfterDiscountFormatted,
      });
    }
  });
});


function discountCheck(mainDish, sideDish, drink, callback) {
  const cart = [mainDish, sideDish, drink];

  const comboQuery = "SELECT * FROM combo_content INNER JOIN food_combo ON combo_content.comboID=food_combo.comboID";
  con.query(comboQuery, (error, comboResults) => {
    if (error) throw error;

    let comboObj = {
      comboName: null,
      discount: 0.00,
    };

    for (const comboResult of comboResults) {
      let isComboMatch = true;

      const comboItems = comboResults
        .filter((result) => result.comboID === comboResult.comboID)
        .map((result) => result.foodName);

      // console.log('comboItems: ', comboItems);

      for (const comboItem of comboItems) {
        if (!cart.includes(comboItem)) {
          isComboMatch = false;
          break;
        }
      }

      if (isComboMatch) {
        comboObj.comboName = comboResult.comboName;
        comboObj.discount = comboResult.discount;
        break; // Exit the loop once a valid combo is found
      }
    }

    callback(null, comboObj);
  });
}



app.get('/main', (req, res) => {
  res.redirect('/');
});

const viewsFolderPath = path.join(__dirname, 'views');

app.get('/login', (req, res) => {
  const loginFilePath = path.join(viewsFolderPath, 'login.php');
  res.set('Content-Type', 'text/html');
  res.sendFile(loginFilePath);
});

app.listen(port, () => {
  console.log('running');
});

module.exports = con;