@extends('layouts.master')

@section('title', trans('feedback_index.page_title'))

@section('styles')
        
@stop

@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('feedback_index.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding overflow-auto">
                <table id="data-table" class="datatable table table-striped table-vmiddle">
                    <thead>
                        <tr>
                            <th><b>{{ trans('feedback_index.subject') }}</b></th>
                            <th><b>{{ trans('feedback_index.type') }}</b></th>
                            <th><b>{{ trans('feedback_index.receiver') }}</b></th>  
                            <th data-type="timedate"><b>{{ trans('feedback_index.sent_date') }}</b></th>
                            <th><b>{{ trans('feedback_index.status') }}</b></th>
                            <th><b>{{ trans('feedback_index.content') }}</b></th>
                            <th><b>{{ trans('feedback_index.resolution') }}</b></th>
                            <th data-type="timedate"><b>{{ trans('feedback_index.resolved_date') }}</b></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($feedbacks as $feedback)
                            <tr>
                                <td>{{ $feedback->name }}</td>
                                <td>{{ $types->{$feedback->relate_feedback_list} }}</td>
                                <td>{{ $feedback->receiver }}</td>
                                <td>{{ SugarUtil::formatDate($feedback->date_entered) }}</td>
                                <td>{{ isset($statuses->{$feedback->status})?$statuses->{$feedback->status}:$feedback->status }}</td>
                                <td>{{ html_entity_decode(nl2br($feedback->description)) }}</td>
                                <td>{{ html_entity_decode(nl2br($feedback->feedback)) }}</td>
                                 <td>{{ SugarUtil::formatDate($feedback->resolved_date) }}</td>
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
    <script src="{{ URL::asset('public/js/datatabel.js') }}"></script>

    @if(Session::has('success_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get("success_message") }}', 'success');
        </script>
    @endif
    
@stop