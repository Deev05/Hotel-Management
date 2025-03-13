<?php

namespace App\Modules\Sopsptickets\Controllers;
use App\Modules\Sopsptickets\Controllers\Notification;
use App\Controllers\BaseController;
use App\Models\CommonModel;

class Sopsptickets extends BaseController
{

    private $web_api = "AAAAL-aXCxQ:APA91bEjUvvNvKYALAcl9PjtxvvUwJTqMsvXdJNETqyvqIt_JQPP-QlTO9POH8XYz1DFC3HflKfgYT_u21j1lK7-tn6OPsMz51yeNMxA8FRu5eXpnoA8S4WWhN4bM8MO51E8R3nlSGrl";
    private $service_provider_web_api = "AAAAFQZ1I50:APA91bF7Il94rQ6BXC7CYcKoBtFDtum6CUDVNbbjMvKPazHnNLiMVa0PKhXw4aSmpPlWgjW7Jt3yJKWIKxOO898RxrgpLrkEz9xCE1R8PxXKW6ogr9Z44SKBwkXSw3KNpYkKUi3SsO0_";


    public function __construct()
    {
        $this->CommonModel = new CommonModel();
        $this->notification = new Notification;
        $this->table = " sop_application_sp_tickets ";
        helper(['form', 'url']);
    }

    // Index
    public function index()
    {

        $data['page_title'] = 'Service Provider Ticket Management';
        $data['page_headline'] = 'Service Provider Ticket Management';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['order']   = $this->CommonModel->get_all_data($this->table);
        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);
        
        $query = "SELECT * FROM sop_application_sp_tickets";
        $allorders   = $this->CommonModel->custome_query($query);
        $data['all_tickets'] = count($allorders);
        
        $query = "SELECT * FROM sop_application_sp_tickets where status = 0";
        $allorders   = $this->CommonModel->custome_query($query);
        $data['opened'] = count($allorders);
        
        $query = "SELECT * FROM sop_application_sp_tickets where status = 1";
        $allorders   = $this->CommonModel->custome_query($query);
        $data['in_progress'] = count($allorders);
        
        $query = "SELECT * FROM sop_application_sp_tickets where status = 2";
        $allorders   = $this->CommonModel->custome_query($query);
        $data['responded'] = count($allorders);
        
        $query = "SELECT * FROM sop_application_sp_tickets where status = 3";
        $allorders   = $this->CommonModel->custome_query($query);
        $data['resolved'] = count($allorders);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Sopsptickets\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }
    
    
    
    public function get_data()
    {
       
        $where = '';
        //$where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " WHERE ( ticket_no LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " and ( message LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT * FROM sop_application_sp_tickets $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array( 
            0 => 'id',
            1 => 'id',
            2 => 'status',
            3 => 'ticket_no',
            4 => 'title',
            5 => 'created',
            6 => 'service_provider_name',
        );

        $sql = "SELECT *";
        $sql .= " FROM sop_application_sp_tickets $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $filter = array("id" => $row->service_provider_id);
            $service_provider_details = $this->CommonModel->get_single("service_providers",$filter);

          
            
            $data['no']         = ++$count;
            $data['id']         = $row->id;
            $data['ticket_no']       = $row->ticket_no;
            $data['service_provider_name']       = $service_provider_details->name;
            $data['title']       = $row->message;

            $data['status']     = $row->status;
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
    
    
    public function single()
    {

        $data['page_title'] = 'Service Provider Ticket Management';
        $data['page_headline'] = 'Service Provider Ticket Management';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['order']   = $this->CommonModel->get_all_data($this->table);
        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);
        
        $ticket_id = $this->request->uri->getSegment(3);
        
        $filter = array("id" => $ticket_id);
        $data['ticket_details'] = $this->CommonModel->get_single("sop_application_sp_tickets",$filter);
        $ticket_details = $this->CommonModel->get_single("sop_application_sp_tickets",$filter);
        
        $data['ticket_id'] = $ticket_id;
        $data['service_provider_id']    = $ticket_details->service_provider_id;
        


        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Sopsptickets\Views\single', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }
    
    
    public function get_conversation()
    {
        $ticket_id = $this->request->uri->getSegment(3);
        
        $query = "select * from sop_application_sp_tickets_conversations where ticket_id = $ticket_id";
 
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
                        
                        if($row->service_provider_id == 0)
                        {
                            $full_name = "User";  
                            $profile_image = base_url()."/uploads/static/user.png";
                        }
                        else
                        {
                            $filter = array("id" => $row->service_provider_id);
                            $service_provider_data = $this->CommonModel->get_single("service_providers",$filter);
                            $full_name = $service_provider_data->name;
                            $profile_image = base_url()."/uploads/static/user.png";
            		
                            
                        }
                        
                        if($row->message_by == "support_team")
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
       

        $message                = $this->request->getVar('message');
        $ticket_id              = $this->request->getVar('ticket_id');
        $service_provider_id    = $this->request->getVar('service_provider_id');
        $message_by             = "support_team";
        $message_type           = "0";
        $created                = date("Y-m-d H:i:s");
        
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
                                "ticket_id"         => $ticket_id,
                                "service_provider_id"           => $service_provider_id,
                                "message"           => $message,
                                "message_by"        => $message_by,
                                "message_type"      => $message_type,
                                "created"           => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('sop_application_sp_tickets_conversations', $insert_data);
        
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
    
    
    public function change_ticket_status()
    {
        
        $ticket_status = $this->request->getVar('status');
        $ticket_id = $this->request->getVar('id');

        $filter = array("id" => $ticket_id);
        $update_data = array("status" => $ticket_status);
        $update = $this->CommonModel->update_data('sop_application_sp_tickets', $update_data, $filter);

    
        if ($update != false) {
            
            
            $filter = array("id" => $ticket_id);
            $ticket_data = $this->CommonModel->get_single("sop_application_sp_tickets",$filter);
            $service_provider_id = $ticket_data->service_provider_id;
            

            if ($ticket_status == 0) 
            {
                $title = "Support Ticket Update";
                $message = "Your Application '.$ticket_data->ticket_no.' status is opened! Our team will help you in short time.";
            } 
            else if ($ticket_status == 1) 
            {
                $title = "Support Ticket Update";
                $message = "Your Application '.$ticket_data->ticket_no.' status is In Porgress! Our team will help you in short time.";
            } 
            else if ($ticket_status == 2) 
            {
                $title = "Support Ticket Update";
                $message = "Your Application '.$ticket_data->ticket_no.' status is In Responded! Please check the message.";
            } 
            else if ($ticket_status == 3) 
            {
                $title = "Greetings ! Support Ticket Update";
                $message = "Your Application '.$ticket_data->ticket_no.' Query has been resolved ! Thank you for contact us.";
            } 
           
            
          
            $data['ticekt_data'] = $this->CommonModel->get_single("sop_application_sp_tickets",$filter);
            $data['title']=$title;
            $data['message']=$message;
            $data['service_provider']=$this->CommonModel->get_single("service_providers",array('id'=>$data['ticekt_data']->service_provider_id));
            $service_provider =$this->CommonModel->get_single("service_providers",array('id'=>$data['ticekt_data']->service_provider_id));

   

            $filter         = array("id" => $service_provider->id);
            $service_provider           = $this->CommonModel->get_single("service_providers",$filter);
            $token          = $service_provider->token;
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

            $message = ['status' => '1', 'message' => 'Ticket Status Updated!'];
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
