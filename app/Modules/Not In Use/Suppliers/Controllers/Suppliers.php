<?php 
namespace App\Modules\Suppliers\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Suppliers extends BaseController {

    public function __construct()
    {
 
     	$this->CommonModel = new CommonModel();
        $this->table = "suppliers";
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
        $this->permissionCheckNormal('supplier_list','normal');

        $data['page_title']     = 'Suppliers';
        $data['page_headline']  = 'Suppliers';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Suppliers\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_suppliers()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( name LIKE '%" . $_REQUEST['search']['value'] . "%' ";
        }

        $totalRecordsSql = "SELECT * FROM user $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'name',
            3 => 'email',
            4 => 'contact',
            5 => 'address',
            6 => 'state',
            7 => 'city',
            8 => 'gst_no',
            9 => 'out_of_state',
            10 => 'created',
            11 => 'action',
        );

        $sql = "SELECT *";
        $sql .= " FROM suppliers $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $data['no']                         = ++$count;
            $data['id']                         = $row->id;
            $data['name']                       = $row->name;
            $data['email']                      = $row->email;
            $data['contact']                    = $row->contact;
            $data['state']                      = $row->state;
            $data['city']                       = $row->city;
            $data['address']                    = $row->address;
            $data['status']                     = $row->status;
            $data['gst_no']                     = $row->gst_no;
            $data['out_of_state']                     = $row->out_of_state;
            $data['created']                    = $row->created;


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
    
    public function add_supplier()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_supplier');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        
        $name       = $this->request->getVar('name');
        $email      = $this->request->getVar('email');
        $contact    = $this->request->getVar('contact');
        $address    = $this->request->getVar('address');
        $state      = $this->request->getVar('state');
        $city       = $this->request->getVar('city');
        $gst_no       = $this->request->getVar('gst_no');
        $out_of_state            = $this->request->getVar('out_of_state');

        
         //Checkbox Value
        if($out_of_state == "")
        {
            $out_of_state = "false";
        }

        $created = date("Y-m-d H:i:s");
        
        $insert_data = array(
                                "name"          => $name,
                                "email"         => $email,
                                "contact"       => $contact,
                                "address"       => $address,
                                "state"         => $state,
                                "city"          => $city,
                                "gst_no"        => $gst_no,
                                "out_of_state"  => $out_of_state,
                                "created"       => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('suppliers', $insert_data);
        
        if ($insert != false) 
        {

            $activity_title = "Created Supplier Named " . $name;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New Supplier has been added!'];
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
        $check = $this->permissionCheck('delete_supplier');
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

            $activity_title = "Supplier Deleted " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Supplier has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }
    
    public function update_supplier()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('update_supplier');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id           = $this->request->getVar('supplier_id');
        $name         = $this->request->getVar('edit_full_name');
        $email        = $this->request->getVar('edit_email');
        $contact      = $this->request->getVar('edit_contact');
        $address      = $this->request->getVar('edit_address');
        $state        = $this->request->getVar('edit_state');
        $city         = $this->request->getVar('edit_city');
        $out_of_state = $this->request->getVar('edit_out_of_state');
        $gst_no = $this->request->getVar('edit_gst_no');
        
        //Checkbox Value
        if($out_of_state == "")
        {
            $out_of_state = "false";
        }

            
            
        $filter = array("id" => $id);
        $update_data = array(
                                "name"      => $name,
                                "email"     => $email,
                                "contact"   => $contact,
                                "address"   => $address,
                                "state"     => $state,
                                "city"      => $city,
                                "gst_no"        => $gst_no,
                                "out_of_state"  => $out_of_state,
                            );

        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);
        

        if ($update != false) 
        {
            $activity_title = "Update Supllier Details " . $id;
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
        } 
        else 
        {
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