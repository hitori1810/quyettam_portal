<?php

/*
*   Class ComplaintController
*   Auhor: Hieu Nguyen
*   Date: 2016-03-15
*   Purpose: To handle complaint logic
*/

class ComplaintController extends BaseController {

    // Render the index page
    public function index() {
        $complaints = SugarUtil::getComplaintList();
        $appListStrings = Session::get('app_list_strings');

        $data = array(
            'complaints' => $complaints,
            'statuses' => $appListStrings->case_status_dom,
            'priorities' => $appListStrings->case_priority_dom,
        );

        return View::make('complaint.index')->with($data);
    }
    
    // Render the add page
    public function add() {
        $session = Session::get('session');
        $user = Session::get('user');
        $contact = Session::get('contact');
        
        $data = array(
            'user' => $user,
            'contact' => $contact,
        );
        
        return View::make('complaint.add')->with($data);    
    }
    
    // Handle saving complaint
    public function save() {
        $session = Session::get('session');
        $user = Session::get('user');
        $contact = Session::get('contact');
        
        // Save user data
        $data = array(
            'name' => Input::get('subject'),
            'type' => 'Complaint',
            'status' => 'New',
            'priority' => 'P1', // High
            'content' => Input::get('contents'),
            'account_id' => $contact->account_id,
            'assigned_user_id' => $user->id,
        );

        $result = $this->client->save($session->id, 'Cases', '', $data);
        
        // Return result into the view
        if($result != null) {
            Session::flash('success_message', trans('complaint_index.send_complaint_success_msg'));
            return Redirect::to('complaint/index');
        } else {
            Session::flash('error_message', trans('complaint_add.send_complaint_failed_msg'));
            return Redirect::back();
        }    
    }	
}
