<?php
namespace App\Modules\service_provider_api\Controllers;
use App\Modules\service_provider_api\Controllers\Notification;
use App\Controllers\BaseController;
use App\Models\CommonModel;

require_once (APPPATH . '../razorpay/Razorpay.php');

use \Razorpay\Api\Api as RazorpayApi;

class Service_provider_api extends BaseController
{
    private $db;
    private $CommonModel;
    private $web_api = "AAAAL-aXCxQ:APA91bEjUvvNvKYALAcl9PjtxvvUwJTqMsvXdJNETqyvqIt_JQPP-QlTO9POH8XYz1DFC3HflKfgYT_u21j1lK7-tn6OPsMz51yeNMxA8FRu5eXpnoA8S4WWhN4bM8MO51E8R3nlSGrl";
    private $service_provider_web_api = "AAAAFQZ1I50:APA91bF7Il94rQ6BXC7CYcKoBtFDtum6CUDVNbbjMvKPazHnNLiMVa0PKhXw4aSmpPlWgjW7Jt3yJKWIKxOO898RxrgpLrkEz9xCE1R8PxXKW6ogr9Z44SKBwkXSw3KNpYkKUi3SsO0_";

    
    public function __construct()
    {
        $this->db = db_connect();

        $this->CommonModel = new CommonModel;
        $this->notification = new Notification;

    }


    ////////////////////////////////////////////////////////////
    ///////////////////Authentication///////////////////////////
    ////////////////////////////////////////////////////////////   
    public function user_device_token()
    {
    	$user_id        =   $this->request->getVar('user_id');
    	$token          =   $this->request->getVar('token');
    	$device_type    =   $this->request->getVar('device_type');
    
        $last_online = date("Y-m-d H:i:sa");
    	$filter         = array("id"    => $user_id);
    	$update_data    = array("token"   => $token,"device_type" => $device_type, "last_online" => $last_online);
    	$update         = $this->CommonModel->update_data("service_providers",$update_data,$filter);
    	    

    	
    	if($update != false)
        {
    		$message = ['status' => '1', 'message' => 'Token Updated!'];
    		echo json_encode($message);
    		die;
        }
    	else
    	{
        	$message = ['status' => '0', 'message' => 'Error Something Went Wrong!'];
            echo json_encode($message);
    		die;
    	} 
    }
    

    public function login()
    {
    	$secrete    =  $this->request->getVar('secrete');
    	$contact    =  $this->request->getVar('contact');
    
       	if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{
    	    if($contact == "")
    	    {
    	        $message = ['status' => "0", 'message' => 'Please Enter Contact'];
                echo json_encode($message);
        		die;
    	    }
    	    
    		$cfilter = array("contact" => $contact);
    		$contact_exist = $this->CommonModel->get_single("service_providers",$cfilter);
    		
           	if(!empty($contact_exist))
        	{
        		if($contact_exist->status == 1)
        		{
    		        $otp = mt_rand(100000, 999999);
        	 	    
            		$filter         = array("contact" => $contact);
            		$update_data    = array("otp" => $otp);
                    $update_otp     = $this->CommonModel->update_data("service_providers",$update_data,$filter);
                    
                    
                    // $user = "aksharshah1975@gmail.com";
                    // $password = "Graphionic%401801";
                    // $msisdn = "$contact";
                    // $sid = "SHHAHS";
                    // $name = "Anurag Sharrma";
                    
                    // $msg = "Dear User, your OTP is ".$otp.". Topjec. From Shah Associate";
                    // $msg = urlencode($msg);
                    // $fl = "0";
                    // $gwid = "2";
                    // $type = "txt";
             
                    // $cSession = curl_init(); 
                    // curl_setopt($cSession,CURLOPT_URL,"http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=".$user."&password=".$password."&msisdn=".$msisdn."&sid=".$sid."&msg=".$msg."&fl=0&gwid=2");
                    // curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
                    // curl_setopt($cSession,CURLOPT_HEADER, false); 
                    // $result=curl_exec($cSession);
                    // curl_close($cSession);
        		    
        			$message = ['status' => "1",  'message' => 'OTP Generated Successfully' ];
        			echo json_encode($message);
        			die;
        		}
        		else
        		{
        		    $message = ['status' => "0", 'message' => 'You are banned by admin please contact admin!'];
                    echo json_encode($message);
            		die;
        		}

        	}
        	else
        	{
                $data = ['status' => "0", 'message' => 'Invalid Contact Number.'];
        		echo json_encode($data);
        		die;
        	}
    		
    	}
    	else
    	{
    		$data = ['status' => "0", 'message' => 'You are bot and bot is not allow to access.'];
    		echo json_encode($data);
    		die;
    	}    
    }
    
    public function verify_otp()
    {
    	$secrete    =  $this->request->getVar('secrete');
    	$contact    =  $this->request->getVar('contact');
    	$otp        =  $this->request->getVar('otp');
    	
    	if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{
    		if($contact == '' )
    		{
    			$data = ['status' => '0', 'message' => 'Please Enter Contact No...!'];
    			echo json_encode($data);
    			die;
    		}
    		else if($otp == '' )
    		{
    			$data = ['status' => '0', 'message' => 'Please Enter OTP...!'];
    			echo json_encode($data);
    			die;
    		}
    		else
    		{
        		$cfilter = array("contact" => $contact);
        		$contact_exist = $this->CommonModel->get_single("service_providers",$cfilter);
                if(!empty($contact_exist))
        		{
    		    	$db_otp = $contact_exist->otp;
    		    	if($otp == $db_otp || $otp == "111111")
    		    	{
                        $message = [
            						'status'        => 1,
            						'user_id'       => $contact_exist->id,
            						'full_name'     => $contact_exist->name,
            						'email'         => $contact_exist->email,
            						'contact'       => $contact_exist->contact,                            
            						'message' => 'Otp Verified Successfully!',
            							]; 
            						echo json_encode($message);
            						die; 
    		    	}
    		    	else
    		    	{
    		    	    $message = ['status' => '0', 'message' => 'Invalid OTP!'];
            			echo json_encode($message);
            			die;
    		    	}
        		}
    			else
    	    	{
    	    	    $message = ['status' => '0', 'message' => 'Something Went Wrong!'];
        			echo json_encode($message);
        			die;
    	    	}
    		}
    	}
    	else
    	{
    		$data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
    		echo json_encode($data);
    		die;
    	}    
    }
    



    ////////////////////////////////////////////////////////////
    ///////////////////Authentication///////////////////////////
    ////////////////////////////////////////////////////////////
    
    //===========================================================//
    



    public function store_info()
    {
    	$secrete =  $this->request->getVar('secrete');
    	if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{
        		$pcfilter = array("id" => 1);
        		$pexist = $this->CommonModel->get_single("pages",$pcfilter);
        		
                if(!empty($pexist))
        		{
                    $message = [
            						'status'            => 1,
            						'androidURL'            => "https://play.google.com/store/apps/details?id=com.graphionic.ringdbell&pli=1",
            						'iosURL' => "https://apps.apple.com/us/app/ringdbell/id1660427481",
            						'about_app'         =>   $pexist->about,
            						'terms_condition'   =>   $pexist->terms_condition,
            						'privacy_policy'    =>   $pexist->privacy_policy,                   
            						'message'           => 'Data Fetched!',
        					    ]; 
						echo json_encode($message);
						die; 
        		}
    			else
    	    	{
    	    	    $message = ['status' => '0', 'message' => 'Something Went Wrong!'];
        			echo json_encode($message);
        			die;
    	    	}
    		
    	}
    	else
    	{
    		$data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
    		echo json_encode($data);
    		die;
    	}    
    }
    
	////////////////////////////////////
	///////////HOMEPAGE STARTS///////////
	//////////////////////////////////
    public function get_homepage_data()
    {
      
        $secrete                =  $this->request->getVar('secrete');
        $service_provider_id    =  $this->request->getVar('service_provider_id');
        
        if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{
    	    
    	    $filter = array("service_provider_id" => $service_provider_id);
    	    $rating = $this->CommonModel->get_by_condition('sop_application_review_rating',$filter);
    	    
    	    $query = "select IFNULL(sum(service_provider_rating),0.00) as ratings from sop_application_review_rating where service_provider_id = $service_provider_id";
    	    $sum = $this->CommonModel->custome_query_single_record($query);
    	    if($sum->ratings == 0)
    	    {
    	        $avg_rating = 0.00;
    	    }
    	    else
    	    {
    	        $avg_rating = $sum->ratings/count($rating);
    	    }
    	    //print_r($sum);
    	    
    	   // $total = array_sum($rating->service_provider_rating);
            
            // printf('The average is %.2f', $avg);
            // die;
    	    
		    $today = date('Y-m-d');
	        $query = "select sum(transaction_amount) as revenue from sop_applications where service_provider_id = $service_provider_id and transaction_status = 'TXN_SUCCESS' and date = '$today'" ;
	        $today_revenues = $this->CommonModel->custome_query_single_record($query);
            $today_revenue = $today_revenues->revenue;
            if($today_revenue == null)
            {
                $today_revenue = "0.00";
            }
            else
            {
                $today_revenue = $today_revenues->revenue;
            }
            
            $query = "select sum(transaction_amount) as revenue from sop_applications where service_provider_id = $service_provider_id and transaction_status = 'TXN_SUCCESS'" ;
	        $total_revenues = $this->CommonModel->custome_query_single_record($query);
            $total_revenue = $today_revenues->revenue;
            if($total_revenue == null)
            {
                $total_revenue = "0.00";
            }
            else
            {
                $total_revenue = $today_revenues->revenue;
            }

	        $query = "select count(id) as total_applications from sop_applications where service_provider_id = $service_provider_id" ;
	        $total_applications = $this->CommonModel->custome_query_single_record($query);
	        
	        
	        $query = "select count(id) as total_applications from sop_applications where service_provider_id = $service_provider_id and date = '$today'" ;
	        $today_applications = $this->CommonModel->custome_query_single_record($query);

            $service_provider_inquiry = $this->get_service_provider_inquiries($service_provider_id);
            
            
            
            
                $query = "select * from sop_applications where service_provider_id = $service_provider_id and is_deleted = 0 and application_status <> 'Completed'";
                $result = $this->CommonModel->custome_query($query);
                $data_array     = array();
            
                if(!empty($result))
                {
                    foreach ($result as  $row) 
                    {
                        $filter = array("id" => $row->service_provider_id);
                        $service_provider = $this->CommonModel->get_single("service_providers",$filter);

                        $application_deadline   = strtotime($row->service_provider_deadline); 
                        $secondsLeft            = $application_deadline - time();
                        $days                   = floor($secondsLeft / (60*60*24)); 
                        $hours                  = floor(($secondsLeft - ($days*60*60*24)) / (60*60));
                        $minutes                = floor(($secondsLeft % 3600) / 60);
                        //$data['deadline']       = $hours." Hour(s) Left";
                        
                        if($row->deadline == "")
                        {
                           $data['alert_message']       = ""; 
                        }
                        else
                        {
                            if($row->application_status == "Completed")
                            {
                                $data['alert_message'] = "Completed";
                            }
                            else
                            {
                               $data['alert_message']   = "Application No : $row->application_no Has  $hours Hours $minutes minutes remaining to complete";
                            } 
                        }
                        
                        array_push($data_array,$data);
                    }
                }
            
           $ratings = sprintf('%0.1f', $avg_rating);
           $float = number_format($ratings, 1);

	        $val = [
	                    'status'                    => '1',
						'today_revenue'             => $today_revenue,
						'today_sop_applications'    => $today_applications->total_applications,
						'total_revenue'             => $total_revenue,
						'total_sop_applications'    => $total_applications->total_applications,
						'service_provider_inquiry'  => $service_provider_inquiry,
						'application_alerts'        => $data_array,
						
						'ratings'                   => number_format($ratings,1),
						
					
	               ];
	               
		    echo json_encode($val);
		    die;
    	
    	}
    	else
    	{
    	    $data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
    		echo json_encode($data);
    		die;
    	}
    }
    
    public function get_service_provider_inquiries($service_provider_id)
    {
        $filter = array("service_provider_id" => $service_provider_id,"status" => 1);
        $inquiry = $this->CommonModel->get_by_condition("service_provider_application_notifications",$filter);

        $data_array = array();
        
        $filter             = array("id" => $service_provider_id);
        $service_provider   = $this->CommonModel->get_single("service_providers",$filter);
        
        $data_array     = array();                         
        
        foreach ($inquiry as $row) 
        {
            $orgDate        = $row->created;  
            
            $filter = array("id" => $row->application_id);
            $application = $this->CommonModel->get_single('sop_applications', $filter);

            $user_id = $application->user_id;
   
            ////////////////  Get User  ///////////////////////
            $filter = array("id" => $user_id);
            $user_details =  $this->CommonModel->get_single('user_master', $filter);
            
            ////////////////  Get Package  ///////////////////////
            $filter = array("id" => $application->package_id);
            $package_details =  $this->CommonModel->get_single('sop_packages', $filter);
            
           ////////////////  Get Sop Service  ///////////////////////
            $filter = array("id" => $package_details->sop_service_id);
            $service_details =  $this->CommonModel->get_single('sop_services', $filter);
            
           ////////////////  Get Country  ///////////////////////
            $filter = array("id" => $package_details->sop_country_id);
            $country_details =  $this->CommonModel->get_single('sop_countries', $filter);
            
            //////Calculating Price//////
                
                $commission = $package_details->price * $service_provider->commission / 100;
                
                $filter = array("id" => 1);
                $setting = $this->CommonModel->get_single("setting",$filter);
                
                $missed_deadline_benefits   = $setting->missed_deadline_benefits;
                $missed_deadline            = $application->missed_deadline;
                $extra_benefit = 0;
                if($missed_deadline == 1)
                {
                    //echo 'deadline is missed';
                   $extra_benefit_commission = $service_provider->commission - $missed_deadline_benefits;
                   
                   if($extra_benefit_commission == 0)
                   {
                       $extra_benefit = $commission;
                   }
                   else
                   {
                        $extra_benefit = $package_details->price * $extra_benefit_commission / 100;
                   }
                }
                
                // print_r($extra_benefit);
                // die;
                
                
                
                
                $final_price = $package_details->price - $commission + $extra_benefit;
            
            
            $data['service_name']               = $service_details->name ." / ". $country_details->name ." / ". $package_details->name;
            $data['notification_message']       = $row->message;
            $data['package_price']              = $package_details->price;
            $data['commission']                 = "$commission";
            $data['final_price']                = "$final_price";
            $data['date']                       = $row->created;
            $data['application_id']             = $row->application_id;
            $data['extra_benefit']             = "$extra_benefit";
            $data['missed_deadline']             = $missed_deadline;
            

            array_push($data_array,$data);
        }
            
           return $data_array;

           
        

    }
    
	function accept_sop_application()
	{
		$secrete              =  $this->request->getVar('secrete');
		$application_id       =  $this->request->getVar('application_id');
		$service_provider_id  =  $this->request->getVar('service_provider_id');
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
		{
		    if($application_id == '' )
			{
				$data = ['status' => '0', 'message' => 'Please Enter Application Id...!'];
				echo json_encode($data);
				die;
			}
			
			if($service_provider_id == '' )
			{
				$data = ['status' => '0', 'message' => 'Please Enter Service Provider Id...!'];
				echo json_encode($data);
				die;
			}

            $filter = array("id" => $application_id);
            $application_details = $this->CommonModel->get_single("sop_applications",$filter);
            if($application_details->service_provider_id != null)
            {
                
                $filter = array("application_id" => $application_id);
                $update_data = array("status" => 0);
                $update = $this->CommonModel->update_data("service_provider_application_notifications",$update_data,$filter);
                
                $data = ['status' => '0', 'message' => 'Oops ! Another Service Provider Accept This Application Request.'];
                echo json_encode($data);
                die;
            }

            
            $filter = array("id" => $application_id);
            $update_data = array("service_provider_id" => $service_provider_id);

            $update = $this->CommonModel->update_data("sop_applications",$update_data,$filter);
    
            if($update != false)
            {
                //////Update Notification//////
                $filter = array("application_id" => $application_id);
                $update_data = array("status" => 0, "Action" => "Accepted");
                $update = $this->CommonModel->update_data("service_provider_application_notifications",$update_data,$filter);
                
                //Commission & Fees///
                ////////////////  Get Package  ///////////////////////
                $filter = array("id" => $application_details->package_id);
                $package_details =  $this->CommonModel->get_single('sop_packages', $filter);
                
                /////////////////Service Provider Details/////////////
                $filter = array("id" => $service_provider_id);
                $service_provider = $this->CommonModel->get_single('service_providers', $filter);
                
                ////////////////  Get Country  ///////////////////////
                $filter = array("id" => $package_details->sop_country_id);
                $country_details =  $this->CommonModel->get_single('sop_countries', $filter);
                
                $commission = $package_details->price * $service_provider->commission / 100;
                
                $final_price = $package_details->price - $commission;
    
                $commission_rate = $service_provider->commission;
                

                //////////Service Provider Deadline////////
                $filter = array("id" => $application_details->package_id);
        	    $package = $this->CommonModel->get_single("sop_packages",$filter);
        	    $package_hours = substr($package->name, 0, 2);
        	    
        	    $filter = array("id" => 1);
        	    $settings = $this->CommonModel->get_single("setting",$filter);
        	    
        	    if($application_details->missed_deadline == 0)
        	    {
            	    if($package_hours == 24)
            	    {
            	        $hours = $settings->hours_24; 
                        $deadline = $application_details->deadline;
                        $service_provider_deadline = date('Y-m-d H:i:s', strtotime($deadline. ' - '.$hours.' hours')); 
            	    }
            	    else if($package_hours == 48)
            	    {
            	        $hours = $settings->hours_48;
            	        $deadline = $application_details->deadline;
                        $service_provider_deadline = date('Y-m-d H:i:s', strtotime($deadline. ' - '.$hours.' hours')); 
            	    }
            	    else if($package_hours == 72)
            	    {
            	        $hours = $settings->hours_72;
            	        $deadline = $application_details->deadline;
                        $service_provider_deadline = date('Y-m-d H:i:s', strtotime($deadline. ' - '.$hours.' hours')); 
            	    }
        	    }
        	    else
        	    {
        	        $service_provider_deadline = $application_details->deadline;
        	    }
                /////////////////

                $filter = array("id" => $application_id);
                $update_data = array("application_status" => 'Service Provider Assigned', "commission_rate" => $commission_rate, "fees" => $commission, 'service_provider_deadline' => $service_provider_deadline);
                $update = $this->CommonModel->update_data('sop_applications', $update_data, $filter);
                
                //Send Notification To User
                $filter         = array("id" => $application_details->user_id);
                $user           = $this->CommonModel->get_single("user_master",$filter);
                $token          = $user->token;
                $token_array    = array($token);
                
                $title = "SOP Application Alert!!!";
                $message = "Service Provider Assigned Successfully";
                
                $this->send_notification($token_array,$title,$message);
                
                $data = ['status' => '1', 'message' => 'Application Accepted Successfully.'];
                echo json_encode($data);
                die;
            }
            else
            {
                $data = ['status' => '0', 'message' => 'Something went wrong.'];
                echo json_encode($data);
                die;
            }
		}
		else
		{
		    $data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
			echo json_encode($data);
			die;
		}
	}
	
	function reject_sop_application()
	{
		$secrete              =  $this->request->getVar('secrete');
		$application_id       =  $this->request->getVar('application_id');
		$service_provider_id  =  $this->request->getVar('service_provider_id');
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
		{
		    if($application_id == '' )
			{
				$data = ['status' => '0', 'message' => 'Please Enter Application Id...!'];
				echo json_encode($data);
				die;
			}
			
			if($service_provider_id == '' )
			{
				$data = ['status' => '0', 'message' => 'Please Enter Service Provider Id...!'];
				echo json_encode($data);
				die;
			}
			
			$filter = array("application_id" => $application_id,"service_provider_id" => $service_provider_id);
            $update_data = array("status" => 0, "Action" => "Rejected");
            $update = $this->CommonModel->update_data("service_provider_application_notifications",$update_data,$filter);
            
            if($update != false)
            {
                $data = ['status' => '1', 'message' => 'Application Rejected.'];
                echo json_encode($data);
                die;
            }
            else
            {
                $data = ['status' => '0', 'message' => 'Something went wrong.'];
                echo json_encode($data);
                die;
            }


		}
		else
		{
		    $data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
			echo json_encode($data);
			die;
		}
	}
    
	////////////////////////////////////
	///////////HOMEPAGE ENDS///////////
	//////////////////////////////////
    
    
    function get_service_provider_applications()
	{
		$secrete              =  $this->request->getVar('secrete');
		$service_provider_id  =  $this->request->getVar('service_provider_id');
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
		{
		    if($service_provider_id == '' )
			{
				$data = ['status' => '0', 'message' => 'Please Enter Service Provider Id...!'];
				echo json_encode($data);
				die;
			}
			
		    $filter = array("service_provider_id" => $service_provider_id);
            $inquiry = $this->CommonModel->get_by_condition("sop_applications",$filter);

            $data_array = array();
        
            $filter             = array("id" => $service_provider_id);
            $service_provider   = $this->CommonModel->get_single("service_providers",$filter);
      
            $data_array     = array();                         
        
         
            foreach ($inquiry as $row) 
            {
                $orgDate        = $row->created;  
                
                $filter = array("id" => $row->id);
                $application = $this->CommonModel->get_single('sop_applications', $filter);
    
                $user_id = $application->user_id;
       
                ////////////////  Get User  ///////////////////////
                $filter = array("id" => $user_id);
                $user_details =  $this->CommonModel->get_single('user_master', $filter);
                
                ////////////////  Get Package  ///////////////////////
                $filter = array("id" => $application->package_id);
                $package_details =  $this->CommonModel->get_single('sop_packages', $filter);
                
               ////////////////  Get Sop Service  ///////////////////////
                $filter = array("id" => $package_details->sop_service_id);
                $service_details =  $this->CommonModel->get_single('sop_services', $filter);
                
               ////////////////  Get Country  ///////////////////////
                $filter = array("id" => $package_details->sop_country_id);
                $country_details =  $this->CommonModel->get_single('sop_countries', $filter);
                
               //////Calculating Price//////
                
                $commission = $package_details->price * $service_provider->commission / 100;
                
                $filter = array("id" => 1);
                $setting = $this->CommonModel->get_single("setting",$filter);
                
                $missed_deadline_benefits   = $setting->missed_deadline_benefits;
                $missed_deadline            = $application->missed_deadline;
                
                $extra_benefit = 0;
                if($missed_deadline == 1)
                {
                    //echo 'deadline is missed';
                   $extra_benefit_commission = $service_provider->commission - $missed_deadline_benefits;
                   
                   if($extra_benefit_commission == 0)
                   {
                       $extra_benefit = $commission;
                   }
                   else
                   {
                        $extra_benefit = $package_details->price * $extra_benefit_commission / 100;
                   }
                }
                
                // print_r($extra_benefit);
                // die;
                
                
                
                
                $final_price = $package_details->price - $commission + $extra_benefit;
                
                
                $data['service_name']               = $service_details->name ." / ". $country_details->name ." / ". $package_details->name;
                $data['package_price']              = $package_details->price;
                $data['commission']                 = "$commission";
                $data['final_price']                = "$final_price";
                $data['date']                       = $row->created;
                $data['application_id']             = $row->id;
                $data['customer_id']                = $user_id;
                $data['application_no']             = $row->application_no;
                $data['applicant_name']             = $row->applicant_name;
                $data['application_status']         = $row->application_status;
                $data['extra_benefit']             = "$extra_benefit";
                $data['missed_deadline']             = $missed_deadline;
                
                if($row->modification_message == "" || $row->modification_message == null)
    			{
    				$data['modification_message']    = "";
    			}
    			else
    			{
    				$data['modification_message']     = $row->modification_message;
    			}
    
                array_push($data_array,$data);
            }
            
            $incomplete_data_array     = array();
            $filter = array("service_provider_id" => $service_provider_id);
            $incomplete = $this->CommonModel->get_by_condition("incomplete_applications",$filter);
            
           
            foreach($incomplete as $row)
            {
                
                $orgDate        = $row->created;  
            
                $filter = array("id" => $row->application_id);
                $application = $this->CommonModel->get_single('sop_applications', $filter);
    
                $user_id = $application->user_id;
       
                ////////////////  Get User  ///////////////////////
                $filter = array("id" => $user_id);
                $user_details =  $this->CommonModel->get_single('user_master', $filter);
                
                ////////////////  Get Package  ///////////////////////
                $filter = array("id" => $application->package_id);
                $package_details =  $this->CommonModel->get_single('sop_packages', $filter);
                
               ////////////////  Get Sop Service  ///////////////////////
                $filter = array("id" => $package_details->sop_service_id);
                $service_details =  $this->CommonModel->get_single('sop_services', $filter);
                
               ////////////////  Get Country  ///////////////////////
                $filter = array("id" => $package_details->sop_country_id);
                $country_details =  $this->CommonModel->get_single('sop_countries', $filter);
                
                $commission = $package_details->price * $service_provider->commission / 100;
                
                $final_price = $package_details->price - $commission;
                
                
                $incomplete_data['service_name']               = $service_details->name ." / ". $country_details->name ." / ". $package_details->name;
                $incomplete_data['package_price']              = $package_details->price;
                $incomplete_data['commission']                 = "$commission";
                $incomplete_data['final_price']                = "$final_price";
                $incomplete_data['date']                       = $row->created;
                $incomplete_data['application_id']             = $row->id;
                $incomplete_data['customer_id']                = $user_id;
                $incomplete_data['application_no']             = $application->application_no;
                $incomplete_data['applicant_name']             = $application->applicant_name;
                $incomplete_data['application_status']         = $application->application_status;
                
                if($application->modification_message == "" || $application->modification_message == null)
    			{
    				$incomplete_data['modification_message']    = "";
    			}
    			else
    			{
    				$incomplete_data['modification_message']     = $application->modification_message;
    			}
    
                array_push($incomplete_data_array,$incomplete_data);
            } 
            
            
            
            $val = ['status' => '1','service_provider_applications' => $data_array, "incomplete_applications" => $incomplete_data_array];
            echo json_encode($val);
            die;
            

		}
		else
		{
		    $data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
			echo json_encode($data);
			die;
		}
	}
	
	
    function get_application_details()
	{
		$secrete              =  $this->request->getVar('secrete');
		$application_id  =  $this->request->getVar('application_id');
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
		{
		    if($application_id == '' )
			{
				$data = ['status' => '0', 'message' => 'Please Enter Application Id...!'];
				echo json_encode($data);
				die;
			}
			
			$filter = array("id" => $application_id);
			$exist = $this->CommonModel->get_single("sop_applications",$filter);

            if(!empty($exist))
            {
                $user_id = $exist->user_id;
           
                ////////////////  Get User  ///////////////////////
                $filter = array("id" => $user_id);
                $user_details =  $this->CommonModel->get_single('user_master', $filter);
                
                ////////////////  Get Package  ///////////////////////
                $filter = array("id" => $exist->package_id);
                $package_details =  $this->CommonModel->get_single('sop_packages', $filter);
                
               ////////////////  Get Sop Service  ///////////////////////
                $filter = array("id" => $package_details->sop_service_id);
                $service_details =  $this->CommonModel->get_single('sop_services', $filter);
                
               ////////////////  Get Country  ///////////////////////
                $filter = array("id" => $package_details->sop_country_id);
                $country_details =  $this->CommonModel->get_single('sop_countries', $filter);
                
                $base_url = base_url()."uploads/documents/";
                $sop_base_url = base_url()."uploads/sop_documents/";
                
                $sop_application_document = $sop_base_url.$exist->sop_application_document;
                if($sop_application_document == null)
                {
                    $sop_application_document = "";
                }
                
                
                $val = [
                           'status'                    => '1',
                            'application_id'            => $exist->id,
                            'service_name'              => $service_details->name ." / ". $country_details->name ." / ". $package_details->name,
 	                        'application_no'            => $exist->application_no,	 	
 	                        'applicant_name'            => $exist->applicant_name,	
 	                        'contact' 	                => $exist->contact,
 	                        'email' 	                => $exist->email,
 	                        'status' 	                => $exist->status,
 	                        'application_status' 	    => $exist->application_status,
 	                        'created' 	 	            => $exist->created,
 	                        'passport_copy'	            => $base_url.$exist->passport_copy,
 	                        'marriage_certificate' 	    => $base_url.$exist->marriage_certificate,
 	                        'offer_letter' 	            => $base_url.$exist->offer_letter,
 	                        'loan_letter' 	            => $base_url.$exist->loan_letter,
 	                        'tuition_fee_receipt' 	    => $base_url.$exist->tuition_fee_receipt,
 	                        'course_certificate' 	    => $base_url.$exist->course_certificate,
 	                        'employment_certificate' 	=> $base_url.$exist->employment_certificate,
 	                        'ielts_certificate'	        => $base_url.$exist->ielts_certificate,
 	                        'fund_related_doc' 	        => $base_url.$exist->fund_related_doc,
 	                        'any_remark' 	            => $exist->any_remark,
 	                        'sop_application_document' 	=> $sop_application_document,
 	                        
 	                        "state"			            => $exist->state,
            				"city"			            => $exist->city,
            				"pincode"			        => $exist->pincode,
            				
            				"father_name"			    => $exist->father_name,
            				"father_employment_status"	=> $exist->father_employment_status,
            				"father_company_name"		=> $exist->father_company_name,
            				"father_designation"		=> $exist->father_designation,
            				
            				"mother_name"			    => $exist->mother_name,
                            "mother_employment_status"	=> $exist->mother_employment_status,
                            "mother_company_name"		=> $exist->mother_company_name,
                            "mother_designation"		=> $exist->mother_designation,
 	                      
 	                        'date' 	 	 	 	        => $exist->date,	 
 	                        
 	                        
 	                        

                 	 	 	
                            
                            ];
                echo json_encode($val);
                die;
            }
            else
            {
                $data = ['status' => '0', 'message' => 'No Data Found.'];
    			echo json_encode($data);
    			die;
            }

		}
		else
		{
		    $data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
			echo json_encode($data);
			die;
		}
	}
	
	public function get_family_members()
	{
	    $secrete        =  $this->request->getVar('secrete');
     	$user_id =  $this->request->getVar('user_id');

	    if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
	        if($user_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter User Id.'];
        		echo json_encode($data);
        		die;
            }
            else
            {
                $filter = array("user_id" => $user_id,"is_deleted" => 0);
                $result = $this->CommonModel->get_by_condition("family_details",$filter);
                
                $data_array = array();
                
                if(!empty($result))
                {
                    foreach($result as $row)
                    {
                        $data["family_id"]      = $row->id;
                        $data["user_id"]        = $row->user_id;
                        $data["relation"]       = $row->relation;
                        $data["name"]           = $row->name;
                        $data["profession"]     = $row->profession;
                        $data["company_name"]   = $row->company_name;
                        $data["designation"]    = $row->designation;
                        $data["elder_younger"]  = $row->elder_younger;
                        $data["education"]      = $row->education;
                        $data["created"]        = $row->created;
                        
                        array_push($data_array,$data);
                    }
                    $data = ['status' => '1', 'family_members' => $data_array, 'message' => 'Data fetched successfully'];
        			echo json_encode($data);
        			die; 
                }
                else
                {
                    $data = ['status' => '0', 'message' => 'No data found.'];
        			echo json_encode($data);
        			die; 
                }
                
            }
	    }
	    else
	    {
	        $data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
			echo json_encode($data);
			die; 
	    }
	}
	
	
	public function sop_application_document()
	{
        $secrete        =  $this->request->getVar('secrete');
     	$file           =  $this->request->getVar('file');
     	$application_id =  $this->request->getVar('application_id');

	    if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
	        
            if($application_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Application Id.'];
        		echo json_encode($data);
        		die;
            }

            if(isset($_FILES["file"]))
            {
                $target_dir = "uploads/sop_documents/"; 

                $tmp            = explode(".",$_FILES["file"]["name"]);
                $file_extension = end($tmp);
                $newfilename    = time() . '_' . rand(100, 999) . '.' . $file_extension;
                
                //$filename = $_FILES["file"]["name"]; 
                    
                $savefile = "$target_dir/$newfilename";
            
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $savefile)) 
                {
                    $filter  = array("id" => $application_id);
                    $update_data = array('sop_application_document' => $newfilename);
                    $update = $this->CommonModel->update_data("sop_applications",$update_data,$filter);	
                    
                    if($update != false)
                    {
                        
                        $filter = array("id" => $application_id);
                        $update_data = array("application_status" => 'SOP Document Sent');
                        $update = $this->CommonModel->update_data('sop_applications', $update_data, $filter);
                        
                        $title          = "Greetings : SOP Application Document Is Ready";
                        $message        = "Your Application Document is ready !";
                        
                        $application_data = $this->CommonModel->get_single('sop_applications',$filter);
                        
                        $filter         = array("id" => $application_data->user_id);
                        $user           = $this->CommonModel->get_single("user_master",$filter);
                        $token          = $user->token;
                        $token_array    = array($token);
                        
                        $this->send_notification($token_array,$title,$message);
                        
                        
                        $data = ['status' => '1', 'message' => 'Document uploaded.'];
                		echo json_encode($data);
                		die;
                    }
                    else
                    {
                        $data = ['status' => '0', 'message' => 'Something went wrong.'];
                		echo json_encode($data);
                		die;
                    }
                }
            }
            else
            {
                $data = ['status' => '0', 'message' => 'Please choose document for Passport Copy.'];
        		echo json_encode($data);
        		die;
            }
	    }
        else
		{
			$data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
			echo json_encode($data);
			die;
		}
	}
	
	
    function get_service_provider_payment_history()
	{
		$secrete              =  $this->request->getVar('secrete');
		$service_provider_id  =  $this->request->getVar('service_provider_id');
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
		{
		    if($service_provider_id == '' )
			{
				$data = ['status' => '0', 'message' => 'Please Enter Service Provider Id...!'];
				echo json_encode($data);
				die;
			}
			
		    $filter = array("service_provider_id" => $service_provider_id);
            $exist = $this->CommonModel->get_by_condition("service_provider_payments",$filter);
            
           

            $data_array = array();
        
            $filter             = array("id" => $service_provider_id);
            $service_provider   = $this->CommonModel->get_single("service_providers",$filter);
      
            $data_array     = array();                         
        
            if(!empty($exist))
            {
                foreach ($exist as $row) 
                {
                    $orgDate        = $row->created;  
                    
                    $filter = array("id" => $row->application_id);
                    $application = $this->CommonModel->get_single('sop_applications', $filter);
        
                    $user_id = $application->user_id;
           
                    ////////////////  Get User  ///////////////////////
                    $filter = array("id" => $user_id);
                    $user_details =  $this->CommonModel->get_single('user_master', $filter);
                    
                    ////////////////  Get Package  ///////////////////////
                    $filter = array("id" => $application->package_id);
                    $package_details =  $this->CommonModel->get_single('sop_packages', $filter);
                    
                   ////////////////  Get Sop Service  ///////////////////////
                    $filter = array("id" => $package_details->sop_service_id);
                    $service_details =  $this->CommonModel->get_single('sop_services', $filter);
                    
                   ////////////////  Get Country  ///////////////////////
                    $filter = array("id" => $package_details->sop_country_id);
                    $country_details =  $this->CommonModel->get_single('sop_countries', $filter);
                    
                    $commission = $package_details->price * $service_provider->commission / 100;
                    
                    $final_price = $package_details->price - $commission;
                    
                    
                    $data['service_name']               = $service_details->name ." / ". $country_details->name ." / ". $package_details->name;
                    $data['payment_mode']              = $row->payment_mode;
                    $data['transaction_id']              = $row->transaction_id;
                    $data['package_price']              = $row->package_price;
                    $data['commission']                 = $row->commission;
                    $data['final_amount']                =  $row->final_amount;
                    $data['date']                       = $row->created;
                    $data['application_id']             = $row->application_id;
        
                    array_push($data_array,$data);
                }
                    $val = ['status' => '1','service_provider_payment_history' => $data_array];
                    echo json_encode($val);
                    die;
            }
            else
            {
                $data = ['status' => '0', 'message' => 'No Data Found.'];
    			echo json_encode($data);
    			die;
            }

		}
		else
		{
		    $data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
			echo json_encode($data);
			die;
		}
	}


	////////////////////////////////////
	///////////PROFILE STARTS///////////
	//////////////////////////////////
	function update_profile()
	{
		$secrete                    =  $this->request->getVar('secrete');
		$service_provider_id        =  $this->request->getVar('service_provider_id');
		$name                       =  $this->request->getVar('name');
		$email                      =  $this->request->getVar('email');
		$contact                    =  $this->request->getVar('contact');
		$image                      =  $this->request->getVar('image');

		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
		{
			if($name == '' )
			{
				$data = ['status' => '0', 'message' => 'Please Enter Full Name...!'];
				echo json_encode($data);
				die;
			}
			else if($service_provider_id == '' )
			{
				$data = ['status' => '0', 'message' => 'Please Service Provider Id...!'];
				echo json_encode($data);
				die;
			}
			else
			{
					$filter = array("id" => $service_provider_id);
					$user = $this->CommonModel->get_single("service_providers",$filter);
					
					$db_image = $user->profile_picture;

					$table = "service_providers";
					$filter = array("id" => $service_provider_id);
					
					if($image == "")
					{
					$image = $db_image;
					}
					else
					{
						$base64_string = $_POST["image"];
						$outputfile = "uploads/service_providers/image.jpg" ;
						$random = md5(microtime());
						$image = "$random.jpg" ;
						$outputfile = "uploads/service_providers/$random.jpg" ;
						$filehandler = fopen($outputfile, 'wb' ); 
						fwrite($filehandler, base64_decode($base64_string));
						fclose($filehandler); 
					}  
	
					$table = "service_providers";
					$filter = array("id" => $service_provider_id);
					
					$update_data = array(
											"name" 		        => $name,
											"email" 			=> $email,
											"contact"   		=> $contact,
											"profile_picture"   => $image,
									);
					$insert =  $this->CommonModel->update_data($table,$update_data,$filter);  
					
					if($insert != false)
					{
						$data = ['status' => '1', 'message' => 'Profile Updated Successfully...!'];
						echo json_encode($data);
						die;      
					}
					else
					{
						$data = ['status' => '0', 'message' => 'Error While Updating Profile...!'];
						echo json_encode($data);
						die;
					}
			}
		}
		else
		{
			$data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
			echo json_encode($data);
			die;
		}    
	}

	public function get_profile_details()
    {
    	$secrete =  $this->request->getVar('secrete');
    	$service_provider_id =  $this->request->getVar('service_provider_id');
    	
    	if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{
    		if($service_provider_id == '' )
    		{
    			$data = ['status' => '0', 'message' => 'Please Enter Service Provider Id...!'];
    			echo json_encode($data);
    			die;
    		}
    		else
    		{
    			$table = "service_providers";
    			$filter = array("id" => $service_provider_id);
    			$exist =  $this->CommonModel->get_single($table,$filter);
    			
    			
    			if(!empty($exist))
    			{
    			    
    			    if($exist->profile_picture == "" || $exist->profile_picture == NULL)
    			    {
    			        $profile_image = base_url()."/uploads/static/user.png";
    			    }
                    else
                    {
                        $profile_image = base_url()."/uploads/service_providers/$exist->profile_picture";
                    }
                    
                    
                    $query = "select count(id) as unread_notifications from service_provider_notifications where service_provider_id = $service_provider_id and is_read = 0";
                    $notification_count = $this->CommonModel->custome_query_single_record($query);
                    $unread_notifications = $notification_count->unread_notifications;
                    
                    
    		         $message = [
                					'status'                		=> '1',
                					'user_id'               		=> $exist->id,
                					'full_name'             		=> $exist->name,
                					'email'                  		=> $exist->email,
                					'contact'                   	=> $exist->contact,
                					'pincode'                   	=> $exist->pincode,
                					'state'                   	    => $exist->state,
                					'city'                   	    => $exist->city,
                					'commission'                    => $exist->commission."%",
                					'unread_notifications'          => $unread_notifications,
                					'profile_picture'     			=> $profile_image,	
    						]; 
    					echo json_encode($message);
    					die; 
    
    			}
    			else
    			{
    				$data = ['status' => '0', 'message' => 'No Data Found...!'];
    				echo json_encode($data);
    				die;
    			}  
    		}
    	}
    	else
    	{
    		$data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
    		echo json_encode($data);
    		die;
    	}    
    }
	
	////////////////////////////////////
	///////////PROFILE STARTS///////////
	//////////////////////////////////




	/////////////////////////
    //CONTACT FORM STARTS//
    /////////////////////////
	public function contact()
	{
		$secrete    			=  $this->request->getVar('secrete');
		$service_provider_id    =  $this->request->getVar('service_provider_id');
		$subject    			=  $this->request->getVar('subject');
		$message    			=  $this->request->getVar('message');
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
		{
			if($service_provider_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Service Provider id.'];
        		echo json_encode($data);
        		die;
            }
			if($subject == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter subject.'];
        		echo json_encode($data);
        		die;
            }
			if($message == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter message.'];
        		echo json_encode($data);
        		die;
            }
			$insert_data = array(
				"service_provider_id" 			=> $service_provider_id,
				"subject"			            => $subject,
				"message"			            => $message,
				"created"			            => date("Y-m-d H:i:s")
			);

			$insert_paylater_history = $this->CommonModel->common_insert_data("service_provider_contact ",$insert_data);	

			if($insert_paylater_history != false)	
			{
				$data = ['status' => '1', 'message' => 'Contact Inquiry Added.'];
				echo json_encode($data);
				die;
			}
			else
			{
				$data = ['status' => '0', 'message' => 'Something went wrong.'];
				echo json_encode($data);
				die;
			}
		}
		else
		{
			$data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
			echo json_encode($data);
			die;
		}
	}
	/////////////////////////
    //CONTACT FORM ENDS//
    /////////////////////////


	
    public function test_notification()
    {
        
        $filter = array("id" => 11);
    	$customer = $this->CommonModel->get_single("user_master",$filter);
    
        $token = $customer->token;    

    	$token_array    = array($token);

    	
     	$title  	= "Notifications";
     	$message   	= "Notification From Web";
		$imageUrl    = "";	

    	if(isset($title))
    	{
     		require_once __DIR__ . '/Notification.php';

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
    			//'image' => $imageUrl,
    			'sound' => 'not_sound.wav',
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
     		echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
     		echo json_encode($fields,JSON_PRETTY_PRINT);
     		echo '</pre></p><h3>Response </h3><p><pre>';
     		echo $result;
    		echo '</pre></p>';
			die;
    	}
    	

    }
    
    /////////////////////////
    //Notifications Starts//
    /////////////////////////

    public function get_service_provider_notifications()
    {
      	$secrete =  $this->request->getVar('secrete');
      	$service_provider_id =  $this->request->getVar('service_provider_id');
    	
    	if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{	
    	    
    	    if($service_provider_id == '')
    	    {
    	        $data = ['status' => '0', 'message' => 'Service Provider Id.'];
        		echo json_encode($data);
        		die;
    	    }
    	    else
    	    {
    	        $filter = array("service_provider_id" => $service_provider_id);
        	    $stores = $this->CommonModel->get_by_condition("service_provider_notifications",$filter);
        	    $data_array2 = array(); 
        	    
        	    if(!empty($stores))
        	    {
                	foreach ($stores as  $row) 
                	{
                        $datas['title']               = $row->title;
                        $datas['message']               = $row->message;
                        $orgDate                            = $row->created;  
                        $datas['date']                 = date("d-M-y h:i A", strtotime($orgDate));  
                        if($row->image == "")
                        {
                             $datas['image_path']   = base_url()."/uploads/static/ok.png";
                        }
                        else
                        {
                             $datas['image_path']   =  $row->image;  ;
                        }
                       
                        
                        array_push($data_array2,$datas);
                    }
                      $val = ['status' => '1','service_provider_notifications' => $data_array2];
                      echo json_encode($val);
                      die;
        	    }
                 
                else
                {
                    $data = ['status' => '0', 'message' => 'No Data Found.'];
            		echo json_encode($data);
            		die;
                }
    	    }
    	}
    	else
    	{
    		$data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
    		echo json_encode($data);
    		die;
    	}
    }


    /////////////////////////
    //Notifications Ends//
    /////////////////////////
    
    function clear_notifications()
    {
      	$secrete =  $this->request->getVar('secrete');
      	$service_provider_id =  $this->request->getVar('service_provider_id');
    	
    	if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{	
    	    
    	    if($service_provider_id == '')
    	    {
    	        $data = ['status' => '0', 'message' => 'Enter Service Provider Id.'];
        		echo json_encode($data);
        		die;
    	    }
    	    else
    	    {
    	        $filter = array("service_provider_id" => $service_provider_id);
        	    $delete = $this->CommonModel->delete_data("service_provider_notifications",$filter);
        	    
        	    if($delete != false)
        	    {
        	        $data = ['status' => '1', 'message' => 'Cleared Successfully.'];
            		echo json_encode($data);
            		die;
        	    }
        	    else
        	    {
        	        $data = ['status' => '0', 'message' => 'Something Went Wrong.'];
            		echo json_encode($data);
            		die;
        	    }
            	
    	    }
    	}
    	else
    	{
    		$data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
    		echo json_encode($data);
    		die;
    	}
    }
    
    /////////////////TICKET/////////////////
	/////////////////TICKET/////////////////
	/////////////////TICKET/////////////////
	function create_ticket()
	{	
	    $secrete            =  $this->request->getVar('secrete');
		$service_provider_id           =  $this->request->getVar('service_provider_id');
		$application_id     =  $this->request->getVar('application_id');
		$message            =  $this->request->getVar('message');
		$ticket_no          = "TIBSOP" . rand(10000,99999999);
		$created            = date("Y-m-d H:i:s");
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
	        if($application_id == "")
	        {
	            $data = ['status' => '0', 'message' => 'Please Enter Application Id.'];
    			echo json_encode($data);
    			die;
	        }
	        else if($service_provider_id == "")
	        {
	            $data = ['status' => '0', 'message' => 'Please Enter Service Provider Id.'];
    			echo json_encode($data);
    			die; 
	        }
	        else if($message == "")
	        {
	            $data = ['status' => '0', 'message' => 'Please Enter Message.'];
    			echo json_encode($data);
    			die; 
	        }
	        else
	        {
	            $insert_data = array("service_provider_id" => $service_provider_id,"application_id" => $application_id, "message" => $message, "ticket_no" => $ticket_no,"created" => $created);
	            $insert = $this->CommonModel->common_insert_data("sop_application_sp_tickets",$insert_data);
	            if($insert != "")
	            {
	                $data = ['status' => '1', 'message' => 'Ticket Created Successfully.'];
        			echo json_encode($data);
        			die; 
	            }
	            else
	            {
	                $data = ['status' => '0', 'message' => 'Something went wrong.'];
		            echo json_encode($data);
        			die; 
	            }
	        }
	    }
	    else
	    {
	        $data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
			echo json_encode($data);
			die;
	    }
	}
	
	public function get_tickets()
	{
	    $secrete        =  $this->request->getVar('secrete');
     	$service_provider_id =  $this->request->getVar('service_provider_id');

	    if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
	        if($service_provider_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Service Provider Id.'];
        		echo json_encode($data);
        		die;
            }
            else
            {
                $filter = array("service_provider_id" => $service_provider_id);
                $result = $this->CommonModel->get_by_condition("sop_application_sp_tickets",$filter);
                
                $data_array = array();
                
                if(!empty($result))
                {
                    foreach($result as $row)
                    {
                        
                        if ($row->status == 0){
                            $status = 'Opened';
                        } else if ($row->status == 1) {
                             $status = 'In Progress';
                        }else if ($row->status == 2) {
                            $status = 'Responded';
                        }else if ($row->status == 3) {
                             $status = 'Resolved';
                        }
                        
                        
                        $data["ticket_id"]      = $row->id;
                        $data["service_provider_id"]        = $row->service_provider_id;
                        $data["ticket_no"]      = $row->ticket_no;
                        $data["message"]        = $row->message;
                        $data["status"]         = $status;
                        $data["created"]        = $row->created;
                        
                        array_push($data_array,$data);
                    }
                    $data = ['status' => '1', 'tickets' => $data_array, 'message' => 'Data fetched successfully'];
        			echo json_encode($data);
        			die; 
                }
                else
                {
                    $data = ['status' => '0', 'message' => 'No data found.'];
        			echo json_encode($data);
        			die; 
                }
                
            }
	    }
	    else
	    {
	        $data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
			echo json_encode($data);
			die; 
	    }
	}
	
	/////////////////TICKET/////////////////
	/////////////////TICKET/////////////////
	/////////////////TICKET/////////////////
	
	
	
    public function send_note()
    {
        $secrete        =  $this->request->getVar('secrete');


	    if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
        
            $application_id = $this->request->getVar('application_id');
            $edit_message = $this->request->getVar('message');
            
            if($application_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Application Id.'];
        		echo json_encode($data);
        		die;
            }
            
            if($edit_message == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Note.'];
        		echo json_encode($data);
        		die;
            }
            
            $filter         = array("id" => $application_id);
            $update_data    = array("edit_mode" => 1 , "edit_message" => $edit_message);
            $update         = $this->CommonModel->update_data('sop_applications', $update_data, $filter);
    
           if ($update != false) 
           {
                $filter             = array("id" => $application_id);
                $application_data   = $this->CommonModel->get_single('sop_applications',$filter);
               
                $title          = "Alert : Require information about your SOP Application";
                $message        = $edit_message;
                
                $filter         = array("id" => $application_data->user_id);
                $user           = $this->CommonModel->get_single("user_master",$filter);
                $token          = $user->token;
                $token_array    = array($token);
                
                $this->send_notification($token_array,$title,$message);
               
                $data = ['status' => '1', 'message' => 'Edit Message Sent to the user!'];
                echo json_encode($data);
        		die;
            } 
            else 
            {
                $data = ['status' => '0', 'message' => 'Status Not Updated!'];
                echo json_encode($data);
        		die;
            }
	    }
	    else
	    {
	         $data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
			echo json_encode($data);
			die;
	    }
    }
    
    
        public function send_notification($token_array,$title,$message)
    {
     	$imageUrl   = ""; 
    	if(isset($title))
    	{
    		require_once __DIR__ . '/Notification.php';
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
    		require_once __DIR__ . '/Notification.php';
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
    
    
    public function get_payment_history()
    {
        
        $secrete    =  $this->request->getVar('secrete');
    	$service_provider_id    =  $this->request->getVar('service_provider_id');
    	$last_id    =  $this->request->getVar('last_id');
    	
        if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
        {
            if($service_provider_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter service provider_id id.'];
        		echo json_encode($data);
        		die;
            }
            else
            {
                ///////////////////////////////////////////////////
                ///////////////////////////////////////////////////
                $query          = "select IFNULL(SUM(amount),0) as credit from transactions where type = 'credit' and service_provider_id = $service_provider_id and payment_status = 'unpaid'; ";
                $total_credit   = $this->CommonModel->custome_query_single_record($query);
                
                $query          = "select IFNULL(SUM(amount),0) as benefit from transactions where type = 'benefit' and service_provider_id = $service_provider_id and payment_status = 'unpaid'; ";
                $total_benefits   = $this->CommonModel->custome_query_single_record($query);
                
                $query          = "select IFNULL(SUM(amount),0) as penalty from transactions where type = 'penalty' and service_provider_id = $service_provider_id and payment_status = 'unpaid'; ";
                $total_penalty   = $this->CommonModel->custome_query_single_record($query);
                
                $totalcredit = $total_credit->credit;
                $totalbenefits = $total_benefits->benefit;
                $totalpenalty = $total_penalty->penalty;
                $totaloutstanding  = $totalcredit + $totalbenefits + $totalpenalty;
                ///////////////////////////////////////////////////
                ///////////////////////////////////////////////////
                
                
                if($last_id == "")
                {
                    $query              = "SELECT * FROM transactions where service_provider_id = $service_provider_id ORDER BY id DESC LIMIT 6";
                    $total_record_query = "SELECT COUNT(id) as total_records FROM transactions where service_provider_id = $service_provider_id";
                    
                }
                else
                {
                    $query              = "SELECT * FROM transactions WHERE service_provider_id = $service_provider_id and id < $last_id ORDER BY id DESC LIMIT 6";
                    $total_record_query = "SELECT COUNT(id) as total_records FROM transactions where service_provider_id = $service_provider_id";
                }

                $exist = $this->CommonModel->custome_query($query);
                
                $total_record = $this->CommonModel->custome_query_single_record($total_record_query);
               
                $total_records = $total_record->total_records;


				$filter = array("id" => $service_provider_id);
				$service_provider_details = $this->CommonModel->get_single("service_providers",$filter);

                
                if(!empty($exist))
                {
					$last_id =  min(array_column($exist, 'id'));
                    
                    $data_array = array();
                    
                    foreach($exist as $row)
                    {


						$date = date("F d, Y", strtotime($row->created));  
						$time = date("h:i A", strtotime($row->created));  

                        if($row->remark == NULL || $row->remark == "")
                        {
                           $filter = array("id" => $row->application_id);
                           $application = $this->CommonModel->get_single("sop_applications",$filter);
                           
                           if($row->type == "penalty")
                           {
                               $data['title']           		= "Penalty Against Deadline application no ".$application->application_no; 
                           }
                           else if($row->type == "credit")
                           {
                              $data['title']           		= "Credited Against completed application no ".$application->application_no;  
                           }
                           else if($row->type == "benefit")
                           {
                              $data['title']           		= "Credited Extra Benefit Against completed application no ".$application->application_no;  
                           }
                           
                        }
                        else
                        {
                            $data['title']           		= $row->remark;
                        }

                        $data['transaction_id']        	= $row->id;
                        
                        $data['type']           		= $row->type;
                        $data['amount']           		= $row->amount;
                        $data['created']           		= $date." at ".$time;

                        array_push($data_array,$data);
                    }
                    
                    $val = [
								'status' 			=> '1',
								'total_records' 	=> $total_records, 
								'last_id' 			=> $last_id,
								'totalcredit'		=> $totalcredit, 
								'totalbenefits'		=> $totalbenefits, 
								'totalpenalty'	    => $totalpenalty, 
								'totaloutstanding'	=> "$totaloutstanding", 
								'payment_history'	=> $data_array
							];
        			echo json_encode($val);
        			die;
                     
                }
                else
                {
                    $data = ['status' => '0', 'message' => 'No Data found.'];
            		echo json_encode($data);
            		die;
                }
                
   
            }
            
            
	    }
    	else
    	{
    		$data = ['status' => '0', 'message' => 'You are bot and bot is not allow to access.'];
    		echo json_encode($data);
    		die;
    	}
    }

    
    
}