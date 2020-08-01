@extends( 'layouts.base' )

@section( 'content' )

<!-- Forms Section-->
<section class="forms"> 
<div class="container-fluid">
    <div class="row">
    <!-- Form Elements -->
    <div class="col-lg-12">
        <div class="card">
        <div class="card-close">
            <div class="dropdown">
            <button type="button" id="closeCard5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
            <div aria-labelledby="closeCard5" class="dropdown-menu dropdown-menu-right has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#" class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
            </div>
        </div>
        <div class="card-header d-flex align-items-center">
            <h3 class="h4">详情</h3>
        </div>
        <div class="card-body">
            <form class="form-horizontal">
            <div class="form-group row">
                <label class="col-sm-3 form-control-label">ID</label>
                <div class="col-sm-9">
                <input type="text" disabled="" placeholder="" class="form-control" value="{{ $app_data->id }}">
                </div>
            </div>
            <div class="line"></div>
            <div class="form-group row">
                <label class="col-sm-3 form-control-label">名称</label>
                <div class="col-sm-9">
                <input type="text" disabled="" placeholder="" class="form-control" value="{{ $app_data->name }}">
                </div>
            </div>
            <div class="line"></div>
            <div class="form-group row">
                <label class="col-sm-3 form-control-label">简介</label>
                <div class="col-sm-9">
                <input type="text" disabled="" placeholder="" class="form-control" value="{{ $app_data->desc }}">
                </div>
            </div>
            <div class="line"></div>
            <div class="form-group row">
                <label class="col-sm-3 form-control-label">下载地址</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" value="{{ $app_data->download_url }}"><small class="help-block-none"></small>
                </div>
            </div>
            <div class="line"></div>
            <div class="form-group row">
                <label class="col-sm-3 form-control-label">点击监测连接</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" value="{{ $app_click_link }}"><small class="help-block-none"></small>
                </div>
            </div>
            <div class="line"></div>
            <div class="form-group row">
                <label class="col-sm-3 form-control-label">展示监测连接</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" value="{{ $app_show_link }}"><small class="help-block-none"></small>
                </div>
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>
</div>
</section>

@endsection