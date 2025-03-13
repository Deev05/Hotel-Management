<?php 
namespace App\Modules\Serviceproviders\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Serviceproviders extends BaseController {

    public function __construct()
    {
 
     	$this->CommonModel = new CommonModel();
        $this->table = "service_providers";
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
        $this->permissionCheckNormal('service_providers_list','normal');

        $data['page_title']     = 'Service Providers';
        $data['page_headline']  = 'Service Providers';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Serviceproviders\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_service_providers()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( name LIKE '%" . $_REQUEST['search']['value'] . "%') ";
            $where .= " or ( email LIKE '%" . $_REQUEST['search']['value'] . "%') ";
            $where .= " or ( contact LIKE '%" . $_REQUEST['search']['value'] . "%') ";
            $where .= " or ( created LIKE '%" . $_REQUEST['search']['value'] . "%') ";
            $where .= " or ( last_login_ip_address LIKE '%" . $_REQUEST['search']['value'] . "%') ";
            $where .= " or ( last_login LIKE '%" . $_REQUEST['search']['value'] . "%') ";
        }

        $totalRecordsSql = "SELECT * FROM service_providers $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'name',
            4 => 'email',
            5 => 'contact',
            6 => 'commission',
            7 => 'status',
            8 => 'logged_in',
            9 => 'last_login',
            10 => 'logged_in',
            11 => 'last_login_ip_address',
            12 => 'action',
            13 => 'pincode',
            14 => 'state',
            15 => 'city',
        );

        $sql = "SELECT *";
        $sql .= " FROM service_providers $where";
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
            $data['commission']                 = $row->commission;
            $data['pincode']                    = $row->pincode;
            $data['state']                      = $row->state;
            $data['city']                       = $row->city;
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
    
    public function add_service_provider()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_service_provider');
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
        $commission = $this->request->getVar('commission');
        $pincode    = $this->request->getVar('pincode');
        $state      = $this->request->getVar('state');
        $city       = $this->request->getVar('city');

       
        
        $created = date("Y-m-d H:i:s");
        
        $insert_data = array(
                                "name"          => $name,
                                "email"         => $email,
                                "contact"       => $contact,
                                "commission"    => $commission,
                                "pincode"       => $pincode,
                                "state"         => $state,
                                "city"          => $city,
                                "created"       => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('service_providers', $insert_data);
        
        if ($insert != false) 
        {

            $activity_title = "Created Service Provider Named " . $name;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New Service Provider has been added!'];
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
        $check = $this->permissionCheck('delete_service_provider');
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

            $activity_title = "Service Provider Deleted " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Service Provider has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }
    
    public function update_service_provider()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('update_service_provider');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id           = $this->request->getVar('service_provider_id');
        $name         = $this->request->getVar('edit_full_name');
        $email        = $this->request->getVar('edit_email');
        $contact      = $this->request->getVar('edit_contact');
        $commission   = $this->request->getVar('edit_commission');
        $pincode      = $this->request->getVar('edit_pincode');
        $state        = $this->request->getVar('edit_state');
        $city         = $this->request->getVar('edit_city');
        
        $filter = array("id" => $id);
        $update_data = array(
                                "name"          => $name,
                                "email"         => $email,
                                "contact"       => $contact,
                                "commission"    => $commission,
                                "pincode"       => $pincode,
                                "state"         => $state,
                                "city"          => $city,
                            );
        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

        if ($update != false) 
        {
            $activity_title = "Update Service Provider Details " . $id;
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
    
    public function service_provider_payments() 
    {
        $data['page_title']     = 'Service Provider Payments';
        $data['page_headline']  = 'Service Providers Payments';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Serviceproviders\Views\service_provider_payments', $data);
        echo view('App\Modules\Admin\Views\footer', $data); 
    }
    
    public function get_service_provider_payment_history()
    {

        $where = '';

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " Where ( payment_mode LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( transaction_id LIKE '%" . $_REQUEST['search']['value'] . "%' )";
           
        }

        $totalRecordsSql = "SELECT * FROM service_provider_payments $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array( 
            0 => 'id',
            1 => 'id',
            2 => 'applicant_no',
            3 => 'service_name',
            4 => 'payment_mode',
            5 => 'transaction_id',
            6 => 'package_price',
            7 => 'commission',
            8 => 'final_amount',
            9 => 'created',
        );

        $sql = "SELECT *";
        $sql .= " FROM service_provider_payments ";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $filter = array("id" => $row->application_id);
            $application = $this->CommonModel->get_single('sop_applications', $filter);

            $user_id = $application->user_id;
   
            ////////////////  Get User  ///////////////////////
            $filter = array("id" => $user_id);
            $user_details =  $this->CommonModel->get_single('user_master', $filter);
            
            ////////////////  Get Service Provider  ///////////////////////
            $filter = array("id" => $application->service_provider_id);
            $service_provider_details =  $this->CommonModel->get_single('service_providers', $filter);
            
            ////////////////  Get Package  ///////////////////////
            $filter = array("id" => $application->package_id);
            $package_details =  $this->CommonModel->get_single('sop_packages', $filter);
            
           ////////////////  Get Sop Service  ///////////////////////
            $filter = array("id" => $package_details->sop_service_id);
            $service_details =  $this->CommonModel->get_single('sop_services', $filter);
            
           ////////////////  Get Country  ///////////////////////
            $filter = array("id" => $package_details->sop_country_id);
            $country_details =  $this->CommonModel->get_single('sop_countries', $filter);
            
            $data['no']         = ++$count;
            $data['id']         = $row->id;
            
            $data['service_name']               = $service_details->name ." / ". $country_details->name ." / ". $package_details->name;
            $data['payment_mode']               = $row->payment_mode;
            $data['service_provider_name']      = $service_provider_details->name;
            $data['application_no']             = $application->application_no;
            $data['transaction_id']             = $row->transaction_id;
            $data['package_price']              = $row->package_price;
            $data['commission']                 = $row->commission;
            $data['final_amount']               =  $row->final_amount;
            $data['created']                    = $row->created;
            $data['application_id']             = $row->application_id;


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
    
    public function get_city_state()
    {
        $pincode =  $this->request->getVar('pincode');
        
        $filter = array("pincode"    => $pincode);
	    $exist  = $this->CommonModel->get_single("pincodes",$filter);
	    
	    if(!empty($exist))
	    {
	        $data = ['status' => '1', 'city' => $exist->district, 'state' => $exist->state ];
    		echo json_encode($data);
    		die;
	    }
	    else
	    {
	        $data = ['status' => '0', 'message' => 'Something Went Wrong.'];
    		echo json_encode($data);
    		die;
	    }
    }
    

}