<?php
namespace App\Modules\Errors\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;

class Errors extends BaseController
{
    private $db;
    private $CommonModel;

    public function __construct()
    {
        $this->db = db_connect();

        $this->CommonModel = new CommonModel;
    }
    

    public function index()
    {
        $mySession = session()->get('userdata');

        if(empty($mySession))
        {
            return redirect()->to(base_url('/admin_login'));
        }       
    }
	
    public function denied()
    {
        
        $data['page_title']     = 'Error';
        $data['page_headline']  = 'Error';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header_two', $data);
        echo view('App\Modules\Errors\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }


}

?>