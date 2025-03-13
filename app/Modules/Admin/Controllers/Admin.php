<?php

namespace App\Modules\Admin\Controllers;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Modules\Admin\Models\AdminModel;

class Admin extends BaseController
{
    protected $CommonModel;
    public function __construct()
    {
        $this->CommonModel = new CommonModel;
        
        $session = session()->get('mySession');
        if($session == "")
        {
            header('location:/admin_login');
            exit();
        }
        
    }

    public function index()
    {
        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);
        $data['page_title']     = "Dashboard";
        $data['page_headline']  = "Dashboard";
        $session = session()->get("mySession");
        $id = $session["id"];
        $filter=array('assigned_to'=>$id);
        $data['id']= $id;
        $data['task_details']= $this->CommonModel->get_all_data_array('task');
        

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Admin\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }
    
    public function update_admin_token()
    {
        $token  =  $this->request->getVar('token');
        
        $update_data = array("token" => $token);
        $filter = array("id"=> 2);
        $update = $this->CommonModel->update_data("user",$update_data,$filter);
        
        if($update != false)
        {
            $val = ['status'        => '1','message'      => 'Token updated' ];
            echo json_encode($val);
            die;
        }
        else
        { 
            $val = ['status'        => '1','message'      => 'somthing went wrong' ];
            echo json_encode($val);
            die;
        }
    }
    
    // public function get_admin_notifications()
    // {

    //     $query              = "SELECT * FROM admin_notifications order by id desc limit 30";
    //     $exist = $this->CommonModel->custome_query($query);

    //     $data_array = array();
        
    //     $result_html = '';
        
    //     if(!empty($exist))
    //     {
    //         foreach ($exist as $row) 
    //         {
    //         $orgDate        = $row->created;  
    //             $result_html .= '<a href="javascript:void(0)" class="message-item">
                                    
    //                                 <div class="mail-contnet">
    //                                     <h5 class="message-title">'.$row->title.'</h5>
    //                                     <span class="mail-desc">'.$row->message.'</span>
    //                                     <span class="time">'.date("d-M-y h:i A", strtotime($orgDate)).'</span>
    //                                 </div>
    //                             </a>';
    //         }

    //         $val = ['status'        => '1','notifications'      => $result_html ];
    //         echo json_encode($val);
    //         die;
    //     } 
    //     else 
    //     {
    //         $data = ['status' => '0', 'query'         =>  $query, 'message' => 'No new notification found.'];
    //         echo json_encode($data);
    //         die;
    //     }
        
    // }
    
    public function get_admin_notifications()
    {

        $query              = "SELECT * FROM admin_notifications order by id desc limit 30";
        $exist = $this->CommonModel->custome_query($query);

        $data_array = array();
        
        $result_html = '';
        
        if(!empty($exist))
        {
            foreach ($exist as $row) 
            {
            $orgDate        = $row->created;  
                $result_html .= '<a href="javascript:void(0)" class="message-item">
                                    
                                    <div class="mail-contnet">
                                        <h5 class="message-title">'.$row->title.'</h5>
                                        <span class="mail-desc">'.$row->message.'</span>
                                        <span class="time">'.date("d-M-y h:i A", strtotime($orgDate)).'</span>
                                    </div>
                                </a>';
            }

            $val = ['status'        => '1','notifications'      => $result_html ];
            echo json_encode($val);
            die;
        } 
        else 
        {
            $data = ['status' => '0', 'query'         =>  $query, 'message' => 'No new notification found.'];
            echo json_encode($data);
            die;
        }
        
    }

    public function final_call(){

        $id =  $this->request->uri->getSegment(4);
        $room =  $this->request->uri->getSegment(3);
       
        $result_html='
        <div><h5>Are you sure you want to begin the task?</h5></div>
        <div class="id_post" style="display:none">'.$id.'</div>
        <div class="room_post" style="display:none">'.$room.'</div>

        <button type="button" class="btn btn-success yes" data-dismiss="modal"><i class="fa fa-tick"></i>Yes</button>
        <button type="button" class="btn waves-effect btn-danger" data-dismiss="modal">Close</button>';





        $val = ['status' => '1','final_call' => $result_html ,'message' => 'Success'];
        echo json_encode($val);
        die;
    }

    public function start_time(){
        $id =  $this->request->uri->getSegment(4);
        $room =  $this->request->uri->getSegment(3);
        $filter= array('room_id'=>$room);
        $sub_task= $this->CommonModel->get_single('task',$filter);
        foreach(json_decode($sub_task->sub_task) as $index => $row){
            if($index==$id){
                $row->start_time = date('H:i:s');
                $row->status= 1;

            }
        }
    }
}