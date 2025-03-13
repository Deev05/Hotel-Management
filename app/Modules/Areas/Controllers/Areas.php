<?php 
namespace App\Modules\Areas\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Areas extends BaseController {
    protected $CommonModel;
    protected $table;
    public function __construct()
    {
 
     	$this->CommonModel = new CommonModel();
        $this->table = "areas";
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

        $data['page_title']     = 'Areas';
        $data['page_headline']  = 'Areas';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['Areas']   = $this->CommonModel->get_by_condition('areas', $filter, $order);

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Areas\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    















    public function get_areas()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( area_type_name LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            
            $where .= " or ( created LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT * FROM areas $where;";

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
            2 => 'area_name',
            3 => 'area_type_id',
            4 => 'created',
            5 => 'action',
        );

        $sql = "SELECT *";
        $sql .= " FROM areas $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        if(!empty($result)){
        foreach ($result as  $row) 
            {
                $data['no']         = ++$count;
                $data['id']         = $row->id;
                $data['area_name']       = $row->area_name;
                //$data['carpet_area']       = $row->carpet_area;
                $data['area_type_id']       = $row->area_type_id;
                
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
    
    public function add_areas()
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

        $area_type_id = $this->request->getVar('area_type_id');
        $area_name = $this->request->getVar('area_name');
        //$carpet_area = $this ->request->getVar('carpet_area');
        $created = date("Y-m-d H:i:s");
        
        $insert_data = array(
                                "area_name" => $area_name,
                                //"carpet_area"=> $carpet_area,
                                "area_type_id"      => $area_type_id,
                                
                                "created"   => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('areas', $insert_data);
        
        if ($insert != false) 
        {

            $activity_title = "New area created named " . $area_name;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New area has been added!'];
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

        $update = $this->CommonModel->common_update_data('areas',$id,$update_data);
        
        
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
    
    public function update_areas()
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
        
        $id             = $this->request->getVar('areas_id');
        $area_type_id   = $this->request->getVar('edit_area_type_id');
        $area_name   = $this->request->getVar('edit_area_name');
        //$carpet_area   = $this->request->getVar('edit_carpet_area');
        
        $filter = array("id" => $id);
        $update_data = array(
                                "area_name" => $area_name,
                                //"carpet_area"=>$carpet_area,
                                "area_type_id"=>$area_type_id,
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

        $_SESSION['message'] = 'Something Went Wrong!';
        session()->markAsFlashdata("message");
        return redirect()->to(base_url('manage_questions'));
    }
    

}