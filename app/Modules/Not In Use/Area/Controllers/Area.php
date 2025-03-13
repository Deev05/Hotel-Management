<?php 
namespace App\Modules\Area\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Area extends BaseController {
    protected $CommonModel;
    protected $table;
    public function __construct()
    {
 
     	$this->CommonModel = new CommonModel();
        $this->table = "area";
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

        $this->permissionCheckNormal('view_area','normal');

        $data['page_title']     = 'Area';
        $data['page_headline']  = 'Area';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Area\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_area()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( area LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT * FROM area $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'city_id',
            3 => 'pincode_id',
            4 => 'area',
            5 => 'status',
            6 => 'created',
            7 => 'action',
            8 => 'select_city_id',
            9 => 'select_pincode_id',
        );

        $sql = "SELECT *";
        $sql .= " FROM area $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {

            $filter = array("id" => $row->city_id);
            $city = $this->CommonModel->get_single("city",$filter);

            $filter = array("id" => $row->pincode_id);
            $pincode = $this->CommonModel->get_single("pincodes",$filter);

            $data['no']             = ++$count;
            $data['id']             = $row->id;
            $data['city_id']        = $city->name;
            $data['pincode_id']        = $pincode->pincode;
            $data['area']        = $row->area;
            $data['status']         = $row->status;
            $data['created']        = $row->created;
            $data['select_city_id']        = $row->city_id;
            $data['select_pincode_id']        = $row->city_id;


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
    
    public function add_area()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_area');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $city_id        = $this->request->getVar('city_id');
        $pincode_id     = $this->request->getVar('pincode_id');
        $area           = $this->request->getVar('area');
        $created        = date("Y-m-d H:i:s");
        
        $insert_data = array(
                                "city_id"     => $city_id,
                                "pincode_id"  => $pincode_id,
                                "area"        => $area,
                                "created"     => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('area', $insert_data);
        
        if ($insert != false) 
        {

            $activity_title = "New Area created name " . $area;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New Area has been added!'];
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
        $check = $this->permissionCheck('delete_aera');
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
            $activity_title = "Area Removed " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Area has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }
    
    public function update_area()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('update_area');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////
        
        $id             = $this->request->getVar('area_id');
        $area           = $this->request->getVar('edit_area');
        $edit_city      = $this->request->getVar('edit_city');
        $edit_pincode   = $this->request->getVar('edit_pincode');

        
        $filter = array("id" => $id);
        $update_data = array(
                                "city_id"       => $edit_city,
                                "pincode_id"    => $edit_pincode,
                                "area"          => $area,
                            );
        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

        if ($update != false) 
        {
            $activity_title = "Area Updated " . $id;
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

    public function get_pincodes()
    {
        $city_id        = $this->request->getVar('city_id');
        $filter         = array("is_deleted" => 0, "city_id" => $city_id,);
        $city_data      = $this->CommonModel->get_by_condition('pincodes', $filter);
        echo json_encode($city_data);
    }
    

}