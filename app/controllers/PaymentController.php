<?php  
class PaymentController extends BaseController {

    public function index() {     
        $paymentList = $this->client->call2("GetPaymentList", array());
        $app_list_strings = $this->client->call2('GetAppListString');
        Session::put('app_list_strings', $app_list_strings);                     

        $data = array(
            'paymentList' => $paymentList->entry_list,
            'customerList' => $app_list_strings->entry_list->customer_options,   
        );

        return View::make('payment.index')->with($data);
    }

    // Render the add page
    public function edit() {
        $session = Session::get('session');
        $user = Session::get('user');                         
        $app_list_strings = $this->client->call2('GetAppListString');
        Session::put('app_list_strings', $app_list_strings);

        if(!empty($_REQUEST['id'])){
            $recordId = $_REQUEST['id'];
            $data = array(
                'id' => $recordId
            );
            $paymentEntry = $this->client->call2('GetPaymentInfo', $data);  
            $paymentInfo = $paymentEntry->entry_list; 

            $paymentDetail = json_decode(html_entity_decode($paymentInfo->payment_detail));    
            
            if(!empty($paymentInfo)){
                $data = array(                    
                    'record_id' => $paymentInfo->id,      
                    'name' => $paymentInfo->name,     
                    'customer' => $paymentInfo->customer,       
                    'payment_date' => $paymentInfo->payment_date,      
                    'paymentAmount' => round($paymentInfo->payment_amount),                               
                    'paymentDetail' => $paymentDetail,
                    'paymentDetailJson' => $paymentInfo->payment_detail,  
                );    
            }          

        }
        else{
            $data = array(       
                'record_id' => '',      
                'name' => '',      
                'customer' => '',      
                'payment_date' => '',      
                'paymentAmount' => '',            
                'paymentDetail' => '',            
                'paymentDetailJson' => '',            
            );    
        }      

        $productList = $this->client->call2("GetProductList", array());
        $productList = $productList->entry_list;

        $data['customerList'] = $app_list_strings->entry_list->customer_options;
        $data['productList'] = $productList;

        return View::make('payment.edit')->with($data);    
    }        

    // Handle saving feedback
    public function save() {
        $session = Session::get('session');
        $user = Session::get('user');       

        $payDetailArr = array();
        foreach($_POST['product'] as $key => $value){
            if(empty($value)) continue;  
            if(empty($_POST['quantity'][$key])) continue;  
            if(empty($_POST['unit_cost'][$key])) continue;  
            if(empty($_POST['payment_amount'][$key])) continue;  

            $payDetailArr[] = array(
                'product'       => $_POST['product'][$key], 
                'quantity'      => $_POST['quantity'][$key], 
                'unit'          => $_POST['unit'][$key],    
                'unit_cost'     => $_POST['unit_cost'][$key],    
                'payment_amount'    => $_POST['pay_detail_amount'][$key], 
            );
        } 

        // Save user data
        $data = array(
            'id'                => Input::get('record_id'),          
            'name'              => Input::get('name'),           
            'customer'          => Input::get('customer'),           
            'payment_date'      => Input::get('payment_date'),                
            'payment_amount'    => Input::get('payment_amount'),             
            'payment_detail'    => $payDetailArr,             
        );

        $result = $this->client->call2('SavePayment', $data);

        // Return result into the view
        if(!empty($result)) {
            Session::flash('success_message', trans('payment_index.save_successful_msg'));
            return Redirect::to('payment/index');
        } else {
            Session::flash('error_message', trans('payment_edit.save_failed_msg'));
            return Redirect::back();
        }    
    }      
}
