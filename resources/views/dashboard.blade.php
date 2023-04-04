@php
    // $user = Auth::user();
    // //see user image exists or not
    // if (!Storage::disk('public')->exists($user->image)) {
    //     $gender = isset($user->gender) ? strtolower($user->gender) : 'male' ;
    //     $user_image = $gender === 'male' ? 'https://ui-avatars.com/api/?name='.$user->name.'&color=7F9CF5&background=EBF4FF&size=256&font-size=0.33&bold=true' : 'https://ui-avatars.com/api/?name='.$user->name.'&background=FCE4EC&color=F06292&bold=true&size=256&font-size=0.33';
    // }else{
    //     $user_image = asset('storage/'.$user->image);
    // }
@endphp
@section('title')
@endsection
@extends('dashboard.app')
@section('exclusive_styles')
@endsection
@section('main')
<x-sidebar/>
<div class="right_content">
    <x-navbar />
    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h1>Socket.io</h1>
                            <button id="order" class="btn btn-primary">Order</button>
                            <ul class="orders">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   
</div>
@endsection

@section('exclusive_scripts')
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
@endsection