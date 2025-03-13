<?php 
namespace App\Modules\Task\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Task extends BaseController {
    protected $CommonModel;
    protected $table;
    private $db;
    public function __construct()
    {
        $this->db = db_connect();
     	$this->CommonModel = new CommonModel();
        $this->table = "task";
        helper(['form', 'url']);
        
        $session = session()->get('mySession');
        if($session == "")
        {
            header('location:/admin_login');
            exit();
        }
        
	}

    public function index()
    {

        $this->permissionCheckNormal('view_permissions','normal');

        $data['page_title']     = 'Tasks';
        $data['page_headline']  = 'Tasks';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['Task']   = $this->CommonModel->get_by_condition($this->table, $filter, $order);

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Task\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    















    public function get_Task()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( task_name LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            
            
        }

        $totalRecordsSql = "SELECT * FROM task $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2=> 'room_no',
            
            3 => 'task_type',
            4 => 'task_name',
            5=> 'assigned_to',
           
            6 => 'created',
            7 => 'action',
        );

        $sql = "SELECT *";
        $sql .= " FROM task $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        


        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $data['no']         = ++$count;
            $data['id']         = $row->id;
            
            $query= json_decode($row->task_data);
            
            $filter=array("id"=> $row->room_id );
            $data["room_no"]= $this->CommonModel->get_single("rooms" ,$filter )->room_no;
            $data['task_type']       = $row->task_type;
            $data['task_name']       = $row->task_name;
            $filter = array("id" => $row->assigned_to);
            $data['assigned_to'] = $this->CommonModel->get_single("user" ,$filter )->name;
           
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
    
    public function create(){
        $data['page_title']     = 'Create Tasks';
        $data['page_headline']  = 'Create Tasks';
        $order[0] = "id";
        $order[1] = "DESC";
        

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);
        
        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Task\Views\create', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }


    public function update(){
        
        $data['page_title']     = 'Update Tasks';
        $data['page_headline']  = 'Update Tasks';
        $order[0] = "id";
        $order[1] = "DESC";
        

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);
        $data['update_id'] = $this->request->uri->getSegment(3);



        $update_id = $this->request->uri ->getSegment(3);
        $filter                 = array( 'id' => $update_id );
        $data['task_details'] = $this->CommonModel->get_single("task" ,$filter );
        
        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data); 
        echo view('App\Modules\Task\Views\update', $data);      
        echo view('App\Modules\Admin\Views\footer', $data);
    }


    public function add_Task()
    {
        
        
        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_Roomtypes');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////
        

        $task_name = $this->request->getVar('task_name');
        $task_type = $this ->request->getVar('task_type');
        $description = $this ->request->getVar('description');
        $user_id= $this->request->getVar('user_id');

        
        $task_data = json_encode($this->request->getPost('room_id'));
        $created = date("Y-m-d H:i:s");
        $length = count($this->request->getPost('room_id'));
        $room_id = $this->request->getPost('room_id');
        
        for($j = 0 ; $j < $length ; $j++){ 
            $sub_task_name = $this->request->getPost('sub_task_name_'.$room_id[$j]);

            $length_1 = count($this->request->getPost('sub_task_name_'. $room_id[$j]));
                $sub_task_manage = array();
                for ($i = 0; $i < $length_1; $i++) { 
                    
                
                    $sub_task_name[$i]= array(
                    'sub_task_name'=>$sub_task_name[$i],
                    'start_time'=> '',
                    'end_time'=>'',
                    'status'=>'',
                    );
                    array_push($sub_task_manage,$sub_task_name[$i]);
            
            }
   
                        $insert_data = array(
                        
                                "task_data"=>$task_data,
                                "room_id" => $room_id[$j],
                                "task_type"=> $task_type,
                                "task_name" => $task_name,
                                "description"=> $description,
                                "created"   => $created,
                                "assigned_to"=> $user_id,
                                "sub_task"=> json_encode($sub_task_manage),
                                                        );
                            
        $insert = $this->CommonModel->common_insert_data('task', $insert_data);
        $task_id[]= $insert;
                                                    }                                            
        
        
            
            
        
        if ($insert != false) 
        {

            $activity_title = "New Task created named " . $task_name;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New Task has been added!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
    
        

    
        
    }
    
    public function delete()
    {
        $data['page_title']     = 'Tasks';
        $data['page_headline']  = 'Tasks';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['Task']   = $this->CommonModel->get_by_condition($this->table, $filter, $order);

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        
        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('delete_Roomtypes');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        
        $id = $this->request->uri->getSegment(3);
	    $update_data = array(
                                "is_deleted"    => 1,
                                "status"        => 0,
                                "id"            => $id,
                            );

        $update = $this->CommonModel->common_update_data($this->table,$id,$update_data);
        

        
        echo view('App\Modules\Admin\Views\header',$data);
        echo view('App\Modules\Admin\Views\sidebar',$data);
        echo view('App\Modules\Task\Views\index',$data);
        echo view('App\Modules\Admin\Views\footer',$data);
        
        if ($update != false) 
        {
            $activity_title = "Room type Removed " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Room type has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }

        

    }
    
    public function update_Task()
    {
     

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);
        $id = $this->request->uri ->getSegment(3); 
        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('update_Roomtypes');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////
        
       
        $task_name   = $this->request->getVar('edit_task_name');
        $user_id   = $this->request->getVar('edit_user_id');
        $task_data = json_encode($this -> request -> getPost('edit_room_id'));
        $task_type   = $this->request->getVar('edit_task_type');
        $description   = $this->request->getVar('edit_description');
        $edit_sub_task_name = $this->request->getPost('edit_sub_task_name');
        $length_1 = count($this->request->getPost('edit_sub_task_name'));
                $sub_task_manage = array();
                for ($i = 0; $i < $length_1; $i++) { 
                    
                
                    $sub_task_name[$i]= array(
                    'sub_task_name'=>$edit_sub_task_name[$i],
                    'start_time'=> '',
                    'end_time'=>'',
                    'status'=>'',
                    );
                    array_push($sub_task_manage,$sub_task_name[$i]);
            
            }
        $filter = array("id" => $id);
        $update_data = array(
                                "task_data" => $task_data,
                                "assigned_to" => $user_id,
                                "task_type"=>$task_type,
                                "task_name"=>$task_name,
                                "description"=>$description,
                                "sub_task"=> json_encode($sub_task_manage),
                            );
        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);
            
        

        
        
        

        
        if ($update != false) 
        {
        
            $activity_title = "Task Updated " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Task Updated!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }


    }
    public function change_status()
    {
        $id = $this->request->uri->getSegment(3);

        $filter = array("id" => $id);
        $data =  $this->CommonModel->get_single($this->table, $filter);

        $status = $data->status;

        if ($status == 1) {
            $filter = array("id" => $id);
            $update_data = array("status" => 0);
            $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

            if ($update != false) {
                $message = ['status' => '1', 'message' => 'Status Updated!'];
                return json_encode($message);
            } else {
                $message = ['status' => '0', 'message' => 'Status Not Updated!'];
                return json_encode($message);
            }


        } else {
            $filter = array("id" => $id);
            $update_data = array("status" => 1);
            $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

            if ($update != false) {
                $message = ['status' => '1', 'message' => 'Status Updated!'];
                return json_encode($message);
            } else {
                $message = ['status' => '0', 'message' => 'Status Not Updated!'];
                return json_encode($message);
            }
        }

        $_SESSION['message'] = 'Something Went Wrong!';
        session()->markAsFlashdata("message");
        return redirect()->to(base_url('manage_questions'));
    }
    public function view_sub_task_details(){
        $id = $this->request->uri->getSegment(3);
        $filter = array('id'=> $id);
        $task_details = $this->CommonModel->get_single('task',$filter);
        $result_html='';
        $filter=array("id"=> $task_details->room_id );
        $room_no= $this->CommonModel->get_single("rooms" ,$filter )->room_no;

        $filter = array("id" => $task_details->assigned_to);
        $assigned_to = $this->CommonModel->get_single("user" ,$filter )->name;

        $sub_task_name = json_decode($task_details->sub_task);




        $result_html.=  '<div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <!-- Your Content Here-->
                                                
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h3 class="box-title">General Info</h3>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Task Name</td>
                                                                    <td> '.$task_details->task_name.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Task type</td>
                                                                    <td> '.$task_details->task_type.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Description</td>
                                                                    <td> '.$task_details->description.' </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td>Assigned to</td>
                                                                    <td> '.$assigned_to.'</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Room no</td>
                                                                    <td> '.$room_no.' </td>
                                                                </tr>
                                                                
                                                               
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                



                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <!-- Your Content Here-->
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    
                                                    <h3 class="box-title">Sub task info Info</h3>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <th>Sub tasks</th>
                                                            </thead>
                                                            <tbody>';
                                                      
                                                            if(!empty($sub_task_name))
                                                            {
                                                                foreach($sub_task_name as $row)
                                                                {
                                                                    
                                                                    $result_html .='
                                                                    <tr>
                                                                        <td> '.$row->sub_task_name.' </td>
                                                                    </tr>   ';
                                                                }
                                                            }
                                                                
                                                $result_html .='</tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        

                                    </div>';

                                    $val = ['status' => '1','task_details_in_modals' => $result_html ,'message' => 'Success'];
                                    echo json_encode($val);
                                    die;

    }
    
    

}