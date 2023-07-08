let ip_address = '192.168.0.120';
let socket_port = '6001';
let socket = io(ip_address + ':' + socket_port);

socket.on('connect', function(){
    console.log('Connected to server');
});