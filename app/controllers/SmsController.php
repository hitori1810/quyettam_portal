<?php

    /*
    *   Class StudentController
    *   Auhor: Hieu Nguyen
    *   Date: 2016-03-15
    *   Purpose: To handle user logic
    */

    class SmsController extends BaseController {

        public function index() {
            $session = Session::get('session');
            $contact = Session::get('contact');
            //$rootSession = $this->client->getRootSession();
            // Get sms that linked to the current student
            $relationshipsParams = array(
                'session' => $session->root_session_id,// $session->id,
                'module_name' => 'Contacts',
                'module_id' => $contact->id,
                'link_field_name' => 'contacts_sms',
                'related_module_query' => 'c_sms.parent_type = "Contacts"',
                'related_fields' => array(
                    'id', 'phone_number', 'description', 'delivery_status', 'date_send'
                ),
                'related_module_link_name_to_fields_array' => array(),
                'deleted'=> '0',
                'order_by' => ' date_send DESC ',
            );

            $result = $this->client->call(SugarMethod::GET_RELATIONSHIPS, $relationshipsParams);
            //fix by Trung Nguyen 2016.06.07
            if(!isset($result->entry_list)) $result->entry_list = array();

            $smsArr = $this->client->toSimpleObjectList($result->entry_list);
            $data = array(
                'smsList' => $smsArr,
            );

            return View::make('sms.index')->with($data);
        }
    }
