<?php

/*
*   Class ViewUtil
*   Auhor: Hieu Nguyen
*   Date: 2016-03-15
*   Purpose: To handle Sugar's util methods
*/

class SugarUtil {

    // Util function to get the SugarClient to handle webservice methods
    static function getClient() {
        $serviceConfig = Config::get('app.service_config');
        $serverUrl = $serviceConfig['server_url'];
        $customService = $serviceConfig['custom_service'];
        $rootUsername = $serviceConfig['root_username'];
        $rootPassword = $serviceConfig['root_password'];

        $client = new SugarClient($serverUrl, $customService, $rootUsername, $rootPassword);
        return $client;
    }

    /**
    * function check session_id API is die
    *
    * @param string session_id
    * @return bool
    *
    * @author Trung Nguyen 2016.06.17
    */
    public static function checkSession($session_id) {
        $client = self::getClient();
        $params = array(
            'session' => $session_id
        );
        $result = $client->call("check_session", $params);
        if(isset($result->status))
            return $result->status;
        return false;
    }       

    // Util function to convert a given date string with from format to db date format
    public static function toDbDate($dateString, $fromFormat, $toUTC = false) {
        if(!empty($dateString)) {
            $preferences = Session::get('user_preferences');
            $timezone = $preferences->timezone;
            $date = DateTime::createFromFormat($fromFormat, $dateString, new DateTimeZone($timezone));
            $dbDateFormat = 'Y-m-d';
            $dbTimeFormat = 'H:i:s';
            $dbFormat = $dbDateFormat .' '. $dbTimeFormat;

            if($toUTC) {
                // Convert to UTC
                $date->setTimezone(new DateTimeZone('UTC'));
            }

            if(strlen($dateString) > 10) {
                // Date only
                return $date->format($dbFormat);
            }
            else {
                // Date and time
                return $date->format($dbDateFormat);
            }
        }
    }
    
    public static function getServiceUrl() {   
        $serviceConfig = Config::get('app.service_config');
        $serverUrl = $serviceConfig['server_url'];                                   
        return $serverUrl;
    }
    //
    public static function getDateformat() {
        $preferences = Session::get('user_preferences');
        $dateFormat = isset($preferences->date_format)?$preferences->date_format:"";
        return $dateFormat;
    }

    public static function getTimeformat() {
        $preferences = Session::get('user_preferences');
        $timeFormat = isset($preferences->time_format)?$preferences->time_format:"";
        return $timeFormat;
    }
    //add by Tung Bui - generate tzname
    public static function tzName($name, $off){
        if(empty($name)) return '';

        $appListStrings = Session::get('app_list_strings');
        $timezineDom = get_object_vars($appListStrings->timezone_dom);

        if(in_array($name, $timezineDom)) {
            $name = $timezineDom[$name];
        }
        return sprintf("%s (GMT%+2d:%02d)%s", str_replace('_',' ', $name), $off/3600, (abs($off)/60)%60, "");
    }

    //Add by Tung - get offset of timezone
    public static function getOffset($tzName){
        if($tzName instanceof DateTimeZone) $tz = $tzName;
        else $tz = timezone_open($tzName);
        if(!$tz) return "???";

        $now = new DateTime("now", $tz);
        return $now->getOffset();
    }

    //Add by Tung - get timezone list
    public static function getTimezoneList(){
        $timezoneList = timezone_identifiers_list();
        $offsetList = array();
        $tempList = array();

        foreach($timezoneList as $key => $value){
            $offset = self::getOffset($value);
            if(!in_array($offset, $offsetList)) $offsetList[] = $offset;
            $tempList[$value] = array(
                'offset' => $offset,
                'label' => self::tzName($value,$offset),
            );
        }

        sort($offsetList);
        $timezoneList = array();

        foreach($offsetList as $offset){
            foreach($tempList as $key => $value){
                if($value['offset'] == $offset){
                    $timezoneList[] = array(
                        'key'    => $key,
                        'label'  => $value['label'],
                        'offset' => $offset,
                    );
                }
            }
        }

        return $timezoneList;
    } 

    // Util function to format date time string
    public static function formatDate($dateString) {
        if(!empty($dateString)) {
            $preferences = Session::get('user_preferences');
            $timezone = isset($preferences->timezone)?$preferences->timezone:"";
            $dateFormat = isset($preferences->date_format)?$preferences->date_format:"";
            $timeFormat = isset($preferences->time_format)?$preferences->time_format:"";

            if(strlen($dateString) > 10) {
                $format = $dateFormat .' '. $timeFormat;
            }
            else {
                $format = $dateFormat;
            }

            $date = new DateTime($dateString);
            $date->setTimezone(new DateTimeZone($timezone));
            return $date->format($format);
        }
    }     
}
?>
