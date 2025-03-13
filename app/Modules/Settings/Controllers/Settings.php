<?php 
namespace App\Modules\Settings\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Settings extends BaseController {
    protected $CommonModel;
    protected $table;

    public function __construct()
    {
     	$this->CommonModel = new CommonModel();
        $this->table = "setting";
        helper(['form', 'url']);
	}

    public function index()
    {
        $session = session()->get('mySession');
        if($session == "")
        {
            header('location:/admin_login');
            exit();
        }
        
        $id = $this->request->getVar('id');
        $submit = $this->request->getVar('submit');

        if($submit == "Submit")
        {
            
     

            ////////////////////////Check Permission/////////////////
            $check = $this->permissionCheck('general_settings');
            $check_resp = json_decode($check);
            $status = $check_resp->status;
            if($status == 0)
            {
                $message = ['status' => '0', 'message' => 'Permission Deined!'];
                return json_encode($message);
                die;
            }
            ////////////////////////Check Permission/////////////////

		    $data = $this->fetch_data_from_post();

            if(is_numeric($id))
            {
                if(!file_exists($_FILES['logo']['tmp_name']) || !is_uploaded_file($_FILES['logo']['tmp_name'])) 
                {
                    $filter = array("id" => $id);
                    $query = $this->CommonModel->get_single($this->table, $filter);
                    $data['logo'] = $query->logo;
                }
                else
                {
                     $tmp = explode(".",$_FILES["logo"]["name"]);
                    $file_extension = end($tmp);
                    $newfilename = time() . '_' . rand(100, 999) . '.' . $file_extension;
                    
                    $data['logo'] = $newfilename;
                    $file_name = $newfilename;
                    $file_path = $_FILES['logo']['tmp_name'];
                    $file_error = $_FILES['logo']['error'];

                    $file_destination ='uploads/setting/'.$file_name;
                    move_uploaded_file($file_path, $file_destination);
                }

                if(!file_exists($_FILES['favicon']['tmp_name']) || !is_uploaded_file($_FILES['favicon']['tmp_name'])) 
                {
                    $filter = array("id" => $id);
                    $query = $this->CommonModel->get_single($this->table, $filter);
                    $data['favicon'] = $query->favicon;
                }
                else
                {
                    $tmp = explode(".",$_FILES["favicon"]["name"]);
                    $file_extension = end($tmp);
                    $newfilename = time() . '_' . rand(100, 999) . '.' . $file_extension;
                    
                    $data['favicon'] = $newfilename;
                    $file_name = $newfilename;
                    $file_path = $_FILES['favicon']['tmp_name'];
                    $file_error = $_FILES['favicon']['error'];

                    $file_destination ='uploads/setting/'.$file_name;
                    move_uploaded_file($file_path, $file_destination);
                }
                
                
                if(!file_exists($_FILES['light_logo']['tmp_name']) || !is_uploaded_file($_FILES['light_logo']['tmp_name'])) 
                {
                    $filter = array("id" => $id);
                    $query = $this->CommonModel->get_single($this->table, $filter);
                    $data['light_logo'] = $query->light_logo;
                }
                else
                {
                    $tmp = explode(".",$_FILES["light_logo"]["name"]);
                    $file_extension = end($tmp);
                    $newfilename = time() . '_' . rand(100, 999) . '.' . $file_extension;
                    
                    $data['light_logo'] = $newfilename;
                    $file_name = $newfilename;
                    $file_path = $_FILES['light_logo']['tmp_name'];
                    $file_error = $_FILES['light_logo']['error'];

                    $file_destination ='uploads/setting/'.$file_name;
                    move_uploaded_file($file_path, $file_destination);
                }


                $update = $this->CommonModel->common_update_data($this->table,$id,$data);

                if($update != false)
                {
                    $message = ['status' => '1', 'message' => 'Changes saved successfully!'];
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
        
        $data = $this->fetch_data_from_db();
        $data['page_title'] = 'Settings';
        $data['page_headline'] = 'Settings';
        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);
        
        $filter = array( 'id' => 1 );
        $data['app_settings'] = $this->CommonModel->get_single('app_settings',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Settings\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }

    public function fetch_data_from_db()
    {
        $filter = array( 'id' => 1 );
        $setting = $this->CommonModel->get_single('setting',$filter);

        $data['id']             = $setting->id;
        $data['name']           = $setting->name;
        $data['headline']       = $setting->headline;
        $data['contact']        = $setting->contact;
        $data['contact_two']    = $setting->contact_two;
        $data['email']          = $setting->email;
        $data['address']        = $setting->address;
        $data['address_two']    = $setting->address_two;
        $data['logo']           = $setting->logo;
        $data['favicon']        = $setting->favicon;
        $data['light_logo']     = $setting->light_logo;
        return $data;
    }

    public function fetch_data_from_post()
    {
        $data['id']             = $this->request->getVar('id');
        $data['name']           = $this->request->getVar('name');
        $data['headline']       = $this->request->getVar('headline');
        $data['contact']        = $this->request->getVar('contact');
        $data['email']          = $this->request->getVar('email');
        $data['address']        = $this->request->getVar('address');
        $data['logo']           = $this->request->getVar('logo');
        $data['favicon']        = $this->request->getVar('favicon');
        $data['light_logo']     = $this->request->getVar('light_logo');

        return $data;
    }
    
    public function get_details()
    {
        
        $data['page_title'] = 'Settings';
        $data['page_headline'] = 'Settings';
        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);
        
        $query = "select * from users";
        $api_users = $this->CommonModel->custome_query($query);
        $data['api_keys']  = $api_users;
        
        $query = "select * from user";
        $admin_users = $this->CommonModel->custome_query($query);
        $data['admin_users']  = $admin_users;
        
        echo view('App\Modules\Settings\Views\settings', $data);

    }
    
    public function change_api()
    {
        $id = $this->request->getVar('id');
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        
        $filter = array("id" => $id);
        $update_data = array("email" => $email,"password" => $password);
        $update = $this->CommonModel->update_data("users",$update_data,$filter);
        
    }
    
    public function change_admin()
    {
        $id = $this->request->getVar('id');
        $user_name = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        $filter = array("id" => $id);
        $update_data = array("user_name" => $user_name,"password" => $password);
        $update = $this->CommonModel->update_data("user",$update_data,$filter);
        
    }

    public function update_payment_method_status()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('payment_methods');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id = $this->request->getVar('pid');
        $status = $this->request->getVar('status');

        $filter = array("id" => $id);
        $update_data = array("status" => $status);
        $update = $this->CommonModel->update_data('payment_methods',$update_data,$filter);

        if($update != false)
        {
            $message = ['status' => '1', 'message' => 'Payment Method Updated!'];
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

    public function app_settings()
    {


        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('app_settings');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id = $this->request->getVar('id');
   
        $data['app_name']               = $this->request->getVar('app_name');
        $data['primary_color']          = $this->request->getVar('primary_color');
        $data['secondary_color']        = $this->request->getVar('secondary_color');
        $data['text_color_dark']        = $this->request->getVar('text_color_dark');
        $data['text_color_semi_dark']   = $this->request->getVar('text_color_semi_dark');
        $data['text_color_light']       = $this->request->getVar('text_color_light');
        $data['app_logo']               = $this->request->getVar('app_logo');
        $data['app_version']            = $this->request->getVar('app_version');

        if(!file_exists($_FILES['app_logo']['tmp_name']) || !is_uploaded_file($_FILES['app_logo']['tmp_name'])) 
        {
            $filter = array("id" => $id);
            $query = $this->CommonModel->get_single('app_settings', $filter);
            $data['app_logo'] = $query->app_logo;
        }
        else
        {
            $tmp = explode(".",$_FILES["app_logo"]["name"]);
            $file_extension = end($tmp);
            $newfilename = time() . '_' . rand(100, 999) . '.' . $file_extension;
            
            $data['app_logo'] = $newfilename;
            $file_name = $newfilename;
            $file_path = $_FILES['app_logo']['tmp_name'];
            $file_error = $_FILES['app_logo']['error'];

            $file_destination ='uploads/setting/'.$file_name;
            move_uploaded_file($file_path, $file_destination);
        }

        $update = $this->CommonModel->common_update_data('app_settings',$id,$data);

        if($update != false)
        {
            $message = ['status' => '1', 'message' => 'Changes saved successfully!'];
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


    public function social_media_links()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('social_media_links');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id = $this->request->getVar('id');
   
        $data['instagram_url']  = $this->request->getVar('instagram_url');
        $data['facebook_url']   = $this->request->getVar('facebook_url');
        $data['twitter_url']    = $this->request->getVar('twitter_url');
        $data['pinterest_url']  = $this->request->getVar('pinterest_url');
        $data['youtube_url']    = $this->request->getVar('youtube_url');
    
        $update = $this->CommonModel->common_update_data('setting',$id,$data);

        if($update != false)
        {
            $message = ['status' => '1', 'message' => 'Changes saved successfully!'];
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


    public function layout_settings()
    {

        $filter = array("id" => 1);
        $layout_settings = $this->CommonModel->get_single("layout_settings",$filter);

        $message = [
                    'status'            => '1', 
                    'mode'              => $layout_settings->mode,
                    'logobgskin'        => $layout_settings->logo_background,
                    'sidebarbgskin'     => $layout_settings->sidebar_background,
                    'navbarbgskin'     => $layout_settings->navbar_background,
                    'message'           => 'Changes saved successfully!'
                ];
        return json_encode($message);
        die;
    }

    public function change_theme_view()
    {
        $mode = $this->request->getVar('theme_view');

        $filter = array("id" => 1);
        $update_data = array("mode" => $mode);
        $update = $this->CommonModel->update_data("layout_settings",$update_data,$filter);

        $message = ['status' => '1', 'message' => 'Changes saved successfully!'];
        return json_encode($message);
        die;

    }

    public function change_logo_backround()
    {
        $logobgskin = $this->request->getVar('logobgskin');

        $filter = array("id" => 1);
        $update_data = array("logo_background" => $logobgskin);
        $update = $this->CommonModel->update_data("layout_settings",$update_data,$filter);

        $message = ['status' => '1', 'message' => 'Changes saved successfully!'];
        return json_encode($message);
        die;

    }

    public function change_sidebar_backround()
    {
        $sidebarbgskin = $this->request->getVar('sidebarbgskin');

        $filter = array("id" => 1);
        $update_data = array("sidebar_background" => $sidebarbgskin);
        $update = $this->CommonModel->update_data("layout_settings",$update_data,$filter);

        $message = ['status' => '1', 'message' => 'Changes saved successfully!'];
        return json_encode($message);
        die;

    }


    public function change_navbar_backround()
    {
        $navbarbgskin = $this->request->getVar('navbarbgskin');

        $filter = array("id" => 1);
        $update_data = array("navbar_background" => $navbarbgskin);
        $update = $this->CommonModel->update_data("layout_settings",$update_data,$filter);

        $message = ['status' => '1', 'message' => 'Changes saved successfully!'];
        return json_encode($message);
        die;

    }
    
}