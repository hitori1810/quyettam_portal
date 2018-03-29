@extends('layouts.master')

@section('title', trans('customer_index.page_title'))

@section('styles')
   
@stop

@section('content')
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('customer_index.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <table id="data-table" class="datatable table table-striped table-vmiddle">
                    <thead>
                        <tr>
                            <th>{{trans('customer_index.code')}}</th>
                            <th>{{trans('customer_index.name')}}</th>
                            <th>{{trans('customer_index.department')}}</th>
                            <th>{{trans('customer_index.phone_mobile')}}</th>
                            <th>{{trans('customer_index.description')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customerList as $customer)
                            <tr record_id="{{ $customer->id }}">
                                <td >{{ $customer->code }} </td>
                                <td >{{ $customer->first_name }} </td>
                                <td >{{ $customer->department }} </td>
                                <td >{{ $customer->phone_mobile }} </td>
                                <td >{{ $customer->description }} </td>                                          
                                <td style="text-align:center">
                                    <button type="button" class="btn btn-primary btn_edit" url="{{ URL::to('customer/edit') }}" onclick="editCustomer($(this).closest('tr'));">{{ trans('customer_index.btn_edit') }}</button>
                                </td>                                          
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
    <script src="{{ URL::asset('public/js/customer_index.js') }}"></script>
    <script src="{{ URL::asset('public/js/datatabel.js') }}"></script>
@stop