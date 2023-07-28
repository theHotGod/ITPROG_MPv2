const express = require('express');
const app = express();
const port = 3000;
const exphbs = require('express-handlebars');
var mysql = require('mysql');

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
app.engine('hbs', exphbs.engine({
    extname: 'hbs'
}));


app.get('/', (req, res) => {
    const getDish = "SELECT * FROM dish WHERE dishCategory='Mains'";
    con.query(getDish, (err, result) => {
      if (err)
        throw err;
      console.log(result);
      res.render('home', {
        dish: result
      });
    });
    
});

app.get('/side', (req, res) => {
    const getDish = "SELECT * FROM dish WHERE dishCategory='Sides'";
    con.query(getDish, (err, result) => {
        if(err) 
          throw err;
        
        res.render('home', {
          dish: result
        });
    });
});

app.get('/drink', (req, res) => {
    const getDish = "SELECT * FROM dish WHERE dishCategory='Drinks'";
    con.query(getDish, (err, result) => {
        if (err)
          throw err;
        
        res.render('home', {
          dish: result
        })
    });
});


app.get('/checkout', (req, res) => {
    res.render('checkout');
});

app.get('/main', (req, res) => {
    res.redirect('/');
});

app.get('/login', (req, res) => {
    res.render('login');
});

app.listen(port, () => {
    console.log('running');
});
