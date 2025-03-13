<?php 
namespace App\Modules\Roles\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Roles extends BaseController {

    private $db;
    public function __construct()
    {
        $this->db = db_connect();
     	$this->CommonModel = new CommonModel();
        $this->table = "roles";
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

        $this->permissionCheckNormal('role_list','normal');

        $data['page_title']     = 'Roles';
        $data['page_headline']  = 'Roles';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Roles\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_roles()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( name LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( created LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT * FROM roles $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'name',
            3 => 'created',
            4 => 'action',
        );

        $sql = "SELECT *";
        $sql .= " FROM roles $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $data['no']         = ++$count;
            $data['id']         = $row->id;
            $data['name']       = $row->name;
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
    
    public function add_role()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_role');
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
        $permissions = $this->request->getVar('permission');
       
        //Add Role
        $created = date("Y-m-d H:i:s");
        
        $insert_data = array(
                                "name"      => $name,
                                "created"   => $created,
                            );

        $role_insert = $this->CommonModel->common_insert_data('roles', $insert_data);
        
        if($role_insert != false)
        {
            $role_id = $role_insert;

            //Add Permission TO Role
            $data_array = array();
            $created = date("Y-m-d H:i:s");
            foreach($permissions as $permission)
            {
                $data['role_id'] = $role_id;
                $data['permission'] = $permission;
                $data['created'] = $created;
 
                array_push($data_array,$data);
            }

            $insert_role_permission  = $this->db->table('role_permissions')->insertBatch($data_array);

          
            if($insert_role_permission != false)
            {

                $activity_title = "Role Added Named " . $name;
                $this->addActivityLog($activity_title);

                $message = ['status' => '1', 'message' => 'New Role has been added!'];
                return json_encode($message);
            }
            else
            {
                $message = ['status' => '0', 'message' => 'Something went wrong!'];
                return json_encode($message);
            }
        }
        
       

    }
    
    public function delete()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('delete_role');
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

            $activity_title = "Role Deleted " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Role has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }
    
    public function update_role()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('role_update');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id             = $this->request->getVar('role_id');
        $name           = $this->request->getVar('edit_name');
        $permissions    = $this->request->getVar('permission');
       
        $filter = array("id" => $id);
        $update_data = array(
                                "name" => $name,
                            );
        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

        // Data which will be added
	
        $data_array = array();
        foreach($permissions as $permission)
        {
           
            $filter = array("role_id" => $id, "permission" => $permission);
            $exist = $this->CommonModel->get_by_condition('role_permissions',$filter);

            if(!empty($exist))
            {
                
            }
            else
            {
                $data['created'] = date('Y-m-d H:i:s');
                $data['role_id'] = $id;
                $data['permission'] = $permission;
                array_push($data_array,$data);
            }
        }
        if(!empty($data_array))
        {
            $insert_role_permission  = $this->db->table('role_permissions')->insertBatch($data_array);
        }
       
        $filter = array('role_id' => $id);
        $all_permissions = $this->CommonModel->get_by_condition('role_permissions',$filter);
        
    
		if(!empty($all_permissions))
        {
			// Permissions which will be deleted
			foreach ($all_permissions as $data) 
            {
				if(!in_array($data->permission, $permissions))
                {
                    $filter = array("id" => $data->id);
                    
                    $delete = $this->CommonModel->delete_data('role_permissions',$filter);

                    echo '<pre>';
                    print_r($filter);
                    die;
            
				}
			
			}
		}


        if ($update != false) 
        {
            $activity_title = "Role Updated " . $id;
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
    
    public function get_details_for_update()
    {
        $id = $this->request->getVar('id');

        $result_html = '';

        $filter         = array("id" => $id);
        
        $role_details   = $this->CommonModel->get_single('roles',$filter);
        $role_name      = $role_details->name;

        $filter = array("role_id" => $id);
        $role_permission = $this->CommonModel->get_by_condition('role_permissions',$filter);

        $filter = array("is_deleted" => 0);
        $all_role_permission  = $this->CommonModel->get_by_condition('permissions',$filter);


        $result_html .= '

                                <div class="form-group col-md-12">
                                    <input type="hidden" class="form-control" name="role_id" id="role_id" value="'.$id.'">
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="recipient-name" class="control-label">Name</label>
                                    <input type="text" class="form-control" name="edit_name" id="edit_name" value="'.$role_name.'">
                                </div>
                            
                                <div class="form-group col-md-12">
                                    <label for="recipient-name" class="control-label">Permissions</label>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                            <th>Name</th>
                                            <th class="text-center" width="50"><input type="checkbox" class="edit-check-select-all-p"></th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                                        if(!empty($all_role_permission))
                                        {
                                            foreach($all_role_permission as $row)
                                            {
                                               
                                                //$isChecked = in_array($row->code, $role_permission) ? 'checked' : '';
                                                if(array_search($row->code, array_column($role_permission, 'permission')) !== false)
                                                {
                                                    $isChecked = 'checked';
                                                }
                                                else
                                                {
                                                    $isChecked = '';
                                                }

                                                $result_html .='
                                                <tr>
                                                    <td>'.$row->title.'</td>
                                                   
                                                    <td width="50" class="text-center"><input type="checkbox" class="edit-check-select-p" name="permission[]" value="'.$row->code.'" '.$isChecked.'></td>
                                                    
                                                </tr>';
                                            }
                                        }
                                        $result_html .='
                                        </tbody>
                                        </table>
                                    </div>
                                </div>   

                                ';
            
            $val = ['status' => '1','role_update_form_in_model' => $result_html ,'message' => 'Success'];
            echo json_encode($val);
            die;
    }

 

}