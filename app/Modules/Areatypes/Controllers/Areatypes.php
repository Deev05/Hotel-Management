<?php 
namespace App\Modules\Areatypes\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Areatypes extends BaseController {
    protected $CommonModel;
    protected $table;
    public function __construct()
    {
 
     	$this->CommonModel = new CommonModel();
        $this->table = "area_type";
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

        $data['page_title']     = 'Area Types';
        $data['page_headline']  = 'Area Types';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['Areatypes']   = $this->CommonModel->get_by_condition($this->table, $filter, $order);

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Areatypes\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    















    public function get_Areatypes()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( area_type_name LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            
            $where .= " or ( created LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT * FROM area_type $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        if(empty($res))
        {
             $totalRecords =0;
        }
        else
        {
            $totalRecords = count($res);
        }
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'area_type_name',
            3 => 'created',
            4 => 'action',
        );

        $sql = "SELECT *";
        $sql .= " FROM area_type $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        if(!empty($result)){
            foreach ($result as  $row) 
            {
                $data['no']         = ++$count;
                $data['id']         = $row->id;
                $data['area_type_name']       = $row->area_type_name;
                
                $data['created']    = $row->created;


                array_push($data_array, $data);
            }
        }

        $json_data = array(
            "draw"            => intval($_REQUEST['draw']),
            "recordsTotal"    => intval($totalRecords),
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data_array
        );

        return json_encode($json_data);
    }
    
    public function add_Areatypes()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_Areatypes');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $area_type_name = $this->request->getVar('area_type_name');


        $created = date("Y-m-d H:i:s");
        
        $insert_data = array(
                                "area_type_name"      => $area_type_name,
                                
                                "created"   => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('area_type', $insert_data);
        
        if ($insert != false) 
        {

            $activity_title = "New area type created named " . $area_type_name;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New Permission has been added!'];
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
        $check = $this->permissionCheck('delete_Areatypes');
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

        $update = $this->CommonModel->common_update_data('area_type',$id,$update_data);
        
        
        if ($update != false) 
        {
            $activity_title = "Area type Removed " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Area type has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }
    
    public function update_Areatypes()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('update_Areatypes');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////
        
        $id             = $this->request->getVar('Areatypes_id');
        $area_type_name   = $this->request->getVar('edit_area_type_name');
        

        
        $filter = array("id" => $id);
        $update_data = array(
                                "area_type_name" => $area_type_name,
                                
                            );
        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

        if ($update != false) 
        {
            $activity_title = "area type Updated " . $id;
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