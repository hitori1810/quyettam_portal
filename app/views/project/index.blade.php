@extends('layouts.master')

@section('title', trans('project_index.page_title'))

@section('styles')
        
@stop

@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('project_index.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <table id="data-table" class="datatable table table-striped table-vmiddle">
                    <thead>
                        <tr>
                            <th>{{ trans('project_index.project_name') }}</th>
                            <th>{{ trans('project_index.status') }}</th>
                            <th data-type="timestamp">{{ trans('project_index.start_date') }}</th>
                            <th data-type="timestamp">{{ trans('project_index.end_date') }}</th>
                            <th>{{ trans('project_index.description') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $project->name }}</td>
                                <td>{{ $statuses->{$project->status} }}</td>
                                <td>{{ SugarUtil::formatDate($project->estimated_start_date) }}</td>
                                <td>{{ SugarUtil::formatDate($project->estimated_end_date) }}</td>
                                <td>{{ $project->description }}</td>
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
    <script src="{{ URL::asset('public/js/project_index.js') }}"></script>

@stop