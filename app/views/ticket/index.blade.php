@extends('layouts.master')

@section('title', trans('ticket_index.page_title'))

@section('styles')
        
@stop

@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('ticket_index.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <table id="data-table" class="datatable table table-striped table-vmiddle">
                    <thead>
                        <tr>
                            <th>{{ trans('ticket_index.ticket_number') }}</th>
                            <th>{{ trans('ticket_index.subject') }}</th>
                            <th>{{ trans('ticket_index.status') }}</th>
                            <th>{{ trans('ticket_index.priority') }}</th>
                            <th>{{ trans('ticket_index.content') }}</th>
                            <th data-type="timestamp">{{ trans('ticket_index.sent_date') }}</th>
                            <th>{{ trans('ticket_index.assigned_staff') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td><a href="{{ URL::to('ticket/view/' . $ticket->id) }}">{{ $ticket->case_number }}</a></td>
                                <td>{{ $ticket->name }}</td>
                                <td>{{ $statuses->{$ticket->status} }}</td>
                                <td>{{ $priorities->{$ticket->priority} }}</td>
                                <td>{{ $ticket->description }}</td>
                                <td>{{ SugarUtil::formatDate($ticket->date_entered) }}</td>
                                <td>{{ $ticket->assigned_user_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
            </div>
        </div>
    </div>

@stop

@section('scripts')

    <script src="{{ URL::asset('public/vendors/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('public/vendors/datatables/media/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('public/js/ticket_index.js') }}"></script>

    @if(Session::has('success_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get('success_message') }}', 'success');
        </script>
    @endif
    
@stop