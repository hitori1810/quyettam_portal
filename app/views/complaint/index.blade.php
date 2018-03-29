@extends('layouts.master')

@section('title', trans('complaint_index.page_title'))

@section('styles')
        
@stop

@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('complaint_index.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <table id="data-table" class="datatable table table-striped table-vmiddle">
                    <thead>
                        <tr>
                            <th>{{ trans('complaint_index.complaint_number') }}</th>
                            <th>{{ trans('complaint_index.subject') }}</th>
                            <th>{{ trans('complaint_index.status') }}</th>
                            <th>{{ trans('complaint_index.priority') }}</th>
                            <th>{{ trans('complaint_index.content') }}</th>
                            <th data-type="timestamp">{{ trans('complaint_index.sent_date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($complaints as $complaint)
                            <tr>
                                <td>{{ $complaint->case_number }}</td>
                                <td>{{ $complaint->name }}</td>
                                <td>{{ $statuses->{$complaint->status} }}</td>
                                <td>{{ $priorities->{$complaint->priority} }}</td>
                                <td>{{ $complaint->description }}</td>
                                <td>{{ SugarUtil::formatDate($complaint->date_entered) }}</td>
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
    <script src="{{ URL::asset('public/js/complaint_index.js') }}"></script>

    @if(Session::has('success_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get('success_message') }}', 'success');
        </script>
    @endif
    
@stop