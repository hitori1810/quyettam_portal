@extends('layouts.master')

@section('title', trans('payment_edit.page_title'))

@section('styles')                                                                                      
<link href="{{ URL::asset('public/css/payment_edit.css') }}" rel="stylesheet" type="text/css">                                                                                         
                                                                                                                              
@stop
      
@section('content')
    
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('payment_edit.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <form id="form-edit-payment" action="{{ URL::to('payment/save') }}" method="post">     
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">{{ trans('payment_edit.customer') }}</label>
                                <div class="fg-line">
                                    <input type="hidden" id="record_id" name="record_id" class="form-control" value="{{$record_id}}"></input>                                    
                                    <select id="customer" name="customer" class="form-control">
                                         @foreach($customerList as $key => $value)
                                             <option value="{{ $key }}" {{ $key == $customer? "selected" : "" }}> {{ $value }} </option>
                                         @endforeach;
                                    </select>   
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">{{ trans('payment_edit.payment_date') }}</label>
                            <div class="input-group form-group">
                                <div class="dtp-container fg-line">
                                    <input type='text' name='payment_date' class="form-control date-picker" value="{{SugarUtil::formatDate($payment_date)}}"></input>  
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <h4>{{ trans('payment_edit.payment_detail') }}</h4><br>
                                <div class="fg-line">                                                                                                     
                                    
                                    <table id="tblPayDetail" class="table table-bordered dynamicTable">
                                    <thead>
                                        <tr>
                                            <th style="width:20%">{{ trans('payment_edit.product') }}</th>
                                            <th style="width:15%">{{ trans('payment_edit.quantity') }}</th>
                                            <th style="width:15%">{{ trans('payment_edit.unit') }}</th>
                                            <th style="width:10%">{{ trans('payment_edit.unit_cost') }}</th>
                                            <th style="width:15%">{{ trans('payment_edit.pay_detail_amount') }}</th>           
                                            <th style="width:10%"><input type="button" class="btnAddRow btn-primary waves-effect" value="{{ trans('payment_edit.add_row') }}" onclick="addRow(this);"></input></th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                        @if(!empty($paymentDetail))        
                                            @foreach($paymentDetail as $key => $value)                      
                                                <tr>
                                                    <td>                         
                                                        <select name="product[]" class="product form-control" onchange="changeProduct($(this).closest('tr'));">                                                      
                                                            @foreach($productList as $productId => $product)   
                                                                @if($product->id == $value->product)
                                                                    <option value="{{ $product->id }}" unit_cost="{{round($product->unit_cost)}}" unit="{{$product->unit}}" selected>
                                                                        {{$product->name}}
                                                                    </option>     
                                                                @else
                                                                    <option value="{{ $product->id }}" unit_cost="{{round($product->unit_cost)}}" unit="{{$product->unit}}">
                                                                        {{$product->name}}
                                                                    </option>      
                                                                @endif
                                                                               
                                                                
                                                            @endforeach   
                                                        </select>                                                          
                                                    </td>
                                                    <td>
                                                        <input type="text" name="quantity[]" width="100%" class="quantity number form-control input-sm" value="{{$value->quantity}}" onchange="calculatePayDetailAmount($(this).closest('tr'));"/>
                                                    </td>
                                                    <td class="number">
                                                        @foreach($productList as $productId => $product)   
                                                            @if($product->id == $value->product)        
                                                                <label class="lbl_unit">{{$product->unit}}</label>
                                                                <input type="hidden" name="unit[]" width="100%" class="unit" value="{{$product->unit}}"/>                                                 
                                                            @endif        
                                                        @endforeach                                                                                                                             
                                                    </td>
                                                    <td>
                                                        <label class="lbl_unit_cost">{{$value->unit_cost}}</label>
                                                        <input type="hidden" name="unit_cost[]" width="100%" class="unit_cost number form-control input-sm" value="{{round($value->unit_cost)}}"  onchange="calculatePayDetailAmount($(this).closest('tr'));"/>
                                                    </td>  
                                                    <td class="number">
                                                        <label class="lbl_pay_detail_amount">{{round($value->payment_amount)}}</label> 
                                                        <input type="hidden" name="pay_detail_amount[]" width="100%" class="pay_detail_amount" value="{{round($value->payment_amount)}}"/>
                                                    </td>
                                                    <td>
                                                        <input type="button" class="btnDelRow  btn-danger waves-effect" value="{{ trans('payment_edit.remove_row') }}" onclick="delRow(this);"></input>
                                                    </td>
                                                </tr>
                                            @endforeach  
                                        @endif    
                                    </tbody>
                                    <tfoot class="template" style="display:none">
                                        <tr>
                                            <td>      
                                                <select name="product[]" class="product form-control" onchange="changeProduct($(this).closest('tr'));">                                                      
                                                    @foreach($productList as $key => $value)                      
                                                        <option value="{{ $value->id }}" unit_cost="{{round($value->unit_cost)}}" unit="{{$value->unit}}">
                                                            {{$value->name}}
                                                        </option>
                                                    @endforeach   
                                                </select>                                                          
                                            </td>
                                            <td>
                                                <input type="text" name="quantity[]" width="100%" class="quantity number form-control input-sm" value="" onchange="calculatePayDetailAmount($(this).closest('tr'));"/>
                                            </td>
                                            <td class="number">
                                                <label class="lbl_unit"></label>
                                                <input type="hidden" name="unit[]" width="100%" class="unit" value=""/>                                                 
                                            </td>
                                            <td>
                                                <label class="lbl_unit_cost"></label>
                                                <input type="hidden" name="unit_cost[]" width="100%" class="unit_cost number form-control input-sm" value=""  onchange="calculatePayDetailAmount($(this).closest('tr'));"/>
                                            </td>   
                                            <td class="number">
                                                <label class="lbl_pay_detail_amount"></label> 
                                                <input type="hidden" name="pay_detail_amount[]" width="100%" class="pay_detail_amount" value=""/>
                                            </td>
                                            <td>
                                                <input type="button" class="btnDelRow  btn-danger waves-effect" value="{{ trans('payment_edit.remove_row') }}" onclick="delRow(this);"></input>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    </table>
                                    <br>                                                   
                                    <h4 id="lbl_payment_amount">{{ trans('payment_edit.payment_amount') }}: {{$paymentAmount}}</h4>
                                    <input type="hidden" id="payment_amount" name="payment_amount" value="{{$paymentAmount}}"/>
                                    <input type="hidden" id="payment_detail_json" name="payment_detail_json" value="{{$paymentDetailJson}}"/>
                                </div>
                            </div>
                        </div>
                    </div>   
                    
                    <button type="submit" class="btn btn-primary btn-sm m-t-10">{{ trans('app.btn_save_text') }}</button>
                </form>       
            </div>
        </div>
    </div>

@stop

@section('scripts')

    {{ ViewUtil::renderJsLanguage('payment_edit') }}

    <script src="{{ URL::asset('public/vendors/jquery-validate/jquery.validate.min.js') }}"></script>                                    
    <script src="{{ URL::asset('public/js/payment_edit.js') }}"></script>                                                                      
    
                                                                                                                                 
    @if(Session::has('error_message'))
        <script type="text/javascript">
            Notification.notify("{{ Session::get('error_message') }}", 'dander');   
        </script>
    @endif
    
@stop