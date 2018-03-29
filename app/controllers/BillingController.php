<?php

/*
*   Class BillingController
*   Auhor: Hieu Nguyen
*   Date: 2016-03-15
*   Purpose: To handle billing logic
*/

class BillingController extends BaseController {

    // Render the index page
    public function index() {
        $session = Session::get('session');
        $contact = Session::get('contact');
        $appListStrings = Session::get('app_list_strings');
        $rootSession = $this->client->getRootSession();
        
        // Get projects that linked to the portal contact
        $relationshipsParams = array(
            'session' => $rootSession,
            'module_name' => 'Accounts',
            'module_id' => $contact->account_id,
            'link_field_name' => 'accounts_c_receipt_1',
            'related_module_query' => '',
            'related_fields' => array(
                'id', 'number', 'name', 'type', 'receipts_date', 'amount', 'total_amount', 'remaining_amount' 
            ),
            'related_module_link_name_to_fields_array' => array(),
            'deleted'=> '0',
            'order_by' => '',
            'offset' => 0,
            'limit' => 1000,
        );
        
        $result = $this->client->call(SugarMethod::GET_RELATIONSHIPS, $relationshipsParams);
        $billings = $this->client->toSimpleObjectList($result->entry_list);

        $data = array(
            'billings' => $billings,
            'types' => $appListStrings->receipt_type_options,
        );
        
        return View::make('billing.index')->with($data);
    }	
}
