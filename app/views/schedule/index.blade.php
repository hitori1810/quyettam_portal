@extends('layouts.master')

@section('title', trans('schedule_index.page_title'))

@section('styles')

    <link href="{{ URL::asset('public/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('public/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('public/css/schedule_index.css') }}" rel="stylesheet">

@stop

@section('content')

    <div class="container c-alt">
                        <div class="wrapper-note">
                          <h3 style="color: #4C4C4C;">{{ trans('app.notes') }}</h3>
                          <div style="margin-bottom: 10px;width: 50px;height: 25px;" class="textbg_dream note-item">
                            <p style="margin-left: 120%;width: 100px;color: #4C4C4C;">{{ trans('schedule_index.finished') }}</p>
                          </div>

                          <div style="margin-bottom: 10px;width: 50px;height: 25px;" class="textbg_orange note-item">
                              <p style="margin-left: 120%;width: 100px;color: #4C4C4C;" class="clear">{{ trans('schedule_index.not_started') }}</p>
                          </div>
                         </div>
                          <div id="calendar" class="has-toolbar">

                          </div>
                      </div>


        <div id="calendar"></div>

        <div id="action-menu">
            <ul class="actions actions-alt" id="fc-actions">
                <li class="dropdown">
                    <a href="" data-toggle="dropdown" aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="active"><a data-view="month" href="">{{ trans('schedule_index.calendar_month_view') }}</a></li>
                        <li><a data-view="basicWeek" href="">{{ trans('schedule_index.calendar_week_view') }}</a></li>
                        <li><a data-view="agendaWeek" href="">{{ trans('schedule_index.calendar_agenda_week_view') }}</a></li>
                        <li><a data-view="basicDay" href="">{{ trans('schedule_index.calendar_day_view') }}</a></li>
                        <li><a data-view="agendaDay" href="">{{ trans('schedule_index.calendar_agenda_day_view') }}</a></li>
                    </ul>
                </li>
            </ul>
        </div>

            <div class="modal fade" id="session_detail" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header custom-modal-header">
                            <h3 class="modal-title custom-modal-header"> {{trans('schedule_index.lbl_sessiondetail')}}</h3>
                        </div>

                        <div class="modal-body overflow-auto">
                        <hr class="no-padding no-margin"/>
                            <table class = 'session_detail' width='100%'>
                                <tbody>
                                    <tr>
                                        <td class="lable" style="background: #fdfdfd; text-align: right;"><b>{{trans('schedule_index.lbl_classname')}}:</b></td>
                                        <td class="value"><span class="class_name"></span></td>
                                        <td class="lable" style="background: #fdfdfd; text-align: right;"><b>{{trans('schedule_index.lbl_duration')}}:</b></td>
                                        <td class="value"><span class="duration"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="lable" style="background: #fdfdfd; text-align: right;"><b>{{trans('schedule_index.lbl_starttime')}}:</b></td>
                                        <td class="value"><span class="starttime"></span></td>
                                        <td class="lable" style="background: #fdfdfd; text-align: right;"><b>{{trans('schedule_index.lbl_endtime')}}:</b></td>
                                        <td class="value"><span class="endtime"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="lable" style="background: #fdfdfd; text-align: right;"><b>{{trans('schedule_index.lbl_attended')}}:</b></td>
                                        <td class="value"><span class="attended"></span></td>
                                        <td class="lable" style="background: #fdfdfd; text-align: right;"><b>{{trans('schedule_index.lbl_homework')}}:</b></td>
                                        <td class="value"><span class="homework"></span></td>
                                    </tr>                                                       
                                    <tr>
                                        <td class="lable" style="background: #fdfdfd; text-align: right;"><b>{{trans('schedule_index.lbl_teacher_comment')}}:</b></td>
                                        <td class="value"><span class="teacher_comment" colspan='3'></span></td>  
                                    </tr>
                                    <tr>
                                        <td class="lable" style="background: #fdfdfd; text-align: right;"><b></b></td>
                                        <td class="value"><span class="teacher_name"></span></td>
                                        <td class="lable" style="background: #fdfdfd; text-align: right;"><b></b></td>
                                        <td class="value"><span class="room_name"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr class="no-padding no-margin"/>
                        </div>

                        <div class="modal-footer">
                            <button type="button" id="btn-cancel" class="btn" data-dismiss="modal">{{trans('app.btn_close_text')}}</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>

@stop

@section('scripts')

    <script src="{{ URL::asset('public/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ URL::asset('public/vendors/bower_components/fullcalendar/dist/lang-all.js') }}"></script>
    <script src="{{ URL::asset('public/js/schedule_index.js') }}"></script>
    <script type="text/javascript">
        var scheduleEvents = {{ json_encode($events) }};
    </script>

@stop