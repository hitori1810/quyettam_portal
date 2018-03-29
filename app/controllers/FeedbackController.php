<?php

    /*
    *   Class feedbackController
    *   Auhor: Hieu Nguyen
    *   Date: 2016-03-15
    *   Purpose: To handle feedback logic
    */

    class FeedbackController extends BaseController {

        // Render the index page
        public function index() {
            $feedbacks = SugarUtil::getFeedbackList();
            $appListStrings = Session::get('app_list_strings');

            $locale = App::getLocale();        
            $typeOptions = ($locale == "vi")? $appListStrings->full_relate_feedback_list_for_vn : $appListStrings->full_relate_feedback_list;
            $statusOptions = ($locale == "vi")? $appListStrings->status_feedback_list_for_vn : $appListStrings->status_feedback_list;
            $none = '-';
            //$appListStrings->jfeedback_slc_target_list->$none = '';
            $data = array(
                'feedbacks' => $feedbacks,
                'types' => $typeOptions,
                //'targets' => $appListStrings->jfeedback_slc_target_list,
                'statuses' => $statusOptions,
            );            
            return View::make('feedback.index')->with($data);
        }

        // Render the add page
        public function add() {
            $session = Session::get('session');
            $user = Session::get('user');
            $contact = Session::get('contact');
            $appListStrings = Session::get('app_list_strings');
            $locale = App::getLocale();

            $caseTypeOptions = ($locale == "vi")? $appListStrings->portal_feedback_type_list_for_vn : $appListStrings->portal_feedback_type_list_for_en;

            $data = array(
                'typeOptions' => $caseTypeOptions,
                'targetOptions' => $appListStrings->jfeedback_slc_target_list,
                'user' => $user,
                'contact' => $contact,
            );

            return View::make('feedback.add')->with($data);    
        }

        // Handle saving feedback
        public function save() {
            $session = Session::get('session');
            $user = Session::get('user');
            $contact = Session::get('contact');

            // Save user data
            $data = array(
                'name' => Input::get('subject'),
                'type_feedback_list' => 'Customer',
                'relate_feedback_list' => Input::get('slc_type'),
                'status' => 'New',
                'description' => Input::get('contents'),
                'contacts_j_feedback_1contacts_ida' => $contact->id,
                'is_portal' => 1,
                'assigned_user_id' => $contact->assigned_user_id,
                'team_id' => $contact->team_id,
                'team_set_id' => $contact->team_id,
            );

            $result = $this->client->save($session->root_session_id, 'J_Feedback', '', $data);

            // Return result into the view
            if($result != null) {
                Session::flash('success_message', trans('feedback_index.send_feedback_success_msg'));
                return Redirect::to('feedback/index');
            } else {
                Session::flash('error_message', trans('feedback_add.send_feedback_failed_msg'));
                return Redirect::back();
            }    
        }	
    }
