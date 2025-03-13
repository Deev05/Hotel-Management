<?php 
namespace App\Modules\Manage_notification\Controllers;
use App\Modules\Manage_notification\Controllers\Notification;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Manage_notification extends BaseController {

    private $web_api = "AAAAL-aXCxQ:APA91bEjUvvNvKYALAcl9PjtxvvUwJTqMsvXdJNETqyvqIt_JQPP-QlTO9POH8XYz1DFC3HflKfgYT_u21j1lK7-tn6OPsMz51yeNMxA8FRu5eXpnoA8S4WWhN4bM8MO51E8R3nlSGrl";

    public function __construct()
    {
        $this->db = db_connect();
     	$this->CommonModel = new CommonModel();
        $this->table = "notifications";
        helper(['form', 'url']);
	}

    // Index
    public function index()
    {

        $data['page_title'] = 'Notification';
        $data['page_headline'] = 'Notification';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['notification_images']   = $this->CommonModel->get_by_condition('notification_images', $filter,$order);
        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);
        
        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Manage_notification\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }

    // Single Notification Index
    public function for_single()
    {

        $data['page_title'] = 'Single User Notification';
        $data['page_headline'] = 'Single User Notification';
        $order[0] = "id";
        $order[1] = "DESC";
        $filter = array("is_deleted" => 0);
        $data['notification_images']   = $this->CommonModel->get_by_condition('notification_images', $filter,$order);
        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);
        $filter = array("status" => 1,"is_deleted" => 0);
        $data['users'] = $this->CommonModel->get_all_data('user_master');
        
        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Manage_notification\Views\for_single', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }


    // Notification Image Upload
    public function notification_image_upload()
    {
        $file       = $_FILES['image'];        
        $file_name  = $file['name'];
		$file_path  = $file['tmp_name'];
		$file_error = $file['error'];

        if ($file_error == 0)
		{
			$file_destination ='uploads/notification/'.$file_name;
			move_uploaded_file($file_path, $file_destination);
        }

        $insert_data = array("image" => $file_name);

        $insert = $this->CommonModel->common_insert_data('notification_images', $insert_data);

        if($insert != false)
        {
            $_SESSION['message'] = 'New Notification Image Added!';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('manage_notification'));
        }
        else
        {
            $_SESSION['message'] = 'Something Went Wrong!';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('manage_notification'));
        }
    }

    // Notification Image Delete
    public function notification_image_delete()
    {
        $id = $this->request->uri->getSegment(3);
	    $update_data = array(
            "is_deleted"    => 1,
            "id"            => $id,
        );

        $update = $this->CommonModel->common_update_data('notification_images',$id,$update_data);
        
        if($update != false)
        {
            $_SESSION['message'] = 'Notification Image Deleted!';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('manage_notification'));
        }
        else
        {
            $_SESSION['message'] = 'Something Went Wrong!';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('manage_notification'));
        }
    }


    public function send_notification()
	{
		

		$title  	= $this->request->getVar('title');
		$message   	= $this->request->getVar('message');
		$image 	= $this->request->getVar('image');
		
	    $user_id  	= $this->request->getVar('user_id');
	    
	    $filter = array("id" => $user_id);
	    $user_exist = $this->CommonModel->get_single("user_master",$filter);
	    
	    $created = date("Y-m-d h:i:s");

	    $insert_data = array(
	                        "title" => $title,
	                        "message" => $message,
	                        "image" => $image,
	                        "user_id"   => $user_id,
	                        "created"   => $created
	                    );
	   $insert = $this->CommonModel->common_insert_data("notifications",$insert_data);
	   

	    $token = $user_exist->token;
	    $registrationIDs = array($token);

    	$web_api    = $this->web_api;
     	//$title  	= "Delivery Person Assigned Successfully :-)";
     	//$message   	= "Your Order No. ". $exist['order_no']." Will Deliver by ".$driver_exist['name'].", Thanks For Beign With Us.";
     	$imageUrl   = $image; 
    	if(isset($title))
    	{
    		require_once __DIR__ . '/Notification.php';
    		$notification = new Notification();
    		$notification->setTitle($title);
    		$notification->setMessage($message);
    		$notification->setImage($imageUrl);
    		$firebase_api = $web_api;
    		$requestData = $notification->getNotificatin();
    		$fields = array(
    			'registration_ids' => $registrationIDs,
    			'data' => $requestData,
    			'priority' => 'high',
    			'notification' => array(
    			'title' => $title,
    			'image' => $imageUrl,
    			'body' => $message,
    			'data' => [
                'click_action'=> 'FLUTTER_NOTIFICATION_CLICK',
                'status'=> 'done',
                
            ],
    			)
    		);
    		$url = 'https://fcm.googleapis.com/fcm/send';
    
    		$headers = array(
    			'Authorization: key=' . $firebase_api,
    			'Content-Type: application/json'
    			);
    	
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_URL, $url);
    		curl_setopt($ch, CURLOPT_POST, true);
    		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    		$result = curl_exec($ch);
    		if($result === FALSE){
    			die('Curl failed: ' . curl_error($ch));
    		}
    		curl_close($ch);
    // 		echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
    // 		echo json_encode($fields,JSON_PRETTY_PRINT);
    // 		echo '</pre></p><h3>Response </h3><p><pre>';
    // 		echo $result;
    // 		echo '</pre></p>';
    // 		die;
    	}
		
		
	    if($insert != false)
        {
            $_SESSION['message'] = 'Notification Send';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('manage_notification/for_single'));
        }
        else
        {
            $_SESSION['message'] = 'Something Went Wrong!';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('manage_notification/for_single'));
        }
		
	}
	
	
    public function send_notification_all()
	{
	    $users = $this->CommonModel->get_all_data("user_master");
	    

		$title  	= $this->request->getVar('title');
		$message   	= $this->request->getVar('message');
		$image   	= $this->request->getVar('image');
		$created    = date("Y-m-d h:i:s");
		
		require_once __DIR__ . '/Notification.php';
		$notification = new Notification();
		$notification->setTitle($title);
		$notification->setMessage($message);
		$notification->setImage($image);
		$firebase_api = $this->web_api;
		$requestData = $notification->getNotificatin();
		
		if($image == "")
		{
		    $fields = array(
			 'to'  => '/topics/okkirana',
			'data' => $requestData,
			'priority' => 'high',
			'notification' => array(
			'title' => $title,
			'body' => $message,
			
			)
		);
		}
		else
		{
		    $fields = array(
			 'to'  => '/topics/vivii',
			'data' => $requestData,
			'priority' => 'high',
			'notification' => array(
			'title' => $title,
			'body' => $message,
			'image' => $image,
			)
		);
		}
		
		
		$url = 'https://fcm.googleapis.com/fcm/send';

		$headers = array(
			'Authorization: key=' . $firebase_api,
			'Content-Type: application/json'
			);
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		if($result === FALSE){
			die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);
		// echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
		// echo json_encode($fields,JSON_PRETTY_PRINT);
		// echo '</pre></p><h3>Response </h3><p><pre>';
		// echo $result;
		// echo '</pre></p>';
		
		$data_array = array();
		///////////////
		foreach($users as $row)
        {
            $data['user_id']      = $row->id;
            $data['title']     = $title;
            $data['message']   = $message;
            $data['image']   = $image;
            $data['created']     = $created;
            array_push($data_array,$data);  
        }
          
        //$builder = $this->db->table('notifications');
        $insert  = $this->db->table('notifications')->insertBatch($data_array);
        //$insert = $builder->insertBatch($data_array);
          
		///////////////
		if($insert != false)
        {
            $_SESSION['message'] = 'Notification Send';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('manage_notification'));
        }
        else
        {
            $_SESSION['message'] = 'Something Went Wrong!';
            session()->markAsFlashdata("message");
            return redirect()->to(base_url('manage_notification'));
        }
		
		
	}
}

