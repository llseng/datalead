<div id="content_alert" class="container-fluid">
    @if( $errors->has('deal_error') )
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        {{ $errors->first('deal_error') }}
    </div>
    @endif

</div>
<script src="{{ asset('/') }}js/include/content_alert.js"></script>