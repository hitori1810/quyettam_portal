@extends('layouts.master')

@section('title', trans('complaint_add.page_title'))

@section('styles')
        
@stop

@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('complaint_add.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <form id="form-add-complaint" action="{{ URL::to('complaint/save') }}" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('complaint_add.customer_id') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="customer_id" name="customer_id" class="form-control" placeholder="{{ trans('complaint_add.customer_id') }}" value="{{ $user->user_name }} ({{ $user->email1 }})" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('complaint_add.company') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="company" name="company" class="form-control" placeholder="{{ trans('complaint_add.company') }}" value="{{ $contact->account_name }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">{{ trans('complaint_add.customer_id') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="subject" name="subject" class="form-control" placeholder="{{ trans('complaint_add.subject') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">{{ trans('complaint_add.content') }}</label>
                                <div class="fg-line">
                                    <textarea type="text" id="contents" name="contents" rows="5" class="form-control" placeholder="{{ trans('complaint_add.content') }}"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-sm m-t-10">{{ trans('app.btn_send_text') }}</button>
                </form>       
            </div>
        </div>
    </div>

@stop

@section('scripts')

    {{ ViewUtil::renderJsLanguage('complaint_add') }}

    <script src="{{ URL::asset('public/vendors/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset('public/js/complaint_add.js') }}"></script>

    @if(Session::has('error_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get('error_message') }}', 'dander');
        </script>
    @endif
    
@stop