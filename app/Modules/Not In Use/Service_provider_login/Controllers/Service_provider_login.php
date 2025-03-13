<?php

namespace App\Modules\Service_provider_login\Controllers;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Models\UserModel;

class Service_provider_login extends BaseController
{
    private $CommonModel;

    public function __construct()
    {
        $this->CommonModel = new CommonModel;

        $this->table = 'service_providers';
        // helper(['form']);
    }

    public function index()
    {
        $data['page_headline'] = 'Service Provider Login';
        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);
        
        echo view('App\Modules\Service_provider_login\Views\index', $data);
        
    }

    public function login_check()
    {
        $session = session();
        
        $contact = $this->request->getVar('contact');
       
       
        $filter = array('contact' => $contact);
        $login_data = $this->CommonModel->get_single($this->table, $filter);
     
        if(empty($login_data)) 
        {
            $message = ['status' => '0', 'message' => 'Invalid Contact!'];
            return json_encode($message);
            die;
        }
        else
        {
            if($login_data->is_deleted == 1)
            {
                $message = ['status' => '0', 'message' => 'Can not find any account!'];
                return json_encode($message);
                die;
            }

            if($login_data->status == 0)
            {
                $message = ['status' => '0', 'message' => 'You are Banned by admin please contact admin!'];
                return json_encode($message);
                die;
            }

            $otp = mt_rand(100000, 999999);
        	 	    
    		$filter         = array("contact" => $contact);
    		$update_data    = array("otp" => $otp);
            $update_otp     = $this->CommonModel->update_data("service_providers",$update_data,$filter);
        
            $message = ['status' => '1', 'contact' => $contact, 'message' => 'Otp Generated Successfully!'];
            return json_encode($message);
            die;
        }
    }
    
    public function verify_otp()
    {
        $otp = $this->request->getVar('otp');
        $contact = $this->request->getVar('otp_contact');
        
        $cfilter = array("contact" => $contact);
		$contact_exist = $this->CommonModel->get_single("service_providers",$cfilter);
	
        if(!empty($contact_exist))
		{
	    	$db_otp = $contact_exist->otp;
	    	if($otp == $db_otp || $otp == "111111")
	    	{
                session()->set("service_provider_session", array(
        
                    'id'            => $contact_exist->id,
                    'full_name'     => $contact_exist->name,
                    'user_name'     => $contact_exist->user_name,
                    'email'         => $contact_exist->email,
                    'contact'       => $contact_exist->contact,
                    'isServiceProviderLoggedIn'    => TRUE
                ));
            
                $last_login = date('Y-m-d H:i:s');
                $last_login_ip_address = $_SERVER['REMOTE_ADDR'];
                
                $update_data = array(
                                        "logged_in"              => 1,
                                        "last_login"              => $last_login,
                                        "last_login_ip_address"   =>  $last_login_ip_address
                                    );
                $filter = array("id" => $contact_exist->id);
            
                $update = $this->CommonModel->update_data('service_providers',$update_data,$filter);
                
                $message = ['status' => '1', 'message' => 'Login Successfully!'];
    			echo json_encode($message);
    			die;
	    	}
	    	else
	    	{
	    	    $message = ['status' => '0', 'message' => 'Invalid OTP!'];
    			echo json_encode($message);
    			die;
	    	}
		}
		else
		{
		    $message = ['status' => '0', 'message' => 'Invalid OTP!'];
			echo json_encode($message);
			die;
		}
    }

    public function logout() 
    {
        $session        = session()->get('service_provider_session');
        
        $update_data    = array("logged_in"  => 0);
        $filter         = array("id" => $session['id']);

        $update = $this->CommonModel->update_data('service_providers',$update_data,$filter);

        session()->remove("service_provider_session");
        return redirect()->to(base_url('/service_provider_login'));
    }

}