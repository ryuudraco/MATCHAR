var mysql = require('mysql')

var conn = mysql.createConnection ({
    host     :  'localhost',
    port     :   8082,
    user     :   'root',
    password :   'root16',
})

conn.connect();

onnection.query('CREATE DATABASE IF NOT EXISTS matcha')
console.log('Database matcha created')
connection.query('USE matcha')
connection.query('CREATE TABLE IF NOT EXISTS users (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, username VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, gender VARCHAR(25), sexuality VARCHAR(25), biography VARCHAR(10000), interests VARCHAR(255), age INT, images VARCHAR(255), city VARCHAR(255)')
console.log('Table users created')
connection.query('CREATE TABLE IF NOT EXISTS likes (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, username VARCHAR(100) NOT NULL, liked VARCHAR(100) NOT NULL)')
console.log('Table likes created')
connection.query('CREATE TABLE IF NOT EXISTS visits (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, username VARCHAR(100) NOT NULL, visited VARCHAR(100) NOT NULL)')
console.log('Table visits created')
connection.query('CREATE TABLE IF NOT EXISTS messages (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, username VARCHAR(100) NOT NULL, sender VARCHAR(100) NOT NULL, message VARCHAR(10000))')
console.log('Table messages created')
connection.end()