'use strict';

const express = require('express');

// Constants
const PORT = 8080;
const HOST = '0.0.0.0';

// App
const app = express();

app.use(express.static('public'));

app.get('/', (req, res) => {
    res.sendFile('/views/index.html', { root: __dirname });
});

app.listen(PORT, HOST);
console.log(`Running on http://${HOST}:${PORT}`);
