<!-- EChart.Simple.js -->
@if( env('APP_DEBUG', false) )
<script src="{{ asset('/') }}vendor/echarts/echarts.simple.js"></script>
@else
<script src="{{ asset('/') }}vendor/echarts/echarts.simple.min.js"></script>
@endif