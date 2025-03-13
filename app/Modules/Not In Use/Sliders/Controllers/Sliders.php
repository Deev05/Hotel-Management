<?php 
namespace App\Modules\Sliders\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Sliders extends BaseController {

    public function __construct()
    {
 
     	$this->CommonModel = new CommonModel();
        $this->table = "sliders";
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

        $this->permissionCheckNormal('view_sliders','normal');

        $data['page_title']     = 'Sliders & Banners';
        $data['page_headline']  = 'Sliders & Banners';
       
        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Sliders\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_sliders()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

   

        $totalRecordsSql = "SELECT * FROM sliders $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'type',
            3 => 'image',
            4 => 'status',
            5 => 'created',
            6 => 'action',
        );

        $sql = "SELECT *";
        $sql .= " FROM sliders $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            
          
            $data['no']             = ++$count;
            $data['id']             = $row->id;
            $data['type']           = $row->type;
            $data['image']          = $row->image;
            $data['status']         = $row->status;
            $data['created']        = $row->created;


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
    
    public function add_slider()
    {
        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_slider');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $type = $this->request->getVar('type');

      

        $image_info = getimagesize($_FILES["image"]["tmp_name"]);
        $image_width = $image_info[0];
        $image_height = $image_info[1];

        // if($image_width > 250 || $image_height > 250)
        // {
        //     $message = ['status' => '0', 'message' => 'Image size must be 250 x 250!'];
        //     return json_encode($message);
        // }

   

        $tmp            = explode(".",$_FILES["image"]["name"]);
        $file_extension = end($tmp);
        $newfilename    = time() . '_' . rand(100, 999) . '.' . $file_extension;
        
        $data['image']      = $newfilename;
        $file_name          = $newfilename;
        $file_path          = $_FILES['image']['tmp_name'];
        $file_error         = $_FILES['image']['error'];

        $file_destination ='uploads/sliders/'.$file_name;
        move_uploaded_file($file_path, $file_destination);
        

        $created = date("Y-m-d H:i:s");
        
        $insert_data = array(
                                "type"      => $type,
                                "image"     => $file_name,
                                "created"   => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('sliders', $insert_data);
        
        if ($insert != false) 
        {
            $activity_title = "Created a Slider & Banner ";
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New Slider has been added!'];
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
        $check = $this->permissionCheck('delete_slider');
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

            $activity_title = "Removed Slider " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Slider has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }
    
    public function update_slider()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('update_slider');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id             = $this->request->getVar('slider_id');
        $type           = $this->request->getVar('edit_type');
        $image          = $this->request->getVar('edit_slider_image');

        if(!file_exists($_FILES['edit_slider_image']['tmp_name']) || !is_uploaded_file($_FILES['edit_slider_image']['tmp_name'])) 
        {
            $filter = array("id" => $id);
            $query  = $this->CommonModel->get_single('sliders', $filter);
            $image  = $query->image;
        }
        else
        {
            $tmp            = explode(".",$_FILES["edit_slider_image"]["name"]);
            $file_extension = end($tmp);
            $newfilename    = time() . '_' . rand(100, 999) . '.' . $file_extension;
            
            $image          = $newfilename;
            $file_name      = $newfilename;
            $file_path      = $_FILES['edit_slider_image']['tmp_name'];
            $file_error     = $_FILES['edit_slider_image']['error'];

            $file_destination ='uploads/sliders/'.$file_name;
            move_uploaded_file($file_path, $file_destination);
        }
        
        $filter = array("id" => $id);
        $update_data = array("type" => $type,"image" => $image);
        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

        if ($update != false) 
        {

            $activity_title = "Updated Slider " . $id;
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


                $activity_title = "Change the status of slider " . $id;
                $this->addActivityLog($activity_title);

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

                $activity_title = "Change the status of Slider " . $id;
                $this->addActivityLog($activity_title);
                
                $message = ['status' => '1', 'message' => 'Status Updated!'];
                return json_encode($message);
            } else {
                $message = ['status' => '0', 'message' => 'Status Not Updated!'];
                return json_encode($message);
            }
        }

       
    }
    


}