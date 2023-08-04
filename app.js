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
  password: "",
  database: "dbclient_side",
  port: 3306
});

con.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
});


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

  res.sendStatus(200);
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

app.listen(port, () => {
    console.log('running');
});

module.exports = con;