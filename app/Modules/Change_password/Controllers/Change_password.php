<?php 
namespace App\Modules\Change_password\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Change_password extends BaseController {

    public function __construct()
    {
     	$this->CommonModel = new CommonModel();
        $this->table = "setting";
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
        

        $session    = session()->get('mySession');
        $id         = $session['id'];

        $submit = $this->request->getVar('submit');

        if($submit == "Submit")
        {
            
            $filter = array("id" => $id);
            $user = $this->CommonModel->get_single("user",$filter);
            $db_current_password = $user->password;

            $data = $this->fetch_data_from_post();

            $current_password = md5($data['current_password']);
            $new_password = md5($data['new_password']);
            $repeat_password = md5($data['repeat_password']);
            
                if($current_password != $db_current_password)
            {
                $message = ['status' => '0', 'message' => 'Current Passowrd Mismatch!'];
                return json_encode($message);
                die;
            }
            else
            {
                
                    $data = array(
                                    "password" => $new_password,
                                );
                                
                        $update = $this->CommonModel->common_update_data('user',$id,$data);

                    if($update != false)
                    {
                        $message = ['status' => '1', 'message' => 'Password changed successfully!'];
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

        }
        
        $data['id']     = $id;
        $data['page_title']     = 'Change Password';
        $data['page_headline']  = 'Change Password';
        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Change_password\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }

    public function fetch_data_from_post()
    {
        $data['id']                     = $this->request->getVar('id');
        $data['current_password']       = $this->request->getVar('current_password');
        $data['new_password']           = $this->request->getVar('new_password');
        $data['repeat_password']           = $this->request->getVar('repeat_password');

        
        return $data;
    }
}