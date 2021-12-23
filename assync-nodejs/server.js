const app = require('./app');
const port = 3000;

app.get('/', (req, res) => {
    res.send('Hello World!')
});

app.listen(port, () => {
    console.log(`Example app listening at http://localhost:${port}`)
});

// var cluster = require('cluster');
// var numThreads = 5;
//
// if (cluster.isMaster) {
//     for (var i = 0; i < numThreads; i++) {
//         cluster.fork();
//     }
// } else {
//     app.get('/', (req, res) => {
//         res.send('Hello World!')
//     });
//
//     app.listen(port, () => {
//         console.log(`Example app listening at http://localhost:${port}`)
//     });
// }