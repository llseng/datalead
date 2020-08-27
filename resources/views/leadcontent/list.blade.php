@extends('layouts.base')

@section('other_source')
<!-- other_source -->
    @include('leadinc.bootstrap_datepicker_js')
    @if( env("APP_DEBUG", false) )
    @else
    @endif
    
@endsection

@section('content')
<!-- content -->
<section class="forms no-padding-bottom"> 
<div class="container-fluid">
    <div class="row">
        <!-- Inline Form-->
        <div class="col-lg-12">                           
            <div class="card">
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">时间范围</h3>
            </div>
            <div class="card-body">
                <form class="form-inline">
                    <div class="form-group mr-3">
                        <input type="text" placeholder="输入" class="form-control">
                    </div>
                    <div class="form-group mr-3 ">
                        <input type="text" placeholder="日期" class="form-control">
                    </div>
                    <div class="form-group mr-3 ">
                        <div class="input-group input-daterange">
                            <input type="text" placeholder="开始日期" class="form-control">
                            <input type="text" placeholder="结束日期" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mr-3">
                        <select class="form-control">
                            <option>选项</option>
                            <option>option 1</option>
                            <option>option 2</option>
                            <option>option 3</option>
                            <option>option 4</option>
                        </select>
                    </div>
                    <div class="form-group mr-3 ">
                        <button type="button" class="btn btn-success">刷新</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
</section>

<section class="tables no-padding-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Striped table with hover effect</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Username</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>@fat</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Larry</td>
                                        <td>the Bird</td>
                                        <td>@twitter</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection