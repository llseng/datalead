<!-- EChart.Common.js -->
@if( env('APP_DEBUG', false) )
<script src="{{ asset('/') }}vendor/echarts/echarts.common.js"></script>
@else
<script src="{{ asset('/') }}vendor/echarts/echarts.common.min.js"></script>
@endif