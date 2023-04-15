const express = require('express');

const app = express();

const server = require('http').createServer(app);

const io = require('socket.io')(server, {
    cors: {origin: '*'}
});

io.on('connection', (socket) => {
    console.log('a user connected');

    socket.on('sendOrderToKitchen', (msg) => {
        socket.broadcast.emit('orderResponseFromKitchen', msg);
    });

    socket.on('updateTableStatus', (msg) => {
        socket.broadcast.emit('updateTableStatusResponse', msg);
    })

    socket.on('disconnect', (socket) => {
        console.log('user disconnected');
    });
});


server.listen(6001, () => {
    console.log('listening on *:6001');
});
