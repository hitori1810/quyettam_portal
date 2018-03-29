<?php

    /*
    *   Class UserController
    *   Auhor: Hieu Nguyen
    *   Date: 2016-03-15
    *   Purpose: To handle user logic
    */

    class UserController extends BaseController {

        // Render the login page
        public function login() {
            if(isset($_REQUEST['MSID']) && $_REQUEST['MSID']) {                
                $params = array(
                    'session_id' => $_REQUEST['MSID'],
                );
                $userId = $this->client->call("get_user_id", $params);
                if(empty($userId))
                    return Redirect::to('user/login');
                //print_r($userId);
                //die;
                $session = array();    
                $session['id'] = $_REQUEST['MSID'];
                $session['contact_session'] = $session['id'];
                $session['root_session_id'] = $this->client->getRootSession();
                $session = (object)$session;
                $user = $this->client->retrieve($session->root_session_id, 'Users', $userId);
                $contact = $this->client->retrieve($session->root_session_id, 'Contacts', $user->portal_contact_id);
                $preferences = $this->client->getUserPreferences($session->root_session_id, $user->id, 'global'); 

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

                $languageParams = array(
                    'session' => $session->root_session_id, 
                    'type' => 'app_list_strings', 
                    'language' => (App::getLocale() == 'en') ? 'en_us' : 'vn_vn'
                );

                $language = $this->client->call2('GetAppListString');
                Session::put('app_list_strings', $language);

                Session::put('session', $session);
                Session::put('user', $user);
                Session::put('contact', $contact);
                Session::put('user_preferences', $preferences);
                return Redirect::to('schedule/index');
            }

            // Redirect the user into the dashboard right away if he already logged in   
            if(Session::get('session')) {
                return Redirect::to('schedule/index');
            }

            // User accessed the login page
            if(!Input::get('submit')) {
                $data = array(
                    'username' => '',
                    'password' => '',
                    'result' => ''
                );

                // Show remembered username and password
                if(Input::cookie('remembered_user')) {
                    $rememberedUser = Input::cookie('remembered_user');
                    $data['username'] = $rememberedUser['username'];
                    $data['password'] = $rememberedUser['password'];
                }

                return View::make('user.login')->with($data);
            }
            // User submitted the login form
            else {
                $username = Input::get('username');
                $password = Input::get('password');
                $remember = Input::get('remember_me');

                $result = $this->client->login($username, $password);

                // Login success
                if($result == 'success') {
                    // Get app list strings
                    $session = Session::get('session');   

                    $language = $this->client->call2('GetAppListString');
                    Session::put('app_list_strings', $language);

                    // Redirect the user into the dashboard the login result is success
                    if(!empty($remember)) {
                        // Save username and password into cookie
                        if(!empty($username) && !empty($password)) {
                            $cookie = Cookie::forever('remembered_user', array('username'=>$username, 'password'=>$password));
                            return Redirect::to('customer/index')->withCookie($cookie);
                        }
                    }
                    // Remove the remember cookie if user does not tick on the remember checkbox
                    else {
                        if(Input::cookie('remembered_user')) {
                            return Redirect::to('customer/index')->withCookie(Cookie::forget('remembered_user'));    
                        }
                    }

                    return Redirect::to('customer/index');
                }

                // Show the login page with error message
                $data = array(
                    'username' => '',
                    'password' => '',
                    'result' => $result
                );

                // Remove the remember cookie saved previously if user does not tick on the remember checkbox 
                if(Input::cookie('remembered_user')) {
                    return View::make('user.login')->with($data)->withCookie(Cookie::forget('remembered_user'));    
                }

                return View::make('user.login')->with($data);
            }
        }

        // Log out the authenticated user
        public function logout() {
            Session::forget('session');
            Session::forget('user');
            Session::forget('contact');
            Session::forget('user_preferences');
            Session::forget('app_list_strings');

            return Redirect::to('user/login');    
        }

        // Render the user profile page
        public function profile() {
            $session = Session::get('session');
            $user = Session::get('user');
            $appListStrings = Session::get('app_list_strings');

            //Get timezone list - Edit by Tung Bui 31/05/2016
            $timezoneList = SugarUtil::getTimezoneList();

            // Get data for the view
            $user = $this->client->retrieve($session->root_session_id, 'Users', $user->id);
            $contact = $this->client->retrieve($session->root_session_id, 'Contacts', $user->portal_contact_id);            

            // Store preference into session cache so that we can use it later in other pages

            $data = array(
                'user' => $user,
                'contact' => $contact,
                'timezones' => $timezoneList,
                'dateFormats' => Config::get('app.date_formats'),
                'timeFormats' => Config::get('app.time_formats'),               
            );

            // Render the view with necessary data
            return View::make('user.profile')->with($data);    
        }

        // Save profile
        public function saveProfile() {
            $session = Session::get('session');
            $user = Session::get('user');

            // Save user data
            $data = array(
                'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name'),
                'phone_work' => Input::get('office_phone'),
                'phone_mobile' => Input::get('mobile_phone'),
                'email1' => Input::get('email'),
                'address_street' => Input::get('address'),
                'description' => Input::get('description'),
            );

            $result = $this->client->save($session->root_session_id, 'Users', $user->id, $data);

            // Save prefrences
            /* $preferencesParams = array(
            'session' => $session->contact_session,  // #1fix by Trung Nguyen 2016.06.07
            'preferences' => array(
            'timezone' => Input::get('timezone'),
            'datef' => Input::get('date_format'),
            'timef' => Input::get('time_format'),    
            ),
            );   */

            //$result = $this->client->call(SugarMethod::SET_USER_PREFERENCES, $preferencesParams);

            Session::flash('flash_message', trans('user_profile.update_profile_success_msg'));
            return Redirect::back();
        }

        // Render the change password page
        public function changePassword() {
            $data = array(
                'current_password' => '',
                'new_password' => '',
                'confirm_password' => '',
            );

            // Get data returned from the save password action if any
            if(Session::has('data')) {
                $data = Session::get('data');
            }

            return View::make('user.change_password')->with($data);    
        }

        // Save the new password
        public function savePassword() {
            $session = Session::get('session');

            $passwordParams = array(
                'session' => $session->id,     // #1fix by Trung Nguyen 2016.06.07
                'current_password' => md5(Input::get('current_password')),    
                'new_password' => md5(Input::get('new_password')),    
            );

            $result = $this->client->call(SugarMethod::CHANGE_PASSWORD, $passwordParams);

            // Return the result into the view
            if($result == null) {
                Session::flash('error_message', trans('user_change_password.update_password_failed_error_msg'));
            }
            else if(isset($result->status) && $result->status == 'Error') {
                Session::flash('error_message', trans('user_change_password.current_password_not_correct_error_msg'));    
            } 
            else {
                Session::flash('success_message', trans('user_change_password.update_password_success_msg'));    
            }

            // Redirect back to the change password page with the submitted data
            return Redirect::back()->with('data', Input::all());
        }

        // Switch language
        public function switchLanguage() {
            $lang = Input::get('lang');

            // Set locale as user's selected language
            if(isset($lang) && in_array($lang, array('en', 'vi'))) {
                Session::put('locale', $lang);
                App::setLocale($lang);
            }

            return Redirect::back();
        }
    }
