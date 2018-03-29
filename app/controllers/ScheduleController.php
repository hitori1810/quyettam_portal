<?php

/*
*   Class StudentController
*   Auhor: Hieu Nguyen
*   Date: 2016-03-15
*   Purpose: To handle user logic
*/

class ScheduleController extends BaseController {

    public function index() {
        //$session = Session::get('session');
        $contact = Session::get('contact');

        $schedules = SugarUtil::getSchedules();
        $lang = trans('schedule_index');
        // Render events for fullcalendar format and return to the view
        $events = array();
        $todayDate = time();

        for($i = 0; $i < count($schedules); $i++) {
            $focusDate = strtotime($schedules[$i]->date);
            $bgClass = '';

            // The session is in the pass
            if($todayDate > $focusDate) {
                // Student is present
                $bgClass = 'textbg_dream';
            }
            // The session is not started
            else {
                $bgClass = 'textbg_orange';
            }
            
            $attended = "";
            $homework = "";
            
            if(!empty($schedules[$i]->atd_id)){  
                $attended  = $schedules[$i]->attended == 1 ? $lang["lbl_yes"] : $lang["lbl_no"];
                $homework  = $schedules[$i]->homework == 1 ? $lang["lbl_yes"] : $lang["lbl_no"];   
            }

            $events[] = array(
                'title' => $schedules[$i]->session_name,
                'start' => date('Y-m-d H:i:s',strtotime("+7 hours".($schedules[$i]->date_start))),
                'starttime' => SugarUtil::formatDate($schedules[$i]->date_start),
                'end' => date('Y-m-d H:i:s',strtotime("+7 hours".($schedules[$i]->date_end))),
                'endtime' => SugarUtil::formatDate($schedules[$i]->date_end),
                'teacher_name' => '', //Hide Teacher - Lap nguyen  $schedules[$i]->teacher_name,
                'class_name' => $schedules[$i]->class_name,
                'room_name' => $schedules[$i]->room_name,
                'duration' => $schedules[$i]->duration,
                'allDay' => false,
                'className' => $bgClass,
                'atd_id'    => $schedules[$i]->atd_id,
                'attended'  => $attended,
                'homework'  => $homework,
                'teacher_comment' => $schedules[$i]->teacher_comment,  
            );
        }

        $data = array(
            'events' => $events
        );

        return View::make('schedule.index')->with($data);
    }

    public function listview() {
        $schedules = SugarUtil::getSchedules();
        $lang = trans('schedule_listview');
        
        foreach($schedules as $key => $value){
            $attended = "";
            $homework = "";
            
            if(!empty($value->atd_id)){  
                 $attended = $value->attended == 1 ? $lang["lbl_yes"] : $lang["lbl_no"];
                 $homework = $value->homework == 1 ? $lang["lbl_yes"] : $lang["lbl_no"];   
            }   
            
            $schedules[$key]->attended = $attended;
            $schedules[$key]->homework = $homework;
        }
        
        $data = array(
            'schedules' => $schedules
        );
        return View::make('schedule.listview')->with($data);
    }
}
