var fs = require('fs');
var mysql = require('mysql2');

console.time('Node.js ' + process.version + ': склеивание строк 1000000 раз');
var str = '';
for (var i = 0; i < 1000000; i++) {
    str += 's';
}
console.timeEnd('Node.js ' + process.version + ': склеивание строк 1000000 раз');


console.time('Node.js ' + process.version + ': сложение чисел 1000000 раз');
var count = 0;
for (var i = 0; i < 1000000; i++) {
    count++;
}
console.timeEnd('Node.js ' + process.version + ': сложение чисел 1000000 раз');


console.time('Node.js ' + process.version + ': наполнение простого массива 1000000 раз');
var array = [];
for (var i = 0; i < 1000000; i++) {
    array.push('s');
}
console.timeEnd('Node.js ' + process.version + ': наполнение простого массива 1000000 раз');


console.time('Node.js ' + process.version + ': наполнение ассоциативного массива 1000000 раз');
var array = {};
for (var i = 0; i < 1000000; i++) {
    array['s' + i] = 's';
}
console.timeEnd('Node.js ' + process.version + ': наполнение ассоциативного массива 1000000 раз');


console.time('Node.js ' + process.version + ': чтение файла 100 раз');
var content;
for (var i = 0; i < 100; i++) {
    content = fs.readFileSync('./someFile.txt');
}
console.timeEnd('Node.js ' + process.version + ': чтение файла 100 раз');


console.time('Node.js ' + process.version + ': mysql query (SELECT NOW()) 100 раз');
// create the connection to database
var connection = mysql.createConnection({host:'localhost', user: 'root', database: 'mif_ru', password: 'password'});

function promiseQuery(query) {
    return new Promise((resolve, reject) => {
        connection.query(query, function (err, results, fields) {
            resolve({err, results, fields});
        });
    });
}
var c = 0;
for (var i = 0; i < 100; i++) {
    var a = promiseQuery('SELECT NOW()');
    a.then(({err, results, fields}) => {
        c++;
        if (c === 100) {
            console.timeEnd('Node.js ' + process.version + ': mysql query (SELECT NOW()) 100 раз');
            connection.end();
        }

    });
}


