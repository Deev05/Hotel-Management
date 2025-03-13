<?php 
namespace App\Modules\Warehouse\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Warehouse extends BaseController {

    public function __construct()
    {
 
     	$this->CommonModel = new CommonModel();
        $this->table = "warehouse";
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


        $this->permissionCheckNormal('warehouse_list','normal');

        $data['page_title']     = 'Warehouse';
        $data['page_headline']  = 'Warehouse';
       
        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Warehouse\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_warehouse()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( name LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT * FROM warehouse $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'name',
            3 => 'email',
            4 => 'contact',
            5 => 'address_line_one',
            6 => 'address_line_two',
            7 => 'status',
            8 => 'created',
            9 => 'action',
        );

        $sql = "SELECT *";
        $sql .= " FROM warehouse $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $data['no']         = ++$count;
            $data['id']         = $row->id;
            $data['name']       = $row->name;
            $data['email']      = $row->email;
            $data['contact']      = $row->contact;
            $data['address_line_one']      = $row->address_line_one;
            $data['address_line_two']      = $row->address_line_two;
            $data['status']     = $row->status;
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
    
    public function add_warehouse()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_warehouse');
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
        $email = $this->request->getVar('email');
        $contact = $this->request->getVar('contact');
        $address_line_one = $this->request->getVar('address_line_one');
        $address_line_two = $this->request->getVar('address_line_two');
  
        

        $created = date("Y-m-d H:i:s");
        
        $insert_data = array(
                                "name"      => $name,
                                "email"      => $email,
                                "contact"     => $contact,
                                "address_line_one"     => $address_line_one,
                                "address_line_two"     => $address_line_two,
                                "created"   => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('warehouse', $insert_data);
        
        if ($insert != false) 
        {

            $activity_title = "Created warehouse named " . $name;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New Warehouse has been added!'];
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
        $check = $this->permissionCheck('delete_warehouse');
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
            $activity_title = "Removed Warehouse " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Warehouse has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }
    
    public function update_warehouse()
    {
        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('update_warehouse');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id             = $this->request->getVar('warehouse_id');
        $name   = $this->request->getVar('edit_warehouse_name');
        $email         = $this->request->getVar('edit_email');
        $contact         = $this->request->getVar('edit_contact');
        $address_line_one         = $this->request->getVar('edit_address_line_one');
        $address_line_two         = $this->request->getVar('edit_address_line_two');
        

        
        $filter = array("id" => $id);
        $update_data = array(
                                "name" => $name,
                                "email" => $email,
                                "contact" => $contact,
                                "address_line_one" => $address_line_one,
                                "address_line_two" => $address_line_two,

                            );
        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

        if ($update != false) 
        {
            $activity_title = "Updated Warehouse " . $id;
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