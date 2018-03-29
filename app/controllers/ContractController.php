<?php

/*
*   Class ContractController
*   Auhor: Hieu Nguyen
*   Date: 2016-03-15
*   Purpose: To handle contract logic
*/

class ContractController extends BaseController {

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
            'link_field_name' => 'contracts',
            'related_module_query' => '',
            'related_fields' => array(
                'id', 'reference_code', 'name', 'status', 'start_date', 'end_date' , 'total_contract_value' 
            ),
            'related_module_link_name_to_fields_array' => array(),
            'deleted'=> '0',
            'order_by' => '',
            'offset' => 0,
            'limit' => 1000,
        );
        
        $result = $this->client->call(SugarMethod::GET_RELATIONSHIPS, $relationshipsParams);
        $contracts = $this->client->toSimpleObjectList($result->entry_list);
        
        $data = array(
            'contracts' => $contracts,
            'statuses' => $appListStrings->contract_status_dom,
        );
        
        return View::make('contract.index')->with($data);
    }	
}
