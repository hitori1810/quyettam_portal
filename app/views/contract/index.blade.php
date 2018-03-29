@extends('layouts.master')

@section('title', trans('contract_index.page_title'))

@section('styles')
        
@stop

@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('contract_index.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <table id="data-table" class="datatable table table-striped table-vmiddle">
                    <thead>
                        <tr>
                            <th>{{ trans('contract_index.contract_number') }}</th>
                            <th>{{ trans('contract_index.contract_name') }}</th>
                            <th>{{ trans('contract_index.status') }}</th>
                            <th data-type="timestamp">{{ trans('contract_index.start_date') }}</th>
                            <th data-type="number">{{ trans('contract_index.end_date') }}</th>
                            <th data-type="number">{{ trans('contract_index.contract_value') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contracts as $contract)
                            <tr>
                                <td>{{ $contract->reference_code }}</td>
                                <td>{{ $contract->name }}</td>
                                <td>{{ $statuses->{$contract->status} }}</td>
                                <td>{{ SugarUtil::formatDate($contract->start_date) }}</td>
                                <td>{{ SugarUtil::formatDate($contract->end_date) }}</td>
                                <td>{{ number_format($contract->total_contract_value) }}</td>
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
    <script src="{{ URL::asset('public/js/contract_index.js') }}"></script>

@stop