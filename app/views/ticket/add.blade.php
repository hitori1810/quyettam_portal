@extends('layouts.master')

@section('title', trans('ticket_add.page_title'))

@section('styles')
        
@stop

@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('ticket_add.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <form id="form-add-ticket" action="{{ URL::to('ticket/save') }}" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('ticket_add.customer_id') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="customer_id" name="customer_id" class="form-control" placeholder="{{ trans('ticket_add.customer_id') }}" value="{{ $user->user_name }} ({{ $user->email1 }})" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('ticket_add.company') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="company" name="company" class="form-control" placeholder="{{ trans('ticket_add.company') }}" value="{{ $contact->account_name }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">{{ trans('ticket_add.subject') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="subject" name="subject" class="form-control" placeholder="{{ trans('ticket_add.subject') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">{{ trans('ticket_add.priority') }}</label>
                                <div class="fg-line">
                                    <select id="priority" name="priority" class="form-control">
                                        @foreach($priorities as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach;
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">{{ trans('ticket_add.content') }}</label>
                                <div class="fg-line">
                                    <textarea type="text" id="contents" name="contents" rows="5" class="form-control" placeholder="{{ trans('ticket_add.content') }}"></textarea>
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

    {{ ViewUtil::renderJsLanguage('ticket_add') }}

    <script src="{{ URL::asset('public/vendors/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset('public/js/ticket_add.js') }}"></script>

    @if(Session::has('flash_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get('flash_message') }}', 'success');
        </script>
    @endif
    
@stop