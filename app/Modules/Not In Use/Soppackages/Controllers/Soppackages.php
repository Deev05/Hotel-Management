<?php 
namespace App\Modules\Soppackages\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Soppackages extends BaseController {

    private $db;
    public function __construct()
    {
        $this->db = db_connect();
     	$this->CommonModel = new CommonModel();
        $this->table = "sop_packages";
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

        $this->permissionCheckNormal('package_list','normal');

        $data['page_title']     = 'Packages';
        $data['page_headline']  = 'Packages';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Soppackages\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    
    public function get_sop_countries()
    {
        $sop_service_id =  $this->request->getVar('sop_service_id');
        
        $filter = array("sop_service_id" => $sop_service_id,"is_deleted" => 0 ,"status" => 1);
        $result = $this->CommonModel->get_by_condition("sop_countries",$filter);
        
        echo json_encode($result);
        
    }

    
    public function get_packages()
    {
        //$where = '';
        //$where .= " WHERE is_deleted = 0";
        
        $where = '';
        $where = 'WHERE p.created_by = "admin" and p.sop_service_id = s.id and p.sop_country_id = c.id';
        $where .= " And p.is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            //$where .= " And ( s.sop_service_name LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            //$where .= " And ( p.name LIKE '%" . $_REQUEST['search']['value'] . "%' )";
             $where .= " And ( s.name LIKE '%" . $_REQUEST['search']['value'] . "%' ) ";
            // $where .= " or ( p.price LIKE '%" . $_REQUEST['search']['value'] . "%' ) ";
            // $where .= " or ( c.name LIKE '%" . $_REQUEST['search']['value'] . "%' ) ";

        }

        $totalRecordsSql = "select p.*,s.name as sop_service_name, c.name as sop_country from sop_packages p, sop_services s, sop_countries c $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'sop_service_name',
            3 => 'sop_country',
            4 => 'name',
            5 => 'price',
            6 => 'status',
            7 => 'created',
            8 => 'sop_service_id',
            9 => 'sop_country_id',
        );

   
        $sql = "select p.*,s.name as sop_service_name, c.name as sop_country from sop_packages p, sop_services s, sop_countries c $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $data['no']                         = ++$count;
            $data['id']                         = $row->id;
            $data['sop_service_name']           = $row->sop_service_name;
            $data['country_name']               = $row->sop_country;
            $data['sop_country']                = $row->sop_country;
            $data['package_name']               = $row->name;
            $data['package_price']              = $row->price;
            $data['status']                     = $row->status;
            $data['sop_service_id']             = $row->sop_service_id;
            $data['sop_country_id']             = $row->sop_country_id;

            $data['created']                = $row->created;


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
    

    
    public function add_package()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_package');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////


        $sop_service_id           = $this->request->getVar('sop_service_id');
        $sop_country_id          = $this->request->getVar('sop_country_id');
        $package_name           = $this->request->getVar('package_name');
        $package_price           = $this->request->getVar('package_price');

        $created = date("Y-m-d H:i:s");

        $insert_data = array(
                                "sop_service_id"           => $sop_service_id,
                                "sop_country_id"          => $sop_country_id,
                                "name"          => $package_name,
                                "price"          => $package_price,
                                "created"   => $created,

                            );

        $package_insert = $this->CommonModel->common_insert_data('sop_packages', $insert_data);
        
        if($package_insert != false)
        {
            $activity_title = "Package Added " . $package_name;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New Package has been added!'];
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
        $check = $this->permissionCheck('delete_package');
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

            $activity_title = "Package Deleted " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Package has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }

    public function update_package()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('update_package');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id                 = $this->request->getVar('sop_package_id');
        $name               = $this->request->getVar('edit_package_name');
        $price              = $this->request->getVar('edit_price');
        $edit_sop_service   = $this->request->getVar('edit_sop_service');
        $edit_country       = $this->request->getVar('edit_country');
        $created            = date("Y-m-d H:i:s");

        


   
        $filter = array("id" => $id);
        $update_data = array(
                                "name"                      => $name,
                                "price"                     => $price,
                                "sop_service_id"            => $edit_sop_service,
                                "sop_country_id"            => $edit_country,
                                
                            );
        $update = $this->CommonModel->update_data("sop_packages", $update_data, $filter);

        if ($update != false) 
        {
            $activity_title = "Package Updated " . $id;
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