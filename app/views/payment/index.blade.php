@extends('layouts.master')

@section('title', trans('payment_index.page_title'))

@section('styles')

@stop

@section('content')
<div class="container">
    <div class="block-header">
        <h2>{{ trans('payment_index.page_title') }}</h2>
    </div>

    <div class="card">
        <div class="card-body card-padding">
            <table id="data-table" class="datatable table table-striped table-vmiddle">
                <thead>
                    <tr>
                        <th>{{trans('payment_index.name')}}</th>
                        <th>{{trans('payment_index.customer')}}</th>
                        <th>{{trans('payment_index.payment_date')}}</th>
                        <th>{{trans('payment_index.payment_amount')}}</th>      
                        <th style="width:20%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentList as $payment)
                    <tr record_id="{{ $payment->id }}">
                        <td >{{ $payment->name }} </td>
                        <td >     
                            <a href="{{ URL::to('customer/view?id=')}}{{$payment->customer}}">
                                {{ $customerList->{$payment->customer} }} 
                            </a>    
                        </td>                         
                        <td data-type="timedate" >{{ SugarUtil::formatDate($payment->payment_date) }} </td> 
                        <td >{{ number_format($payment->payment_amount) }} </td>                               
                        <td style="text-align:center">
                            <button type="button" class="btn btn-primary btn_edit" url="{{ URL::to('payment/edit') }}" onclick="editPayment($(this).closest('tr'));">{{ trans('payment_index.btn_edit') }}</button>
                            <button type="button" class="btn btn-primary btn_export" onclick="exportPayment($(this).closest('tr'));">{{ trans('payment_index.btn_export') }}</button>
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
<script src="{{ URL::asset('public/js/payment_index.js') }}"></script>
<script src="{{ URL::asset('public/js/datatabel.js') }}"></script>
@stop