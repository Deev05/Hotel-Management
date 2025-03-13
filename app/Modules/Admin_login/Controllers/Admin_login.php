<?php

namespace App\Modules\Admin_login\Controllers;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Models\UserModel;

class Admin_login extends BaseController
{
    private $CommonModel;
    private $table;
    public function __construct()
    {
        $this->CommonModel = new CommonModel;

        $this->table = 'user';
        // helper(['form']);
    }

    public function index()
    {
        $data['page_headline'] = 'Admin Login';
        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);
        
        echo view('App\Modules\Admin_login\Views\index', $data);
        
    }

    public function login_check()
    {
        $session = session();
        
        $user_name = $this->request->getVar('user_name');
        $password = ($this->request->getVar('password'));
      
        
       
        $filter = array('user_name' => $user_name);
        $login_data = $this->CommonModel->get_single($this->table, $filter);

        if(is_null($login_data)) 
        {
            $message = ['status' => '0', 'message' => 'Invalid Username Or Password!'];
            return json_encode($message);
            die;
        }
        else if($password != $login_data->password) 
        {
            $message = ['status' => '0', 'message' => 'Invalid Username Or Password!'];
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

             session()->set("mySession", array(

                'id'            => $login_data->id,
                'full_name'     => $login_data->name,
                'user_name'     => $login_data->user_name,
                'role'          => $login_data->role,
                'email'         => $login_data->email,
                'contact'       => $login_data->contact,
                'isLoggedIn'    => TRUE
            ));

            $last_login = date('Y-m-d H:i:s');
            $last_login_ip_address = $_SERVER['REMOTE_ADDR'];
            
            $update_data = array(
                                    "logged_in"              => 1,
                                    "last_login"              => $last_login,
                                    "last_login_ip_address"   =>  $last_login_ip_address
                                );
            $filter = array("id" => $login_data->id);

            $update = $this->CommonModel->update_data('user',$update_data,$filter);
            
            $message = ['status' => '1', 'message' => 'Login Successfull!'];
            return json_encode($message);
            die;

        }

        


    }

    public function logout() 
    {
        $session        = session()->get('mySession');
        
        $update_data    = array("logged_in"  => 0);
        $filter         = array("id" => $session['id']);

        $update = $this->CommonModel->update_data('user',$update_data,$filter);

        session()->remove("mySession");
        return redirect()->to(base_url('/admin_login'));
    }

}