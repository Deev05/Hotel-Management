<?php 
namespace App\Modules\Serviceprovidercontact\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Serviceprovidercontact extends BaseController {

    public function __construct()
    {
     	$this->CommonModel = new CommonModel();
        $this->table = "service_provider_contact";
        helper(['form', 'url']);
                $session = session()->get('service_provider_session');
        if($session == "")
        {
            header('location:/service_provider_login');
            exit();
        }
	}

    // Index
    public function index()
    {
        

        $session    = session()->get('service_provider_session');
        $id         = $session['id'];

        $submit = $this->request->getVar('submit');

        if($submit == "Submit")
        {

            $data = $this->fetch_data_from_post();
                  
            $update = $this->CommonModel->common_insert_data('service_provider_contact',$data);
            if($update != false)
            {
                $message = ['status' => '1', 'message' => 'Query Submitted Successfully!'];
                return json_encode($message);
                die;
            }
            else
            {
                $message = ['status' => '0', 'message' => 'Something went wrong!'];
                return json_encode($message);
                die;
            }
        }
        
        $data['id']     = $id;
        $data['page_title']     = 'Contact Support';
        $data['page_headline']  = 'Contact Support';
        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Serviceproviderhome\Views\service_provider_sidebar', $data);
        echo view('App\Modules\Serviceprovidercontact\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }

    public function fetch_data_from_post()
    {

        $session    = session()->get('service_provider_session');
        $id         = $session['id'];

        $data['service_provider_id'] = $id;
        $data['subject']            = $this->request->getVar('subject');
        $data['message']            = $this->request->getVar('message');
        $data['created']            = date("Y-m-d H:i:s");

        
        return $data;
    }
}