
<!-- Page Header-->
<header class="page-header">
<div class="container-fluid">
    @if(isset($view_title))
    <h2 class="no-margin-bottom">{{ $view_title }}</h2>
    @else
    <h2 class="no-margin-bottom">{{ config('app.name', 'Laravel') }}</h2>
    @endif
</div>
</header>