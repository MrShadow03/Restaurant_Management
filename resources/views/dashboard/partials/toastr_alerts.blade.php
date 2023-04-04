<script>
    toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "100",
    "hideDuration": "100",
    "timeOut": "2500",
    "extendedTimeOut": "2000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };
</script>
  
@if(Session::has('error'))
    <script>
        toastr.error("{{ Session::get('error') }}");
    </script>
@endif
@if(Session::has('success'))
    <script>
        toastr.success("{{ Session::get('success') }}");
    </script>
@endif
@if(Session::has('info'))
    <script>
        toastr.info("{{ Session::get('info') }}");
    </script>
@endif
@if(Session::has('warning'))
    <script>
        toastr.warning("{{ Session::get('warning') }}");
    </script>
@endif
