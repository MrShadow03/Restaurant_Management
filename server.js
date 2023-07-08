const cors = require('cors');
const corsOptions = {
    origin: 'http://192.168.0.120', // Replace '*' with the specific origin URL of your frontend application
    methods: ['GET', 'POST'],
    allowedHeaders: ['Content-Type'],
};

const express = require('express');

const app = express();

const server = require('http').createServer(app);

const io = require('socket.io')(server, {
    cors: {origin: 'http://192.168.0.120'}
});

io.on('connection', (socket) => {
    console.log('a user connected');

    socket.on('sendOrderToKitchen', (msg) => {
        socket.broadcast.emit('orderFromStuff', msg);
    });

    socket.on('updateTableStatus', (msg) => {
        socket.broadcast.emit('updateTableStatusResponse', msg);
    });

    socket.on('responseToStaff', (msg) => {
        socket.broadcast.emit('responseFromKitchen', msg);
    });

    socket.on('paymentDone', (msg) => {
        socket.broadcast.emit('paymentDoneResponse', msg);
    });

    socket.on('tableDeleted', (tableId) => {
        socket.broadcast.emit('tableDeletedEvent', tableId);
    });

    socket.on('disconnect', (socket) => {
        console.log('user disconnected');
    });
});


server.listen(6001, '0.0.0.0', () => {
    console.log('listening on http://0.0.0.0:6001');
});
