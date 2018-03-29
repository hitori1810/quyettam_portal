<?php  
class CustomerController extends BaseController {

    public function index() {     
        $customerList = $this->client->call2("GetCustomerList", array());    
        //            $customerList = $this->client->toSimpleObject($customerList);                                                              
        $data = array(
            'customerList' => $customerList->entry_list,
        );

        return View::make('customer.index')->with($data);
    }

    // Render the add page
    public function edit() {
        $session = Session::get('session');
        $user = Session::get('user');  

        if(!empty($_REQUEST['id'])){
            $customerId = $_REQUEST['id'];
            $data = array(
                'id' => $customerId
            );
            $customerEntry = $this->client->call2('GetCustomerInfo', $data);  
            $customerInfo = $customerEntry->entry_list;  
            if(!empty($customerInfo)){
                $data = array(       
                    'record_id' => $customerInfo->id,      
                    'name' => $customerInfo->first_name,      
                    'department' => $customerInfo->department,      
                    'phone_mobile' => $customerInfo->phone_mobile,      
                    'description' => $customerInfo->description,     
                );    
            }          

        }
        else{
            $data = array(       
                'record_id' => '',      
                'name' => '',      
                'department' => '',      
                'phone_mobile' => '',      
                'description' => '',     
            );    
        }    

        return View::make('customer.edit')->with($data);    
    }

    // Handle saving feedback
    public function save() {
        $session = Session::get('session');
        $user = Session::get('user');       

        // Save user data
        $data = array(
            'id'            => Input::get('record_id'),          
            'name'          => Input::get('name'),           
            'department'    => Input::get('department'),                
            'phone_mobile'  => Input::get('phone_mobile'),          
            'description'   => Input::get('description'),          
        );

        $result = $this->client->call2('SaveCustomer', $data);

        // Return result into the view
        if(!empty($result)) {
            Session::flash('success_message', trans('customer_index.save_successful_msg'));
            return Redirect::to('customer/index');
        } else {
            Session::flash('error_message', trans('customer_edit.save_failed_msg'));
            return Redirect::back();
        }    
    }    
}
