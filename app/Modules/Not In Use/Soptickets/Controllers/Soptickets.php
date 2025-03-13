<?php 
namespace App\Modules\Soptickets\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Soptickets extends BaseController {

    public function __construct()
    {
     	$this->CommonModel = new CommonModel();
        helper(['form', 'url']);
	}

    public function index()
    {
        
    }
    
    public function ticket()
    {
        $data['page_title']     = 'SOP Tickets';
        $data['page_headline']  = 'SOP Tickets';
        
        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);
        
        
        $ticket_id = $this->request->uri->getSegment(3);
        
        $filter = array("id" => $ticket_id);
        $ticket_details = $this->CommonModel->get_single("sop_application_user_tickets",$filter);
        
        $data['ticket_id'] = $ticket_id;
        $data['user_id']    = $ticket_details->user_id;
        $data['ticket_details']    = $ticket_details;
        
        echo view('App\Modules\Soptickets\Views\header', $data);
        echo view('App\Modules\Soptickets\Views\index', $data);
        echo view('App\Modules\Soptickets\Views\footer', $data);
    }
    
  
    
    public function get_conversation()
    {
        $ticket_id = $this->request->uri->getSegment(3);
        
        $query = "select * from sop_application_user_tickets_conversations where ticket_id = $ticket_id";
 
        $result = $this->CommonModel->custome_query($query);
    
        $conversation   =  ''; 
        
        $conversation .= '<ul class="chat-list">';
        $base_url = base_url();
            
                if(!empty($result))
                {
                    foreach($result as $row)
                    {
                        $orgDate    = $row->created;
                        $msg_date_time = date("d-m-Y h:i A", strtotime($orgDate));
                        
                        if($row->message_by == 1)
                        {
                            if($row->message_type == 0)
                            {
                               $conversation .= '  <li class="chat-item">
                                                <div class="chat-img">
                                                    <img src="'.$base_url.'uploads/static/ticket_user_support_team.png" alt="user">
                                                </div>
                                                <div class="chat-content">
                                                    <h6 class="font-medium">Support Team</h6>
                                                    <div class="box bg-light-info">'.$row->message.'</div>
                                                </div>
                                                <div class="chat-time">'.$msg_date_time.'</div>
                                            </li>'; 
                            }
                            else
                            {
                               $conversation .= '  <li class="chat-item">
                                                <div class="chat-img">
                                                    <img src="'.$base_url.'uploads/static/ticket_user_support_team.png" alt="user">
                                                </div>
                                                <div class="chat-content">
                                                    <h6 class="font-medium">Support Team</h6>
                                                    <a href="#"><div class="box bg-light-info">View Attachment</div></a>
                                                </div>
                                                <div class="chat-time">'.$msg_date_time.'</div>
                                            </li>'; 
                            }
                            
                        }
                        else
                        {
                           if($row->message_type == "0")
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
        $ticket_id      = $this->request->getVar('ticket_id');
        $user_id        = $this->request->getVar('user_id');
        $message_by     = "0";
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
                                "ticket_id"         => $ticket_id,
                                "user_id"           => $user_id,
                                "message"           => $message,
                                "message_by"        => $message_by,
                                "message_type"      => $message_type,
                                "created"           => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('sop_application_user_tickets_conversations', $insert_data);
        
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
    
   
    
   

}