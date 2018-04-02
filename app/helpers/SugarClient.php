<?php

/*
*   Class SugarMethod
*   Auhor: Hieu Nguyen
*   Date: 2016-03-15
*   Purpose: To store enumurate values for Sugar's webservice methods
*/

abstract class SugarMethod {
    const LOGIN = 'login';   
    const LOGOUT = 'logout';   
    const SET_ENTRY = 'set_entry';   
    const SET_ENTRIES = 'set_entries';   
    const GET_ENTRY = 'get_entry';   
    const GET_ENTRY_LIST = 'get_entry_list';   
    const GET_ENTRIES_COUNT = 'get_entries_count';   
    const GET_RELATIONSHIPS = 'get_relationships';  
    const GET_ENROLLMENT_LIST = 'get_enrollment_list';  
    const GET_SCHEDULES = 'get_schedules';
    const SET_RELATIONSHIP = 'set_relationship';
    const SET_NOTE_ATTACHMENT = 'set_note_attachment';   
    const SET_USER_PREFERENCES = 'set_user_preferences';   
    const GET_SUGAR_LANGUAGE = 'get_sugar_language';   
    const CHANGE_PASSWORD = 'change_password';   
}

/*
*   Class SugarClient
*   Auhor: Hieu Nguyen
*   Date: 2016-03-15
*   Purpose: To handle Sugar's webservices client
*/

class SugarClient {

    var $appName = 'CustomerPortal';
    var $version = '1';
    var $serviceUrl = '';
    var $rootUsername = '';
    var $rootPassword = '';

    function __construct($serverUrl, $custom, $rootUsername, $rootPassword) {
        $this->serverUrl = $serverUrl;
        $this->rootUsername = $rootUsername;
        $this->rootPassword = $rootPassword;
        $this->serviceUrl = $serverUrl . ($custom ? '/custom/' : '/') .'service/v4_1/rest.php';       
        $this->newApiUrl = $serverUrl .'/?entryPoint=api';       
    }

    // Make request
    public function call($method, $parameters) {
        ob_start();
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->serviceUrl);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);

        $post = array(
            'method' => $method,
            'input_type' => 'JSON',
            'response_type' => 'JSON',
            'rest_data' => json_encode($parameters)
        );

        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($curl);     
        curl_close($curl);

        if(!$result) {
            return null;    
        }

        ob_end_flush();  
        $response = json_decode($result);

        return $response;
    }

    // Make request
    public function call2($method, $parameters = array()) {
        ob_start();
        $curl = curl_init($this->newApiUrl);     
        curl_setopt($curl, CURLOPT_POST,true);    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);             

        $params = array(
            'RequestAction' => $method,    
            'Params' => base64_encode(json_encode($parameters))
        );

        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        $result = curl_exec($curl);   
        $curlInfo = curl_getinfo($curl);  
        curl_close($curl);

        if(!$result) {
            return null;    
        }

        ob_end_flush();  
        $response = json_decode($result);                     

        return $response;
    }

    // Util function to retrieve a specific record from the given module
    public function retrieve($sessionId, $moduleName, $id, $selectFields = '') {
        $params = array(  
            'session' => $sessionId,
            'module_name' => $moduleName,
            'id' => $id, 
            'select_fields' => $selectFields,
        );

        $response = $this->call(SugarMethod::GET_ENTRY, $params);

        if(!$response) {
            return null;    
        }

        return $this->toSimpleObject($response->entry_list[0]);
    }

    // Util function to save a specific record into the given module
    public function save($sessionId, $moduleName, $id = '', $data) {
        $params = array(  
            'session' => $sessionId,
            'module_name' => $moduleName,
            'name_value_list' => array(),
        );

        // Add data to name value list array
        if($id != '') {
            $params['name_value_list'][] = array(
                'name' => 'id',
                'value' => $id
            );
        }

        foreach($data as $field => $value) {
            $params['name_value_list'][] = array(
                'name' => $field,
                'value' => $value
            );    
        }

        $response = $this->call(SugarMethod::SET_ENTRY, $params);

        if(!$response) {
            return null;    
        }

        return $response;
    }

    // Util function to get records count in the given module
    public function count($sessionId, $moduleName, $query = '') {
        $params = array(
            'session' => $sessionId,
            'module_name' => $moduleName,
            'query' => $query,
            'deleted' => '0',
        );

        $response = $this->call(SugarMethod::GET_ENTRIES_COUNT, $params);

        if($response == null) {
            return 0;
        }

        return $response->result_count;    
    }

    // Util funtion to get all records from a given module
    public function getFullList($sessionId, $moduleName, $selectFields = array(), $query = '', $orderBy = '', $limit = 1000, $relationships = array()) {
        $params = array(
            'session' => $sessionId,
            'module_name' => $moduleName,
            'query' => $query,
            'order_by' => $orderBy,
            'offset' => '0',
            'select_fields' => $selectFields,
            'link_name_to_fields_array' => $relationships,
            'max_results' => '10',
            'deleted' => '0',
            'favorites' => false,
        );

        $response = $this->call(SugarMethod::GET_ENTRY_LIST, $params);
        $list = $this->toSimpleObjectList($response->entry_list);

        return $list;    
    }

    // Util function to convert the complex object returned from the webservice into simple object
    public function toSimpleObject($complexObject) {
        if(!$complexObject) {
            return null;
        }

        $result = new stdClass();

        foreach($complexObject->name_value_list as $field => $data) {
            $result->$field = $data->value;    
        }

        return $result;   
    }

    // Util function to convert the complex object list returned from the webservice into simple object list
    public function toSimpleObjectList($complexObjectList) {
        if(!$complexObjectList) {
            return array();
        }
        if(!is_array($complexObjectList)) {
            return array();
        }

        $result = array();

        // Loop throught all the objects in the complex list
        for($i = 0; $i < count($complexObjectList); $i++) {
            $simpleObject = new stdClass();

            // Loop through all field of the complex object
            foreach($complexObjectList[$i] as $field => $data) {
                $simpleObject->$field = $data->value;
            }

            // Append the simple object into the result list
            $result[] = $simpleObject;
        }

        return $result;   
    }

    // Util function to get the most powerfull user's session
    public function getRootSession() {
        $loginParams = array(
            'user_auth' => array(
                'user_name' => $this->rootUsername,
                'password' => $this->rootPassword,
                'version' => $this->version
            ),
            'application_name' => $this->appName,
        );
        $loginResult = $this->call(SugarMethod::LOGIN, $loginParams);

        return ($loginResult) ? $loginResult->id : null;
    }

    //Login
    public function login($username, $password) {     
        $loginParams = array(
            'user_auth' => array(
                'user_name' => $username,
                'password' => md5($password),
                'version' => $this->version
            ),
            'application_name' => $this->appName,
        );    

        $session = $this->call(SugarMethod::LOGIN, $loginParams);


        if(isset($session->id)){                                             
            $session->root_session_id = $this->getRootSession();
            //$session->id = $this->getRootSession();

            $userId = $session->name_value_list->user_id->value;

            // Retrieve user info
            $user = $this->retrieve($session->root_session_id, 'Users', $userId);

            $preferences = $this->getUserPreferences($session->root_session_id, $user->id, 'global');                     
            if(empty($preferences->timezone)){
                $preferences->timezone = 'Asia/Ho_Chi_Minh';
            }
            if(empty($preferences->date_format)){
                if(empty($preferences->datef))
                    $preferences->date_format = 'd/m/Y';
                else 
                    $preferences->date_format = $preferences->datef;
            }
            if(empty($preferences->time_format)){
                if(empty($preferences->timef))
                    $preferences->time_format = 'h:i A';
                else 
                    $preferences->time_format = $preferences->timef;                     
            }
            if(empty($preferences->default_locale_name_format)){
                $preferences->default_locale_name_format = 's l f';
            }                    

            // Save login session
            Session::put('session', $session);
            Session::put('user', $user);        
            Session::put('user_preferences', $preferences);

            // Return success status
            $status = 'success';
        } 
        else {
            $status = 'login_failed';
        }

        return $status;
    }

    // Util function to get user preference by a given user id and category
    public function getUserPreferences($sessionId, $userId, $category){
        $params = array(
            'session' => $sessionId,
            'module_name' => 'UserPreferences',
            'query' => 'user_preferences.assigned_user_id = "'. $userId .'" AND category = "'. $category .'"',
            'select_fields' => array('id', 'contents'),
            'deleted' => '0',
        );

        $result = $this->call(SugarMethod::GET_ENTRY_LIST, $params);
        $data = $result->entry_list[0]->name_value_list;
        $content = $data->contents->value;             
        $preferences = unserialize(base64_decode($content));    // Convert from string to array
        $preferences = (object)$preferences;  // Convert from array to object

        return $preferences;
    }
}
?>
