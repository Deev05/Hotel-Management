<?php 
namespace App\Modules\Activitylogs\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Activitylogs extends BaseController {

    public function __construct()
    {
        $this->db = db_connect();
     	$this->CommonModel = new CommonModel();
        $this->table = "activity_logs";
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

        $data['page_title'] = 'Activity logs';
        $data['page_headline'] = 'Activity logs';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['user_master']   = $this->CommonModel->get_all_data($this->table);
        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);
        
        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Activitylogs\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    
    public function get_activity_logs()
    {

        $filter_dates = $this->request->getVar('filter_dates');

        $where = '';
        //$where .= " WHERE is_deleted = 0";

        

        ///////////ORDER DATEWISE FILTER STARTS
        if (!empty($filter_dates)) {
            $split = explode('-', $filter_dates);

            #check make sure have 2 elements in array
            $count = count($split);
            if ($count <> 2) {
                #invalid data
            }

            $start = $split[0];

            $startdate = str_replace('/', '-', $start);
            $startdate = date('Y-m-d', strtotime($startdate));

            $end = $split[1];

            $enddate = str_replace('/', '-', $end);
            $enddate = date('Y-m-d', strtotime($enddate));

            $where .= " where (created BETWEEN '$startdate' AND '$enddate') ";
            
            if (!empty($_REQUEST['search']['value'])) {
            $where .= " and ( title LIKE '%" . $_REQUEST['search']['value'] . "%' )";
           
            }
        }
        else
        {
            if (!empty($_REQUEST['search']['value'])) {
            $where .= " where ( title LIKE '%" . $_REQUEST['search']['value'] . "%' )";
           
            }
        }
        ///////////ORDER DATEWISE FILTER ENDS



        $totalRecordsSql = "SELECT * FROM activity_logs $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'ip_address',
            3 => 'message',
            4 => 'user',
            5 => 'role',
            6 => 'created',
            7 => 'action',
        );

        $sql = "SELECT *";
        $sql .= " FROM activity_logs $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

    

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {


            $filter = array("id" => $row->user);
            $user_details = $this->CommonModel->get_single("user",$filter);
            $user_name = $user_details->name;
            $user_role = $user_details->role;


            $filter = array("id" => $user_role);
            $role_details = $this->CommonModel->get_single("roles",$filter);
            $role_name = $role_details->name;

            $data['no']             = ++$count;
            $data['id']             = $row->id;
            $data['ip_address']     = $row->ip_address;
            $data['message']        = $row->title;
            $data['user']           = $user_name;
            $data['role']           = $role_name;
            $data['created']        = $row->created;


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
        $id = $this->request->uri->getSegment(3);
        $data['page_title'] = 'Profile Details';
        $data['page_headline'] = 'Profile Details';
        $order[0] = "id";
        $order[1] = "DESC";
        
        $filter = array("id" => $id);
        $data['user_master'] = $this->CommonModel->get_single($this->table,$filter);

        $query = "select count(user_id) as total_videos from videos where user_id = $id and is_deleted = 0 and status = 1 and dueter_user_id = 0";
        $lifetime_video_count = $this->CommonModel->custome_query_single_record($query);
        $data['video_counts'] =    $lifetime_video_count->total_videos;
        
        
        $vquery = "select * from videos where user_id = $id and is_deleted = 0 and status = 1 and dueter_user_id = 0";
        $data['videos'] = $this->CommonModel->custome_query($vquery);
    

        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);
        
        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Activitylogs\Views\single_details', $data);
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
            $_SESSION['message'] = 'Status Updated!';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('activitylogs'));
		}
		else
		{
		    $filter = array("id" => $id);
		    $update_data = array("status" => 1);
	    	$update = $this->CommonModel->update_data($this->table,$update_data,$filter);
            $_SESSION['message'] = 'Status Updated!';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('activitylogs'));
		}

        $_SESSION['message'] = 'Something Went Wrong!';
        session()->markAsFlashdata("message");
	    return redirect()->to(base_url('activitylogs'));
	}
}