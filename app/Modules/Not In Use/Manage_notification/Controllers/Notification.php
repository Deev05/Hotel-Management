<?php
namespace App\Modules\Manage_notification\Controllers;
use App\Controllers\BaseController;

class Notification extends BaseController
{
	private $title;
	private $message;
	private $data;
	private $imageUrl;
	
	function __construct(){
         
	}
 
	public function setTitle($title){
		$this->title = $title;
	}
 
	public function setMessage($message){
		$this->message = $message;
	}
 

	public function setPayload($data){
		$this->data = $data;
	}
	
		 public function setImage($imageUrl) {
        $this->image = $imageUrl;
    }
	
	public function getNotificatin(){
		$notification = array();
		$notification['title'] = $this->title;
		$notification['message'] = $this->message;
		
		if($this->image != "")
		{
		    		$notification['image'] = $this->image;
		}
		

		return $notification;
	}
}
?>