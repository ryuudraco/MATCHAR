var mysql = require('mysql');

var conn = mysql.createConnection({
    host     :  'localhost',
    port     :   8082,
    user     :   'root',
    password :   'root16',
    database :   'matcha'
})

conn.connect()
module.exports = conn