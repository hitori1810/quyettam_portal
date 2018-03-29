@extends('layouts.master')

@section('title', trans('user_profile.page_title'))

@section('styles')
        
@stop

@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('user_profile.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <form id="form-profile" action="{{ URL::to('user/saveProfile') }}" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('user_profile.customer_id') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="customer_id" name="customer_id" class="form-control" placeholder="{{ trans('user_profile.customer_id') }}" value="{{ $user->user_name }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                
                                <div class="fg-line">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('user_profile.last_name') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="{{ trans('user_profile.last_name') }}" value="{{ $user->last_name }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('user_profile.first_name') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="first_name" name="first_name"  class="form-control" placeholder="{{ trans('user_profile.first_name') }}" value="{{ $user->first_name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                
                                <div class="fg-line">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('user_profile.mobile_phone') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="mobile_phone" name="mobile_phone"  class="form-control" placeholder="{{ trans('user_profile.mobile_phone') }}" value="{{ $user->phone_mobile }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('user_profile.email') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="email" name="email" class="form-control" placeholder="{{ trans('user_profile.email') }}" value="{{ $user->email1 }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('user_profile.address') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="address" name="address"  class="form-control" placeholder="{{ trans('user_profile.address') }}" value="{{ $user->address_street }}">
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">{{ trans('user_profile.description') }}</label>
                                <div class="fg-line">
                                    <textarea type="text" id="description" name="description" rows="5" class="form-control" placeholder="{{ trans('user_profile.description') }}">{{ $user->description }}</textarea>    
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

    {{ ViewUtil::renderJsLanguage('user_profile') }}
    
    <script src="{{ URL::asset('public/vendors/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset('public/js/user_profile.js') }}"></script>

    @if(Session::has('flash_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get('flash_message') }}', 'success');
        </script>
    @endif
         
@stop