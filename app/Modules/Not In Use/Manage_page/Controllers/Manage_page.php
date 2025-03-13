<?php

namespace App\Modules\Manage_page\Controllers;

use App\Controllers\BaseController;
use App\Models\CommonModel;


class Manage_page extends BaseController
{

    public function __construct()
    {
        $this->CommonModel = new CommonModel();
        $this->table = "pages";
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
        $id = $this->request->getVar('id');
        $submit = $this->request->getVar('submit');

        if ($submit == "Submit") {
            $data = $this->fetch_data_from_post();

            if (is_numeric($id)) {
                $update = $this->CommonModel->common_update_data($this->table, $id, $data);

                if ($update != false) {
                    $_SESSION['message'] = 'Setting Details Updated!';
                    session()->markAsFlashdata("message");
                    return redirect()->to(base_url('manage_page'));
                } else {
                    $_SESSION['message'] = 'No Changes Found!';
                    session()->markAsFlashdata("message");
                    return redirect()->to(base_url('manage_page'));
                }
            }
        }

        $data = $this->fetch_data_from_db();
        $data['page_title'] = 'Pages';
        $data['page_headline'] = 'Pages';

        $filter = array('id' => 1);
        $data['setting'] = $this->CommonModel->get_single('setting', $filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Manage_page\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }

    // Database Data
    public function fetch_data_from_db()
    {
        $filter = array('id' => 1);
        $page = $this->CommonModel->get_single($this->table, $filter);

        $data['id']                 = $page->id;
        $data['about']              = $page->about;
        $data['terms_condition']    = $page->terms_condition;
        $data['privacy_policy']     = $page->privacy_policy;
        return $data;
    }

    // Post Data
    public function fetch_data_from_post()
    {
        $data['id']                 = $this->request->getVar('id');
        $data['about']              = $this->request->getVar('about');
        $data['terms_condition']    = $this->request->getVar('terms_condition');
        $data['privacy_policy']     = $this->request->getVar('privacy_policy');
        return $data;
    }
}
