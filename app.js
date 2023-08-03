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
  port: 3307
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

  res.render('checkout', {
    cart: cartItems
  })
});



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