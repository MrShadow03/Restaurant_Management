const express = require('express');

const app = express();

const server = require('http').createServer(app);

const io = require('socket.io')(server, {
    cors: {origin: '*'}
});

io.on('connection', (socket) => {
    console.log('a user connected');

    socket.on('sendOrderToKitchen', (msg) => {
        console.log('message: ' + msg);

        // io.emit('orderResponseFromKitchen', msg);
        //broadcast to all except the sender
        socket.broadcast.emit('orderResponseFromKitchen', msg);
    });

    socket.on('disconnect', (socket) => {
        console.log('user disconnected');
    });
});

server.listen(6001, () => {
    console.log('listening on *:6001');
});
