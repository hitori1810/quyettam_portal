@extends('layouts.master')

@section('title', trans('home_index.page_title'))

@section('content')

    <div class="container">
        <div class="block-header">
            <h2>{{ trans('home_index.page_title') }}</h2>
        </div>
        
        <div id="recent-news" class="card">
            <div class="card-header">
                <h2>{{ trans('home_index.recent_news') }}</h2>
            </div>
            
            <div class="card-body">
                <div class="item-list">
                    {{ $feed }}
                </div>    
            </div>
        </div>
    </div>

@stop

@section('scripts')

@stop