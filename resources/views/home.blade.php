@extends('layouts.base')

@section('content')
<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">{{ config('app.name', 'Laravel') }}</h2>
    </div>
    </header>
    
    <!-- Page Footer-->
    <footer class="main-footer">
        <div class="container-fluid">
            <div class="row">
            <div class="col-sm-6">
                <p>Copyright &copy; 2019.Company name All rights reserved.</p>
            </div>
            <div class="col-sm-6 text-right">
                <p></p>
                <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
            </div>
            </div>
        </div>
    </footer>
</div>
@endsection
