<?php
    class GradebookController extends BaseController {

        public function index() {
            //$contact = Session::get('contact');  .
            if(!Session::get('session')) {
                return Redirect::to('home/index');
            }

            $class = SugarUtil::getClassOfStudent();
            $data = array(
                'classes' => $class,
            );

            return View::make('gradebook.index')->with($data);
        }

        public function getGradebookDetail() {
            $class_id = Input::get('class_id');
            $data = SugarUtil::getGradebookDetail($class_id);
            $data = $this->restructureGracebookDetail($data);
            $detail_htmls = array();
            $lang = trans('gradebook_index');
            // print_r($lang);
                 
            $htmlSummary = $this->displaySummaryGradebook($data, $lang);
            $htmlDetail = array(); 
            $htmlDetail['Progress'] = $this->displayProcessDetail($data, $lang);
            $htmlDetail['Commitment'] = $this->displayCommitmentDetail($data, $lang);
            
            

            return json_encode(array(
                'html' => $htmlSummary,
                'total_result' => '',
                'detail' => $htmlDetail,
            ));
            
            $gradebooks = $datas->gradebooks;
            for($i = 0; $i < count($gradebooks); $i++) {  
                $gradebook = $gradebooks[$i]; 
                $detail = $gradebook->detail;
                $detail_content = "<table class = 'gb_detail' width='100%'>
                <tbody>
                <tr>
                <td><b>{$lang['lbl_name']}:</b></td>
                <td>{$gradebook->name}</td>
                </tr>
                <tr>    
                <td><b>{$lang['lbl_class_name']}:</b></td>
                <td>{$gradebook->class_name}</td>
                </tr>
                <tr>
                <td><b>{$lang['lbl_dateinput']}:</b></td>
                <td>".(SugarUtil::formatDate($gradebook->date_input))."</td>
                </tr>
                <tr>
                <td><b>{$lang['lbl_center']}:</b></td>
                <td>{$gradebook->center_name}</td>
                </tr>
                <tr>
                <tr>
                <td><b>{$lang['lbl_teacher_comment']}:</b></td>
                <td>".$detail->comment."</td>
                </tr>
                <tr>
                </tbody>
                </tabel> 

                <div class= 'overflow-auto'>
                <table class = 'mark_detail table table-striped' width='100%'>
                <thead>
                <tr><th></th>";
                $header_html = '';
                $max_html = '';
                $mark_html = '';
                $weight_html = '';
                $per_html = '';
                for($j = 0; $j < count($detail->header); $j++){
                    $header_html.= "<th>{$detail->header[$j]}</th>"; 
                    $max_html.= "<td>{$detail->max[$j]}</td>"; 
                    $mark_html.= "<td>{$detail->mark[$j]}</td>"; 
                    $weight_html.= "<td>{$detail->weight[$j]}</td>"; 
                    $per_html.= "<td>{$detail->per[$j]}</td>"; 
                }
                $detail_content .= "$header_html </tr></thead>
                <tbody>
                <tr>
                <td>{$lang['lbl_weight']}</td>
                $weight_html
                </tr>
                <tr>    
                <td>{$lang['lbl_max_score']}</td> 
                $max_html                
                </tr>
                <tr>    
                <td>{$lang['lbl_score']}</td>
                $mark_html
                </tr>                   
                <tr>
                <td>{$lang['lbl_result']}</td>
                $per_html
                </tr>
                <tr>
                </tbody>
                </tabel> 
                </div>
                "; 
                // $detail_content = array(base64_encode($detail_content));
                $detail_htmls[$i] = $detail_content;
                $tr = "<tr>
                <td class = 'center'>".($i+1)."</td>
                <td>{$gradebook->name}</td>
                <td>{$gradebook->weight}</td>                 
                <td>".(SugarUtil::formatDate($gradebook->date_input))."</td>                 
                <td>".($gradebook->final_result * 100)."</td>                 
                <td>{$gradebook->center_name}</td>                 
                <td class='center'>
                <input name='detail' type = 'button' value = '{$lang['lbl_detail']}' class ='btn-info btn btn_detail' data='".$i."' >  
                </td>                  
                </tr>";
                $html.= $tr;
            }
            $html .= "</tbody>
            </table>             
            ";
            $total_result = "";
            $result = $datas->total;
            if( !empty($result) ) {
                $total_result = " <table id = 'gradebook_result' width='100%'>
                <thead>
                <tr>
                <td ><b>{$lang['lbl_final_result']}: </b></td>            
                <td ><b>{$result->mark}</b></td>            
                </tr> 
                </thead>  
                <tbody> 
                <tr>
                <td>{$lang['lbl_teacher_comment']}: </td>
                <td>".base64_decode($result->comment)."</td>
                </tbody>
                </table> 
                ";
            }

            if(!empty($result) && !empty($result->certificate_type) && $result->certificate_type != 'Fail') {
                $url = Config::get('app.url')."/gradebook/viewCertificate?class_id=$class_id";
                $total_result .= "
                <hr>
                <input name='detail' type = 'button' value = '{$lang['lbl_certificate']}' class ='btn-info btn btn_certificate' 
                onClick=\"window.open('$url','_blank')\" >  
                ";
            }

            return json_encode(array(
                'html' => $html,
                'total_result' => $total_result,
                'detail' => $detail_htmls,
            ));                
        }
        
        private function restructureGracebookDetail($data){
            $data = json_encode($data);
            $data = json_decode($data, true);
            
            $result = array(
                'Progress_Detail' => array(),
                'Summary' => array(),
            );
            
            foreach($data as $key => $value){
                switch($value["type"]){
                    case "Progress":
                        if(!empty($value['minitest'])){
                            $result['Progress_Detail'][] = $value;
                        } 
                        else{
                            $result['Summary']['Progress'] = $value;
                        }
                    
                        break;
                    case "Commitment":
                        $result['Summary']['Commitment'] = $value;
                        break;
                    case "Overall":
                        $result['Summary']['Overall'] = $value;
                        break;
                }   
            }  
            
            return $result;  
        }

        private function displaySummaryGradebook($data, $lang){
            $html = "";
            $html = "<table id = 'gradebook_content' class = 'table table-striped' width='100%'>
            <thead>
            <tr>
            <td ><b>".$lang['lbl_no']."</b></td>            
            <td ><b>".$lang['lbl_name']."</b></td>            
            <td ><b>".$lang['lbl_weight']."</b></td>
            <td ><b>".$lang['lbl_dateinput']."</b></td>
            <td ><b>".$lang['lbl_total_result']."</b></td>                      
            <td ><b>".$lang['lbl_center']."</b></td>            
            <td ><b></b></td>            
            </tr> 
            </thead>  
            <tbody> ";                     
            
            $counter = 1;                      
            foreach($data['Summary'] as $key => $gradebook){
                $btn = "";
                if($key != "Overall")
                    $btn = "<input name='detail' type = 'button' value = '{$lang['lbl_detail']}' class ='btn-info btn btn_detail' data='".$key."' >";
                
                $tr = "<tr>
                <td class = 'center'>".($counter)."</td>
                <td>{$gradebook['type']}</td>
                <td>{$gradebook['weight']}</td>                 
                <td>".(SugarUtil::formatDate($gradebook['date_input']))."</td>                 
                <td>".($gradebook['result'])."</td>                 
                <td>{$gradebook['center']}</td>                 
                <td class='center'>
                $btn  
                </td>                  
                </tr>";   
                $html .= $tr;
                $counter++;  
            }   
            $html .= "</tbody>
            </table>             
            "; 
            
            return $html;
        }
        
        private function displayProcessDetail($data, $lang){
            $html = "
            ";
            
            foreach($data['Progress_Detail'] as $key => $gradebook){ 
                $thead = "";
                $tbody = "";
                foreach($gradebook['detail'] as $label => $detail){
                    if($label != "Overall(%)"){
                        $header = $label."<br> ({$detail['weight']}%)";   
                        $mark = $detail['mark']." / ".$detail['mark'];
                        $thead .= "<th>$header</th>";
                    }
                    else{
                        $header = $label; 
                        $mark = $detail['mark']."%";   
                        $thead .= "<th class='th_gb_detail_overall'>$header</th>";
                    }  
                    
                    $tbody .= "<td class='td_gb_detail_value'>$mark</td>"; 
                }
                
                $table = "<table width='100%' class='table table-striped tbl_gb_detail'>
                <thead><tr>
                <th class='th_gb_detail_name'>{$gradebook['minitest']}</th>
                $thead
                </tr></thead>
                <tbody><tr>
                <td></td>
                $tbody
                </tr></tbody>
                ";
                
                $html .= "
                $table<br><br>"; 
            } 
            
            $html .= "";
            
            return $html;
        }
        
        private function displayCommitmentDetail($data, $lang){
            $thead = "";
            $tbody = "";

            foreach($data['Summary']['Commitment']['detail'] as $label => $gradebook){ 
                $mark = $gradebook['mark'];
                $thead .= "<th>$label</th>"; 
                $tbody .= "<td>$mark</td>"; 
            } 

            $html = "<table width='100%' class='table table-striped tbl_gb_detail'> 
            <thead><tr>
            $thead
            </tr></thead>
            <tbody><tr>
            $tbody
            </tr></tbody>
            "; 

            return $html;
        }
        
        public function viewCertificate() {   
            $classID = Input::get('class_id');             
            $data = SugarUtil::getCertificate($classID);   
            //  'https://view.officeapps.live.com/op/view.aspx?src='.$GLOBALS['sugar_config']['site_url'].'/'.$file;       
            // return Redirect::to('https://docs.google.com/viewer?url='.$data->file_url); 
            if(isset($data->file_url)) {       
                //print_r($data)  ;die;
                //return Redirect::to('https://docs.google.com/viewer?url='.$data->file_url);
                return Redirect::to('https://view.officeapps.live.com/op/view.aspx?src='.$data->file_url);           
            } else {
                echo "<h2>Had error! Try again!</h2>";
                die;
            }
        }
    }
