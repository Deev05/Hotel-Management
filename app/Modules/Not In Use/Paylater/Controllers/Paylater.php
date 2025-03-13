<?php 
namespace App\Modules\Paylater\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Paylater extends BaseController {

    public function __construct()
    {
 
     	$this->CommonModel = new CommonModel();
        $this->table = "paylater_transactions";
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

        $this->permissionCheckNormal('view_paylater_history','normal');

        $data['page_title']     = 'Paylater History';
        $data['page_headline']  = 'Paylater History';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Paylater\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_paylater_history()
    {
        $where = '';
        //$where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( full_name LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( contact LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( title LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( type LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( amount LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( p.created LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT p.*, u.full_name,u.contact FROM paylater_transactions p, user_master u WHERE p.user_id = u.id";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'full_name',
            3 => 'contact',
            4 => 'title',
            5 => 'type',
            6 => 'before_utilized',
            7 => 'after_utilized',
            8 => 'amount',
            9 => 'created',
     
        );

        $sql = "SELECT ";
        $sql .= " p.*, u.full_name,u.contact FROM paylater_transactions p, user_master u WHERE p.user_id = u.id $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $data['no']         = ++$count;
            $data['id']         = $row->id;
            $data['title']       = $row->title;
            $data['type']       = $row->type;
            $data['before_utilized']       = $row->before_utilized;
            $data['after_utilized']       = $row->after_utilized;
            $data['amount']       = $row->amount;
            $data['full_name']       = $row->full_name;
            $data['contact']       = $row->contact;
            $data['created']       = $row->created;

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