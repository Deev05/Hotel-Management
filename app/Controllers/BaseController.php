<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\CommonModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [
        'basic',
        'form',
        'url',
        'cookie',
        'module'
    ];

    /**
     * Constructor.
     */

    

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->session = \Config\Services::session();
        // E.g.: $this->session = \Config\Services::session();
    }

    public function permissionCheckNormal($key)
    {

        $session = session()->get('mySession');

        
        $filter = array("role_id" => $session['role'], "permission" => $key);
        $has_permission = $this->CommonModel->get_single("role_permissions",$filter);

        if(!empty($has_permission))
        {
           
        }
        else
        {
            $this->response->redirect('errors/denied');
        }
            
    }

    public function permissionCheck($key)
    {
      
        $session = session()->get('mySession');

        $role_id = $session['role'];

        $query = "SELECT * FROM role_permissions WHERE role_id = $role_id and permission like '%$key%' ";
        $has_permission = $this->CommonModel->custome_query_single_record($query);

 
        if(!empty($has_permission))
        {
            $message = ['status' => '1', 'message' => 'Permission Granted!'];
            return json_encode($message);
        }
        else
        {
            $message = ['status' => '0', 'message' => 'Permission Denied!'];
            return json_encode($message);
            die;
        }
            
    }


    public function addActivityLog($title)
    {
        $session = session()->get('mySession');
        $user_id = $session['id'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $insert_data = array("title" => $title,"user" => $user_id ,"created" => date('Y-m-d H:i:s'),"ip_address" => $ip_address);
        $insert = $this->CommonModel->common_insert_data("activity_logs",$insert_data);
    }
}
