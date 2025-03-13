<?php 
namespace App\Modules\Locality\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Locality extends BaseController {

    public function __construct()
    {
 
     	$this->CommonModel = new CommonModel();
        $this->table = "locality";
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

        $this->permissionCheckNormal('view_locality','normal');

        $data['page_title']     = 'Locality';
        $data['page_headline']  = 'Locality';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Locality\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_locality()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( locality LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT * FROM locality $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'city_id',
            3 => 'pincode_id',
            4 => 'area_id',
            5 => 'locality',
            6 => 'status',
            7 => 'created',
            8 => 'action',
            9 => 'select_city_id',
            10 => 'select_pincode_id',
            10 => 'select_area_id',
        );

        $sql = "SELECT *";
        $sql .= " FROM locality $where";
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

            $filter = array("id" => $row->area_id);
            $area = $this->CommonModel->get_single("area",$filter);

            $data['no']             = ++$count;
            $data['id']             = $row->id;
            $data['city_id']        = $city->name;
            $data['pincode_id']        = $pincode->pincode;
            $data['area_id']        = $area->area;
            $data['locality']        = $row->locality;
            $data['status']         = $row->status;
            $data['created']        = $row->created;
            $data['select_city_id']        = $row->city_id;
            $data['select_pincode_id']        = $row->city_id;
            $data['select_area_id']        = $row->area_id;


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
    
    public function add_locality()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_locality');
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
        $area_id     = $this->request->getVar('area_id');
        $locality           = $this->request->getVar('locality');
        $created        = date("Y-m-d H:i:s");
        
        $insert_data = array(
                                "city_id"     => $city_id,
                                "pincode_id"  => $pincode_id,
                                "area_id"     => $area_id,
                                "locality"    => $locality,
                                "created"     => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('locality', $insert_data);
        
        if ($insert != false) 
        {

            $activity_title = "New Locality created name " . $locality;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New Locality has been added!'];
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
        $check = $this->permissionCheck('delete_locality');
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
            $activity_title = "Locality Removed " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Locality has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }
    
    public function update_locality()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('update_locality');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////
        
        $id             = $this->request->getVar('locality_id');
        $edit_pincode   = $this->request->getVar('edit_pincode');
        $edit_area      = $this->request->getVar('edit_area');
        $edit_city      = $this->request->getVar('edit_city');
        $locality       = $this->request->getVar('edit_locality');

        
        $filter = array("id" => $id);
        $update_data = array(
                                "city_id"       => $edit_city,
                                "pincode_id"    => $edit_pincode,
                                "area_id"       => $edit_area,
                                "locality"      => $locality,
                            );
        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

        if ($update != false) 
        {
            $activity_title = "Locality Updated " . $id;
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

    public function get_area()
    {
        $pincode_id     = $this->request->getVar('pincode_id');
        $filter         = array("is_deleted" => 0, "pincode_id" => $pincode_id,);
        $city_data      = $this->CommonModel->get_by_condition('area', $filter);
        echo json_encode($city_data);
    }
    

}