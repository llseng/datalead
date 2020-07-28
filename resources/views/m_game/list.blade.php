@extends('layouts.base')

@section('content')
<!-- Forms Section-->
<section class="forms"> 
    <div class="container-fluid">
        <div class="row">
            <!-- Inline Form-->
            <div class="col-lg-12">
                <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <a href="{{ route('game_create') }}"><button type="button" class="btn btn-primary">create</button></a>
                    </div>
                </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Projects Section-->
<section class="projects no-padding-top">{{ dump($errors) }}
    <div class="container-fluid">
        @foreach( $app_list as $app_li )
        <!-- Project-->
        <div class="project">
        <div class="row bg-white has-shadow">
            <div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
            <div class="project-title d-flex align-items-center">
                <div class="image has-shadow"><img src="img/project-1.jpg" alt="..." class="img-fluid"></div>
                <div class="text">
                <h3 class="h4">{{ $app_li->name }}</h3><small>{{ $app_li->desc }}</small>
                </div>
            </div>
            <div class="project-date"><span class="hidden-sm-down">{{ $app_li->created_at }}</span></div>
            </div>
            <div class="right-col col-lg-6 d-flex align-items-center">
                <div class="comments">
                    <input type="text" placeholder="Username" class="mr-3 form-control" value='{{ $app_li->created_at }}'>
                </div>
                <div class="comments">
                <a href="{{ route('game_update') }}"><button type="button" class="btn btn-primary">update</button></a>
                </div>
            </div>
        </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
