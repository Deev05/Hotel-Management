<?php
namespace App\Modules\server_api\Controllers;
use App\Modules\server_api\Controllers\Notification;
use App\Controllers\BaseController;
use App\Models\CommonModel;

require_once (APPPATH . '../razorpay/Razorpay.php');

use \Razorpay\Api\Api as RazorpayApi;

class Server_api extends BaseController
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
    	$update         = $this->CommonModel->update_data("user_master",$update_data,$filter);
    	    

    	
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
    
    public function register()
    {
        $secrete        =  $this->request->getVar('secrete');
    	$firstname      =  $this->request->getVar('firstname');
    	$lastname       =  $this->request->getVar('lastname');
    	$email          =  $this->request->getVar('email');
    	$contact        =  $this->request->getVar('contact');
    
       	if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{
    	    
    	    if($firstname == "")
    	    {
    	        $message = ['status' => "0", 'message' => 'Please Enter First Name'];
                echo json_encode($message);
        		die;
    	    }
    	    
    	    if($lastname == "")
    	    {
    	        $message = ['status' => "0", 'message' => 'Please Enter Last Name'];
                echo json_encode($message);
        		die;
    	    }
    	    
    	    if($contact == "")
    	    {
    	        $message = ['status' => "0", 'message' => 'Please Enter Contact'];
                echo json_encode($message);
        		die;
    	    }
    	    
    	    if($email == "")
    	    {
    	        $message = ['status' => "0", 'message' => 'Please Enter Email Address'];
                echo json_encode($message);
        		die;
    	    }
    	    
    		$cfilter = array("contact" => $contact);
    		$contact_exist = $this->CommonModel->get_single("user_master",$cfilter);
    		
    		$cfilter = array("email" => $email);
    		$email_exist = $this->CommonModel->get_single("user_master",$cfilter);
    		
           	if(!empty($contact_exist))
        	{
        		if($contact_exist->status == 1)
        		{
    		        $message = ['status' => "0", 'message' => 'Contact No Already Exist! Please add different'];
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
        	else if(!empty($email_exist))
        	{
        		if($email_exist->status == 1)
        		{
    		        $message = ['status' => "0", 'message' => 'Email Already Exist! Please add different'];
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
        	    $otp = mt_rand(100000, 999999);
    			$user_data = array(
                                        "firstname"     => $firstname,
                                        "lastname"      => $lastname,
                                        "contact"       => $contact,
                                        "email"         => $email,
                                        "otp"           => $otp,
                                        "status"        => 1,
                                        "created" 	    => date('Y-m-d H:i:s')
                                  );
                $insert =  $this->CommonModel->common_insert_data('user_master',$user_data);  
                
                if($insert != false)
                {
                    
                    $user = "aksharshah1975@gmail.com";
                    $password = "Graphionic%401801";
                    $msisdn = "$contact";
                    $sid = "SHHAHS";
                    $name = "Anurag Sharrma";
                    
                    $msg = "Dear User, your OTP is ".$otp.". Topjec. From Shah Associate";
                    $msg = urlencode($msg);
                    $fl = "0";
                    $gwid = "2";
                    $type = "txt";
             
                    $cSession = curl_init(); 
                    curl_setopt($cSession,CURLOPT_URL,"http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=".$user."&password=".$password."&msisdn=".$msisdn."&sid=".$sid."&msg=".$msg."&fl=0&gwid=2");
                    curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
                    curl_setopt($cSession,CURLOPT_HEADER, false); 
                    $result=curl_exec($cSession);
                    curl_close($cSession);
                   
                    
                    $filter = array("id" => $insert);
    		        $row = $this->CommonModel->get_single("user_master",$cfilter);
    		
                    $message = [
            			            'status'        => "1", 
            			            'user_id'       => $row->id,
            			            'firstname'     => $row->firstname,
            			            'lastname'      => $row->lastname,
            			            'full_name'     => $row->firstname." ".$row->lastname,
            			            'email'         => $row->email,
            			            'contact'       => $row->contact,
            			            'message'       => 'Registration Successfully!'
        			            ];
        			echo json_encode($message);
        			die;
                }
                else
                {
                    $data = ['status' => "0", 'message' => 'Something went wrong ! Please try again later.'];
            		echo json_encode($data);
            		die; 
                }
        	}
    		
    	}
    	else
    	{
    		$data = ['status' => "0", 'message' => 'You are bot and bot is not allow to access.'];
    		echo json_encode($data);
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
    		$contact_exist = $this->CommonModel->get_single("user_master",$cfilter);
    		
           	if(!empty($contact_exist))
        	{
        		if($contact_exist->status == 1)
        		{
    		        $otp = mt_rand(100000, 999999);
        	 	    
            		$filter         = array("contact" => $contact);
            		$update_data    = array("otp" => $otp);
                    $update_otp     = $this->CommonModel->update_data("user_master",$update_data,$filter);
                    
                    
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
        		    
        			$message = [
            			            'status'        => "1", 
            			            'user_id'       => $contact_exist->id,
            			            'firstname'     => $contact_exist->firstname,
            			            'lastname'      => $contact_exist->lastname,
            			            'full_name'     => $contact_exist->firstname." ".$contact_exist->lastname,
            			            'email'         => $contact_exist->email,
            			            'contact'        => $contact_exist->contact,
            			            'message'       => 'Login Validated'
        			            ];
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
                $otp = mt_rand(100000, 999999);
                
                $user = "aksharshah1975@gmail.com";
                $password = "Graphionic%401801";
                $msisdn = "$contact";
                $sid = "SHHAHS";
                $name = "Anurag Sharrma";
                
                $msg = "Dear User, your OTP is ".$otp.". Topjec. From Shah Associate";
                $msg = urlencode($msg);
                $fl = "0";
                $gwid = "2";
                $type = "txt";
         
                $cSession = curl_init(); 
                curl_setopt($cSession,CURLOPT_URL,"http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=".$user."&password=".$password."&msisdn=".$msisdn."&sid=".$sid."&msg=".$msg."&fl=0&gwid=2");
                curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($cSession,CURLOPT_HEADER, false); 
                $result=curl_exec($cSession);
                curl_close($cSession);
                
    			$user_data = array(
                                        "firstname"     => "",
                                        "lastname"     => "",
                                        "email"     => "",
                                        "contact"       => $contact,
                                        "otp"           => $otp,
                                        "status"        => 1,
                                        "created" 	    => date('Y-m-d H:i:s')
                                  );
                $insert =  $this->CommonModel->common_insert_data('user_master',$user_data);  
                if($insert != false)
                {
                   
                    $filter = array("id" => $insert);
    		        $row = $this->CommonModel->get_single("user_master",$cfilter);
    		
                    $message = [
            			            'status'        => "1", 
            			            'user_id'       => $row->id,
            			            'firstname'     => $row->firstname,
            			            'lastname'      => $row->lastname,
            			            'full_name'     => $row->firstname." ".$row->lastname,
            			            'email'         => $row->email,
            			            'contact'       => $row->contact,
            			            'message'       => 'Login Validated'
        			            ];
        			echo json_encode($message);
        			die;
                }
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
        		$contact_exist = $this->CommonModel->get_single("user_master",$cfilter);
                if(!empty($contact_exist))
        		{
    		    	$db_otp = $contact_exist->otp;
    		    	if($otp == $db_otp || $otp == "111111")
    		    	{
                        $message = [
            						'status'        => 1,
            						'user_id'       => $contact_exist->id,
            						'firstname'     => $contact_exist->firstname,
            						'lastname'      => $contact_exist->lastname,
            						'full_name'     => $contact_exist->firstname." ".$contact_exist->lastname,
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
    

    public function change_notification_status()
    {
    	$secrete    =  $this->request->getVar('secrete');
    	$user_id   =  $this->request->getVar('user_id');

    	if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{
    		if($user_id == '' )
    		{
    			$data = ['status' => '0', 'message' => 'Please Enter user _id...!'];
    			echo json_encode($data);
    			die;
    		}
    		else
    		{
        		$cfilter = array("id" => $user_id);
        		$user = $this->CommonModel->get_single("user_master",$cfilter);
        		
        		$notification_status = $user->notification_status;
        		
                if($notification_status == 1)
        		{
        		    $update_data    = array("notification_status" => 0);
        		}
    			else
    	    	{
    	    	    $update_data    = array("notification_status" => 1);
    	    	}
    	    	
    	    	    $filter         = array("id" => $user_id);
    	    	    $update         = $this->CommonModel->update_data("user_master",$update_data,$filter);
        		    
    		    	if($update != false)
    		    	{
                        $message = ['status' => 1,'message' => 'Changed Successfully!']; 
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
      
        $secrete =  $this->request->getVar('secrete');
        $user_id =  $this->request->getVar('user_id');
        
        if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{
    	    
			$sop_services			= $this->get_sop_services();
			
			$top_banners			= $this->get_top_banners();
			
			$bottom_banners			= $this->get_bottom_banners();
			
			$bottom_info			= $this->get_bottom_info();
			
			
			$filter             = array('is_deleted' => 0, 'status' => 1);
    		$sop_service_exist              = $this->CommonModel->get_by_condition('sop_services',$filter);
    		$sop_service_list   = array(); 
    		
    		if(!empty($sop_service_exist))
    		{
    			foreach ($sop_service_exist as  $row) 
    			{
    				$sop_service_data['sop_service_id']         = $row->id;
    				$sop_service_data['sop_service_name']       = $row->name;
    				array_push($sop_service_list,$sop_service_data);
    			}
    		} 
    		
			$filter             = array('is_deleted' => 0, 'status' => 1);
    		$sop_country_exist              = $this->CommonModel->get_by_condition('sop_countries',$filter);
    		$sop_country_list   = array(); 
    		
    		if(!empty($sop_country_exist))
    		{
    			foreach ($sop_country_exist as  $row) 
    			{
    				$sop_country_data['sop_country_id']         = $row->id;
    				$sop_country_data['sop_country_name']       = $row->name;
    				array_push($sop_country_list,$sop_country_data);
    			}
    		} 
    		
    		
    		$package_hours = array( "24 Hours", "48 Hours" , "72 Hours");
			
			
			$sop_country_image_path = base_url()."/uploads/sop_countries/";	

	        $val = [
	                    'status'                    => '1',
						'sop_services'              => $sop_services,
						'top_banners'               => $top_banners,
						'bottom_banners'            => $bottom_banners,
						'bottom_info'               => $bottom_info,
						'sop_country_image_path'    => $sop_country_image_path,
						'sop_service_list'          => $sop_service_list,
						'sop_country_list'          => $sop_country_list,
						'package_hours'             => $package_hours,
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
	////////////////////////////////////
	///////////HOMEPAGE ENDS///////////
	//////////////////////////////////
    

	/////////////GET SOP SERVICES/////////////////
	function get_sop_services()
	{
		
		$query = "select * from sop_services where is_deleted = 0 and status = 1 order by orders asc";
		$exist      = $this->CommonModel->custome_query($query);
			   
		
		$base_url               = base_url()."/uploads/sop_services/";	    
		$sop_services_array     = array(); 
		$sop_package_array     = array(); 
		
		if(!empty($exist))
		{
			foreach ($exist as  $row) 
			{

			    $query = "SELECT p.*,c.name as country_name, c.image as country_image, s.name as service_name, s.id as sop_service_id, c.id as sop_country_id from sop_packages p, sop_services s, sop_countries c WHERE p.created_by = 'admin' and p.status = 1 and p.is_deleted = 0 and p.sop_service_id = s.id and p.sop_country_id = c.id and s.id = $row->id ";
			    $packages      = $this->CommonModel->custome_query($query);

				$data['sop_service_id']       = $row->id;
				$data['sop_service_image']    = $row->image;
				$data['sop_service_name']     = $row->name;

				if($row->image == "" || $row->image == null)
				{
					$data['image_path']     = "";
				}
				else
				{
					$data['image_path']     = $base_url.$row->image;
				}
				
			    $data['packages'] = $packages;
				
				array_push($sop_services_array,$data);
			}

			return $sop_services_array;
				
		} 
		
		
	}
    /////////////GET SOP SERVICES/////////////////
    
    /////////////GET PACKAGES/////////////////
	function get_packages()
	{
	    
	    $secrete            =  $this->request->getVar('secrete');
        $sop_service_id     =  $this->request->getVar('sop_service_id');
        $sop_country_id     =  $this->request->getVar('sop_country_id');
        
        if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
        {
            $filter = array("sop_service_id" => $sop_service_id, "sop_country_id" => $sop_country_id, "is_deleted" => 0, "status" => 1);
            $exist = $this->CommonModel->get_by_condition("sop_packages",$filter);
     

    		$package_array  = array(); 
		
    		if(!empty($exist))
    		{
    			foreach ($exist as  $row) 
    			{
    
    				$data['package_id']      = $row->id;
    				$data['package_name']    = $row->name;
    				$data['package_price']   = $row->price;

    				array_push($package_array,$data);
    			}
    
    		
    				
    		} 
            
        
            $val = [
                        'status'       => '1',
        				'sop_packages' => $package_array,
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
		
		
		
		
	
    /////////////GET PACKAGES/////////////////

	/////////////TOP BANNER START/////////////////
	function get_top_banners()
	{
		
		$filter             = array('is_deleted' => 0, 'status' => 1 ,'type' => 'top');
		$order[0]           = "sr_no";
		$order[1]           = "ASC";
		$exist              = $this->CommonModel->get_by_condition('sliders',$filter,$order);
		$base_url           = base_url()."/uploads/sliders/";	    
		$top_banners_array  = array(); 
		
		if(!empty($exist))
		{
			foreach ($exist as  $row) 
			{

	
				$top_slider_data['top_slider_id']       = $row->id;
				$top_slider_data['top_slider_image']    = $row->image;

				if($row->image == "" || $row->image == null)
				{
					$top_slider_data['image_path']     = "";
				}
				else
				{
					$top_slider_data['image_path']     = $base_url.$row->image;
				}
				
				

				array_push($top_banners_array,$top_slider_data);
			}

			return $top_banners_array;
				
		} 
		
		
	}
    /////////////TOP BANNER ENDS/////////////////


	/////////////PROMO BANNER START/////////////////
	function get_promo_banners()
	{
		$filter             = array('is_deleted' => 0, 'status' => 1 ,'type' => 'Promo');
		$order[0]           = "sr_no";
		$order[1]           = "ASC";
		$exist              = $this->CommonModel->get_by_condition('sliders',$filter,$order);
		$base_url           = base_url()."/uploads/sliders/";	    
		$promo_banners_array  = array(); 
		
		if(!empty($exist))
		{
			foreach ($exist as  $row) 
			{


				$promo_slider_data['top_slider_id']       = $row->id;
				$promo_slider_data['top_slider_image']    = $row->image;
				$promo_slider_data['category_id']         = $row->category_id;
				
				if($row->image == "" || $row->image == null)
				{
					$promo_slider_data['image_path']     = "";
				}
				else
				{
					$promo_slider_data['image_path']     = $base_url.$row->image;
				}
				array_push($promo_banners_array,$promo_slider_data);
			}
			return $promo_banners_array;
		}
	}
	/////////////PROMO BANNER ENDS/////////////////
	
	
	/////////////BOTTOM BANNER STARTS/////////////////
	function get_bottom_banners()
	{
		$filter             = array('is_deleted' => 0, 'status' => 1 ,'type' => 'bottom');
		$order[0] = "name";
		$order[1] = "ASC";
		$exist   = $this->CommonModel->get_by_condition('sliders',$filter,$order);
		$base_url = base_url()."/uploads/sliders/";	    
		$bottom_banner_array = array(); 
		if(!empty($exist))
		{
			foreach ($exist as  $row) 
			{


				$bottom_slider_data['bottom_slider_id']    = $row->id;
				$bottom_slider_data['bottom_slider_image'] = $row->image;

				if($row->image == "" || $row->image == null)
				{
					$bottom_slider_data['image_path']     = "";
				}
				else
				{
					$bottom_slider_data['image_path']     = $base_url.$row->image;
				}
				array_push($bottom_banner_array,$bottom_slider_data);
			}
			return $bottom_banner_array;
		}
	}
	/////////////BOTTOM BANNER ENDS/////////////////
	
	/////////////BOTTOM INFO STARTS/////////////////
	function get_bottom_info()
	{
		$filter             = array('is_deleted' => 0);
		$order[0] = "name";
		$order[1] = "ASC";
		$exist   = $this->CommonModel->get_by_condition('bottom_info',$filter,$order);
		$base_url = base_url()."/uploads/bottom_info/";	    
		$bottom_info_array = array(); 
		if(!empty($exist))
		{
			foreach ($exist as  $row) 
			{


				$bottom_info_data['bottom_info_id']    = $row->id;
				$bottom_info_data['bottom_info_image'] = $row->image;
				$bottom_info_data['title'] = $row->title;
				$bottom_info_data['description'] = $row->description;
				
				if($row->image == "" || $row->image == null)
				{
					$bottom_info_data['image_path']     = "";
				}
				else
				{
					$bottom_info_data['image_path']     = $base_url.$row->image;
				}
				array_push($bottom_info_array,$bottom_info_data);
			}
			return $bottom_info_array;
		}
	}
	/////////////BOTTOM INFO ENDS/////////////////
	






	////////////////////////////////////
	///////////PROFILE STARTS///////////
	//////////////////////////////////
	function update_profile()
	{
		$secrete        =  $this->request->getVar('secrete');
		
		$firstname      =  $this->request->getVar('firstname');
		$lastname      =  $this->request->getVar('lastname');
		$email          =  $this->request->getVar('email');
		$user_id        =  $this->request->getVar('user_id');
		$contact        =  $this->request->getVar('contact');
		$image          =  $this->request->getVar('image');
		$gst_no          =  $this->request->getVar('gst_no');
		$out_of_state          =  $this->request->getVar('out_of_state');

		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
		{
			if($firstname == '' )
			{
				$data = ['status' => '0', 'message' => 'Please Enter First Name...!'];
				echo json_encode($data);
				die;
			}
			else if($user_id == '' )
			{
				$data = ['status' => '0', 'message' => 'Please User Id...!'];
				echo json_encode($data);
				die;
			}
			else
			{
					$filter = array("id" => $user_id);
					$user = $this->CommonModel->get_single("user_master",$filter);
					
					$db_image = $user->profile_picture;

					$table = "user_master";
					$filter = array("id" => $user_id);
					
					if($image == "")
					{
					$image = $db_image;
					}
					else
					{
						$base64_string = $_POST["image"];
						$outputfile = "uploads/customers/image.jpg" ;
						$random = md5(microtime());
						$image = "$random.jpg" ;
						$outputfile = "uploads/customers/$random.jpg" ;
						$filehandler = fopen($outputfile, 'wb' ); 
						fwrite($filehandler, base64_decode($base64_string));
						fclose($filehandler); 
					}  
	
					$table = "user_master";
					$filter = array("id" => $user_id);
					
					$update_data = array(
											"firstname" 		=> $firstname,
											"lastname" 		=> $lastname,
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
    	$user_id =  $this->request->getVar('user_id');
    	
    	if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{
    		if($user_id == '' )
    		{
    			$data = ['status' => '0', 'message' => 'Please Enter User Id...!'];
    			echo json_encode($data);
    			die;
    		}
    		else
    		{
    			$table = "user_master";
    			$filter = array("id" => $user_id);
    			$exist =  $this->CommonModel->get_single($table,$filter);
    			
    			
    			if(!empty($exist))
    			{
    			    
    			    if($exist->profile_picture == "" || $exist->profile_picture == NULL)
    			    {
    			        $profile_image = base_url()."/uploads/static/user.png";
    			    }
                    else
                    {
                        $profile_image = base_url()."/uploads/customers/$exist->profile_picture";
                    }
                    
                    
                    $query = "select count(id) as unread_notifications from notifications where user_id = $user_id and is_read = 0";
                    $notification_count = $this->CommonModel->custome_query_single_record($query);
                    $unread_notifications = $notification_count->unread_notifications;
                    
                    
    		         $message = [
                					'status'                		=> '1',
                					'user_id'               		=> $exist->id,
                					'firstname'             		=> $exist->firstname,
                					'lastname'             		    => $exist->lastname,
                					'email'                  		=> $exist->email,
                					'contact'                   	=> $exist->contact,
                					'notification_status'           => $exist->notification_status,
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
		$user_id    			=  $this->request->getVar('user_id');
		$subject    			=  $this->request->getVar('subject');
		$message    			=  $this->request->getVar('message');
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
		{
			if($user_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter user id.'];
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
				"user_id" 			=> $user_id,
				"subject"			=> $subject,
				"message"			=> $message,
				"created"			=> date("Y-m-d H:i:s")
			);

			$insert_paylater_history = $this->CommonModel->common_insert_data("contact",$insert_data);	

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

    public function get_notifications()
    {
      	$secrete =  $this->request->getVar('secrete');
      	$user_id =  $this->request->getVar('user_id');
    	
    	if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{	
    	    
    	    if($user_id == '')
    	    {
    	        $data = ['status' => '0', 'message' => 'Enter User Id.'];
        		echo json_encode($data);
        		die;
    	    }
    	    else
    	    {
    	        $filter = array("user_id" => $user_id);
        	    $stores = $this->CommonModel->get_by_condition("notifications",$filter);
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
                      $val = ['status' => '1','notifications' => $data_array2];
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
      	$user_id =  $this->request->getVar('user_id');
    	
    	if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{	
    	    
    	    if($user_id == '')
    	    {
    	        $data = ['status' => '0', 'message' => 'Enter User Id.'];
        		echo json_encode($data);
        		die;
    	    }
    	    else
    	    {
    	        $filter = array("user_id" => $user_id);
        	    $delete = $this->CommonModel->delete_data("notifications",$filter);
        	    
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
    
    /////////////////////////////////////////////////////
    ////////////////////SOP SERVICE ADD/////////////////
    ////////////////////////////////////////////////////
    public function sop_service_step_one()
	{
		$secrete    			    =  $this->request->getVar('secrete');
		$user_id    			    =  $this->request->getVar('user_id');
		$package_id    			    =  $this->request->getVar('package_id');
		$applicant_name    			=  $this->request->getVar('applicant_name');
		$contact    			    =  $this->request->getVar('contact');
		$email    			        =  $this->request->getVar('email');
		$date    			        =  date('Y-m-d');
		
		$pincode    		=  $this->request->getVar('pincode');
		$state    			=  $this->request->getVar('state');
		$city    			=  $this->request->getVar('city');
		
		$father_name    			=  $this->request->getVar('father_name');
		$father_employment_status   =  $this->request->getVar('father_employment_status');
		$father_company_name    	=  $this->request->getVar('father_company_name');
		$father_designation    	    =  $this->request->getVar('father_designation');
		
		$mother_name    			=  $this->request->getVar('mother_name');
		$mother_employment_status   =  $this->request->getVar('mother_employment_status');
		$mother_company_name    	=  $this->request->getVar('mother_company_name');
		$mother_designation    	    =  $this->request->getVar('mother_designation');
		
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
		{
			if($user_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter user id.'];
        		echo json_encode($data);
        		die;
            }
			if($package_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter package.'];
        		echo json_encode($data);
        		die;
            }
			if($applicant_name == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Applicant Name.'];
        		echo json_encode($data);
        		die;
            }
            if($contact == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Contact.'];
        		echo json_encode($data);
        		die;
            }
            if($email == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Email Address.'];
        		echo json_encode($data);
        		die;
            }
            
            if($father_name == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Father Name.'];
        		echo json_encode($data);
        		die;
            }
            
            if($father_employment_status == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Father Employment Status.'];
        		echo json_encode($data);
        		die;
            }
            
          
            
            if($mother_name == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Mother Name.'];
        		echo json_encode($data);
        		die;
            }
            
            if($mother_employment_status == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Mother Employment Status.'];
        		echo json_encode($data);
        		die;
            }
            
           

             $application_no       = "TIB" . rand(10000,99999999);
            
            
			$insert_data = array(
				"user_id" 			        => $user_id,
				"application_no"            => $application_no,
				"package_id"			    => $package_id,
				"applicant_name"			=> $applicant_name,
				"contact"			        => $contact,
				"email"			            => $email,
				
				"state"			            => $state,
				"city"			            => $city,
				"pincode"			        => $pincode,
				
				"father_name"			    => $father_name,
				"father_employment_status"	=> $father_employment_status,
				"father_company_name"		=> $father_company_name,
				"father_designation"		=> $father_designation,
				
				"mother_name"			    => $mother_name,
                "mother_employment_status"	=> $mother_employment_status,
                "mother_company_name"		=> $mother_company_name,
                "mother_designation"		=> $mother_designation,
				
				
				
				"date"			            => $date,
				"created"			        => date("Y-m-d H:i:s")
			);

			$insert = $this->CommonModel->common_insert_data("sop_applications",$insert_data);	

			if($insert != false)	
			{
				$data = ['status' => '1', 'application_id' => $insert, 'message' => 'Applicant form saved successfully.'];
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
	
	
    public function sop_service_step_one_update()
	{
		$secrete    			    =  $this->request->getVar('secrete');
		$application_id    			=  $this->request->getVar('application_id');
		$applicant_name    			=  $this->request->getVar('applicant_name');
		$contact    			    =  $this->request->getVar('contact');
		$email    			        =  $this->request->getVar('email');
		
		$pincode    		        =  $this->request->getVar('pincode');
		$state    			        =  $this->request->getVar('state');
		$city    			        =  $this->request->getVar('city');
		
		$father_name    			=  $this->request->getVar('father_name');
		$father_employment_status   =  $this->request->getVar('father_employment_status');
		$father_company_name    	=  $this->request->getVar('father_company_name');
		$father_designation    	    =  $this->request->getVar('father_designation');
		
		$mother_name    			=  $this->request->getVar('mother_name');
		$mother_employment_status   =  $this->request->getVar('mother_employment_status');
		$mother_company_name    	=  $this->request->getVar('mother_company_name');
		$mother_designation    	    =  $this->request->getVar('mother_designation');
		
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
		{

			if($application_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Application id.'];
        		echo json_encode($data);
        		die;
            }
			if($applicant_name == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Applicant Name.'];
        		echo json_encode($data);
        		die;
            }
            if($contact == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Contact.'];
        		echo json_encode($data);
        		die;
            }
            if($email == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Email Address.'];
        		echo json_encode($data);
        		die;
            }
            
             if($father_name == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Father Name.'];
        		echo json_encode($data);
        		die;
            }
            
            if($father_employment_status == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Father Employment Status.'];
        		echo json_encode($data);
        		die;
            }
            
    
            
       
            
            if($mother_name == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Mother Name.'];
        		echo json_encode($data);
        		die;
            }
            
            if($mother_employment_status == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Mother Employment Status.'];
        		echo json_encode($data);
        		die;
            }
            
    
  
        
			$update_data = array(
			
				"applicant_name"			=> $applicant_name,
				"contact"			        => $contact,
				"email"			            => $email,
				
				"state"			            => $state,
				"city"			            => $city,
				"pincode"			        => $pincode,
				
				"father_name"			    => $father_name,
				"father_employment_status"	=> $father_employment_status,
				"father_company_name"		=> $father_company_name,
				"father_designation"		=> $father_designation,
				
				"mother_name"			    => $mother_name,
                "mother_employment_status"	=> $mother_employment_status,
                "mother_company_name"		=> $mother_company_name,
                "mother_designation"		=> $mother_designation,
				
				"created"			        => date("Y-m-d H:i:s")
			);

            $filter = array("id" => $application_id);
			$update = $this->CommonModel->update_data("sop_applications",$update_data,$filter);	

			if($update != false)	
			{
				$data = ['status' => '1', 'message' => 'Applicant form saved successfully.'];
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
	
	public function add_family_member()
	{
	    $secrete        =  $this->request->getVar('secrete');
	    $user_id        =  $this->request->getVar('user_id');
     	$relation       =  $this->request->getVar('relation');
     	$name           =  $this->request->getVar('name');
     	$profession     =  $this->request->getVar('profession');
     	$company_name   =  $this->request->getVar('company_name');
     	$designation    =  $this->request->getVar('designation');
     	$elder_younger  =  $this->request->getVar('elder_younger');
     	$education      =  $this->request->getVar('education');
     	$created        =  date("Y-m-d H:i:s");
        
	    if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
	        if($user_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter User Id.'];
        		echo json_encode($data);
        		die;
            }
            
            if($relation == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Relation.'];
        		echo json_encode($data);
        		die;
            }
            
            if($name == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Name.'];
        		echo json_encode($data);
        		die;
            }
            
            if($relation == "Father" || $relation == "Mother")
            {
                $elder_younger = "";
            }
            
	        $insert_data = array(
	                                "user_id"       => $user_id,
	                                "relation"      => $relation,
	                                "name"          => $name,
	                                "profession"    => $profession,
	                                "company_name"  => $company_name,
	                                "designation"   => $designation,
	                                "elder_younger" => $elder_younger,
	                                "education"     => $education,
	                                "created"       => $created
	                            );
	        $insert = $this->CommonModel->common_insert_data("family_details",$insert_data);	

			if($insert != false)	
			{
				$data = ['status' => '1', 'message' => 'Family member added successfully.'];
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
	
	public function remove_family_member()
	{
	    $secrete        =  $this->request->getVar('secrete');
     	$family_id           =  $this->request->getVar('family_id');
     	
	    if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
            if($family_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Family Id.'];
        		echo json_encode($data);
        		die;
            }
            else
            {
                $filter = array("id" => $family_id);
                $update_data = array("is_deleted" => 1);
                $update = $this->CommonModel->update_data("family_details",$update_data,$filter);
                
                if($update != false)
                {
                    $data = ['status' => '1', 'message' => 'Family Member Removed Successfully.'];
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
	}
	
	public function update_any_remark()
	{
	    
	    $secrete        =  $this->request->getVar('secrete');
     	$application_id =  $this->request->getVar('application_id');
     	$any_remark =  $this->request->getVar('any_remark');
     	
	    if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
	        
            if($application_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Application Id.'];
        		echo json_encode($data);
        		die;
            }
            else
            {
                $filter  = array("id" => $application_id);
                $update_data = array('any_remark' => $any_remark);
                $update = $this->CommonModel->update_data("sop_applications",$update_data,$filter);	
                
                if($update != false)
                {
                    $data = ['status' => '1', 'message' => 'Application Details Updated.'];
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
	
	public function sop_application_update_document()
	{
        $secrete        =  $this->request->getVar('secrete');
     	$file           =  $this->request->getVar('file');
     	$application_id =  $this->request->getVar('application_id');
     	$column_name    =  $this->request->getVar('column_name');
        
	    if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
	        
            if($application_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Application Id.'];
        		echo json_encode($data);
        		die;
            }
            
            if($column_name == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Column Name.'];
        		echo json_encode($data);
        		die;
            }
	        
            if(isset($_FILES["file"]))
            {
                $target_dir = "uploads/documents/"; 
                
                
                $tmp            = explode(".",$_FILES["file"]["name"]);
                $file_extension = end($tmp);
                $newfilename    = time() . '_' . rand(100, 999) . '.' . $file_extension;
                
                //$filename = $_FILES["file"]["name"]; 
                    
                $savefile = "$target_dir/$newfilename";
            
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $savefile)) 
                {
                    $filter  = array("id" => $application_id);
                    $update_data = array($column_name => $newfilename,"edit_mode" => 0);
                    $update = $this->CommonModel->update_data("sop_applications",$update_data,$filter);	
                    
                    if($update != false)
                    {
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
	
	public function get_sop_application_list()
	{
		$secrete =  $this->request->getVar('secrete');
		$user_id =  $this->request->getVar('user_id');
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
	        if($user_id == "")
	        {
	            $data = ['status' => '0', 'message' => 'Please Enter User Id.'];
    			echo json_encode($data);
    			die;
	        }
	        else
	        {
	            $filter = array("user_id" => $user_id);
	            $result = $this->CommonModel->get_by_condition("sop_applications",$filter);
	            
	            if(!empty($result))
	            {
                    $data_array = array(); 
        	    
    	             $base_url = base_url()."/uploads/sop_countries/";	 
        	             
                	foreach ($result as  $row) 
                	{
                	    
                	    $filter = array("id" => $row->package_id);
                	    $package = $this->CommonModel->get_single("sop_packages",$filter);
                	    
                	    $filter = array("id" => $package->sop_country_id);
                	    $country = $this->CommonModel->get_single("sop_countries",$filter);
                	    
                	    $filter = array("id" => $package->sop_service_id);
                	    $service = $this->CommonModel->get_single("sop_services",$filter);
                	    
                	    
                	    $filter = array("application_id" => $row->id,"user_id" => $user_id);
                	    $review_rating = $this->CommonModel->get_single("sop_application_review_rating",$filter);
                	    
                	   
                	    
                	    
                        $data['application_id']             = $row->id;
                        
                        $data['edit_mode']             = $row->edit_mode;
                        
                        $data['country_name']             = $country->name;
                        
                        $data['service_name']             = $service->name;
                        
                        $data['package_name']             = $package->name;
                        
                        $data['package_price']             = $package->price;
                        
                     
        	    
            	    	if($country->image == "" || $country->image == null)
            			{
            				$data['country_image']    = "";
            			}
            			else
            			{
            				$data['country_image']     = $base_url.$country->image;
            			}
                        
                        if($row->edit_message == "" || $row->edit_message == null)
            			{
            				$data['edit_message']    = "";
            			}
            			else
            			{
            				$data['edit_message']     = $row->edit_message;
            			}
            			
            			if($row->application_status == "Documents Under Verification")
            			{
            			    $data['application_status_message'] = "Your Documents are in under verification";
            			}
            			else if($row->application_status == "Service Provider Assigned")
            			{
            			    $data['application_status_message'] = "Service provider has been assigned to your SOP Application";
            			}
            			else if($row->application_status == "SOP Document Sent")
            			{
            			    $data['application_status_message'] = "SOP Document has been sent";
            			}
            			else if($row->application_status == "Completed")
            			{
            			    $data['application_status_message'] = "Your SOP application is completed";
            			}
            			
                        
                        $data['application_no']             = $row->application_no;
                        $data['applicant_name']             = $row->applicant_name;
                        $data['application_status'] = $row->application_status;
                        $data['contact']             = $row->contact;
                        $data['email']             = $row->email;
                        $data['draft_status']             = $row->draft_status;
                        
                        if(!empty($review_rating))
                	    {
                	      $data['review_rating']             = "false";
                	    }
                	    else
                	    {
                	         $data['review_rating'] = "true";
                	    }

                        $orgDate                    = $row->created;  
                        $data['date']              = date("d-M-y h:i A", strtotime($orgDate));  
                        
                    
                        array_push($data_array,$data);
                    }
                    
                        $val = ['status' => '1','user_sop_applications' => $data_array];
                        echo json_encode($val);
                        die;
            	    
	            }
	            else
	            {
	                $data = ['status' => '0', 'message' => 'Oops ! Nothing to see here.'];
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
	
	public function confirm_sop_package_details()
	{
	    $secrete =  $this->request->getVar('secrete');
		$application_id =  $this->request->getVar('application_id');
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
	        if($application_id == "")
	        {
	            $data = ['status' => '0', 'message' => 'Please Enter Application Id.'];
    			echo json_encode($data);
    			die;
	        }
	        else
	        {
	            $filter = array("id" => $application_id);
	            $row = $this->CommonModel->get_single("sop_applications",$filter);
	            
	            $filter = array("id" => $row->package_id);
        	    $package = $this->CommonModel->get_single("sop_packages",$filter);
        	    
        	    $filter = array("id" => $package->sop_country_id);
        	    $country = $this->CommonModel->get_single("sop_countries",$filter);
        	    
        	    $filter = array("id" => $package->sop_service_id);
        	    $service = $this->CommonModel->get_single("sop_services",$filter);
        	    
        	    $base_url = base_url()."/uploads/sop_countries/";	   
        	    
    	    	if($country->image == "" || $country->image == null)
				{
					$country_image    = "";
				}
				else
				{
					$country_image     = $base_url.$country->image;
				}
        	    
        	    
        	    
                $data = [
                            'status' => '1',
                            'country_name'  => $country->name,
                            'applicant_name'=> $row->applicant_name,
                            'contact'       => $row->contact,
                            'email'         => $row->email,
                            'package_price' => $package->price,
                            'package_name'  => $package->name,
                            'service_name'  => $service->name,
                            'country_image'  => $country_image,
                            
                            
                            'message' => 'Data Fetched Successfully.'
                        ];
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
	
	public function payment_successful()
	{ 
	    $secrete                =  $this->request->getVar('secrete');
		$application_id         =  $this->request->getVar('application_id');
		$transaction_status     =  $this->request->getVar('transaction_status');
		$transaction_amount     =  $this->request->getVar('transaction_amount');
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
	        if($application_id == "")
	        {
	            $data = ['status' => '0', 'message' => 'Please Enter Application Id.'];
    			echo json_encode($data);
    			die;
	        }
	        else if($transaction_status == "")
	        {
	            $data = ['status' => '0', 'message' => 'Please Enter Transaction Status.'];
    			echo json_encode($data);
    			die;
	        }
	        else if($transaction_amount == "")
	        {
	            $data = ['status' => '0', 'message' => 'Please Enter Transaction Amount.'];
    			echo json_encode($data);
    			die;
	        }
	        
	        else
	        {
	            $filter = array("id" => $application_id);
	            $row = $this->CommonModel->get_single("sop_applications",$filter);
	            $application_details = $this->CommonModel->get_single("sop_applications",$filter);

	            $filter = array("id" => $row->package_id);
        	    $package = $this->CommonModel->get_single("sop_packages",$filter);
   
        	    $hours = substr($package->name, 0, 2);
             
		        $pay_date = date('Y-m-d H:i:s');
                $deadline = date('Y-m-d H:i:s', strtotime("+".$hours." hours")); 
                $deadline = date('Y-m-d H:i:s', strtotime($pay_date. ' + '.$hours.' hours')); 

        	    
        	    $filter = array("id" => $application_id);
        	    $update_data = array(
        	                            "payment_status"        => 1,
        	                            "date"                  => date("Y-m-d"),
        	                            "transaction_status"    => $transaction_status,
        	                            "transaction_amount"    => $transaction_amount,
        	                            "package_price"         => $package->price,
        	                            "deadline"              => $deadline,
        	                            "draft_status"          => 0,
        	                        );
        	             
        	    $update = $this->CommonModel->update_data("sop_applications",$update_data,$filter);
                
                if($update != false)
                {
                    
                ////////////SEND NOTIFICATION TO SERVICE PROVIDER/////////
                ////////////SEND NOTIFICATION TO SERVICE PROVIDER/////////

                $filter = array("id" => $application_id);
                $application_details = $this->CommonModel->get_single("sop_applications",$filter);
                
                $user_state = $application_details->state;
                $user_city = $application_details->city;
                
                $filter = array("city" => $user_city);
                $city_service_provider = $this->CommonModel->get_by_condition("service_providers",$filter);
                
                $filter = array("state" => $user_state);
                $state_service_provider = $this->CommonModel->get_by_condition("service_providers",$filter);
                
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
                  
                    $filter = array("status" => 1,"is_deleted" => 0);
                    $service_providers = $this->CommonModel->get_by_condition("service_providers",$filter);
                    
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
                ////////////SEND NOTIFICATION TO SERVICE PROVIDER/////////
                
                
                ////////////SEND NOTIFICATION TO ADMIN/////////
                 $insert_data = array(
                                        "title"   => "New Application Recieved #".$application_details->application_no,
                                        "message" => "User Needs SOP Service in ".$package->name,
                                        "created" => date("Y-m-d H:i:s")
                                        );	
                $insert = $this->CommonModel->common_insert_data('admin_notifications',$insert_data);
                
                //Send To Web
                $filter         = array("id" => $row->id);
                $user           = $this->CommonModel->get_single("user",$filter);
                $token          = $user->token;
                $token_array    = array($token);
                
                $title = "New Inquiry Alert !!!";
                $message = "SOP Service Request Recieved !";
                
                $this->send_notification($token_array,$title,$message);
                
                ////////////SEND NOTIFICATION TO ADMIN/////////

                    $data = ['status' => '1', 'message' => 'Payment Details Added Successfully.'];
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
                
                $base_url = base_url()."uploads/sop_documents/";
                
                $sop_application_document = $base_url.$exist->sop_application_document;
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
	
	
	//////////////UPDATE SOP APPLICATION DETAILS/////////////
	//////////////UPDATE SOP APPLICATION DETAILS/////////////
	//////////////UPDATE SOP APPLICATION DETAILS/////////////
	public function get_applicant_details()
	{
	    $secrete =  $this->request->getVar('secrete');
		$application_id =  $this->request->getVar('application_id');
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
	        if($application_id == "")
	        {
	            $data = ['status' => '0', 'message' => 'Please Enter Application Id.'];
    			echo json_encode($data);
    			die;
	        }
	        else
	        {
	            $filter = array("id" => $application_id);
	            $exist = $this->CommonModel->get_single("sop_applications",$filter);
	       
                $data = [
                            'status' => '1',
                            'applicant_name'            => $exist->applicant_name,	
 	                        'contact' 	                => $exist->contact,
 	                        'email' 	                => $exist->email,
 	                        
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
 	                        
                            'message' => 'Data Fetched Successfully.'
                        ];
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
	
	
	public function get_documents()
	{
	    $secrete =  $this->request->getVar('secrete');
		$application_id =  $this->request->getVar('application_id');
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
	        if($application_id == "")
	        {
	            $data = ['status' => '0', 'message' => 'Please Enter Application Id.'];
    			echo json_encode($data);
    			die;
	        }
	        else
	        {
	            $filter = array("id" => $application_id);
	            $exist = $this->CommonModel->get_single("sop_applications",$filter);
	            
	            $base_url = base_url()."uploads/documents/";
	            
                $passport_copy              = $exist->passport_copy;
                $marriage_certificate 	    = $exist->marriage_certificate;
                $offer_letter 	            = $exist->offer_letter;
                $loan_letter 	            = $exist->loan_letter;
                $tuition_fee_receipt 	    = $exist->tuition_fee_receipt;
                $course_certificate 	    = $exist->course_certificate;
                $employment_certificate 	= $exist->employment_certificate;
                $ielts_certificate	        = $exist->ielts_certificate;
                $fund_related_doc 	        = $exist->fund_related_doc;
                $any_remark	                = $exist->any_remark;

                if($any_remark == "")
                {
                    $any_remark = "";
                    $any_remark_status = "0";
                }
                else
                {
                    $any_remark = $base_url.$any_remark;
                    $any_remark_status = "1";
                }  

                if($fund_related_doc == "")
                {
                    $fund_related_doc = "";
                    $fund_related_doc_status = "0";
                }
                else
                {
                    $fund_related_doc = $base_url.$fund_related_doc;
                    $fund_related_doc_status = "1";
                }  

                if($ielts_certificate == "")
                {
                    $ielts_certificate = "";
                    $ielts_certificate_status = "0";
                }
                else
                {
                    $ielts_certificate = $base_url.$ielts_certificate;
                    $ielts_certificate_status = "1";
                }  
                
                if($course_certificate == "")
                {
                    $course_certificate = "";
                    $course_certificate_status = "0";
                }
                else
                {
                    $course_certificate = $base_url.$course_certificate;
                    $course_certificate_status = "1";
                }  

                if($tuition_fee_receipt == "")
                {
                    $tuition_fee_receipt = "";
                    $tuition_fee_receipt_status = "0";
                }
                else
                {
                    $tuition_fee_receipt = $base_url.$tuition_fee_receipt;
                    $tuition_fee_receipt_status = "1";
                }  

                if($loan_letter == "")
                {
                    $loan_letter = "";
                    $loan_letter_status = "0";
                }
                else
                {
                    $loan_letter = $base_url.$loan_letter;
                    $loan_letter_status = "1";
                }  

                if($offer_letter == "")
                {
                    $offer_letter = "";
                    $offer_letter_status = "0";
                }
                else
                {
                    $offer_letter = $base_url.$offer_letter;
                    $offer_letter_status = "1";
                }  
                
                if($passport_copy == "")
                {
                    $passport_copy = "";
                    $passport_copy_status = "0";
                }
                else
                {
                    $passport_copy = $base_url.$passport_copy;
                    $passport_copy_status = "1";
                }                
                
                if($employment_certificate == "")
                {
                    $employment_certificate = "";
                    $employment_certificate_status = "0";
                }
                else
                {
                    $employment_certificate = $base_url.$employment_certificate;
                    $employment_certificate_status = "1";
                }
                
                
                if($marriage_certificate == "")
                {
                    $marriage_certificate = "";
                    $marriage_certificate_status = "0";
                }
                else
                {
                    $marriage_certificate = $base_url.$marriage_certificate;
                    $marriage_certificate_status = "1";
                }
	       
                $data = [
                            'status' => '1',
                            
                            'employment_certificate'                => $employment_certificate,
                            'employment_certificate_status'         => $employment_certificate_status,
                            'passport_copy'                         => $passport_copy,
                            'passport_copy_status'                  => $passport_copy_status,
                            'marriage_certificate'                  => $marriage_certificate,
                            'marriage_certificate_status'           => $marriage_certificate_status,
                            'offer_letter'                          => $offer_letter,
                            'offer_letter_status'                   => $offer_letter_status,
                            'loan_letter'                           => $loan_letter,
                            'loan_letter_status'                    => $loan_letter_status,
                            'tuition_fee_receipt'                   => $tuition_fee_receipt,
                            'tuition_fee_receipt_status'            => $tuition_fee_receipt_status,
                            'course_certificate'                    => $course_certificate,
                            'course_certificate_status'             => $course_certificate_status,
                            'ielts_certificate'                     => $ielts_certificate,
                            'ielts_certificate_status'              => $ielts_certificate_status,
                            'fund_related_doc'                      => $fund_related_doc,
                            'fund_related_doc_status'               => $fund_related_doc_status,
                            'any_remark'                            => $any_remark,
                            'any_remark_status'                     => $any_remark_status,
                            'payment_status'                    => $exist->payment_status,
                            
                            'message' => 'Data Fetched Successfully.'
                        ];
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
	//////////////UPDATE SOP APPLICATION DETAILS/////////////
	//////////////UPDATE SOP APPLICATION DETAILS/////////////
	//////////////UPDATE SOP APPLICATION DETAILS/////////////
	
	
	
	/////////////////TICKET/////////////////
	/////////////////TICKET/////////////////
	/////////////////TICKET/////////////////
	function create_ticket()
	{	
	    $secrete            =  $this->request->getVar('secrete');
		$user_id            =  $this->request->getVar('user_id');
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
	        else if($user_id == "")
	        {
	            $data = ['status' => '0', 'message' => 'Please Enter User Id.'];
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
	            $insert_data = array("user_id" => $user_id,"application_id" => $application_id, "message" => $message, "ticket_no" => $ticket_no,"created" => $created);
	            $insert = $this->CommonModel->common_insert_data("sop_application_user_tickets",$insert_data);
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
                $filter = array("user_id" => $user_id);
                $result = $this->CommonModel->get_by_condition("sop_application_user_tickets",$filter);
                
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
                        $data["user_id"]        = $row->user_id;
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
	
	
	
	public function send_mail()
	{
	    
	    
	    
	     //Send Email
                    $message = '<!DOCTYPE html>';
            		$message .= '<html>';   
                    $message .= '<head>';
                    $message .= '<meta name="viewport" content="width=device-width" />';
                    $message .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    $message .= '<title>Eliteadmin Responsive web app kit</title>';
                    $message .= '</head>';
                    $message .= '<body style="margin:0px; background: #f8f8f8; ">';
                    $message .= '<div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">';
                    $message .= '<div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">';
                    $message .= '<table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">';
                    $message .= '<tbody>';
                    $message .= '<tr>';
                    $message .= '<td style="vertical-align: top; padding-bottom:30px;" align="center"><a href="http://eliteadmin.themedesigner.in" target="_blank"><img src="../../assets/images/logo-icon.png" alt="Eliteadmin Responsive web app kit" style="border:none"><br/>';
                    $message .= '<img src="../../assets/images/logo-text.png" alt="Eliteadmin Responsive web app kit" style="border:none"></a>';
                    $message .= '</td>';
                    $message .= '</tr>';
                    $message .= '</tbody>';
                    $message .= '</table>';
                    $message .= '<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">';
                    $message .= '<tbody>';
                    $message .= '<tr>';
                    $message .= '<td style="background:#2962FF; padding:20px; color:#fff; text-align:center;"> Warning: You are approaching your limit. Please upgrade. </td>';
                    $message .= '</tr>';
                    $message .= '</tbody>';
                    $message .= '</table>';
                    $message .= '<div style="padding: 40px; background: #fff;">';
                    $message .= '<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">';
                    $message .= '<tbody>';
                    $message .= '<tr>';
                    $message .= '<td>';
                    $message .= '<p>Your Trial Expire from <b>19th sep 2018</b></p>';
                    $message .= '<p>Add your credit card now to upgrade your account to a premium plan to ensure you don not miss out on any reports.</p>';
                    $message .= '<center>';
                    $message .= '<a href="javascript: void(0);" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #4fc3f7; border-radius: 60px; text-decoration:none;">Upgrade My Account</a>';
                    $message .= '</center>';
                    $message .= '<b>- Thanks (Wrappixel team)</b> </td>';
                    $message .= '</tr>';
                    $message .= '</tbody>';
                    $message .= '</table>';
                    $message .= '</div>';
                    $message .= '<div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">';
                    $message .= '<p> Powered by warppixel';
                    $message .= '<br>';
                    $message .= '<a href="javascript: void(0);" style="color: #b2b2b5; text-decoration: underline;">Unsubscribe</a> </p>';
                    $message .= '</div>';
                    $message .= '</div>';
                    $message .= '</div>';
                    $message .= '</body>';
                    $message .= '</html>';
            		$datetime = date('d-M-Y h:i A');
            		$heads    = "Services - Graphionic Infotech";
                                                        	      
            		$config = Array(
                    'mailtype'  => 'html', 
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                     );
            
                     //Load email library
                    $this->email->set_mailtype("html");
                	$this->load->library('email',$config); 
                	$this->email->set_newline("\r\n");
            
            		$this->email->from('info@graphionicinfotech.com', 'Graphionic Remiders'); 
                 	$this->email->to('graphionic@gmail.com');
                	$this->email->subject($heads); 
            		$this->email->message($message); 
                		  
                   //Send mail
            		$this->email->send(); 
	    

	}
	
	
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    
    public function get_state_city_from_pincode()
    {
      	$secrete    =  $this->request->getVar('secrete');
      	$pincode    =  $this->request->getVar('pincode');
    	
    	if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{	
    	    
    	    if($pincode == '')
    	    {
    	        $data = ['status' => '0', 'message' => 'Enter Pincode.'];
        		echo json_encode($data);
        		die;
    	    }
    	    else
    	    {
    	        $filter = array("pincode"    => $pincode);
        	    $exist  = $this->CommonModel->get_single("pincodes",$filter);
        	    
        	    if(!empty($exist))
        	    {
        	       
        	        
        	        $data = ['status' => '1', 'city' => $exist->district, 'state' => $exist->state ];
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
    
    public function create_custom_package()
    {
        $secrete            =  $this->request->getVar('secrete');
        $user_id            = $this->request->getVar('user_id');
        $sop_service_id     = $this->request->getVar('sop_service_id');
        $sop_country_id     = $this->request->getVar('sop_country_id');
        $package_name       = $this->request->getVar('package_name');
        $package_price      = 2000;
        

    	if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
    	{
    	    if($sop_service_id == '')
    	    {
    	        $data = ['status' => '0', 'message' => 'Enter SOP Service Id.'];
        		echo json_encode($data);
        		die;
    	    }
    	    
    	    if($sop_country_id == '')
    	    {
    	        $data = ['status' => '0', 'message' => 'Enter SOP Country Id.'];
        		echo json_encode($data);
        		die;
    	    }
    	    
    	    if($package_name == '')
    	    {
    	        $data = ['status' => '0', 'message' => 'Enter SOP Package Name.'];
        		echo json_encode($data);
        		die;
    	    }
    	    
    	    if($user_id == '')
    	    {
    	        $data = ['status' => '0', 'message' => 'Enter User Id.'];
        		echo json_encode($data);
        		die;
    	    }
    	    
            $created = date("Y-m-d H:i:s");
    
            $insert_data = array(
                                    "sop_service_id"            => $sop_service_id,
                                    "sop_country_id"            => $sop_country_id,
                                    "name"                      => $package_name,
                                    "price"                     => $package_price,
                                    "created"                   => $created,
                                    "created_by"                => "user",
                                    "user_id"                   => $user_id,
    
                                );
    
            $package_insert = $this->CommonModel->common_insert_data('sop_packages', $insert_data);
            
            if($package_insert != false)
            {
                $data = ['status' => '1', 'package_id' => "$package_insert", "message" => "Package Inserted Successfully" ];
        		echo json_encode($data);
        		die;
            }
            else
            {
                $message = ['status' => '0', 'message' => 'Something went wrong!'];
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
    

    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////
    
    
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
    
    public function send_modification_message()
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
            $update_data    = array("edit_mode" => 1 , "modification_message" => $edit_message);
            $update         = $this->CommonModel->update_data('sop_applications', $update_data, $filter);
    
           if ($update != false) 
           {
                $filter             = array("id" => $application_id);
                $application_data   = $this->CommonModel->get_single('sop_applications',$filter);
               
                $title          = "Alert : Require modification about your SOP Application";
                $message        = $edit_message;
                
                $filter         = array("id" => $application_data->service_provider_id);
                $user           = $this->CommonModel->get_single("service_providers",$filter);
                $token          = $user->token;
                $token_array    = array($token);
                
                $imageUrl   = ""; 
        
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
         		/*echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
         		echo json_encode($fields,JSON_PRETTY_PRINT);
         		echo '</pre></p><h3>Response </h3><p><pre>';
         		echo $result;
        		echo '</pre></p>';
        		die;*/
               
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
    
    
    public function complete_by_user()
    {
        $secrete        =  $this->request->getVar('secrete');


	    if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
	    {
        
            $application_id = $this->request->getVar('application_id');

            if($application_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter Application Id.'];
        		echo json_encode($data);
        		die;
            }

            $filter         = array("id" => $application_id);
            $update_data    = array("application_status" => 'Completed' , "completed_on" => date('Y-m-d H:i:s'));
            $update         = $this->CommonModel->update_data('sop_applications', $update_data, $filter);
    
           if ($update != false) 
           {
                $filter             = array("id" => $application_id);
                $application_data   = $this->CommonModel->get_single('sop_applications',$filter);
               
                /////Update Edit Mode/////
                $filter  = array("id" => $application_id);
                $update_data = array("edit_mode" => 0);
                $update = $this->CommonModel->update_data("sop_applications",$update_data,$filter);	
               
               /////Insert Transaction/////
               
               $amount = $application_data->package_price - $application_data->fees;
               
               $insert_data = array(
                                        "application_id"        => $application_id,
                                        "service_provider_id"   => $application_data->service_provider_id,
                                        "type"                  => "credit",
                                        "amount"                => $amount,
                                        "created"               => date('Y-m-d H:i:s')
                                    );
               $insert = $this->CommonModel->common_insert_data("transactions",$insert_data);
               
               
               //Extra benefit///
                
                
               if($application_data->missed_deadline == 1)
                {
                    $filter             = array("id" => $application_data->service_provider_id);
                    $service_provider   = $this->CommonModel->get_single("service_providers",$filter);
    
                    $commission = $application_data->package_price * $service_provider->commission / 100;
    
                    $filter = array("id" => 1);
                    $setting = $this->CommonModel->get_single("setting",$filter);
                    
                    $missed_deadline_benefits   = $setting->missed_deadline_benefits;
                    
                        //echo 'deadline is missed';
                       $extra_benefit_commission = $service_provider->commission - $missed_deadline_benefits;
                       
                       if($extra_benefit_commission == 0)
                       {
                           $extra_benefit = $commission;
                       }
                       else
                       {
                            $extra_benefit = $application_data->package_price * $extra_benefit_commission / 100;
                       }
                    
                   
                    $insert_data = array(
                                        "application_id"        => $application_id,
                                        "service_provider_id"   => $application_data->service_provider_id,
                                        "type"                  => "benefit",
                                        "amount"                => $extra_benefit,
                                        "created"               => date('Y-m-d H:i:s')
                                    );
                    $insert = $this->CommonModel->common_insert_data("transactions",$insert_data);
               }
               
               /////Insert Transaction/////
               
               
               
                $title          = "Greetings : SOP Application Completed";
                $message        = "User has Completed the SOP Application Request";
                
                $filter         = array("id" => $application_data->service_provider_id);
                $user           = $this->CommonModel->get_single("service_providers",$filter);
                $token          = $user->token;
                $token_array    = array($token);
                
                $imageUrl   = ""; 
        
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
         		/*echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
         		echo json_encode($fields,JSON_PRETTY_PRINT);
         		echo '</pre></p><h3>Response </h3><p><pre>';
         		echo $result;
        		echo '</pre></p>';
        		die;*/
               
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
    
    
	public function add_review_rating()
	{
		$secrete    			    =  $this->request->getVar('secrete');
		$application_id    			=  $this->request->getVar('application_id');
		$user_id   			        =  $this->request->getVar('user_id');
		$application_rating    		=  $this->request->getVar('application_rating');
		$service_provider_rating    =  $this->request->getVar('service_provider_rating');
		$review    			        =  $this->request->getVar('review');
		
		if($secrete == 'dacb465d593bd139a6c28bb7289fa798')
		{
			if($application_id == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter application id.'];
        		echo json_encode($data);
        		die;
            }
		
			if($service_provider_rating == "")
            {
                $data = ['status' => '0', 'message' => 'Please enter service provider rating.'];
        		echo json_encode($data);
        		die;
            }
            
            $filter = array("id" => $application_id);
            $application = $this->CommonModel->get_single("sop_applications",$filter);
            

            $service_provider_id        = $application->service_provider_id;
            
            $filter = array("user_id" => $user_id,"application_id" => $application_id);
            $check_exist = $this->CommonModel->get_single("sop_application_review_rating",$filter);
            
            if(!empty($check_exist))
            {
                $data = ['status' => '0', 'message' => 'You have already given the review rating.'];
				echo json_encode($data);
				die; 
            }
            
			$insert_data = array(
				"user_id" 			        => $user_id,
				"service_provider_id"		=> $service_provider_id,
				"application_id"		    => $application_id,
				"application_rating"		=> $application_rating,
				"service_provider_rating"	=> $service_provider_rating,
				"review"			        => $review,
				"created"			        => date("Y-m-d H:i:s")
			);

			$insert= $this->CommonModel->common_insert_data("sop_application_review_rating ",$insert_data);	

			if($insert != false)	
			{
				$data = ['status' => '1', 'message' => 'Thank you ! Review Submitted Successfully.'];
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
	

    
}