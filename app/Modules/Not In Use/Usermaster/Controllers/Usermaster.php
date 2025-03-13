<?php 
namespace App\Modules\Usermaster\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Usermaster extends BaseController {

    public function __construct()
    {
        $this->db = db_connect();
     	$this->CommonModel = new CommonModel();
        $this->table = "user_master";
        helper(['form', 'url']);
        
        $session = session()->get('mySession');
        if($session == "")
        {
            header('location:/admin_login');
            exit();
        }
	}

    // Index
    public function index()
    {

        $data['page_title'] = 'Users';
        $data['page_headline'] = 'Users';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['user_master']   = $this->CommonModel->get_all_data($this->table);
        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);
        
        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Usermaster\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    
    public function get_usermaster()
    {
        $where = '';
        //$where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( firstname LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( lastname LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( email LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( contact LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT * FROM user_master $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'firstname',
            3 => 'lastname',
            4 => 'email',
            5 => 'contact',
            6 => 'profile_picture',
            7 => 'gst_no',
            8 => 'out_of_state',
            9 => 'status',
            10 => 'created',
            11 => 'action',
        );

        $sql = "SELECT *";
        $sql .= " FROM user_master $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $data['no']         = ++$count;
            $data['id']         = $row->id;
            $data['firstname']       = $row->firstname;
            $data['lastname']       = $row->lastname;
            $data['email']       = $row->email;
            $data['contact']      = $row->contact;
            $data['profile_picture']      = $row->profile_picture;
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
    

    public function single_details()
    {

        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);

        $id = $this->request->uri->getSegment(3);
        $data['page_title'] = 'Profile Details';
        $data['page_headline'] = 'Profile Details';
        $order[0] = "id";
        $order[1] = "DESC";
        
        $filter = array("id" => $id);
        $data['user_master'] = $this->CommonModel->get_single($this->table,$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Usermaster\Views\single_details', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }

    // Status Change
    public function change_status()
	{
        $id = $this->request->uri->getSegment(3);
	    
	    $filter = array("id" => $id);
		$data =  $this->CommonModel->get_single($this->table,$filter);
		
		$status = $data->status;
		
		if($status == 1)
		{
		    $filter = array("id" => $id);
		    $update_data = array("status" => 0);
	    	$update = $this->CommonModel->update_data($this->table,$update_data,$filter);
	    	
            $message = ['status' => '1', 'message' => 'Status Updated!'];
            return json_encode($message);
            die;
		}
		else
		{
		    $filter = array("id" => $id);
		    $update_data = array("status" => 1);
	    	$update = $this->CommonModel->update_data($this->table,$update_data,$filter);
	    	
            $message = ['status' => '1', 'message' => 'Status Updated!'];
            return json_encode($message);
            die;
		}

        
	}
	
	
	public function get_user_applications()
    {
     
        $user_id = $this->request->uri->getSegment(3);  
       
       
        $where = '';
        $where .= " WHERE user_id = $user_id and is_deleted = 0";
       
        

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( applicant_name LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( contact LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( email LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT * FROM sop_applications $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array( 
            0 => 'id',
            1 => 'id',
            2 => 'applicantion_no',
            3 => 'applicant_name',
            4 => 'contact',
            5 => 'draft_status',
            6 => 'email',
            7 => 'created',
        );

        $sql = "SELECT *";
        $sql .= " FROM sop_applications $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $filter = array("id" => $row->service_provider_id);
            $service_provider = $this->CommonModel->get_single("service_providers",$filter);

            if(!empty($service_provider))
            {
                $data['service_provider'] = $service_provider->name;
            }
            else
            {
                $data['service_provider'] = "Not Assigned";
            }
            
            $data['no']         = ++$count;
            $data['id']         = $row->id;
            $data['application_no']       = $row->application_no;
            $data['applicant_name']       = $row->applicant_name;
            $data['contact']       = $row->contact;
            $data['email']       = $row->email;
  
            $data['application_status']     = $row->application_status;
            $data['draft_status']     = $row->draft_status;
            $data['status']     = $row->status;
            $data['payment_status']     = $row->payment_status;
            $data['edit_mode']     = $row->edit_mode;
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


}