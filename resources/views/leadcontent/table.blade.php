@extends('layouts.base')

@section('other_source')
<!-- other_source -->
    @include('leadinc.bootstrap_datepicker_js')

    @php
        $source_suffix = "";
        if( env("APP_DEBUG", false) ) {
            $source_suffix = time();
        }
    @endphp

    @foreach( $LCtable->getSources() as $source )
                                
    @switch( $source["type"] )

        @case( "js" )
            <script src="{{ $source['path'] }}?{{ $source_suffix }}"></script>
            @break

        @case( "css" )
            <link rel="stylesheet" href="{{ $source['path'] }}?{{ $source_suffix }}">
            @break

        @default

    @endswitch

    @endforeach
    
@endsection

@section('content')
<!-- content -->
@if( $LCtable->getFormBlock() ) 
<section class="forms no-padding-bottom"> 
<div class="container-fluid">
    <div class="row">
        <!-- Inline Form-->
        <div class="col-lg-12">                           
            <div class="card">
            <div class="card-header d-flex align-items-center">
                <h3 class="h4">搜索条件</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ url()->current() }}" class="form-inline">

                    @foreach( $LCtable->getRows() as $LCtable_row )
                    <div class="form-group mr-3">

                        @php
                            $LCtable_row_attr = $LCtable_row->getDefAttr();
                            $old_data = old( $LCtable_row->getName() );
                            if( $old_data ) {
                                if( is_array( $old_data ) ) $old_data = join( ',', $old_data );
                                $LCtable_row->setValue( $old_data );
                            }

                        @endphp

                        @switch( $LCtable_row->getRowType() )
                            @case( "input" )
                                <input name="{{ $LCtable_row->getName() }}" value="{{ $LCtable_row->getValue() }}" {!! tagAttrToStr( $LCtable_row_attr ) !!} class="form-control {{ $errors->has( $LCtable_row->getName() ) ? 'is-invalid' : '' }}">
                                @break

                            @case( "select" )

                                @php
                                    $LCtable_row_opt = $LCtable_row->getOptions();
                                @endphp

                                <select name="{{ $LCtable_row->getName() }}{{ $LCtable_row->isMultiple()? '[]': '' }}" {!! tagAttrToStr( $LCtable_row_attr ) !!} class="form-control {{ $errors->has( $LCtable_row->getName() ) ? 'is-invalid' : '' }}">
                                    
                                    <option value="">{{ $LCtable_row->getTitle() }}</option>

                                    @foreach( $LCtable_row_opt as $LCtable_row_optk => $LCtable_row_optv )

                                    @php
                                        $LCtable_row_optv_attr = $LCtable_row_optv['attr'];
                                    @endphp

                                    <option value="{{ $LCtable_row_optk }}" {!! tagAttrToStr( $LCtable_row_optv_attr ) !!}>{{ $LCtable_row_optv['value'] }}</option>

                                    @endforeach
                                </select>
                                @break

                            @default

                        @endswitch
                    </div>
                    @endforeach
                    
                    <div class="form-group mr-3 ">
                        <button type="submit" class="btn btn-success">搜索</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
</section>
@endif

<section class="tables {{ $LCtable->getFormBlock()? 'no-padding-top': '' }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">{{ $LCtable->getTitle() }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @php
                                $LCtable_attr = $LCtable->getDefAttr();
                            @endphp
                            <table id="table" {!! tagAttrToStr( $LCtable_attr ) !!} class="table table-striped table-hover">
                                @php
                                    $LCtable_lines = $LCtable->getLines();
                                    $LCtable_pkey = $LCtable->getPkey();
                                @endphp
                                <thead>
                                    <tr>
                                        @foreach( $LCtable_lines as $LCtable_line )

                                        <th>{{ $LCtable_line->getTitle() }}</th>

                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach( $LCdata as $LCdata_li )

                                    <tr data-pkey="{{ $LCtable_pkey }}" data-pval="{{ isset( $LCdata_li[ $LCtable_pkey ] )? $LCdata_li[ $LCtable_pkey ]: '' }}">
                                        @foreach( $LCtable_lines as $LCtable_line )

                                            @php
                                                $LCtable_line_attr = $LCtable_line->getDefAttr();
                                            @endphp

                                            @switch( $LCtable_line->getLineType() )

                                                @case( 'info' )
                                                    <td {!! tagAttrToStr( $LCtable_line_attr ) !!}>{{ $LCtable_line->handle( $LCdata_li ) }}</td>
                                                    @break

                                                @case( 'btns' )
                                                    <td {!! tagAttrToStr( $LCtable_line_attr ) !!}>
                                                    @foreach( $LCtable_line->getBtns() as $LCtable_line_btn )
                                                        <button data-btn="{{ $LCtable_line_btn['name'] }}" type="button" class="btn {{ $LCtable_line_btn['type'] }}">{{ $LCtable_line_btn['info'] }}</button>
                                                    @endforeach
                                                    </td>
                                                    @break
                                                
                                                @default

                                            @endswitch

                                        @endforeach
                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                    {{ $LCpages }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection