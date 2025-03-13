<?php 
namespace App\Modules\Admin\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    var $table = 'notification_images';

    public function __construct()
    {
        parent::__construct();
        $db = \Config\Database::connect();
    }

    public function get_all()
    {
        $query = $this->db->query('select * from notification_images');
        return $query->getResult();
    }



    public function getUsers()
    {
        // Write your function here to perform database operation
        return $data['users'] = array(array('name'=> 'Steve'),array('name'=> 'John'),array('name'=> 'Amanda')); 
        
    }
}