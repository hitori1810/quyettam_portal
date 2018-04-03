@extends('layouts.master')

@section('title', trans('feedback_add.page_title'))

@section('styles')
        
@stop
      
@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('feedback_add.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <form id="form-add-feedback" action="{{ URL::to('feedback/save') }}" method="post">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">{{ trans('feedback_add.type') }}</label>
                                <div class="fg-line">
                                    <select id="slc_type" name="slc_type" class="form-control">
                                         @foreach($typeOptions as $key => $value)
                                             <option value="{{ $key }}"> {{ $value }} </option>
                                         @endforeach;
                                    </select>    
                                </div>
                            </div>
                        </div>
                    </div>                    
                             
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">{{ trans('feedback_add.subject') }}</label>
                                <div class="fg-line">
                                    <input type="text" id="subject" name="subject" class="form-control" placeholder="{{ trans('feedback_add.subject') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">{{ trans('feedback_add.content') }}</label>
                                <div class="fg-line">
                                    <textarea type="text" id="contents" name="contents" rows="5" class="form-control" placeholder="{{ trans('feedback_add.content') }}"></textarea>
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

    {{ ViewUtil::renderJsLanguage('feedback_add') }}

    <script src="{{ URL::asset('public/vendors/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset('public/js/feedback_add.js') }}"></script>

    @if(Session::has('error_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get('error_message') }}', 'dander');
        </script>
    @endif
    
@stop