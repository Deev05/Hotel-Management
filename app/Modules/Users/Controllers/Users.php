<?php 
namespace App\Modules\Users\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Users extends BaseController {

    public function __construct()
    {
 
     	$this->CommonModel = new CommonModel();
        $this->table = "user";
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
        $this->permissionCheckNormal('user_list','normal');

        $data['page_title']     = 'Users';
        $data['page_headline']  = 'Users';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Users\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_users()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( name LIKE '%" . $_REQUEST['search']['value'] . "%') ";
            $where .= " or ( user_name LIKE '%" . $_REQUEST['search']['value'] . "%') ";
            $where .= " or ( email LIKE '%" . $_REQUEST['search']['value'] . "%') ";
            $where .= " or ( contact LIKE '%" . $_REQUEST['search']['value'] . "%') ";
            $where .= " or ( created LIKE '%" . $_REQUEST['search']['value'] . "%') ";
            $where .= " or ( last_login_ip_address LIKE '%" . $_REQUEST['search']['value'] . "%') ";
            $where .= " or ( last_login LIKE '%" . $_REQUEST['search']['value'] . "%') ";
        }

        $totalRecordsSql = "SELECT * FROM user $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'name',
            3 => 'user_name',
            4 => 'email',
            5 => 'contact',
            6 => 'role',
            7 => 'status',
            8 => 'logged_in',
            9 => 'last_login',
            10 => 'logged_in',
            11 => 'last_login_ip_address',
            12 => 'action',
        );

        $sql = "SELECT *";
        $sql .= " FROM user $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {

            $filter = array("id" => $row->role);
            $role = $this->CommonModel->get_single("roles",$filter);
            $role_name = $role->name;


            $data['no']                         = ++$count;
            $data['id']                         = $row->id;
            $data['name']                       = $row->name;
            $data['user_name']                  = $row->user_name;
            $data['email']                      = $row->email;
            $data['contact']                    = $row->contact;
            $data['role']                       = $role_name;
            $data['status']                     = $row->status;
            $data['logged_in']                  = $row->logged_in;
            $data['last_login']                 = $row->last_login;
            $data['last_login_ip_address']      = $row->last_login_ip_address;
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
    
    public function add_user()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_user');
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
        $user_name  = $this->request->getVar('user_name');
        $email      = $this->request->getVar('email');
        $contact    = $this->request->getVar('contact');
        $role       = $this->request->getVar('role');
        $password   = md5($this->request->getVar('password'));

        $filter = array("user_name" => $user_name);
        $user_name_exist = $this->CommonModel->get_single("user",$filter);
        if(!empty($user_name_exist))
        {
            $message = ['status' => '0', 'message' => 'Username already exist please enter diffrent username!'];
            return json_encode($message);
        }
        
        $created = date("Y-m-d H:i:s");
        
        $insert_data = array(
                                "name"          => $name,
                                "user_name"     => $user_name,
                                "email"         => $email,
                                "contact"       => $contact,
                                "role"          => $role,
                                "password"      => $password,
                                "created"       => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('user', $insert_data);
        
        if ($insert != false) 
        {

            $activity_title = "Created User Named " . $name;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New User has been added!'];
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
        $check = $this->permissionCheck('delete_user');
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

            $activity_title = "User Deleted " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'User has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }
    
    public function update_user()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('update_user');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id           = $this->request->getVar('user_id');
        $name         = $this->request->getVar('edit_full_name');
        $user_name    = $this->request->getVar('edit_user_name');
        $email        = $this->request->getVar('edit_email');
        $contact      = $this->request->getVar('edit_contact');
        $role         = $this->request->getVar('edit_role');
        

        
        $filter = array("id" => $id);
        $update_data = array(
                                "name" => $name,
                                "email" => $email,
                                "contact" => $contact,
                                "role" => $role,
                            );
        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

        if ($update != false) 
        {
            $activity_title = "Update User Details " . $id;
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