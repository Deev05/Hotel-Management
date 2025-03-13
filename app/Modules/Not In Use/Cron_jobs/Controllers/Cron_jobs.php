<?php
namespace App\Modules\Cron_jobs\Controllers;
use App\Modules\Cron_jobs\Controllers\Notifications;
use App\Controllers\BaseController;
use App\Models\CommonModel;

class Cron_jobs extends BaseController
{
    private $db;
    private $CommonModel;
    
    private $web_api = "AAAAL-aXCxQ:APA91bEjUvvNvKYALAcl9PjtxvvUwJTqMsvXdJNETqyvqIt_JQPP-QlTO9POH8XYz1DFC3HflKfgYT_u21j1lK7-tn6OPsMz51yeNMxA8FRu5eXpnoA8S4WWhN4bM8MO51E8R3nlSGrl";
    private $service_provider_web_api = "AAAAFQZ1I50:APA91bF7Il94rQ6BXC7CYcKoBtFDtum6CUDVNbbjMvKPazHnNLiMVa0PKhXw4aSmpPlWgjW7Jt3yJKWIKxOO898RxrgpLrkEz9xCE1R8PxXKW6ogr9Z44SKBwkXSw3KNpYkKUi3SsO0_";


    public function __construct()
    {
        $this->db = db_connect();

        $this->CommonModel = new CommonModel;
		$this->notification = new Notifications;
    }
    

    public function index()
    {
        $mySession = session()->get('userdata');

        if(empty($mySession))
        {
            return redirect()->to(base_url('/admin_login'));
        }       
    }
    
    function check_deadlines()
    {
        
       date_default_timezone_set("Asia/Calcutta"); 


        
        $query = "select * from sop_applications where service_provider_id IS NOT NULL and application_status <> 'Completed'";
        $result = $this->CommonModel->custome_query($query);
        
        if(!empty($result))
        {
            $filter = array("id" => 1);
            $setting = $this->CommonModel->get_single("setting",$filter);
            
            $missed_deadline_penalty = $setting->missed_deadline_penalty;
  
            
            foreach ($result as  $row) 
            {

                $application_deadline   = strtotime($row->service_provider_deadline); 
                $secondsLeft            = $application_deadline - time();
                $days                   = floor($secondsLeft / (60*60*24)); 
                $hours                  = floor(($secondsLeft - ($days*60*60*24)) / (60*60));
                $minutes                = floor(($secondsLeft % 3600) / 60);
                
                // print_r($hours);
                // print_r("\n");
                // print_r($minutes);
                // die;
                
                if($hours == 0 && $minutes == 30)
                {
                    //Send To Web
                    $filter         = array("id" => $row->service_provider_id);
                    $user           = $this->CommonModel->get_single("service_providers",$filter);
                    $token          = $user->web_token;
                    $token_array    = array($token);
                    
                    $title = "Alert : 30 Minutes Left !!!";
                    $message = "Submit SOP Document As Soon As Possible";
                    
                    $this->send_notification($token_array,$title,$message);
                    
                    //Send To APP
                    $filter         = array("id" => $row->service_provider_id);
                    $user           = $this->CommonModel->get_single("service_providers",$filter);
                    $token          = $user->token;
                    $token_array    = array($token);
                    
                    $this->send_push_notification($token_array,$title,$message);
                    
                    
                    echo "30 Minutes left";
                }
                else if($hours == 0 && $minutes == 10)
                {
                    $filter         = array("id" => $row->service_provider_id);
                    $user           = $this->CommonModel->get_single("service_providers",$filter);
                    $token          = $user->web_token;
                    $token_array    = array($token);
                    
                    $title = "Alert : 10 Minutes Left !!!";
                    $message = "Submit SOP Document As Soon As Possible";
                    
                    $this->send_notification($token_array,$title,$message);
                    
                    //Send To APP
                    $filter         = array("id" => $row->service_provider_id);
                    $user           = $this->CommonModel->get_single("service_providers",$filter);
                    $token          = $user->token;
                    $token_array    = array($token);
                    
                    $this->send_push_notification($token_array,$title,$message);
                    
                    echo "10 minutes left";
                }
                
                // print_r($hours);
                // print_r("\n");
                // print_r($minutes);
                // die;
                // if(time() > $application_deadline)
                // {
                //     echo "deadline mismatched";
                // }

                //$hours = 0;
                $amount = $missed_deadline_penalty;
                
                if(time() > $application_deadline)
                {
                    
                    $filter         = array("id" => $row->service_provider_id);
                    $user           = $this->CommonModel->get_single("service_providers",$filter);
                    $token          = $user->web_token;
                    $token_array    = array($token);
                    
                    $title = "Alert : Dealine Mismatched !!!";
                    $message = "You have not provided SOP Document on time ! You can't Upload SOP Document";
                    
                    $this->send_notification($token_array,$title,$message);
                    
                    //Send To APP
                    $filter         = array("id" => $row->service_provider_id);
                    $user           = $this->CommonModel->get_single("service_providers",$filter);
                    $token          = $user->token;
                    $token_array    = array($token);
                    
                    $this->send_push_notification($token_array,$title,$message);
                    
                    ///////////////ADD INCOMPLETE APPLICATION///////////
                    $insert_data = array("application_id" => $row->id, "service_provider_id" => $row->service_provider_id, "created" => date('Y-m-d H:i:s'));
                    $insert = $this->CommonModel->common_insert_data("incomplete_applications",$insert_data);
                    ///////////////ADD INCOMPLETE APPLICATION///////////
                    
                    ///////////////ADD PENALTY///////////
                    $insert_data = array("application_id" => $row->id, "service_provider_id" => $row->service_provider_id, "type" => "penalty", "amount" => $amount,"created" => date('Y-m-d H:i:s'));
                    $insert = $this->CommonModel->common_insert_data("transactions",$insert_data);
                    ///////////////ADD PENALTY///////////
                
                    ///////////////UPDATE SOP APPLICATION///////////
                    $filter = array("id" => $row->id);
                    $update_data = array(
                                            "missed_deadline"                   => 1, 
                                            "service_provider_id"               => NULL, 
                                            "last_notification_sended_to"       => NULL, 
                                            "last_notification_sended_datetime" => NULL ,
                                            "service_provider_deadline"         => NULL);
                    $update = $this->CommonModel->update_data('sop_applications',$update_data,$filter);
                    ///////////////UPDATE SOP APPLICATION///////////
 
                }
                else
                {
                    echo "Hours ". $hours;
                    echo "\n";
                    echo "minutes ". $minutes;
                    echo "\n";
                    echo 'time available';
                }
                  
            }
        }
    
       die;
    }
	
	
	function send_new_inquiry_notificaion_service_provider()
    {
        $query  = "SELECT * FROM sop_applications WHERE service_provider_id IS NULL and draft_status = 0 and payment_status = 1";
        $result = $this->CommonModel->custome_query($query);
        
        if(!empty($result))
        {
            foreach($result as $row)
            {
                $application_id = $row->id;
                
                if($row->last_notification_sended_datetime == "" && $row->last_notification_sended_to == "")
                {
                    ////////////SEND NOTIFICATION TO SERVICE PROVIDER/////////
                    ////////////SEND NOTIFICATION TO SERVICE PROVIDER/////////
    
                    $filter = array("id" => $application_id);
                    $application_details = $this->CommonModel->get_single("sop_applications",$filter);
                    
                    $user_state = $application_details->state;
                    $user_city = $application_details->city;
                    
                    //$filter = array("city" => $user_city);
                    //$city_service_provider = $this->CommonModel->get_by_condition("service_providers",$filter);
                    $query = "SELECT * FROM service_providers WHERE service_providers.status = 1 and service_providers.is_deleted = 0 and service_providers.city = '$user_city' and NOT EXISTS (SELECT 1 FROM incomplete_applications WHERE incomplete_applications.service_provider_id = service_providers.ID and incomplete_applications.application_id = $application_id) ";
                    $city_service_provider = $this->CommonModel->custome_query($query);
                    
                    
                    //$filter = array("state" => $user_state);
                    //$state_service_provider = $this->CommonModel->get_by_condition("service_providers",$filter);
                    $query = "SELECT * FROM service_providers WHERE service_providers.status = 1 and service_providers.is_deleted = 0 and service_providers.state = '$user_state' and NOT EXISTS (SELECT 1 FROM incomplete_applications WHERE incomplete_applications.service_provider_id = service_providers.ID and incomplete_applications.application_id = $application_id) ";
                    $state_service_provider = $this->CommonModel->custome_query($query);
                    
                    if(!empty($city_service_provider))
                    {
                        
                        foreach($city_service_provider as $row)
                        {
                            
                            $insert_data = array(
                                "service_provider_id"   => $row->id,
                                "application_id"        =>  $application_id,
                                "message"               => "User want SOP Service, New Inquiry",
                                "created"               => date("Y-m-d H:i:s"),  
                            );
                            
                            $insert = $this->CommonModel->common_insert_data("service_provider_application_notifications",$insert_data);
                            
                            $filter = array("id" => $application_id);
                            $update_data = array("last_notification_sended_datetime" => date('Y-m-d H:i:s'), "last_notification_sended_to" => "city");
                            $update = $this->CommonModel->update_data("sop_applications",$update_data,$filter);
    
                            //Send To Web
                            $filter         = array("id" => $row->id);
                            $user           = $this->CommonModel->get_single("service_providers",$filter);
                            $token          = $user->web_token;
                            $token_array    = array($token);
                            
                            $title = "New Inquiry Alert !!!";
                            $message = "SOP Service Request Recieved ! Accept As Soon As Possible";
                            
                            $this->send_notification($token_array,$title,$message);
                            
                            //Send To APP
                            $filter         = array("id" => $row->id);
                            $user           = $this->CommonModel->get_single("service_providers",$filter);
                            $token          = $user->token;
                            $token_array    = array($token);
                            
                            $this->send_push_notification($token_array,$title,$message);
                            
                        }
                    }
                    else if(!empty($state_service_provider))
                    {
                        foreach($state_service_provider as $row)
                        {
                            
                            $insert_data = array(
                                "service_provider_id"   => $row->id,
                                "application_id"        =>  $application_id,
                                "message"               => "User want SOP Service, New Inquiry",
                                "created"               => date("Y-m-d H:i:s"),  
                            );
                            
                            $insert = $this->CommonModel->common_insert_data("service_provider_application_notifications",$insert_data);
                            
                            $filter = array("id" => $application_id);
                            $update_data = array("last_notification_sended_datetime" => date('Y-m-d H:i:s'), "last_notification_sended_to" => "state");
                            $update = $this->CommonModel->update_data("sop_applications",$update_data,$filter);
    
                            //Send To Web
                            $filter         = array("id" => $row->id);
                            $user           = $this->CommonModel->get_single("service_providers",$filter);
                            $token          = $user->web_token;
                            $token_array    = array($token);
                            
                            $title = "New Inquiry Alert !!!";
                            $message = "SOP Service Request Recieved ! Accept As Soon As Possible";
                            
                            $this->send_notification($token_array,$title,$message);
                            
                            //Send To APP
                            $filter         = array("id" => $row->id);
                            $user           = $this->CommonModel->get_single("service_providers",$filter);
                            $token          = $user->token;
                            $token_array    = array($token);
                            $this->send_push_notification($token_array,$title,$message);
                            
                        }
                    }
                    else
                    {
                      
                        //$filter = array("status" => 1,"is_deleted" => 0);
                        //$service_providers = $this->CommonModel->get_by_condition("service_providers",$filter);
                        $query = "SELECT * FROM service_providers WHERE service_providers.status = 1 and service_providers.is_deleted = 0 and NOT EXISTS (SELECT 1 FROM incomplete_applications WHERE incomplete_applications.service_provider_id = service_providers.ID and incomplete_applications.application_id = $application_id) ";
                        $service_providers = $this->CommonModel->custome_query($query);
                    
                        
                        foreach($service_providers as $row)
                        {
                            $insert_data = array(
                                                    "service_provider_id"   => $row->id,
                                                    "application_id"        =>  $application_id,
                                                    "message"               => "User want SOP Service, New Inquiry",
                                                    "created"               => date("Y-m-d H:i:s"),
                                                    
                                                );
                                                
                                                
                            $insert = $this->CommonModel->common_insert_data("service_provider_application_notifications",$insert_data);
                            
                            $filter = array("id" => $application_id);
                            $update_data = array("last_notification_sended_datetime" => date('Y-m-d H:i:s'), "last_notification_sended_to" => "all");
                            $update = $this->CommonModel->update_data("sop_applications",$update_data,$filter);
                            
                            //Send To Web
                            $filter         = array("id" => $row->id);
                            $user           = $this->CommonModel->get_single("service_providers",$filter);
                            $token          = $user->web_token;
                            $token_array    = array($token);
                            
                            $title = "New Inquiry Alert !!!";
                            $message = "SOP Service Request Recieved ! Accept As Soon As Possible";
                            
                            $this->send_notification($token_array,$title,$message);
                            
                            //Send To APP
                            $filter         = array("id" => $row->id);
                            $user           = $this->CommonModel->get_single("service_providers",$filter);
                            $token          = $user->token;
                            $token_array    = array($token);
                            $this->send_push_notification($token_array,$title,$message);
                            
                        }
                    }     
                    ////////////SEND NOTIFICATION TO SERVICE PROVIDER/////////
                }
                else
                {

                    $filter = array("id" => $application_id);
                    $application_details = $this->CommonModel->get_single("sop_applications",$filter);
                    
                    $user_state = $application_details->state;
                    $user_city = $application_details->city;
                    
                    //$filter = array("city" => $user_city);
                    //$city_service_provider = $this->CommonModel->get_by_condition("service_providers",$filter);
                    $query = "SELECT * FROM service_providers WHERE service_providers.status = 1 and service_providers.is_deleted = 0 and service_providers.city = '$user_city' and NOT EXISTS (SELECT 1 FROM incomplete_applications WHERE incomplete_applications.service_provider_id = service_providers.ID and incomplete_applications.application_id = $application_id) ";
                    $city_service_provider = $this->CommonModel->custome_query($query);
                  
                    
                    //$filter = array("state" => $user_state);
                    //$state_service_provider = $this->CommonModel->get_by_condition("service_providers",$filter);
                    $query = "SELECT * FROM service_providers WHERE service_providers.status = 1 and service_providers.is_deleted = 0 and service_providers.state = '$user_state' and NOT EXISTS (SELECT 1 FROM incomplete_applications WHERE incomplete_applications.service_provider_id = service_providers.ID and incomplete_applications.application_id = $application_id) ";
                    $state_service_provider = $this->CommonModel->custome_query($query);
                    
                    
                    ///Calculate Minutes//
                    $start = date('Y-m-d H:i:s');
                    $end = $row->last_notification_sended_datetime;

                    $to_time = strtotime($start);
                    $from_time = strtotime($row->last_notification_sended_datetime);
                    $minute_diffrence = round(abs($to_time - $from_time) / 60);
                    ///Calculate Minutes//
                    
                    // echo "-----";
                    // print_r($minute_diffrence);
                    // echo "-----";

                    if($row->last_notification_sended_to == "city")
                    {
                        //echo "City :" . $minute_diffrence;
                        
                        if($minute_diffrence > 1)
                        {
                            //echo "More than five minute condition true";
                            
                            //print_r($state_service_provider);
                            
                            if(!empty($state_service_provider))
                            {
                                //Remove All Notification Of an application
                                $filter = array("application_id" => $application_id);
                                $remove_all_notification = $this->CommonModel->delete_data("service_provider_application_notifications",$filter);
                                
                                
                                foreach($state_service_provider as $row)
                                {
                                    
                                    $insert_data = array(
                                        "service_provider_id"   => $row->id,
                                        "application_id"        =>  $application_id,
                                        "message"               => "User want SOP Service, New Inquiry",
                                        "created"               => date("Y-m-d H:i:s"),  
                                    );
                                    
                                    $insert = $this->CommonModel->common_insert_data("service_provider_application_notifications",$insert_data);
                                    
                                    $filter = array("id" => $application_id);
                                    $update_data = array("last_notification_sended_datetime" => date('Y-m-d H:i:s'), "last_notification_sended_to" => "state");
                                    $update = $this->CommonModel->update_data("sop_applications",$update_data,$filter);
            
                                    //Send To Web
                                    $filter         = array("id" => $row->id);
                                    $user           = $this->CommonModel->get_single("service_providers",$filter);
                                    $token          = $user->web_token;
                                    $token_array    = array($token);
                                    
                                    $title = "New Inquiry Alert !!!";
                                    $message = "SOP Service Request Recieved ! Accept As Soon As Possible";
                                    
                                    $this->send_notification($token_array,$title,$message);
                                    
                                    //Send To APP
                                    $filter         = array("id" => $row->id);
                                    $user           = $this->CommonModel->get_single("service_providers",$filter);
                                    $token          = $user->token;
                                    $token_array    = array($token);
                                    $this->send_push_notification($token_array,$title,$message);
                                    
                                }
                            }
                        }
                    }
                    else if ($row->last_notification_sended_to == "state")
                    {
                        $filter = array("status" => 1,"is_deleted" => 0);
                        $service_providers = $this->CommonModel->get_by_condition("service_providers",$filter);
                        
                        if($minute_diffrence > 1)
                        {
                            //Remove All Notification Of an application
                            $filter = array("application_id" => $application_id);
                            $remove_all_notification = $this->CommonModel->delete_data("service_provider_application_notifications",$filter);
                            
                                
                            foreach($service_providers as $row)
                            {
                                $insert_data = array(
                                                        "service_provider_id"   => $row->id,
                                                        "application_id"        =>  $application_id,
                                                        "message"               => "User want SOP Service, New Inquiry",
                                                        "created"               => date("Y-m-d H:i:s"),
                                                        
                                                    );
                                                    
                                                    
                                $insert = $this->CommonModel->common_insert_data("service_provider_application_notifications",$insert_data);
                                
                                $filter = array("id" => $application_id);
                                $update_data = array("last_notification_sended_datetime" => date('Y-m-d H:i:s'), "last_notification_sended_to" => "all");
                                $update = $this->CommonModel->update_data("sop_applications",$update_data,$filter);
                                
                                //Send To Web
                                $filter         = array("id" => $row->id);
                                $user           = $this->CommonModel->get_single("service_providers",$filter);
                                $token          = $user->web_token;
                                $token_array    = array($token);
                                
                                $title = "New Inquiry Alert !!!";
                                $message = "SOP Service Request Recieved ! Accept As Soon As Possible";
                                
                                $this->send_notification($token_array,$title,$message);
                                
                                //Send To APP
                                $filter         = array("id" => $row->id);
                                $user           = $this->CommonModel->get_single("service_providers",$filter);
                                $token          = $user->token;
                                $token_array    = array($token);
                                $this->send_push_notification($token_array,$title,$message);
                                
                            }
                        }
                        
                    }
                    else
                    {
                        echo "All";
                    }
                    
                    //print_r($row->last_notification_sended_datetime);
                    //print_r($row->last_notification_sended_to);
                }
                
            }   
            die;
        }

    }
    
    
    public function send_notification($token_array,$title,$message)
    {
     	$imageUrl   = ""; 
    	if(isset($title))
    	{
    		require_once __DIR__ . '/Notifications.php';
    		$notification = $this->notification;
    		$notification->setTitle($title);
    		$notification->setMessage($message);
    		$notification->setImage($imageUrl);
    		$firebase_api = $this->web_api;
    		$requestData = $notification->getNotificatin();
    		$fields = array(
    			'registration_ids' => $token_array,
    			'data' => $requestData,
    			'priority' => 'high',
    			'notification' => array(
    			'title' => $title,
    			'body' => $message,
    			'image' => $imageUrl,
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
    //  		echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
    //  		echo json_encode($fields,JSON_PRETTY_PRINT);
    //  		echo '</pre></p><h3>Response </h3><p><pre>';
    //  		echo $result;
    // 		echo '</pre></p>';
    // 		die;
    	}
    	
    }
    
    public function send_push_notification($token_array,$title,$message)
    {
     	$imageUrl   = ""; 
    	if(isset($title))
    	{
    		require_once __DIR__ . '/Notifications.php';
    		$notification = $this->notification;
    		$notification->setTitle($title);
    		$notification->setMessage($message);
    		$notification->setImage($imageUrl);
    		$firebase_api = $this->service_provider_web_api;
    		$requestData = $notification->getNotificatin();
    		$fields = array(
    			'registration_ids' => $token_array,
    			'data' => $requestData,
    			'priority' => 'high',
    			'notification' => array(
    			'title' => $title,
    			'body' => $message,
    			'image' => $imageUrl,
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
    //  		echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
    //  		echo json_encode($fields,JSON_PRETTY_PRINT);
    //  		echo '</pre></p><h3>Response </h3><p><pre>';
    //  		echo $result;
    // 		echo '</pre></p>';
    // 		die;
    	}
    	
    }



}

?>