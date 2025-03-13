<?php

namespace App\Modules\Serviceproviderapplications\Controllers;
use App\Modules\Serviceproviderapplications\Controllers\Notification;
use App\Controllers\BaseController;
use App\Models\CommonModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// require_once (APPPATH . '../PHPMailer/src/PHPMailer.php');
// require_once (APPPATH . '../PHPMailer/src/SMTP.php');
// require_once (APPPATH . '../PHPMailer/src/Exception.php');
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

class Serviceproviderapplications extends BaseController
{

    private $web_api = "AAAAL-aXCxQ:APA91bEjUvvNvKYALAcl9PjtxvvUwJTqMsvXdJNETqyvqIt_JQPP-QlTO9POH8XYz1DFC3HflKfgYT_u21j1lK7-tn6OPsMz51yeNMxA8FRu5eXpnoA8S4WWhN4bM8MO51E8R3nlSGrl";
    private $service_provider_web_api = "AAAAFQZ1I50:APA91bF7Il94rQ6BXC7CYcKoBtFDtum6CUDVNbbjMvKPazHnNLiMVa0PKhXw4aSmpPlWgjW7Jt3yJKWIKxOO898RxrgpLrkEz9xCE1R8PxXKW6ogr9Z44SKBwkXSw3KNpYkKUi3SsO0_";


    public function __construct()
    {
        $this->CommonModel = new CommonModel();
        $this->notification = new Notification;
        $this->table = "sop_applications";
        helper(['form', 'url']);
    }

    // Index
    public function index()
    {

        $data['page_title'] = 'SOP Applications';
        $data['page_headline'] = 'SOP Applications';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['order']   = $this->CommonModel->get_all_data($this->table);
        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Serviceproviderhome\Views\service_provider_sidebar', $data);
        echo view('App\Modules\Serviceproviderapplications\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }
    
    public function get_data()
    {
       
        $session = session()->get('service_provider_session');
        $service_provider_id = $session['id'];
       
        $where = '';
        $where .= " WHERE service_provider_id = $service_provider_id and is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( applicant_name LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( applicant_no LIKE '%" . $_REQUEST['search']['value'] . "%' )";
           
        }

        $totalRecordsSql = "SELECT * FROM sop_applications $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array( 
            0 => 'id',
            1 => 'id',
            2 => 'applicant_no',
            3 => 'applicant_name',
            4 => 'contact',
            5 => 'draft_status',
            6 => 'email',
            7 => 'sop_application_document',
            8 => 'created',
            9 => 'deadline',
            10 => 'modification_message',
            
        );

        $sql = "SELECT *";
        $sql .= " FROM sop_applications $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);
        

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $filter = array("id" => $row->service_provider_id);
            $service_provider = $this->CommonModel->get_single("service_providers",$filter);

            if(!empty($service_provider))
            {
                $data['service_provider'] = $service_provider->name;
            }
            else
            {
                $data['service_provider'] = "Not Assigned";
            }
            
            $data['no']         = ++$count;
            $data['id']         = $row->id;
            $data['application_no']       = $row->application_no;
            $data['applicant_name']       = $row->applicant_name;
            $data['contact']       = $row->contact;
            $data['email']       = $row->email;
            $data['sop_application_document']       = $row->sop_application_document;
            $data['modification_message']       = $row->modification_message;
            
            $application_deadline   = strtotime($row->deadline); 
            $secondsLeft            = $application_deadline - time();
            $days                   = floor($secondsLeft / (60*60*24)); 
            $hours                  = floor(($secondsLeft - ($days*60*60*24)) / (60*60));
            //$data['deadline']       = $hours." Hour(s) Left";
            
            if($row->deadline == "")
            {
               $data['deadline']       = ""; 
            }
            else
            {
                if($row->application_status == "Completed")
                {
                    $data['deadline'] = "Completed";
                }
                else
                {
                    if($hours == 1)
                    {
                        $data['deadline']       = "Only ".$hours." Hour(s) Left";
                    }
                    else
                    {
                        $data['deadline']       = $hours." Hour(s) Left";
                    }
                    
                }
                
            }
  
            $data['application_status']     = $row->application_status;
            $data['draft_status']     = $row->draft_status;
            $data['status']     = $row->status;
            $data['payment_status']     = $row->payment_status;
            $data['edit_mode']     = $row->edit_mode;
            $data['created']    = $row->created;
            


            array_push($data_array, $data);
        }

        $json_data = array(
            "draw"            => intval($_REQUEST['draw']),
            "recordsTotal"    => intval($totalRecords),
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data_array
        );

        return json_encode($json_data);
    }
    
   

    public function get_application_details()
    {
        $id = $this->request->getVar('id');


        $filter = array("id" => $id);
        $application = $this->CommonModel->get_single('sop_applications', $filter);
        
      
        $user_id = $application->user_id;
        $package_id = $application->package_id;

        ////////////////  Get User  ///////////////////////
        $filter = array("id" => $user_id);
        $user_details =  $this->CommonModel->get_single('user_master', $filter);
        
        ////////////////  Get Package  ///////////////////////
        $filter = array("id" => $package_id);
        $package_details =  $this->CommonModel->get_single('sop_packages', $filter);
        
       ////////////////  Get Sop Service  ///////////////////////
        $filter = array("id" => $package_details->sop_service_id);
        $service_details =  $this->CommonModel->get_single('sop_services', $filter);
        
       ////////////////  Get Country  ///////////////////////
        $filter = array("id" => $package_details->sop_country_id);
        $country_details =  $this->CommonModel->get_single('sop_countries', $filter);
    
        ////////////////  Model  ///////////////////////
        $modal_title = 'Application No : #' . $application->application_no;
        
        
        if($application->draft_status == 1)
        {
            $draft_status = "In Draft";
            $draft_desc = "label-warning";
        }
        else
        {
            $draft_status = "Published";
            $draft_desc = "label-primary";
        }
        
         if($application->status == 1)
        {
            $app_status = "Active";
            $app_desc = "label-primary";
        }
        else
        {
            $app_status = "InActive";
            $app_desc = "label-warning";
        }
        
        
        if($application->payment_status == 1)
        {
            $payment_status = "Paid";
            $payment_desc = "label-primary";
        }
        else
        {
            $payment_status = "Unpaid";
            $payment_desc = "label-danger";
        }
        
        $base_url = base_url()."/uploads/documents/";
        
        $personal_details = '
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">Package Details</h4>
                                <div class="list-group">
                                    <p class="list-group-item"><i class="fas fa-user m-r-10"></i> Service : ' . $service_details->name . ' </p>
                                    <p class="list-group-item"><i class="fas fa-envelope m-r-10"></i> Country : ' . $country_details->name . '</p>
                                    <p class="list-group-item"><i class="fas fa-phone m-r-10"></i> Package : ' . $package_details->name . '</p>
                                    <p class="list-group-item"><i class="fas fa-calendar-alt m-r-10"></i>  Price : ' . $package_details->price . '</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="card-title">Updates</h4>
                                <div class="list-group">
                                    <p class="list-group-item"><i class="fas fa-file-alt m-r-10"></i> Draft Status : <span class="label ' . $draft_desc . ' font-weight-100"> ' . $draft_status . ' </span></p>
                                    <p class="list-group-item"><i class="fas fa-file-alt m-r-10"></i> Application Status : <span class="label ' . $app_desc . ' font-weight-100"> ' . $app_status . ' </span></p>
                                    <p class="list-group-item"><i class="fas fa-file-alt m-r-10"></i> Process : <span class="label label-info font-weight-100"> ' . $application->application_status . ' </span></p>
                                    
                                </div>
                            </div>
                        </div>
                        <br/>
                        
                        <div class="row">
                            <div class="col-4">
                                <h4 class="card-title">Applicant Details</h4>
                                <div class="list-group">
                                    <p class="list-group-item"><i class="fas fa-user m-r-10"></i> Applicant Name : ' . $application->applicant_name . ' </p>
                                    <p class="list-group-item"><i class="fas fa-map m-r-10"></i> State : ' . $application->state . '</p>
                                    <p class="list-group-item"><i class="fas fa-map m-r-10"></i> City : ' . $application->city . '</p>
                                    <p class="list-group-item"><i class="fas fa-calendar-alt m-r-10"></i>  Date : ' . $application->created . '</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <h4 class="card-title">Father Details</h4>
                                <div class="list-group">
                                    <p class="list-group-item"><i class="fas fa-file-alt m-r-10"></i> Father Name : ' . $application->father_name . '</p>
                                    <p class="list-group-item"><i class="fas fa-file-alt m-r-10"></i> Father Employment Status : ' . $application->father_employment_status . '</p>
                                    <p class="list-group-item"><i class="fas fa-file-alt m-r-10"></i> Father Company Name : ' . $application->father_company_name . '</p>
                                    <p class="list-group-item"><i class="fas fa-file-alt m-r-10"></i> Father Designation : ' . $application->father_designation . '</p>
                                    
                                </div>
                            </div>
                            <div class="col-4">
                                <h4 class="card-title">Mother Details</h4>
                                <div class="list-group">
                                    <p class="list-group-item"><i class="fas fa-file-alt m-r-10"></i> Mother Name : ' . $application->mother_name . '</p>
                                    <p class="list-group-item"><i class="fas fa-file-alt m-r-10"></i> Mother Employment Status : ' . $application->mother_employment_status . '</p>
                                    <p class="list-group-item"><i class="fas fa-file-alt m-r-10"></i> Mother Company Name : ' . $application->mother_company_name . '</p>
                                    <p class="list-group-item"><i class="fas fa-file-alt m-r-10"></i> Mother Designation : ' . $application->mother_designation . '</p>
                                </div>
                            </div>
                        </div>
                        
                        <br/>';
                    
         
                    
                    $personal_details .= '<h4 class="card-title">Family Details</h4>';
                    
                    $personal_details .= '<div class="row">';
                   
                    $filter = array("user_id" => $application->user_id, "is_deleted" => 0);
                    $family_members = $this->CommonModel->get_by_condition("family_details",$filter);
                    foreach($family_members as $row)
                    {
                        $personal_details .= '<div class="col-6">
                                                    <div class="list-group" style="margin-bottom: 15px;">';
                                                    
                                                        $personal_details .= '<p class="list-group-item">   Relation : <span class="badge badge-pill badge-primary">' . $row->relation . '</span></p>';
                                                        $personal_details .= '<p class="list-group-item">   Name : ' . $row->name . '</p>';
                                                        $personal_details .= '<p class="list-group-item">   Profession : ' . $row->profession . '</p>';
                                                        
                                                        if($row->relation == "Father" || $row->relation == "Mother")
                                                        {
                                                            $personal_details .= '<p class="list-group-item">   Company Name : ' . $row->company_name . '</p>';
                                                            $personal_details .= '<p class="list-group-item">   Designation : ' . $row->designation . '</p>';
                                                        }
                                                        
                                                        if($row->relation == "Brother" || $row->relation == "Sister")
                                                        {
                                                            $personal_details .= '<p class="list-group-item">   Elder/Younger : ' . $row->elder_younger . '</p>';
                                                            
                                                            if($row->profession == "Study")
                                                            {
                                                                $personal_details .= '<p class="list-group-item">   Profession : ' . $row->profession . '</p>';
                                                                $personal_details .= '<p class="list-group-item">   Education : ' . $row->education . '</p>';
                                                            }
                                                            else
                                                            {
                                                                $personal_details .= '<p class="list-group-item">   Profession : ' . $row->profession . '</p>';
                                                                $personal_details .= '<p class="list-group-item">   Company Name : ' . $row->company_name . '</p>';
                                                                $personal_details .= '<p class="list-group-item">   Designation : ' . $row->designation . '</p>';
                                                            }
                                                        }
                                                        
                        $personal_details .=     '</div>';
                        $personal_details .= '</div>';
                        
                        $personal_details .= '<br>';
                    }
                    $personal_details .= '</div>';
    
$personal_details .= '<br/>
                    <div class="row">
                        <div class="col-12">
                        
                            <h4 class="card-title">Uploaded Documents</h4>
                            <table class="table table-striped table-bordered show-child-rows w-100">
                                <tr>
                                    <th>No.</th>
                                    <th>Document Name</th>
                                    <th>View</th>
                                    <th>Download</th>
                                </tr>
                                <tbody> 
                                    <tr>
                                        <td>1</td>
                                        <td>Employment/Gap Evidence/Internship/Training Certificate/Extra Currriculam</td>';
                                        if($application->employment_certificate =="")
                                        {
                                             $personal_details .= '<td>Not Uploaded</td>';
                                             $personal_details .= '<td>Not Uploaded</td>';
                                        }
                                        else
                                        {
                                            $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->employment_certificate.'">View</a></td>';
                                            $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->employment_certificate.'">Download</a></td>';
                                        }
                                    $personal_details .= '</tr>';
                                    
                                    
                            $personal_details .= '         <tr>
                                        <td>2</td>
                                        <td>Passsport Copy  & Visa Stamp</td>';
                                        if($application->passport_copy =="")
                                        {
                                             $personal_details .= '<td>Not Uploaded</td>';
                                             $personal_details .= '<td>Not Uploaded</td>';
                                        }
                                        else
                                        {
                                            $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->passport_copy.'">View</a></td>';
                                            $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->passport_copy.'">Download</a></td>';
                                        }
                                    $personal_details .= '</tr>';
                                    
                            $personal_details .= '         <tr>
                                <td>3</td>
                                <td>SSC/HSC, Diploma, Bachelor, Master, Any Academic Certificate</td>';
                                if($application->course_certificate =="")
                                {
                                     $personal_details .= '<td>Not Uploaded</td>';
                                     $personal_details .= '<td>Not Uploaded</td>';
                                }
                                else
                                {
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->course_certificate.'">View</a></td>';
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->course_certificate.'">Download</a></td>';
                                }
                            $personal_details .= '</tr>';
                                    
                            $personal_details .= '         <tr>
                                <td>4</td>
                                <td>Marriage Certificate</td>';
                                if($application->marriage_certificate =="")
                                {
                                     $personal_details .= '<td>Not Uploaded</td>';
                                     $personal_details .= '<td>Not Uploaded</td>';
                                }
                                else
                                {
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->marriage_certificate.'">View</a></td>';
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->marriage_certificate.'">Download</a></td>';
                                }
                            $personal_details .= '</tr>';
                            
                            
                            $personal_details .= '         <tr>
                                <td>5</td>
                                <td>IELTS Or Other Language Test Certificate</td>';
                                if($application->ielts_certificate =="")
                                {
                                     $personal_details .= '<td>Not Uploaded</td>';
                                     $personal_details .= '<td>Not Uploaded</td>';
                                }
                                else
                                {
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->ielts_certificate.'">View</a></td>';
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->ielts_certificate.'">Download</a></td>';
                                }
                            $personal_details .= '</tr>';
                            
                            $personal_details .= '         <tr>
                                <td>6</td>
                                <td>Offer Letter</td>';
                                if($application->offer_letter =="")
                                {
                                     $personal_details .= '<td>Not Uploaded</td>';
                                     $personal_details .= '<td>Not Uploaded</td>';
                                }
                                else
                                {
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->offer_letter.'">View</a></td>';
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->offer_letter.'">Download</a></td>';
                                }
                            $personal_details .= '</tr>';
                            
                            
                            $personal_details .= '         <tr>
                                <td>7</td>
                                <td>Loan Letter</td>';
                                if($application->loan_letter =="")
                                {
                                     $personal_details .= '<td>Not Uploaded</td>';
                                     $personal_details .= '<td>Not Uploaded</td>';
                                }
                                else
                                {
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->loan_letter.'">View</a></td>';
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->loan_letter.'">Download</a></td>';
                                }
                            $personal_details .= '</tr>';
                            
                            $personal_details .= '         <tr>
                                <td>8</td>
                                <td>Tuition Fee Receipt</td>';
                                if($application->tuition_fee_receipt =="")
                                {
                                     $personal_details .= '<td>Not Uploaded</td>';
                                     $personal_details .= '<td>Not Uploaded</td>';
                                }
                                else
                                {
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->tuition_fee_receipt.'">View</a></td>';
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->tuition_fee_receipt.'">Download</a></td>';
                                }
                            $personal_details .= '</tr>';
                            
                            $personal_details .= '         <tr>
                                <td>9</td>
                                <td>GIC, FTS, Any Fund Related Doc</td>';
                                if($application->fund_related_doc =="")
                                {
                                     $personal_details .= '<td>Not Uploaded</td>';
                                     $personal_details .= '<td>Not Uploaded</td>';
                                }
                                else
                                {
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->fund_related_doc.'">View</a></td>';
                                    $personal_details .= '<td><a target="_blank" href="'.$base_url.$application->fund_related_doc.'">Download</a></td>';
                                }
                            $personal_details .= '</tr>';
                            
                           
                            
                            $personal_details .= '         <tr>
                                <td>10</td>';
                                if($application->any_remark =="")
                                {
                                     $personal_details .= '<td>Other Remark</td>';
                                     $personal_details .= '<td>-</td>';
                                     $personal_details .= '<td-</td>';
                                }
                                else
                                {
                                    $personal_details .= '<td>Other Remark : '.$application->any_remark.'</td>';
                                    $personal_details .= '<td>-</td>';
                                    $personal_details .= '<td>-</td>';
                                }
                            $personal_details .= '</tr>';
                                    
                                    
                                    
                    $personal_details .= '</tbody>
                            </table>
                            
                            
                            
                           
                        </div>
                       
                       
                    </div>
                    
        ';



        ////////////////  Table  ///////////////////////

        $result_html = '';
        $count = 0;

        $message = ['status' => '1', 'message' => 'Data Fetched!', 'table_data' => $result_html, 'personal_details' => $personal_details, 'modal_title' => $modal_title];
        echo json_encode($message);
        die;
        return $this->response->setJSON($message);
    }
    
    public function send_notification($token_array,$title,$message)
    {
     	$imageUrl   = ""; 
    	if(isset($title))
    	{
    		require_once __DIR__ . '/Notification.php';
    		$notification = $this->notification;
    		$notification->setTitle($title);
    		$notification->setMessage($message);
    		$notification->setImage($imageUrl);
    		$firebase_api = $this->web_api;
    		$requestData = $notification->getNotificatin();
    		$fields = array(
    			'registration_ids' => $token_array,
    			'data' => $requestData,
    			'priority' => 'high',
    			'notification' => array(
    			'title' => $title,
    			'body' => $message,
    			'image' => $imageUrl,
    			)
    		);
    		$url = 'https://fcm.googleapis.com/fcm/send';
    
    		$headers = array(
    			'Authorization: key=' . $firebase_api,
    			'Content-Type: application/json'
    			);
    	
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, $url);
    		curl_setopt($ch, CURLOPT_POST, true);
    		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    		$result = curl_exec($ch);
    		if($result === FALSE){
    			die('Curl failed: ' . curl_error($ch));
    		}
    		curl_close($ch);
    //  		echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
    //  		echo json_encode($fields,JSON_PRETTY_PRINT);
    //  		echo '</pre></p><h3>Response </h3><p><pre>';
    //  		echo $result;
    // 		echo '</pre></p>';
    // 		die;
    	}
    	
    }
    
    
    public function send_push_notification($token_array,$title,$message)
    {
     	$imageUrl   = ""; 
    	if(isset($title))
    	{
    		require_once __DIR__ . '/Notification.php';
    		$notification = $this->notification;
    		$notification->setTitle($title);
    		$notification->setMessage($message);
    		$notification->setImage($imageUrl);
    		$firebase_api = $this->service_provider_web_api;
    		$requestData = $notification->getNotificatin();
    		$fields = array(
    			'registration_ids' => $token_array,
    			'data' => $requestData,
    			'priority' => 'high',
    			'notification' => array(
    			'title' => $title,
    			'body' => $message,
    			'image' => $imageUrl,
    			)
    		);
    		$url = 'https://fcm.googleapis.com/fcm/send';
    
    		$headers = array(
    			'Authorization: key=' . $firebase_api,
    			'Content-Type: application/json'
    			);
    	
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, $url);
    		curl_setopt($ch, CURLOPT_POST, true);
    		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    		$result = curl_exec($ch);
    		if($result === FALSE){
    			die('Curl failed: ' . curl_error($ch));
    		}
    		curl_close($ch);
    //  		echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
    //  		echo json_encode($fields,JSON_PRETTY_PRINT);
    //  		echo '</pre></p><h3>Response </h3><p><pre>';
    //  		echo $result;
    // 		echo '</pre></p>';
    // 		die;
    	}
    	
    }
    
    
    public function upload_sop_document()
    {
        
        $application_id = $this->request->getVar('upload_application_id');
        $sop_document   = $this->request->getVar('sop_document');
        
        $tmp            = explode(".",$_FILES["sop_document"]["name"]);
        $file_extension = end($tmp);
        $newfilename    = time() . '_' . rand(100, 999) . '.' . $file_extension;
        
        $data['sop_document']       = $newfilename;
        $file_name                  = $newfilename;
        $file_path                  = $_FILES['sop_document']['tmp_name'];
        $file_error                 = $_FILES['sop_document']['error'];

        $file_destination ='uploads/sop_documents/'.$file_name;
        
        if(move_uploaded_file($file_path, $file_destination))
        {
            $filter  = array("id" => $application_id);
            $update_data = array('sop_application_document' => $newfilename);
            $update = $this->CommonModel->update_data("sop_applications",$update_data,$filter);	
            
            if($update != false)
            {
                $filter = array("id" => $application_id);
                $update_data = array("application_status" => 'SOP Document Sent');
                $update = $this->CommonModel->update_data('sop_applications', $update_data, $filter);

                $data = ['status' => '1', 'message' => 'Document uploaded.'];
        		echo json_encode($data);
        		die;
            }
            else
            {
                $data = ['status' => '0', 'message' => 'Something went wrong.'];
        		echo json_encode($data);
        		die;
            }
        }
        
    }
    
    
    public function conversation()
    {

        $data['page_title'] = 'Coversation';
        $data['page_headline'] = 'Conversation';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['order']   = $this->CommonModel->get_all_data($this->table);
        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);
        
        $application_id = $this->request->uri->getSegment(3);
        
        $filter = array("id" => $application_id);
        $data['application_details'] = $this->CommonModel->get_single("sop_applications",$filter);
        $application_details = $this->CommonModel->get_single("sop_applications",$filter);
        
        $data['application_id'] = $application_id;
        $data['service_provider_id']    = $application_details->service_provider_id;
        


        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Serviceproviderhome\Views\service_provider_sidebar', $data);
        echo view('App\Modules\Serviceproviderapplications\Views\conversation', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }
    
    
    public function get_conversation()
    {
        $application_id = $this->request->uri->getSegment(3);
        
        $query = "select * from service_provider_user_conversations where application_id = $application_id";
 
        $result = $this->CommonModel->custome_query($query);
    
        $conversation   =  ''; 
        
        $conversation .= '<ul class="chat-list">';
        $base_url = base_url().'admin_theme/';
        
        
            
                if(!empty($result))
                {
                    foreach($result as $row)
                    {
                        $orgDate    = $row->created;
                        $msg_date_time = date("d-m-Y h:i A", strtotime($orgDate));
                        
                        
                        if($row->user_id == 0)
                        {
                            $full_name = "User";  
                            $profile_image = base_url()."uploads/static/user.png";
                            
                        }
                        else
                        {
                           
                            $filter = array("id" => $row->user_id);
                            $user_data = $this->CommonModel->get_single("user_master",$filter);
                            
                            $full_name = $user_data->firstname." ".$user_data->lastname;
                            
                            if($user_data->profile_picture != "")
                            {
                                $profile_image = base_url()."uploads/customers/".$user_data->profile_picture;
                            }
                            else
                            {
                                $profile_image = base_url()."uploads/static/user.png";
                            } 
                        }
                        
                        if($row->message_by == "service_provider")
                        {
                            if($row->message_type == 0)
                            {
                            
                                $conversation .= '  <li class="odd chat-item">
                                                    <div class="chat-content">
                                                        <div class="box bg-light-inverse">'.$row->message.'</div>
                                                        <br>
                                                    </div>
                                                    <div class="chat-time">'.$msg_date_time.'</div>
                                                </li>';    
                                
                               
                            }
                            else
                            {
                                
                                
                                $conversation .= '  <li class="odd chat-item">
                                                    <div class="chat-content">
                                                        <a href="#"><div class="box bg-light-inverse">View Attachment</div></a>
                                                        <br>
                                                    </div>
                                                    <div class="chat-time">'.$msg_date_time.'</div>
                                                </li>';
                            }
                            
                        }
                        else
                        {
                           if($row->message_type == "0")
                           {
                               
                               $conversation .= '  <li class="chat-item">
                                                <div class="chat-img">
                                                    <img src="'.$profile_image.'" alt="user">
                                                </div>
                                                <div class="chat-content">
                                                    <h6 class="font-medium">'.$full_name.'</h6>
                    
                                                    <div class="box bg-light-info">'.$row->message.'</div>
                                                </div>
                                                <div class="chat-time">'.$msg_date_time.'</div>
                                            </li>'; 

                           }
                           else
                           {
                                $conversation .= '  <li class="chat-item">
                                                <div class="chat-img">
                                                    <img src="'.$profile_image.'" alt="user">
                                                </div>
                                                <div class="chat-content">
                                                    <h6 class="font-medium">'.$full_name.'</h6>
                                                    <a href="#"><div class="box bg-light-info">View Attachment</div></a>
                                                </div>
                                                <div class="chat-time">'.$msg_date_time.'</div>
                                            </li>'; 
                           }
                        }
                        
                    }
                }

        
        $conversation .= '</ul>';        
        
        $message = ['status' => '1', 'message' => 'Data Fetched!', 'conversation' => $conversation];
        echo json_encode($message);
        die;
        
    }
    
    public function send_message()
    {
       

        $message        = $this->request->getVar('message');
        $application_id      = $this->request->getVar('application_id');
        $service_provider_id        = $this->request->getVar('service_provider_id');
        $message_by     = "service_provider";
        $message_type   = "0";
        $created        = date("Y-m-d H:i:s");
        
        $orgDate    = $created;
        $msg_date_time = date("d-m-Y h:i A", strtotime($orgDate));

        // $image_info = getimagesize($_FILES["image"]["tmp_name"]);
        // $image_width = $image_info[0];
        // $image_height = $image_info[1];

        // $tmp            = explode(".",$_FILES["image"]["name"]);
        // $file_extension = end($tmp);
        // $newfilename    = time() . '_' . rand(100, 999) . '.' . $file_extension;
        
        // $data['image']      = $newfilename;
        // $file_name          = $newfilename;
        // $file_path          = $_FILES['image']['tmp_name'];
        // $file_error         = $_FILES['image']['error'];

        // $file_destination ='uploads/sop_services/'.$file_name;
        // move_uploaded_file($file_path, $file_destination);
        

        $created = date("Y-m-d H:i:s");
        
        $insert_data = array(
                                "application_id"         => $application_id,
                                "service_provider_id"           => $service_provider_id,
                                "message"           => $message,
                                "message_by"        => $message_by,
                                "message_type"      => $message_type,
                                "created"           => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('service_provider_user_conversations', $insert_data);
        
        if ($insert != false) 
        {
            
            $new_message = '<li class="odd chat-item">
                                <div class="chat-content">
                                    <div class="box bg-light-inverse">'.$message.'</div>
                                    <br>
                                </div>
                                <div class="chat-time">'.$msg_date_time.'</div>
                            </li>';
            
            
            $message = ['status' => '1', 'new_message' => $new_message, 'message' => 'New Message has been added!'];
            return json_encode($message);
            die;
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
            die;
        }
    }
    
    public function send_edit_message()
    {
        $application_id = $this->request->getVar('edit_application_id');
        $edit_message = $this->request->getVar('edit_message');
        
        $filter         = array("id" => $application_id);
        $update_data    = array("edit_mode" => 1 , "edit_message" => $edit_message);
        $update         = $this->CommonModel->update_data($this->table, $update_data, $filter);

       if ($update != false) 
       {
            $filter             = array("id" => $application_id);
            $application_data   = $this->CommonModel->get_single($this->table,$filter);
           
            $title          = "Alert : Require information about your SOP Application";
            $message        = $edit_message;
            
            $filter         = array("id" => $application_data->user_id);
            $user           = $this->CommonModel->get_single("user_master",$filter);
            $token          = $user->token;
            $token_array    = array($token);
            
            $imageUrl   = ""; 
    
    		require_once __DIR__ . '/Notification.php';
    		$notification = $this->notification;
    		$notification->setTitle($title);
    		$notification->setMessage($message);
    		$notification->setImage($imageUrl);
    		$firebase_api = $this->web_api;
    		$requestData = $notification->getNotificatin();
    		$fields = array(
    			'registration_ids' => $token_array,
    			'data' => $requestData,
    			'priority' => 'high',
    			'notification' => array(
    			'title' => $title,
    			'body' => $message,
    			'image' => $imageUrl,
    			)
    		);
    		$url = 'https://fcm.googleapis.com/fcm/send';
    
    		$headers = array(
    			'Authorization: key=' . $firebase_api,
    			'Content-Type: application/json'
    			);
    	
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, $url);
    		curl_setopt($ch, CURLOPT_POST, true);
    		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    		$result = curl_exec($ch);
    		if($result === FALSE){
    			die('Curl failed: ' . curl_error($ch));
    		}
    		curl_close($ch);
     		/*echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
     		echo json_encode($fields,JSON_PRETTY_PRINT);
     		echo '</pre></p><h3>Response </h3><p><pre>';
     		echo $result;
    		echo '</pre></p>';
    		die;*/
           
            $message = ['status' => '1', 'message' => 'Edit Message Sent to the user!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Status Not Updated!'];
            return json_encode($message);
        }
    }
    
    public function change_application_status()
    {
        
        $application_status = $this->request->getVar('status');
        $application_id = $this->request->getVar('id');

        $filter = array("id" => $application_id);
        $update_data = array("application_status" => $application_status);
        $update = $this->CommonModel->update_data('sop_applications', $update_data, $filter);

    
        if ($update != false) {
            
            
            $filter = array("id" => $application_id);
            $application_data = $this->CommonModel->get_single("sop_applications",$filter);
            $user_id = $application_data->user_id;
            
            if ($application_status == "Submitted") 
            {
                $title = "SOP Application Update";
                $message = "Your Application is Submitted Successfully ! We will get back to you shortly.";
            } 
            else if ($application_status == "Documents Under Verification") 
            {
                $title = "SOP Application Update";
                $message = "Your Application is Under Review ! Document Verfication In Process ! We will deliver your order in short time.";
            } 
            else if ($application_status == "Service Provider Assigned") 
            {
                $title = "SOP Application Update";
                $message = "Service Provider Assigned ! Your Application is now processing ! We will get back to you soon.";
            } 
            else if ($application_status == "SOP Document Sent") 
            {
                $title = "SOP Application Update";
                $message = "Greetings ! We have sent the SOP Document Please Check your Application";
            } 
            else if ($application_status == "Completed") 
            {
                
                
             /////Insert Transaction/////
               
               $amount = $application_data->package_price - $application_data->fees;
               
               $insert_data = array(
                                        "application_id"        => $application_id,
                                        "service_provider_id"   => $application_data->service_provider_id,
                                        "type"                  => "credit",
                                        "amount"                => $amount,
                                        "created"               => date('Y-m-d H:i:s')
                                    );
               $insert = $this->CommonModel->common_insert_data("transactions",$insert_data);
               
                 //Extra benefit///
                
                
                if($application_data->missed_deadline == 1)
                {
                    $filter             = array("id" => $application_data->service_provider_id);
                    $service_provider   = $this->CommonModel->get_single("service_providers",$filter);
    
                    $commission = $application_data->package_price * $service_provider->commission / 100;
    
                    $filter = array("id" => 1);
                    $setting = $this->CommonModel->get_single("setting",$filter);
                    
                    $missed_deadline_benefits   = $setting->missed_deadline_benefits;
                    
                        //echo 'deadline is missed';
                       $extra_benefit_commission = $service_provider->commission - $missed_deadline_benefits;
                       
                       if($extra_benefit_commission == 0)
                       {
                           $extra_benefit = $commission;
                       }
                       else
                       {
                            $extra_benefit = $application_data->package_price * $extra_benefit_commission / 100;
                       }
                    
                   
                    $insert_data = array(
                                        "application_id"        => $application_id,
                                        "service_provider_id"   => $application_data->service_provider_id,
                                        "type"                  => "benefit",
                                        "amount"                => $extra_benefit,
                                        "created"               => date('Y-m-d H:i:s')
                                    );
                    $insert = $this->CommonModel->common_insert_data("transactions",$insert_data);
               }
                
                
                
                $title = "SOP Application Update";
                $message = "SOP Application Delivered ! Thanks for orderding";
            } 
            
          
            $data['application_data'] = $this->CommonModel->get_single("sop_applications",$filter);
            $data['title']=$title;
            $data['message']=$message;
            $data['user']=$this->CommonModel->get_single("user_master",array('id'=>$application_data->user_id));

            $filter         = array("id" => $user_id);
            $user           = $this->CommonModel->get_single("user_master",$filter);
            $token          = $user->token;
            $token_array    = array($token);
            
            $imageUrl   = ""; 
 
    		require_once __DIR__ . '/Notification.php';
    		$notification = $this->notification;
    		$notification->setTitle($title);
    		$notification->setMessage($message);
    		$notification->setImage($imageUrl);
    		$firebase_api = $this->web_api;
    		$requestData = $notification->getNotificatin();
    		$fields = array(
    			'registration_ids' => $token_array,
    			'data' => $requestData,
    			'priority' => 'high',
    			'notification' => array(
    			'title' => $title,
    			'body' => $message,
    			'image' => $imageUrl,
    			)
    		);
    		$url = 'https://fcm.googleapis.com/fcm/send';
    
    		$headers = array(
    			'Authorization: key=' . $firebase_api,
    			'Content-Type: application/json'
    			);
    	
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, $url);
    		curl_setopt($ch, CURLOPT_POST, true);
    		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    		$result = curl_exec($ch);
    		if($result === FALSE){
    			die('Curl failed: ' . curl_error($ch));
    		}
    		curl_close($ch);
     		/*echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
     		echo json_encode($fields,JSON_PRETTY_PRINT);
     		echo '</pre></p><h3>Response </h3><p><pre>';
     		echo $result;
    		echo '</pre></p>';
    		die;*/

            $message = ['status' => '1', 'message' => 'Application Status Updated!'];
            echo json_encode($message);
            die;
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong'];
            echo json_encode($message);
            die;
        }
    }
    

}
