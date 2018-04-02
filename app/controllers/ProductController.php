<?php  
class ProductController extends BaseController {

    public function index() {     
        $productList = $this->client->call2("GetProductList", array());             
                                                                    
        $data = array(
            'productList' => $productList->entry_list,
        );

        return View::make('product.index')->with($data);
    }

    // Render the add page
    public function edit() {
        $session = Session::get('session');
        $user = Session::get('user');  

        if(!empty($_REQUEST['id'])){
            $recordId = $_REQUEST['id'];
            $data = array(
                'id' => $recordId
            );
            $productEntry = $this->client->call2('GetProductInfo', $data);  
            $productInfo = $productEntry->entry_list;  
            if(!empty($productInfo)){
                $data = array(                    
                    'record_id' => $productInfo->id,      
                    'code' => $productInfo->code,      
                    'name' => $productInfo->name,      
                    'unit' => $productInfo->unit,      
                    'unit_cost' => round($productInfo->unit_cost),        
                );    
            }          

        }
        else{
            $data = array(       
                'record_id' => '',      
                'code' => '',      
                'name' => '',      
                'unit' => '',      
                'unit_cost' => '',       
            );    
        }    

        return View::make('product.edit')->with($data);    
    }

    // Handle saving feedback
    public function save() {
        $session = Session::get('session');
        $user = Session::get('user');       

        // Save user data
        $data = array(
            'id'            => Input::get('record_id'),          
            'name'          => Input::get('name'),           
            'unit'    => Input::get('unit'),                
            'unit_cost'  => Input::get('unit_cost'),             
        );

        $result = $this->client->call2('SaveProduct', $data);

        // Return result into the view
        if(!empty($result)) {
            Session::flash('success_message', trans('product_index.save_successful_msg'));
            return Redirect::to('product/index');
        } else {
            Session::flash('error_message', trans('product_edit.save_failed_msg'));
            return Redirect::back();
        }    
    }     
}
