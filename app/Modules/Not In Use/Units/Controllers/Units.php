<?php 
namespace App\Modules\Units\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Units extends BaseController {

    public function __construct()
    {
 
     	$this->CommonModel = new CommonModel();
        $this->table = "units";
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

        $this->permissionCheckNormal('view_units','normal');

        $data['page_title']     = 'Units';
        $data['page_headline']  = 'Units';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Units\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_units()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( name LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT * FROM units $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'name',
            3 => 'code',
            4 => 'status',
            5 => 'created',
            6 => 'action',
            7 => 'base_unit_id',
        );

        $sql = "SELECT *";
        $sql .= " FROM units $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {

            $data['no']             = ++$count;
            $data['id']             = $row->id;
            $data['name']           = $row->name;
            $data['code']           = $row->code;
            $data['status']         = $row->status;
            $data['created']        = $row->created;
            $data['base_unit_id']   = $row->base_unit;


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
    
    public function add_unit()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_unit');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $name = $this->request->getVar('name');
        $code = $this->request->getVar('code');

        $created = date("Y-m-d H:i:s");
        
        $insert_data = array(
                                "name"      => $name,
                                "code"      => $code,
                                "base_unit"      => 0,
                                "value"      => 1,
                                "created"   => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('units', $insert_data);
        
        if ($insert != false) 
        {

            $activity_title = "New Unit named " . $name;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New Unit has been added!'];
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
        $check = $this->permissionCheck('delete_unit');
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
            $activity_title = "Unit Removed " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Unit has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }
    
    public function update_unit()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('update_unit');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////
        
        $id             = $this->request->getVar('unit_id');
        $name   = $this->request->getVar('edit_name');
        $code = $this->request->getVar('edit_code');

        
        $filter = array("id" => $id);
        $update_data = array(
                                "name"      => $name,
                                "code"      => $code,
                                "base_unit" => 0,
                                "value"     => 1,
                            );
        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

        if ($update != false) 
        {
            $activity_title = "Unit Updated " . $id;
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

        
    }
    

}