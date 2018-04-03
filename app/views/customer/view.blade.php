@extends('layouts.master')

@section('title', trans('customer_view.page_title'))

@section('styles')
                 
<link href="{{ URL::asset('public/css/customer_view.css') }}" rel="stylesheet" type="text/css"> 
@stop
      
@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('customer_view.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <form id="form-edit-customer" action="{{ URL::to('customer/save') }}" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('customer_view.name') }}</label>
                                <div class="fg-line">
                                    <input type="hidden" id="record_id" name="record_id" class="form-control" value="{{$record_id}}"></input>
                                    <label id="name" name="name" class="form-control">{{$name}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('customer_view.department') }}</label>
                                <div class="fg-line">                                                                                         
                                    <label id="department" name="department" class="form-control">{{$department}}</label>
                                </div>
                            </div>
                        </div>
                    </div>     
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('customer_view.phone_mobile') }}</label>
                                <div class="fg-line">
                                    <label id="phone_mobile" name="phone_mobile" class="form-control">{{$phone_mobile}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('customer_view.description') }}</label>
                                <div class="fg-line">                                                                                                   
                                    <label id="description" name="description" class="form-control">{{$description}}</label>
                                </div>
                            </div>
                        </div>
                    </div>  
                    
                    <button type="button" class="btn btn-primary btn-sm m-t-10">{{ trans('app.btn_edit_text') }}</button>
                    <br>
                    <br>
                    <div class="pmb-block">                                   
                        <h4><i class="zmdi zmdi-time m-r-5"></i> {{ trans('customer_view.payment_list') }}</h4>
                                     
                        <table class="table table-bordered tbl_payment">  
                                <tr>                                                                 
                                    <th>{{trans('payment_index.name')}}</th>     
                                    <th>{{trans('payment_index.payment_date')}}</th>    
                                    <th>{{trans('payment_index.payment_amount')}}</th>            
                                    <th style="width:20%"></th>
                                </tr>    
                                @foreach($paymentList as $payment)
                                <tr record_id="{{ $payment->id }}">     
                                    <td class="center">{{ $payment->name }} </td>                                             
                                    <td class="center" data-type="timedate" >{{ SugarUtil::formatDate($payment->payment_date) }} </td> 
                                    <td class="right">{{ number_format($payment->payment_amount) }} </td>                               
                                    <td class="center">
                                        <button type="button" class="btn btn-primary btn_edit" url="{{ URL::to('payment/edit') }}" onclick="editPayment($(this).closest('tr'));">{{ trans('payment_index.btn_edit') }}</button>
                                        <button type="button" class="btn btn-primary btn_export" onclick="exportPayment($(this).closest('tr'));">{{ trans('payment_index.btn_export') }}</button>
                                    </td>                                          
                                </tr>
                                @endforeach 
                        </table>
                    </div>
                    
                </form>       
            </div>
        </div>
    </div>

@stop

@section('scripts')

    {{ ViewUtil::renderJsLanguage('customer_view') }}

    <script src="{{ URL::asset('public/vendors/jquery-validate/jquery.validate.min.js') }}"></script> 
    <script src="{{ URL::asset('public/js/customer_view.js') }}"></script> 

    @if(Session::has('error_message'))
        <script type="text/javascript">
            Notification.notify('{{ Session::get('error_message') }}', 'dander');
        </script>
    @endif
    
@stop