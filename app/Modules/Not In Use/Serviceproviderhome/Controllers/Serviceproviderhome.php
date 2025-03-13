<?php

namespace App\Modules\Serviceproviderhome\Controllers;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Modules\Serviceproviderhome\Models\AdminModel;

class Serviceproviderhome extends BaseController
{

    public function __construct()
    {
        $this->CommonModel = new CommonModel;
        
        $session = session()->get('service_provider_session');
        if($session == "")
        {
            header('location:/service_provider_login');
            exit();
        }
        
    }

    public function index()
    {
        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);
        $data['page_title']     = "Service Provider - Dashboard";
        $data['page_headline']  = "Service Provider - Dashboard";
        
        $session = session()->get('service_provider_session');
        $data['service_provider_id'] = $session['id'];

        $data['panel'] = 'service_provider';

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Serviceproviderhome\Views\service_provider_sidebar', $data);
        echo view('App\Modules\Serviceproviderhome\Views\service_provider_index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }
    
    public function profile()
    {
        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);
        $data['page_title']     = "Service Provider - Profile";
        $data['page_headline']  = "Service Provider - Profile";
        
        $session = session()->get('service_provider_session');
        $data['service_provider_id'] = $session['id'];

        $data['panel'] = 'service_provider';
        
        $filter = array("id" => $session['id']);
        $data['service_provider'] = $this->CommonModel->get_single("service_providers",$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Serviceproviderhome\Views\service_provider_sidebar', $data);
        echo view('App\Modules\Serviceproviderhome\Views\profile', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }
    
    public function update_profile()
    {
        $id  =  $this->request->getVar('id');  
        $name  =  $this->request->getVar('name');  
        $email  =  $this->request->getVar('email');  
    
        $filter = array("id" => $id);
        $update_data = array("name" => $name, "email" => $email);
        $update = $this->CommonModel->update_data("service_providers",$update_data,$filter);
        
        if($update != false)
        {
            $val = ['status' => '1','message' => 'Profile Updated Successfully' ];
            echo json_encode($val);
            die;
        }
        else
        {
            $val = ['status' => '0','message' => 'Something went wrong' ];
            echo json_encode($val);
            die;
        }
        
    }
    
    public function update_service_provider_token()
    {
        $token  =  $this->request->getVar('token');
        
        $session = session()->get('service_provider_session');
        $service_provider_id = $session['id'];
        
        $update_data = array("web_token" => $token);
        $filter = array("id"=> $service_provider_id);
        $update = $this->CommonModel->update_data("service_providers",$update_data,$filter);
        
        if($update != false)
        {
            $val = ['status'        => '1','message'      => 'Token updated' ];
            echo json_encode($val);
            die;
        }
        else
        { 
            $val = ['status'        => '1','message'      => 'somthing went wrong' ];
            echo json_encode($val);
            die;
        }
    }
    
    public function get_service_provider_inquiries()
    {
        $session = session()->get('service_provider_session');
        $filter = array("service_provider_id" => $session['id'],"status" => 1);
        $inquiry = $this->CommonModel->get_by_condition("service_provider_application_notifications",$filter);

        $data_array = array();
        
        $result_html = '';
        
        if(!empty($inquiry))
        {
            
            $filter             = array("id" => $session['id']);
            $service_provider   = $this->CommonModel->get_single("service_providers",$filter);
                                    
            
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

                $result_html .= '<div class="d-flex flex-row comment-row m-t-0">
                                    <div class="p-2">
                                        <div class="m-r-10">
                                            <span class="btn btn-circle btn-lg bg-danger">
                                                <i class="ti-clipboard text-white"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="comment-text w-100">
                                        <h6 class="font-medium">'.$service_details->name ." / ". $country_details->name ." / ". $package_details->name.'</h6>
                                        
                                        <span class="m-b-15 d-block">'.$row->message.'</span>
                                        
                                        <span class="m-b-15 d-block font-bold">Package Price : '.$package_details->price.'</span>
                                        
                                        <span class="m-b-15 d-block text-danger font-bold">- Fees/Charge('.$service_provider->commission.'%) : '.$commission.'</span>
                                        
                                        <span class="m-b-15 d-block text-success font-bold">+ Extra For Urgent('.$service_provider->commission.'%) : '.$extra_benefit.'</span>
                                        
                                        <b><span class="m-b-15 d-block text-primary font-bold">You Recieved    : '.$final_price.' </span></b>
                                        
                                        <div class="comment-footer">
                                            <span class="text-muted float-right">'.$row->created.'</span>
                                            <a href="javascript:void(0)" data-id="'.$row->application_id.'" class="sop_application_request_accpet"><span class="label label-rounded label-primary " >Accept</span></a>
                                            <a href="javascript:void(0)" data-id="'.$row->application_id.'" class="sop_application_request_reject"><span class="label label-rounded label-danger " >Reject</span></a>
                                           
                                        </div>
                                    </div>
                                </div>';
            }
            
           

            $val = ['status' => '1','service_provider_inquiry' => $result_html ];
            echo json_encode($val);
            die;
        } 
        else 
        {
            $data = ['status' => '0','message' => 'No new inquiry found.'];
            echo json_encode($data);
            die;
        }
    }
    
    public function accept_sop_application()
    {
        $session = session()->get('service_provider_session');

        $service_provider_id  = $session['id'];
        
        $application_id  =  $this->request->getVar('application_id');
        
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
            $filter = array("application_id" => $application_id);
            $update_data = array("status" => 0, "Action" => "Accepted");
            $update = $this->CommonModel->update_data("service_provider_application_notifications",$update_data,$filter);
            
            
            $filter = array("id" => $application_id);
            $application = $this->CommonModel->get_single('sop_applications', $filter);


            ////////////////  Get Package  ///////////////////////
            $filter = array("id" => $application->package_id);
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
            $filter = array("id" => $application->package_id);
    	    $package = $this->CommonModel->get_single("sop_packages",$filter);
    	    $package_hours = substr($package->name, 0, 2);
    	    
    	    $filter = array("id" => 1);
    	    $settings = $this->CommonModel->get_single("setting",$filter);
    	    
    	    if($application->missed_deadline == 0)
    	    {
        	    if($package_hours == 24)
        	    {
        	        $hours = $settings->hours_24; 
                    $deadline = $application->deadline;
                    $service_provider_deadline = date('Y-m-d H:i:s', strtotime($deadline. ' - '.$hours.' hours')); 
        	    }
        	    else if($package_hours == 48)
        	    {
        	        $hours = $settings->hours_48;
        	        $deadline = $application->deadline;
                    $service_provider_deadline = date('Y-m-d H:i:s', strtotime($deadline. ' - '.$hours.' hours')); 
        	    }
        	    else if($package_hours == 72)
        	    {
        	        $hours = $settings->hours_72;
        	        $deadline = $application->deadline;
                    $service_provider_deadline = date('Y-m-d H:i:s', strtotime($deadline. ' - '.$hours.' hours')); 
        	    }
    	    }
    	    else
    	    {
    	        $service_provider_deadline = $application->deadline;
    	    }
            /////////////////
            
            $filter = array("id" => $application_id);
            $update_data = array("application_status" => 'Service Provider Assigned', "commission_rate" => $commission_rate, "fees" => $commission, 'service_provider_deadline' => $service_provider_deadline);
            $update = $this->CommonModel->update_data('sop_applications', $update_data, $filter);
            
            $data = ['status' => '1', 'message' => 'Updated Successfully.'];
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
    
    public function reject_sop_application()
    {
        $session = session()->get('service_provider_session');

        $service_provider_id  = $session['id'];
        
        $application_id  =  $this->request->getVar('application_id');
        
        $filter = array("application_id" => $application_id,"service_provider_id" => $service_provider_id);
        $update_data = array("status" => 0, "Action" => "Rejected");
        $update = $this->CommonModel->update_data("service_provider_application_notifications",$update_data,$filter);
        
        if($update != false)
        {
            $data = ['status' => '1', 'message' => 'Updated Successfully.'];
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

    public function get_service_provider_notifications()
    {

        $query              = "SELECT * FROM service_provider_notifications order by id desc limit 30";
        $exist = $this->CommonModel->custome_query($query);

        $data_array = array();
        
        $result_html = '';
        
        if(!empty($exist))
        {
            foreach ($exist as $row) 
            {
            $orgDate        = $row->created;  
                $result_html .= '<a href="javascript:void(0)" class="message-item">
                                    
                                    <div class="mail-contnet">
                                        <h5 class="message-title">'.$row->title.'</h5>
                                        <span class="mail-desc">'.$row->message.'</span>
                                        <span class="time">'.date("d-M-y h:i A", strtotime($orgDate)).'</span>
                                    </div>
                                </a>';
            }

            $val = ['status'        => '1','notifications'      => $result_html ];
            echo json_encode($val);
            die;
        } 
        else 
        {
            $data = ['status' => '0', 'query'         =>  $query, 'message' => 'No new notification found.'];
            echo json_encode($data);
            die;
        }
        
    }

}