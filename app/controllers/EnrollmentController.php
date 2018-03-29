<?php

/*
*   Class StudentController
*   Auhor: Hieu Nguyen
*   Date: 2016-03-15
*   Purpose: To handle user logic
*/

class EnrollmentController extends BaseController {

    public function index() {
        $session = Session::get('session');
        $contact = Session::get('contact');

        // Get sms that linked to the current student
        $params = array(
            'session' => $session->root_session_id,
            'student_id' => $contact->id,
        );

        $enrrolments = $this->client->call(SugarMethod::GET_ENROLLMENT_LIST, $params);
        //return $enrrolments;
        $data = array(
            'enrollents' => $enrrolments,
        );

        return View::make('enrollment.index')->with($data);
    }
}
