// const http = require('http');

const hostname = '127.0.0.1';
const port = 3000;

const server = http.createServer((req, res) => {
    res.statusCode = 200;
    res.setHeader('Content-Type', 'text/plain');
    res.end('Hello World');
});

server.listen(port, hostname, () => {
    console.log(`Server running at http://${hostname}:${port}/`);
});

// var cluster = require('cluster');
// var http = require('http');
// var numThreads = 1;
//
// if (cluster.isMaster) {
//     for (var i = 0; i < numThreads; i++) {
//         cluster.fork();
//     }
// } else {
//     http.createServer(function(req, res) {
//         res.statusCode = 200;
//         res.setHeader('Content-Type', 'text/plain');
//         res.end('Hello World');
//     }).listen(port, hostname, () => {
//         console.log(`Server running at http://${hostname}:${port}/`);
//     });
// }