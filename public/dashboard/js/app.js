let ip_address = 'localhost';
let socket_port = '6001';
let socket = io(ip_address + ':' + socket_port);

socket.on('connect', function(){
    console.log('Connected to server');
});