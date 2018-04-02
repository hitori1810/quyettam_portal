@extends('layouts.master')

@section('title', trans('product_index.page_title'))

@section('styles')
   
@stop

@section('content')
    <div class="container">
        <div class="block-header">
            <h2>{{ trans('product_index.page_title') }}</h2>
        </div>
        
        <div class="card">
            <div class="card-body card-padding">
                <table id="data-table" class="datatable table table-striped table-vmiddle">
                    <thead>
                        <tr>
                            <th>{{trans('product_index.code')}}</th>
                            <th>{{trans('product_index.name')}}</th>
                            <th>{{trans('product_index.unit_cost')}}</th>
                            <th>{{trans('product_index.unit')}}</th>       
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productList as $product)
                            <tr record_id="{{ $product->id }}">
                                <td >{{ $product->code }} </td>
                                <td >{{ $product->name }} </td>
                                <td >{{ round($product->unit_cost) }} </td>
                                <td >{{ $product->unit }} </td>                                          
                                <td style="text-align:center">
                                    <button type="button" class="btn btn-primary btn_edit" url="{{ URL::to('product/edit') }}" onclick="editProduct($(this).closest('tr'));">{{ trans('product_index.btn_edit') }}</button>
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
    <script src="{{ URL::asset('public/js/product_index.js') }}"></script>
    <script src="{{ URL::asset('public/js/datatabel.js') }}"></script>
@stop