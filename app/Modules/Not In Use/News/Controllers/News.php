<?php 
namespace App\Modules\News\Controllers;
use App\Modules\News\Controllers\Notification;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class News extends BaseController {

    public function __construct()
    {
     	$this->CommonModel = new CommonModel();
        $this->table = "news";
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

        $data['page_title']     = 'News Feed';
        $data['page_headline']  = 'News Feed';
        $order[0]               = "id";
        $order[1]               = "DESC";
        $filter                 = array("is_deleted" => 0);
        $data['questions']      = $this->CommonModel->get_by_condition($this->table, $filter,$order);
        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\News\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_news()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( name LIKE '%" . $_REQUEST['search']['value'] . "%' ";
        }

        $totalRecordsSql = "SELECT * FROM news $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'title',
            3 => 'description',
            4 => 'status',
            5 => 'created',
            6 => 'action',
        );

        $sql = "SELECT *";
        $sql .= " FROM news $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $data['no']         = ++$count;
            $data['id']         = $row->id;
            $data['title']       = $row->title;
            $data['description']      = $row->description;
            $data['status']     = $row->status;
            $data['created']    = $row->created;


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
    
    public function add_news()
    {
        $title = $this->request->getVar('title');
        $description = $this->request->getVar('description');
        $created = date("Y-m-d H:i:s");
        $date = date("Y-m-d");
        
        $insert_data = array(
                                "title"      => $title,
                                "description"     => $description,
                                "date"   => $date,
                                "created"   => $created,
                            );
                            
        $insert = $this->CommonModel->common_insert_data('news', $insert_data);
        
        if ($insert != false) 
        {
            
        	    $filter     = array("notification_status" => 1);
                $users      = $this->CommonModel->get_by_condition("user_master",$filter);

        		$title  	= $this->request->getVar('title');
        		$message   	= $description;
        		$image   	= $this->request->getVar('image');
        		$created    = date("Y-m-d h:i:s");
        		
        		require_once __DIR__ . '/Notification.php';

                $web_api    = "AAAADhGr36k:APA91bF2GXMfwmS3kvmkT3266VAyKJ5gynoMe6JN1fbfXtRiKEBcG8-55FMpGMheqXt00ubgdI9Wvb9H_Pz-vU7E_zKSkP_cdJyFZQbfSLqkyo0p2Eg5qkvg5-6RTSWNaPz0U9hP9FKb";

        		foreach($users as $row)
                {
                    
            	    $token = $row->token;
            	    $registrationIDs = array($token);

                    
                	$notification = new Notification();
            		$notification->setTitle($title);
            		$notification->setMessage($message);
            		$notification->setImage($image);
            		$firebase_api = $web_api;
            		$requestData = $notification->getNotificatin();
            	    $fields = array(
                			'registration_ids' => $registrationIDs,
                			'data' => $requestData,
                			'priority' => 'high',
                			'notification' => array(
                			'title' => $title,
                			'body' => $message,
                			
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
                	/*	echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
                		echo json_encode($fields,JSON_PRETTY_PRINT);
                		echo '</pre></p><h3>Response </h3><p><pre>';
                		echo $result;
                		echo '</pre></p>';*/
                }
          
            $message = ['status' => '1', 'message' => 'News Added!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
    }
    
    public function create()
    {
        $session = session();

        $update_id = $this->request->uri->getSegment(3);
        $submit = $this->request->getVar('submit');

        if($submit == "Submit")
        {
		    $data = $this->fetch_data_from_post();


            if(is_numeric($update_id))
            {
                
               
                
                $update = $this->CommonModel->common_update_data($this->table,$update_id,$data);

                if($update != false)
                {
                    $_SESSION['message'] = 'Details Updated!';
                    session()->markAsFlashdata("message");
                    return redirect()->to(base_url('manage_questions/create/'.$update_id));
                }
                else
                {
                    $_SESSION['message'] = 'No Changes Found!';
                    session()->markAsFlashdata("message");
                    return redirect()->to(base_url('manage_questions'));
                }

            }
            else
            {              

                
                $insert = $this->CommonModel->common_insert_data($this->table, $data);

                $query = $this->CommonModel->custome_query('SELECT id FROM questions WHERE id = (SELECT MAX(id) FROM questions)');

                if($insert != false)
                {
                    $_SESSION['message'] = 'New Question Added!';
                    session()->markAsFlashdata("message");
                    return redirect()->to(base_url('manage_questions/create/'.$query[0]->id));
                }
                else
                {
                    $_SESSION['message'] = 'Something Went Wrong!';
                    session()->markAsFlashdata("message");
                    return redirect()->to(base_url('manage_questions/create'));
                }
            }
        }

        if((is_numeric($update_id)) && ($submit!="Submit"))
        {
            $data = $this->fetch_data_from_db($update_id);
        }
        else
        {
            $data = $this->fetch_data_from_post();
        }

        if(!is_numeric($update_id))
        {
            $data['page_title'] = "Add New Question";
            $data['page_headline'] = "Add New Question";
        }
        else
        {
            $data['page_title'] = "Update Question Details";
            $data['page_headline'] = "Update Question Details";
        }

        $data['update_id'] = $update_id;
        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Manage_questions\Views\create', $data);
        echo view('App\Modules\Admin\Views\footer', $data);

    }

    public function fetch_data_from_db($update_id)
    {
        $filter = array("id" => $update_id);
        $query = $this->CommonModel->get_by_condition($this->table,$filter);
        foreach($query as $row)
        {
            $data['main_category_id']       = $row->main_category_id;
            $data['question']               = $row->question;
            $data['answer']                 = $row->answer;
        };
        return $data;
    }

    public function fetch_data_from_post()
    {
        $data['main_category_id']           = $this->request->getVar('main_category_id');
        $data['question']                   = $this->request->getVar('question');
        $data['answer']                     = $this->request->getVar('answer');

        return $data;
    }

    public function delete()
    {
        $id = $this->request->uri->getSegment(3);
	    $update_data = array(
                                "is_deleted"    => 1,
                                "status"        => 0,
                                "id"            => $id,
                            );

        $update = $this->CommonModel->common_update_data($this->table,$id,$update_data);
        
        
        if ($update != false) 
        {
            $message = ['status' => '1', 'message' => 'News Deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }
    
    public function update_news()
    {
        $id             = $this->request->getVar('news_id');
        $title          = $this->request->getVar('edit_title');
        $description    = $this->request->getVar('edit_description');
        
        
        $filter = array("id" => $id);
        $update_data = array("title" => $title,"description" => $description);
        $update = $this->CommonModel->update_data($this->table, $update_data, $filter);

        if ($update != false) 
        {
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
                $message = ['status' => '1', 'message' => 'Status Updated!'];
                return json_encode($message);
            } else {
                $message = ['status' => '0', 'message' => 'Status Not Updated!'];
                return json_encode($message);
            }
        }

        $_SESSION['message'] = 'Something Went Wrong!';
        session()->markAsFlashdata("message");
        return redirect()->to(base_url('manage_questions'));
    }
    

}