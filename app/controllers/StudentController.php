<?php

/*
*   Class StudentController
*   Auhor: Hieu Nguyen
*   Date: 2016-03-15
*   Purpose: To handle user logic
*/

class StudentController extends BaseController {

	public function index() {
		//$contact = Session::get('contact');
		/*$data = array(
			'students' => array(
				array('name' => 'trung'),
				array('name' => 'tung'),
			),
		); */
        $classID = '4db9f4b3-737e-84e0-27a2-5722bc742ee8';
        $data = SugarUtil::getCertificate($classID);
		
		return View::make('student.index')->with($data);
	}
}
