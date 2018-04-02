@extends('layouts.master')

@section('title', trans('product_edit.page_title'))

@section('styles')
        
@stop
      
@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('product_edit.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <form id="form-edit-product" action="{{ URL::to('product/save') }}" method="post">     
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">{{ trans('product_edit.name') }}</label>
                                <div class="fg-line">
                                    <input type="hidden" id="record_id" name="record_id" class="form-control" value="{{$record_id}}"></input>
                                    <input type="text" id="name" name="name" class="form-control" value="{{$name}}"></input>
                                </div>
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">{{ trans('product_edit.unit_cost') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="unit_cost" name="unit_cost" class="form-control" value="{{$unit_cost}}"></input>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">{{ trans('product_edit.unit') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="unit" name="unit" class="form-control" value="{{$unit}}"></input>
                                </div>
                            </div>
                        </div>
                    </div>   
                    
                    <button type="submit" class="btn btn-primary btn-sm m-t-10">{{ trans('app.btn_save_text') }}</button>
                </form>       
            </div>
        </div>
    </div>

@stop

@section('scripts')

    {{ ViewUtil::renderJsLanguage('product_edit') }}

    <script src="{{ URL::asset('public/vendors/jquery-validate/jquery.validate.min.js') }}"></script> 

    @if(Session::has('error_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get('error_message') }}', 'dander');
        </script>
    @endif
    
@stop