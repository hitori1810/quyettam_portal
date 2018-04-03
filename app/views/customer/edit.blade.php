@extends('layouts.master')

@section('title', trans('customer_edit.page_title'))

@section('styles')
        
@stop
      
@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('customer_edit.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <form id="form-edit-customer" action="{{ URL::to('customer/save') }}" method="post">     
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('customer_edit.name') }}</label>
                                <div class="fg-line">
                                    <input type="hidden" id="record_id" name="record_id" class="form-control" value="{{$record_id}}"></input>
                                    <input type="text" id="name" name="name" class="form-control" value="{{$name}}"></input>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('customer_edit.department') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="department" name="department" class="form-control" value="{{$department}}"></input>
                                </div>
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('customer_edit.phone_mobile') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="phone_mobile" name="phone_mobile" class="form-control" value="{{$phone_mobile}}"></input>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('customer_edit.description') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="description" name="description" class="form-control" value="{{$description}}"></input>
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

    {{ ViewUtil::renderJsLanguage('customer_edit') }}

    <script src="{{ URL::asset('public/vendors/jquery-validate/jquery.validate.min.js') }}"></script> 

    @if(Session::has('error_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get('error_message') }}', 'dander');
        </script>
    @endif
    
@stop