@extends('layouts.base')

@section('other_source')
<!-- other_source -->
    @foreach( $LCform->getSources() as $source )
                                
    @switch( $source["type"] )
        @case( "js" )
            <script src="{{ $source['path'] }}"></script>
            @break

        @case( "css" )
            <link rel="stylesheet" href="{{ $source['path'] }}">
            @break

        @default

    @endswitch

    @endforeach
@endsection

@section('content')
<!-- content -->
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">{{ $LCform->getTitle() }}</h3>
                    </div>
                    <div class="card-body">
                        <form method="{{ $LCform->getMethod() }}" action="{{ $LCform->getAction() }}" class="form-horizontal">
                            
                            {{ csrf_field() }}

                            @foreach( $LCform->getHideData() as $hide_k => $hide_v )
                            
                            <input name="{{ $hide_k }}" type="hidden" value="{{ $hide_v }}">

                            @endforeach

                            @foreach( $LCform->getRows() as $LCform_row )

                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">{{ $LCform_row->getTitle() }}
                                    <br><small class="text-primary">{{ $LCform_row->getPrompt() }}</small>
                                </label>
                                <div class="col-sm-9">
                                    @php
                                        $LCform_row_attr = $LCform_row->getDefAttr();
                                        $old_data = old( $LCform_row->getName() );
                                        if( $old_data ) {
                                            if( is_array( $old_data ) ) $old_data = join( ',', $old_data );
                                            $LCform_row->setValue( $old_data );
                                        }
                                        
                                    @endphp

                                    @switch( $LCform_row->getRowType() )
                                        @case( "input" )
                                            <input name="{{ $LCform_row->getName() }}" value="{{ $LCform_row->getValue() }}" {!! tagAttrToStr( $LCform_row_attr ) !!} class="form-control {{ $errors->has( $LCform_row->getName() ) ? 'is-invalid' : '' }}">
                                            @break

                                        @case( "textarea" )
                                            <textarea name="{{ $LCform_row->getName() }}" {!! tagAttrToStr( $LCform_row_attr ) !!} class="form-control {{ $errors->has( $LCform_row->getName() ) ? 'is-invalid' : '' }}">{{ $LCform_row->getValue() }}</textarea>
                                            @break
                                            
                                        @case( "checkbox" )

                                            @php
                                                $LCform_row_opt = $LCform_row->getOptions();
                                            @endphp

                                            @foreach( $LCform_row_opt as $LCform_row_optk => $LCform_row_optv )

                                            @php
                                                $LCform_row_optv_attr = $LCform_row_optv['attr'];
                                            @endphp

                                            <div>
                                                <input name="{{ $LCform_row->getName() }}[]" value="{{ $LCform_row_optk }}" id="{{ $LCform_row->getName() }}_option_{{ $LCform_row_optk }}" {!! tagAttrToStr( $LCform_row_attr ) !!} {!! tagAttrToStr( $LCform_row_optv_attr ) !!} >
                                                <label for="{{ $LCform_row->getName() }}_option_{{ $LCform_row_optk }}">{{ $LCform_row_optv['value'] }}</label>
                                            </div>
                                            @endforeach

                                            @break

                                        @case( "radio" )

                                            @php
                                                $LCform_row_opt = $LCform_row->getOptions();
                                            @endphp

                                            @foreach( $LCform_row_opt as $LCform_row_optk => $LCform_row_optv )

                                            @php
                                                $LCform_row_optv_attr = $LCform_row_optv['attr'];
                                            @endphp

                                            <div>
                                                <input name="{{ $LCform_row->getName() }}" value="{{ $LCform_row_optk }}" id="{{ $LCform_row->getName() }}_option_{{ $LCform_row_optk }}" {!! tagAttrToStr( $LCform_row_attr ) !!} {!! tagAttrToStr( $LCform_row_optv_attr ) !!}>
                                                <label for="{{ $LCform_row->getName() }}_option_{{ $LCform_row_optk }}">{{ $LCform_row_optv['value'] }}</label>
                                            </div>
                                            @endforeach

                                            @break
                                            
                                        @case( "select" )

                                            @php
                                                $LCform_row_opt = $LCform_row->getOptions();
                                            @endphp

                                            <select name="{{ $LCform_row->getName() }}{{ $LCform_row->isMultiple()? '[]': '' }}" {!! tagAttrToStr( $LCform_row_attr ) !!} class="form-control {{ $errors->has( $LCform_row->getName() ) ? 'is-invalid' : '' }}">
                                                
                                                @foreach( $LCform_row_opt as $LCform_row_optk => $LCform_row_optv )

                                                @php
                                                    $LCform_row_optv_attr = $LCform_row_optv['attr'];
                                                @endphp

                                                <option value="{{ $LCform_row_optk }}" {!! tagAttrToStr( $LCform_row_optv_attr ) !!}>{{ $LCform_row_optv['value'] }}</option>

                                                @endforeach
                                            </select>
                                            @break

                                        @default

                                    @endswitch

                                    <small class="help-block-none">{{ $LCform_row->getIntro() }}</small>
                                    <small class="help-block-none text-danger">{{ $LCform_row->getErrIntro() }}</small>
                                    
                                    @if( $errors->has( $LCform_row->getName() ) )
                                    <small class="help-block-none text-danger">{{ $errors->first( $LCform_row->getName() ) }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="line"></div>

                            @endforeach
                            
                            @if( $LCform->getSubmitBtn() )
                            <div class="form-group row">
                                <div class="col-sm-4 offset-sm-3">
                                    <button type="submit" class="btn btn-primary">{{ $LCform->getSubmitBtnName() }}</button>
                                </div>
                            </div>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection