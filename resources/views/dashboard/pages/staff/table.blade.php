@php
    function addLeadingZero($number){
        return $number < 10 ? '0'.$number : $number;
    }
    //get the max table number
    $max_table_number = $tables->max('table_number')+1;
@endphp
@section('title')
<title>Admin-Teacher</title>
@endsection
@extends('dashboard.app')
@section('main')
    <x-sidebar/>
    <div class="right_content">
        <x-navbar />
        <div class="heading">
            <h2 class="heading__title text-title">Table Management</h2>
        </div>
        <div>
            <div class="order_table_wrapper">
                @foreach ($tables as $table)
                <div class="order_table">
                    <div class="order_table_title">{{ addLeadingZero($table->table_number) }}</div>
                    <div class="order_table_top">
                        <div class="order_table_top_left">
                            <div class="status_indicator">
                                <i class="text-yellow fa-solid fa-circle-small"></i>
                                <span>Free</span>
                            </div>
                        </div>
                        <div class="order_table_top_right">
                        </div>
                    </div>
                    <div class="order_middle">
                        <a class="btn-sm btn-primary">Take Order</a>
                    </div>
                    <div class="order_table_bottom">
                        <div class="oreder_table_bottom_left">
                        </div>
                        <div class="oreder_table_bottom_right">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('exclusive_scripts')
<script>
    
</script>
@endsection

