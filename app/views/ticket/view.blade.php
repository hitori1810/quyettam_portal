@extends('layouts.master')

@section('title', trans('ticket_view.page_title'))

@section('styles')

    <link href="{{ URL::asset('public/css/ticket_view.css') }}" rel="stylesheet">        
            
@stop

@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('ticket_view.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2>{{ trans('ticket_view.summary') }}</h2>
            </div>

            <div class="card-body card-padding">
                <table id="data-table" class="table table-striped table-vmiddle">
                    <thead>
                        <tr>
                            <th>{{ trans('ticket_index.ticket_number') }}</th>
                            <th>{{ trans('ticket_index.subject') }}</th>
                            <th>{{ trans('ticket_index.status') }}</th>
                            <th>{{ trans('ticket_index.priority') }}</th>
                            <th>{{ trans('ticket_index.sent_date') }}</th>
                            <th>{{ trans('ticket_index.assigned_staff') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $ticket->case_number }}</td>
                            <td>{{ $ticket->name }}</td>
                            <td>{{ $statuses->{$ticket->status} }}</td>
                            <td>{{ $priorities->{$ticket->priority} }}</td>
                            <td>{{ SugarUtil::formatDate($ticket->date_entered) }}</td>
                            <td>{{ $ticket->assigned_user_name }}</td>
                        </tr>
                    </tbody>
                </table>       
            </div>
        </div>
        
        @if($ticket->status != 'Closed')
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('ticket_view.close_ticket') }}</h2>
                </div>

                <div class="card-body card-padding">
                    <form id="form-close-ticket" action="{{ URL::to('/ticket/close/' . $ticket->id) }}" method="post">
                        <p>{{ trans('ticket_view.close_ticket_form_description') }}</p>
                        <button type="submit" name="submit" class="btn btn-primary btn-sm m-t-10"><i class="zmdi zmdi-check"></i> {{ trans('app.btn_close_text') }}</button>
                    </form>
                </div>
            </div>
        @endif
        
        <div class="card">
            <div class="card-header">
                <h2>{{ trans('ticket_view.conversation') }}</h2>
            </div>
        
            <div class="card-body card-padding">
                <div class="ms-body">
                    <div class="listview lv-message">
                        <div class="lv-body">                                    
                            <div class="lv-item media">
                                <div class="lv-avatar pull-left">
                                    <img src="{{ URL::asset('public/img/customer-avatar.png') }}" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="ms-item">
                                        {{ $ticket->description }}
                                    </div>
                                    <div class="ms-meta">
                                        <small class="ms-sender"><i class="zmdi zmdi-account-circle"></i> {{ $ticket->assigned_user_name }}</small>
                                        <small class="ms-date"><i class="zmdi zmdi-time"></i> {{ SugarUtil::formatDate($ticket->date_entered) }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    @foreach($comments as $comment)
                        <div class="listview lv-message">
                            <div class="lv-body">                                    
                                <div class="lv-item media @if($comment->assigned_user_id != $user->id) right @endif">
                                    <div class="lv-avatar @if($comment->assigned_user_id != $user->id) pull-right @else pull-left @endif">
                                        <img src="{{ URL::to('public/img/' . (($comment->assigned_user_id == $user->id) ? 'customer-avatar.png' : 'staff-avatar.png')) }}" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="ms-item">
                                            {{ $comment->description }}
                                        </div>
                                        <div class="ms-meta">
                                            <small class="ms-sender"><i class="zmdi zmdi-account-circle"></i> {{ $comment->assigned_user_name }}</small>
                                            <small class="ms-date"><i class="zmdi zmdi-time"></i> {{ SugarUtil::formatDate($comment->date_entered) }}</small>
                                            @if($comment->filename != '')
                                                <small class="ms-attachment"><i class="zmdi zmdi-attachment"></i> <a href="{{ Config::get('app.service_config.server_url') }}/index.php?entryPoint=download&id={{ $comment->id }}&type=Notes">{{ $comment->filename }}</a></small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2>{{ trans('ticket_view.send_comment') }}</h2>
            </div>
        
            <div class="card-body card-padding">
                <form id="form-comment" action="{{ URL::to('ticket/comment/' . $ticket->id) }}" method="post" enctype="multipart/form-data">
                    <p></p>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">{{ trans('ticket_view.message') }}</label>
                                <div class="fg-line">
                                    <textarea id="message" name="message" class="form-control" placeholder="{{ trans('ticket_view.message') }}"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">{{ trans('ticket_view.attachment') }}</label>
                                <div class="fg-line">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn btn-file m-r-10">
                                            <span class="fileinput-new">{{ trans('ticket_view.attach_file') }}</span>
                                            <span class="fileinput-exists">{{ trans('ticket_view.change_file') }}</span>
                                            <input type="file" name="attachment">
                                        </span>
                                        <span class="fileinput-filename"></span>
                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-sm m-t-10"><i class="zmdi zmdi-mail-send"></i> {{ trans('app.btn_send_text') }}</button>
                </form>
            </div>
        </div>
    </div>

@stop

@section('scripts')

    {{ ViewUtil::renderJsLanguage('ticket_view') }}

    <script src="{{ URL::asset('public/vendors/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset('public/vendors/fileinput/fileinput.min.js') }}"></script>
    <script src="{{ URL::asset('public/js/ticket_view.js') }}"></script>

    @if(Session::has('success_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get('success_message') }}', 'success');
        </script>
    @endif
    
    @if(Session::has('error_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get('error_message') }}', 'danger');
        </script>
    @endif
    
@stop