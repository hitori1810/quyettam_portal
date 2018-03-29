<?php

/*
*   Class ProjectController
*   Auhor: Hieu Nguyen
*   Date: 2016-03-15
*   Purpose: To handle project logic
*/

class ProjectController extends BaseController {

    // Render the index page
    public function index() {
        $session = Session::get('session');
        $contact = Session::get('contact');
        $appListStrings = Session::get('app_list_strings');
        $rootSession = $this->client->getRootSession();
        
        // Get projects that linked to the portal contact
        $relationshipsParams = array(
            'session' => $rootSession,
            'module_name' => 'Contacts',
            'module_id' => $contact->id,
            'link_field_name' => 'project',
            'related_module_query' => '',
            'related_fields' => array(
                'id', 'name', 'status', 'estimated_start_date', 'estimated_end_date' , 'description' 
            ),
            'related_module_link_name_to_fields_array' => array(),
            'deleted'=> '0',
            'order_by' => '',
            'offset' => 0,
            'limit' => 1000,
        );
        
        $result = $this->client->call(SugarMethod::GET_RELATIONSHIPS, $relationshipsParams);
        $projects = $this->client->toSimpleObjectList($result->entry_list);

        $data = array(
            'projects' => $projects,
            'statuses' => $appListStrings->project_status_dom,
        );
        
        return View::make('project.index')->with($data);
    }	
}
