var mysql = require("mysql");

//local mysql db connection
var dbConn = mysql.createConnection({
  host: "localhost",
  user: "root",//"teamb004",
  password: "",//"ZLuP2kQPvK",
  database: "test",//"teamb004",
});

//online mysql db connection
dbConn.connect(function (err) {
  if (err) throw err;
  console.log("Database Connected!");
});

module.exports = dbConn;
