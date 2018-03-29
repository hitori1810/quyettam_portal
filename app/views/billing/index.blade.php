@extends('layouts.master')

@section('title', trans('billing_index.page_title'))

@section('styles')
        
@stop

@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('billing_index.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <table id="data-table" class="datatable table table-striped table-vmiddle">
                    <thead>
                        <tr>
                            <th>{{ trans('billing_index.billing_number') }}</th>
                            <th>{{ trans('billing_index.billing_name') }}</th>
                            <th>{{ trans('billing_index.type') }}</th>
                            <th data-type="timestamp">{{ trans('billing_index.billing_date') }}</th>
                            <th data-type="number">{{ trans('billing_index.billing_amount') }}</th>
                            <th data-type="number">{{ trans('billing_index.total_amount') }}</th>
                            <th data-type="number">{{ trans('billing_index.remaining_amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($billings as $billing)
                            <tr>
                                <td>{{ $billing->number }}</td>
                                <td>{{ $billing->name }}</td>
                                <td>{{ $types->{$billing->type} }}</td>
                                <td>{{ SugarUtil::formatDate($billing->receipts_date) }}</td>
                                <td>{{ number_format($billing->amount) }}</td>
                                <td>{{ number_format($billing->total_amount) }}</td>
                                <td>{{ number_format($billing->remaining_amount) }}</td>
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
    <script src="{{ URL::asset('public/js/billing_index.js') }}"></script>

@stop