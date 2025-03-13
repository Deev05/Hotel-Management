<?php 
namespace App\Modules\Rooms\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Rooms extends BaseController {
    protected $CommonModel;
    protected $table;
    public function __construct()
    {
 
     	$this->CommonModel = new CommonModel();
        $this->table = "rooms";
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

        $data['page_title']     = 'Rooms';
        $data['page_headline']  = 'Rooms';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['Rooms']   = $this->CommonModel->get_by_condition($this->table, $filter, $order);

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Rooms\Views\indexx', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    















    public function get_rooms()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( room_type_name LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            
            $where .= " or ( created LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT * FROM rooms $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'room_no',
            3 => 'carpet_area',
            4 => 'room_type_id',
            5 => 'created',
            6 => 'action',
        );

        $sql = "SELECT *";
        $sql .= " FROM rooms $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $data['no']         = ++$count;
            $data['id']         = $row->id;
            $data['room_no']       = $row->room_no;
            $data['carpet_area']       = $row->carpet_area;
            $data['room_type_id']       = $row->room_type_id;
            
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
    
    public function add_rooms()
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

        $room_type_id = $this->request->getVar('room_type_id');
        $room_no = $this->request->getVar('room_no');
        $carpet_area = $this ->request->getVar('carpet_area');
        $created = date("Y-m-d H:i:s");
        
        $insert_data = array(
                                "room_no" => $room_no,
                                "carpet_area"=> $carpet_area,
                                "room_type_id"      => $room_type_id,
                                
                                "created"   => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('rooms', $insert_data);
        
        if ($insert != false) 
        {

            $activity_title = "New room created named " . $room_type_id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New room has been added!'];
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
    
    public function update_rooms()
    {

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
        
        $id             = $this->request->getVar('rooms_id');
        $room_type_id   = $this->request->getVar('edit_room_type_id');
        $room_no   = $this->request->getVar('edit_room_no');
        $carpet_area   = $this->request->getVar('edit_carpet_area');
        
        $filter = array("id" => $id);
        $update_data = array(
                                "room_no" => $room_no,
                                "carpet_area"=>$carpet_area,
                                "room_type_id"=>$room_type_id,
                            );
        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

        if ($update != false) 
        {
            $activity_title = "Room Updated " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Details Updated!'];
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
    

}