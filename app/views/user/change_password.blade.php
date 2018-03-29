@extends('layouts.master')

@section('title', trans('user_change_password.page_title'))

@section('styles')
        
@stop

@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('user_change_password.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <form id="form-change-password" action="{{ URL::to('user/savePassword') }}" method="post">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">{{ trans('user_change_password.current_password') }}</label>
                                <div class="fg-line">
                                    <input type="password" id="current_password" name="current_password" class="form-control" placeholder="{{ trans('user_change_password.current_password') }}" value="{{ $current_password }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">{{ trans('user_change_password.new_password') }}</label>
                                <div class="fg-line">
                                    <input type="password" id="new_password" name="new_password" class="form-control" placeholder="{{ trans('user_change_password.new_password') }}" value="{{ $new_password }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">{{ trans('user_change_password.confirm_password') }}</label>
                                <div class="fg-line">
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="{{ trans('user_change_password.confirm_password') }}" value="{{ $confirm_password }}">
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

    {{ ViewUtil::renderJsLanguage('user_change_password') }}

    <script src="{{ URL::asset('public/vendors/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset('public/js/user_change_password.js') }}"></script>
    
    @if(Session::has('error_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get('error_message') }}', 'danger');
        </script>
    @endif
    
    @if(Session::has('success_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get('success_message') }}', 'success');
        </script>
    @endif
         
@stop