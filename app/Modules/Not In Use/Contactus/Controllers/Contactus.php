<?php 
namespace App\Modules\Contactus\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Contactus extends BaseController {

    public function __construct()
    {
     	$this->CommonModel = new CommonModel();
        $this->table = "contact";
        
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

        $data['page_title'] = 'User Contact Inquiry';
        $data['page_headline'] = 'User Contact Inquiry';
        $order[0] = "id";
        $order[1] = "DESC";

        $data['contactus']   = $this->CommonModel->get_all_data($this->table);
        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);
        
        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Contactus\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function service_provider_contact_inquiry()
    {

        $data['page_title'] = 'Service Provier Contact Inquiry';
        $data['page_headline'] = 'Service Provier Contact Inquiry';
        $order[0] = "id";
        $order[1] = "DESC";

        $data['contactus']   = $this->CommonModel->get_all_data("service_provider_contact");
        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);
        
        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Contactus\Views\serviceprovidercontact', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }

}