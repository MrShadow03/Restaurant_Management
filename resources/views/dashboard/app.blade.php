<!DOCTYPE html>
<html lang="en">
<head>
    {{-- meta details are here... --}}
    @include('dashboard.partials.head')
    @section('exclusive_styles')
        {{-- here you can add exclusive styles for this page --}}
    @show
</head>
    <body>
        <div class="main  remodal-bg">
            @section('main')
                {{-- here you can add main content for this page --}}
            @show
        </div>
        {{-- scripts are here...--}}
        @include('dashboard.partials.scripts')
        @include('dashboard.partials.toastr_alerts')
        @section('exclusive_scripts')
            {{-- here you can add exclusive scripts for this page --}}
        @show
    </body>
</html>