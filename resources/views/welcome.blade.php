<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restaurant</title>
</head>
<body>
    <h1>Restaurant</h1>
    <button class="order" id="order">Order Now</button>
    <ul class="orders">
    </ul>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js" integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $(function(){
            $('#order').click(function(){
                socket.emit('sendOrderToKitchen', {
                    table: 1,
                    item: 'Sandwitch',
                    qty: 1
                });
            });
            socket.on('orderResponseFromKitchen', function(data){
                console.log(data);
                $('.orders').append('<li>' + data.item + ' - ' + data.qty + '</li>');
            });

        });

    </script>
</body>
</html>