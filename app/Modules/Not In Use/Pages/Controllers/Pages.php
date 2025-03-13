<?php 
namespace App\Modules\Pages\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;

class Pages extends BaseController {

    public function __construct()
    {
        $this->CommonModel = new CommonModel();
        $this->table = "pages";
	}

    public function about()
    {
        $filter = array("page" => 'about');
        $data['meta'] = $this->CommonModel->get_single('meta_data',$filter);

        

        $filter = array('id' => 1);
        $data['page'] = $this->CommonModel->get_single($this->table, $filter);

        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);
        
        $session = session()->get('userSession');
        if(!empty($session))
        {
            $user_id = $session['id'];
            $data['user_id'] = $session['id'];
        }
        else
        {
            $data['user_id'] = "";
        }

        echo view('App\Modules\Home\Views\header', $data);
        echo view('App\Modules\Pages\Views\about', $data);
        echo view('App\Modules\Home\Views\footer', $data);
    }

    public function terms_condition()
    {
        $data['title'] = "Terms Condition";
        
        $filter = array("page" => 'terms');
        $data['meta'] = $this->CommonModel->get_single('meta_data',$filter);        

        $filter = array('id' => 1);
        $data['page'] = $this->CommonModel->get_single($this->table, $filter);

        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);
        
        $session = session()->get('userSession');
        if(!empty($session))
        {
            $user_id = $session['id'];
            $data['user_id'] = $session['id'];
        }
        else
        {
            $data['user_id'] = "";
        }

        echo view('App\Modules\Home\Views\header', $data);
        echo view('App\Modules\Pages\Views\terms_condition', $data);
        echo view('App\Modules\Home\Views\footer', $data);
    }

    public function privacy_policy()
    {
        $data['title'] = "Privacy Policy";
        
     
        $filter = array('id' => 1);
        $data['page'] = $this->CommonModel->get_single($this->table, $filter);

        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);
        
        $session = session()->get('userSession');
        if(!empty($session))
        {
            $user_id = $session['id'];
            $data['user_id'] = $session['id'];
        }
        else
        {
            $data['user_id'] = "";
        }

        echo view('App\Modules\Pages\Views\privacy_policy', $data);
    }

    public function return_policy()
    {
        $data['title'] = "Return Policy";

        $filter = array("page" => 'return');
        $data['meta'] = $this->CommonModel->get_single('meta_data',$filter);

        $filter = array('id' => 1);
        $data['page'] = $this->CommonModel->get_single($this->table, $filter);

        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);
        
        $session = session()->get('userSession');
        if(!empty($session))
        {
            $user_id = $session['id'];
            $data['user_id'] = $session['id'];
        }
        else
        {
            $data['user_id'] = "";
        }
        
        echo view('App\Modules\Home\Views\header', $data);
        echo view('App\Modules\Pages\Views\return_policy', $data);
        echo view('App\Modules\Home\Views\footer', $data);
    }
    
        public function contact()
    {
        $data['title'] = "Contact";
        
        $filter = array("page" => 'contact');
        $data['meta'] = $this->CommonModel->get_single('meta_data',$filter);        

        $filter = array('id' => 1);
        $data['page'] = $this->CommonModel->get_single($this->table, $filter);

        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);
        
        $session = session()->get('userSession');
        if(!empty($session))
        {
            $user_id = $session['id'];
            $data['user_id'] = $session['id'];
        }
        else
        {
            $data['user_id'] = "";
        }

        echo view('App\Modules\Home\Views\header', $data);
        echo view('App\Modules\Pages\Views\contact', $data);
        echo view('App\Modules\Home\Views\footer', $data);
    }

    public function create()
    {
        $name       = $this->request->getVar('name');
        $email      = $this->request->getVar('email');
        $subject    = $this->request->getVar('subject');
        $message    = $this->request->getVar('message');

        $data = array(
            "name"      => $name,
            "email"     => $email,
            "subject"   => $subject,
            "message"   => $message,
            "created"   => date('Y-m-d h:i:s')
        );

        $insert = $this->CommonModel->common_insert_data('contact', $data);

        if ($insert != false) {
            session()->setFlashdata('msg', 'Message Sent');
            return redirect()->to(base_url('contact'));
        } else {
            session()->setFlashdata('error', 'Something Went Wrong!');
            return redirect()->to(base_url('contact'));
        }
    }
   
}