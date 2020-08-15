<!-- EChart.js -->
@if( env('APP_DEBUG', false) )
<script src="{{ asset('/') }}vendor/echarts/echarts.js"></script>
@else
<script src="{{ asset('/') }}vendor/echarts/echarts.min.js"></script>
@endif