<!-- Chart.js -->
@if( env('APP_DEBUG', false) )
<script src="{{ asset('/') }}vendor/chart.js/Chart.js"></script>
@else
<script src="{{ asset('/') }}vendor/chart.js/Chart.min.js"></script>
@endif