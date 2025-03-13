<?php 
namespace App\Modules\Products\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Products extends BaseController {
    protected $CommonModel;
    protected $table; 
    private $db;
    public function __construct()
    {
        $this->db = db_connect();
     	$this->CommonModel = new CommonModel();
        $this->table = "products";
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

        $this->permissionCheckNormal('product_list','normal');

        $data['page_title']     = 'Products';
        $data['page_headline']  = 'Products';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Products\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function stock_logs()
    {

        $this->permissionCheckNormal('product_list','normal');

        $data['page_title']     = 'Stock Logs';
        $data['page_headline']  = 'Stock Logs';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);
        
        $data['product_id'] = $this->request->uri->getSegment(3);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Products\Views\stock_logs', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_products()
    {
        $where = '';
        $where .= " WHERE is_deleted = 0";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( product_name LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( product_code LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( product_price LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            $where .= " or ( product_sell_price LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT * FROM products $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'product_name',
            3 => 'product_image',
            4 => 'product_price',
            5 => 'product_sell_price',
            6 => 'product_sell_price',
            7 => 'main_stock',
            8 => 'created',
            9 => 'action',
        );

        $sql = "SELECT *";
        $sql .= " FROM products $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $data['no']                     = ++$count;
            $data['id']                     = $row->id;
            $data['product_name']           = $row->product_name;
            $data['product_price']          = $row->product_price;
            $data['product_sell_price']     = $row->product_sell_price;
            $data['product_image']          = $row->product_image;
            $data['main_stock']          = $row->main_stock;
            $data['created']                = $row->created;


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
    
    public function get_stock_logs()
    {
        
        $product_id = $this->request->uri->getSegment(3);
       
        $where = '';
        $where .= " WHERE product_id = $product_id ";

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( name LIKE '%" . $_REQUEST['search']['value'] . "%' ";
        }

        $totalRecordsSql = "SELECT * FROM stock_logs $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'description',
            3 => 'type',
            4 => 'warehouse_id',
            5 => 'quantity',
            6 => 'created',

        );

        $sql = "SELECT *";
        $sql .= " FROM stock_logs $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);
  

        $data_array = array();
        $count      = 0;
        
        foreach ($result as  $row) 
        {
            $filter = array("id" => $row->warehouse_id);
            $warehouse = $this->CommonModel->get_single("warehouse",$filter);
            
            $data['no']                     = ++$count;
            $data['id']                     = $row->id;
            $data['description']            = $row->description;
            $data['type']                   = $row->type;
            $data['warehouse_id']              = $warehouse->name;
            $data['quantity']               = $row->quantity;
            $data['created']                = $row->created;


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
    
    public function add_product()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_product');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////


        $category_id            = $this->request->getVar('category_id');
        $product_name           = $this->request->getVar('product_name');
        $hsn_code               = $this->request->getVar('hsn_code');
        $product_code           = $this->request->getVar('product_code');
        $unit_id                = $this->request->getVar('unit_id');
        $unit_value                = $this->request->getVar('unit_value');
        $product_price          = $this->request->getVar('product_price');
        $product_sell_price     = $this->request->getVar('product_sell_price');
        $tax_id                 = $this->request->getVar('tax_id');
        $quantity_alert         = $this->request->getVar('quantity_alert');
        $product_image          = $this->request->getVar('product_image');
        $description            = $this->request->getVar('description');
        $suppliers              = $this->request->getVar('suppliers');
        $tags                   = $this->request->getVar('tags');
        $is_popular             = $this->request->getVar('is_popular');

        $created = date("Y-m-d H:i:s");

        //Image Upload//
        $tmp = explode(".",$_FILES["product_image"]["name"]);
        $file_extension = end($tmp);
        $newfilename = time() . '_' . rand(100, 999) . '.' . $file_extension;
        
       
        $file_name = $newfilename;
        $file_path = $_FILES['product_image']['tmp_name'];
        $file_error = $_FILES['product_image']['error'];

        $file_destination ='uploads/products/'.$file_name;
        move_uploaded_file($file_path, $file_destination);

        $product_image = $newfilename;
        //Image Upload//

        //Multiple Suppliers Separated By Comma
        if(!empty($suppliers))
        {
            $suppliers = implode(',', $suppliers);
        }
        else
        {
            $suppliers = "";
        }
        
        //Checkbox Value
        if($is_popular == "")
        {
            $is_popular = 0;
        }
        
        $insert_data = array(
                                "category_id"           => $category_id,
                                "product_name"          => $product_name,
                                "hsn_code"              => $hsn_code,
                                "product_code"          => $product_code,
                                "unit_id"               => $unit_id,
                                "unit_value"               => $unit_value,
                                "product_price"         => $product_price,
                                "product_sell_price"    => $product_sell_price,
                                "tax_id"                => $tax_id,
                                "quantity_alert"        => $quantity_alert,
                                "product_image"         => $product_image,
                                "description"           => $description,
                                "suppliers"             => $suppliers,
                                "tags"                  => $tags,
                                "is_popular"            => $is_popular,
                                "created"               => $created,
                                "linked_id"             => 0,
                            );

        //Comma separated String To Array               
        // $myArray = explode(',', $List);
        // print_r($myArray);

        $product_insert = $this->CommonModel->common_insert_data('products', $insert_data);
        
        if($product_insert != false)
        {
            $activity_title = "Product Added " . $product_name;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'New Product has been added!'];
            return json_encode($message);
        }
        else
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
    }
    
    
    public function duplicate_product()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('add_product');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////


        $copy_product_id            = $this->request->getVar('copy_product_id');
        $filter = array("id"=> $copy_product_id);
        $copy_product_data = $this->CommonModel->get_single("products",$filter);
        
        
        $category_id            = $copy_product_data->category_id;
        $hsn_code               = $copy_product_data->hsn_code;
        $product_name           = $this->request->getVar('copy_product_name');
        $product_code           = rand(100000,900000);
        $unit_id                = $this->request->getVar('copy_unit_id');
        $unit_value             = $this->request->getVar('copy_unit_value');
        $product_price          = $this->request->getVar('copy_product_price');
        $product_sell_price     = $this->request->getVar('copy_product_sell_price');
        $tax_id                 = $copy_product_data->tax_id;
        $quantity_alert         = $copy_product_data->quantity_alert;
        $product_image          = $copy_product_data->product_image;
        $description            = $copy_product_data->description;
        $suppliers              = $copy_product_data->suppliers;
        $tags                   = $copy_product_data->tags;
        $is_popular             = $this->request->getVar('copy_is_popular');

        $created = date("Y-m-d H:i:s");
        
        //Checkbox Value
        if($is_popular == "")
        {
            $is_popular = 0;
        }
        
        $insert_data = array(
                                "category_id"           => $category_id,
                                "product_name"          => $product_name,
                                "hsn_code"              => $hsn_code,
                                "product_code"          => $product_code,
                                "unit_id"               => $unit_id,
                                "unit_value"               => $unit_value,
                                "product_price"         => $product_price,
                                "product_sell_price"    => $product_sell_price,
                                "tax_id"                => $tax_id,
                                "quantity_alert"        => $quantity_alert,
                                "product_image"         => $product_image,
                                "description"           => $description,
                                "suppliers"             => $suppliers,
                                "tags"                  => $tags,
                                "is_popular"            => $is_popular,
                                "created"               => $created,
                                "linked_id"             => $copy_product_id,
                            );

        $product_insert = $this->CommonModel->common_insert_data('products', $insert_data);
        
        if($product_insert != false)
        {
            $activity_title = "Product Added " . $product_name;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Product has been copied successfully!'];
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
        $check = $this->permissionCheck('delete_product');
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

            $activity_title = "Product Deleted " . $id;
            $this->addActivityLog($activity_title);

            $message = ['status' => '1', 'message' => 'Product has been deleted!'];
            return json_encode($message);
        } 
        else 
        {
            $message = ['status' => '0', 'message' => 'Something went wrong!'];
            return json_encode($message);
        }
        

    }


    
    
    public function update_product()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('update_product');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id                     = $this->request->getVar('product_id');
        $product_name           = $this->request->getVar('product_name');
        $hsn_code               = $this->request->getVar('hsn_code');
        $unit_id                = $this->request->getVar('unit_id');
        $unit_value                = $this->request->getVar('unit_value');
        $product_price          = $this->request->getVar('product_price');
        $product_sell_price     = $this->request->getVar('product_sell_price');
        $tax_id                 = $this->request->getVar('tax_id');
        $quantity_alert         = $this->request->getVar('quantity_alert');
        $product_image          = $this->request->getVar('product_image');
        $description            = $this->request->getVar('description');
        $suppliers              = $this->request->getVar('suppliers');
        $tags                   = $this->request->getVar('tags');
        $is_popular             = $this->request->getVar('is_popular');
        $created                = date("Y-m-d H:i:s");

        if($is_popular == "")
        {
            $is_popular = 0;
        }
   
    
   
    
    
        //Image Upload//
        if (empty($_FILES["product_image"]["name"]))
        {
            $filter                 = array("id" => $id);
            $query                  = $this->CommonModel->get_single($this->table, $filter);
            $product_image  = $query->product_image;
        }
        else
        {
           

            $tmp = explode(".",$_FILES["product_image"]["name"]);
            $file_extension = end($tmp);
            $newfilename = time() . '_' . rand(100, 999) . '.' . $file_extension;
            
        
            $file_name = $newfilename;
            $file_path = $_FILES['product_image']['tmp_name'];
            $file_error = $_FILES['product_image']['error'];

            $file_destination ='uploads/products/'.$file_name;
            move_uploaded_file($file_path, $file_destination);

            $product_image = $newfilename;

        }
        //Image Upload//

        //Multiple Suppliers Separated By Comma
        if(!empty($suppliers))
        {
            $suppliers = implode(',', $suppliers);
        }
        else
        {
            $suppliers = "";
        }

        // print_r($id);
        // print_r($product_name);
        // print_r($unit_id);
        // print_r($product_price);
        // print_r($product_sell_price);
        // print_r($tax_id);
        // print_r($quantity_alert);
        // print_r($product_image);
        // print_r($description);
        // print_r($suppliers);
        // print_r($tags);
        // die;
   
        $filter = array("id" => $id);
        $update_data = array(
                                "product_name"          => $product_name,
                                "hsn_code"              => $hsn_code,
                                "unit_id"               => $unit_id,
                                "unit_value"            => $unit_value,
                                "product_price"         => $product_price,
                                "product_sell_price"    => $product_sell_price,
                                "tax_id"                => $tax_id,
                                "quantity_alert"        => $quantity_alert,
                                "product_image"         => $product_image,
                                "description"           => $description,
                                "suppliers"             => $suppliers,
                                "tags"                  => $tags,
                                "is_popular"            => $is_popular,
                            );
        $update = $this->CommonModel->update_data("products", $update_data, $filter);

        if ($update != false) 
        {
            $activity_title = "Product Updated " . $id;
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


    }

    


    public function edit_product()
    {
        $this->permissionCheckNormal('product_list','normal');

        $data['page_title']     = 'Products';
        $data['page_headline']  = 'Products';

        $filter                 = array( 'id' => 1 );
        $data['setting']        = $this->CommonModel->get_single('setting',$filter);

        $product_id = $this->request->uri->getSegment(3);

        $data['product_id'] = $product_id;

        $filter = array("id" => $product_id);
        $data['product_details'] = $this->CommonModel->get_single("products",$filter);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Products\Views\edit_product', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
    }
    
    public function get_details_for_view()
    {
        $id = $this->request->getVar('id');

        $result_html = '';

        $filter         = array("id" => $id);
        $product_details   = $this->CommonModel->get_single('products',$filter);

        $filter         = array("id" => $product_details->category_id);
        $category_details   = $this->CommonModel->get_single('categories',$filter);

        $filter         = array("id" => $product_details->unit_id);
        $unit_details   = $this->CommonModel->get_single('units',$filter);

        $filter         = array("id" => $product_details->tax_id);
        $tax_details   = $this->CommonModel->get_single('tax_rates',$filter);
        
        $filter = array("is_deleted" => 0);
        $warehouse = $this->CommonModel->get_by_condition('warehouse',$filter);

        $available_qty = array();
        foreach($warehouse as $row)
        {
            $add_query = "SELECT sum(quantity) as total_sum FROM stock_logs WHERE warehouse_id = $row->id and product_id = $id and type='Add'";
            $total_add = $this->CommonModel->custome_query_single_record($add_query);

            $sub_query = "SELECT sum(quantity) as total_sum FROM stock_logs WHERE warehouse_id = $row->id and product_id = $id and type='Sub'";
            $total_sub = $this->CommonModel->custome_query_single_record($sub_query);

            $available_quantity = $total_add->total_sum -  $total_sub->total_sum;

            

            $data['warehouse_name']         = $row->name;
            $data['available_quantity']     = $available_quantity;

            array_push($available_qty,$data);

        }


        // $all_role_permission  = $this->CommonModel->get_all_data('permissions');


        $result_html .= '

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <!-- Your Content Here-->
                                                
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h3 class="box-title">General Info</h3>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Product Name</td>
                                                                    <td> '.$product_details->product_name.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Product Code</td>
                                                                    <td> '.$product_details->product_code.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Category</td>
                                                                    <td> '.$category_details->name.' </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td>Price</td>
                                                                    <td> '.$product_details->product_price.'</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Sell Price</td>
                                                                    <td> '.$product_details->product_sell_price.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Unit</td>
                                                                    <td> '.$unit_details->name.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Sell Per Unit Value</td>
                                                                    <td> '.$product_details->unit_value.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tax Rate</td>
                                                                    <td> '.$tax_details->name.' </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Alert Quantity</td>
                                                                    <td> '.$product_details->quantity_alert.' </td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">
                                                <!-- Your Content Here-->
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    
                                                    
                                                    <div class="text-center">
                                                        <img class="img img-responsive" width="200" height="200" src="'.base_url().'uploads/products/'.$product_details->product_image.'">
                                                    </div>

                                                    <br/>
                                                    <h3 class="box-title">Stock Info</h3>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <th>Warehouse</th>
                                                                <th>Available Quantity</th>
                                                            </thead>
                                                            <tbody>';
                                                      
                                                            if(!empty($available_qty))
                                                            {
                                                                foreach($available_qty as $row)
                                                                {
                                                                    
                                                                    $result_html .='
                                                                    <tr>
                                                                        <td> '.$row['warehouse_name'].' </td>
                                                                        <td> '.$row['available_quantity'].' </td>
                                                                    </tr>   ';
                                                                }
                                                            }
                                                                
                                                $result_html .='</tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                ';
            
            $val = ['status' => '1','product_details_in_model' => $result_html ,'message' => 'Success'];
            echo json_encode($val);
            die;
    }
    
    public function get_product_price()
    {
        $id = $this->request->getVar('id');

        $result_html = '';

        $filter         = array("id" => $id);
        $product_details   = $this->CommonModel->get_single('products',$filter);
        
        $val = ['status' => '1', 'product_id' => $product_details->id ,'product_price' => $product_details->product_price , 'product_sell_price' => $product_details->product_sell_price, 'message' => 'Success'];
        echo json_encode($val);
        die;


    }
    
    
    public function get_product_details_for_copy()
    {
        $id = $this->request->getVar('id');

        $filter         = array("id" => $id);
        $product_details   = $this->CommonModel->get_single('products',$filter);
        
        $val = [
                    'status' => '1', 
                    'product_id' => $product_details->id ,
                    'product_price' => $product_details->product_price , 
                    'product_sell_price' => $product_details->product_sell_price, 
                    'message' => 'Success'
                ];
        echo json_encode($val);
        die;
    }
    
    public function update_price()
    {

        ////////////////////////Check Permission/////////////////
        $check = $this->permissionCheck('update_product');
        $check_resp = json_decode($check);
        $status = $check_resp->status;
        if($status == 0)
        {
            $message = ['status' => '0', 'message' => 'Permission Deined!'];
            return json_encode($message);
            die;
        }
        ////////////////////////Check Permission/////////////////

        $id                     = $this->request->getVar('edit_price_product_id');
        $edit_product_price           = $this->request->getVar('edit_product_price');
        $edit_product_sell_price                = $this->request->getVar('edit_product_sell_price');
        

   
        $filter = array("id" => $id);
        $update_data = array(
                                "product_price"          => $edit_product_price,
                                "product_sell_price"               => $edit_product_sell_price,
                            );
        $update = $this->CommonModel->update_data("products", $update_data, $filter);

        if ($update != false) 
        {
            $activity_title = "Product Updated " . $id;
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
    
    public function import_products()
    {
      
        if($file = $this->request->getFile('file')) 
        {
            if ($file->isValid() && ! $file->hasMoved()) 
            {
               
                $newName    = $file->getRandomName();
                
                $file->move('./uploads/import', $newName);
                
                $file = fopen("./uploads/import/".$newName,"r");
                
              
                $i = 0;
                
                $numberOfFields = 15;
                
                $csvArr = array();
                
   

                $data_array = array();
                while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) 
                {
 
                    $num = count($filedata);
                    if($i >= 0 && $num == $numberOfFields)
                    { 
                        
                        $filter = array("name" => $filedata[0]);
                        $category = $this->CommonModel->get_single("categories",$filter);
                        
                        $filter = array("name" => $filedata[7]);
                        $unit = $this->CommonModel->get_single("units",$filter);
                        if(!empty($unit))
                        {
                            $unit_id = $unit->id;
                        }
                        else
                        {
                             $unit_id = $filedata[7];
                        }
                        
                        
                        $filter = array("name" => $filedata[8]);
                        $tax = $this->CommonModel->get_single("tax_rates",$filter);
                        if(!empty($tax))
                        {
                            $tax_id = $tax->id;
                        }
                        else
                        {
                             $tax_id = $filedata[7];
                        }
                        
                        $myArray = explode(',', $filedata[5]);
                 
                        $count =  count($myArray);
                        if($count>1)
                        {
                            $supplier_array = array();
                            for($i =0; $i<$count;$i++)
                            {
                                $supplier_name = $myArray[$i];
                                
                                $filter = array("name" => $supplier_name);
                                $supplier = $this->CommonModel->get_single("suppliers",$filter);
                                
                                
                                $supplier_ids = $supplier->id;
                                
                                array_push($supplier_array,$supplier_ids);
                            }
                      
                            $supplier_id = implode(',', $supplier_array);
                            
                        }
                        else
                        {
                            $filter = array("name" => $supplier_name);
                            $supplier = $this->CommonModel->get_single("suppliers",$filter);
                            
                            $supplier_id = $supplier->id;
                        }
                        
                        
                        
                        $csvArr['category']             = $category->id;
                        $csvArr['product_name']         = $filedata[1];
                        $csvArr['product_price']        = $filedata[2];
                        $csvArr['product_sell_price']   = $filedata[3];
                        $csvArr['suppliers']            = $supplier_id;
                        $csvArr['product_code']         = $filedata[5];
                        $csvArr['unit_id']              = $unit_id;
                        $csvArr['tax_id']               = $tax_id;
                        $csvArr['quantity_alert']       = $filedata[8];
                        $csvArr['product_image']        = $filedata[9];
                        $csvArr['description']          = $filedata[10];
                        $csvArr['tags']                 = $filedata[11];
                        $csvArr['is_popular']           = $filedata[12];
                        
                        array_push($data_array,$csvArr);
                    }
                    $i++;
                }
                fclose($file);
                $count = 0;
                

                
                foreach($data_array as $row)
                {
                  
                    
                    $filter = array("product_name" => $row['product_name']);
                    $findRecord = $this->CommonModel->get_single("products",$filter);
                    
                    if(!empty($findRecord))
                    {
                        echo "hii";
                    }
                    else
                    {
                        $insert_data = array(
                                                'category_id'            => $row['category'], 
                                                'product_name'        => $row['product_name'], 
                                                'product_price'       => $row['product_price'], 
                                                'product_sell_price'  => $row['product_sell_price'],
                                                'suppliers'           => $row['suppliers'], 
                                                'product_code'        => $row['product_code'], 
                                                'unit_id'             => $row['unit_id'], 
                                                'tax_id'              => $row['tax_id'], 
                                                'quantity_alert'      => $row['quantity_alert'], 
                                                'product_image'       => $row['product_image'], 
                                                'description'         => $row['description'], 
                                                'tags'                => $row['tags'], 
                                                'is_popular'          => $row['is_popular'] 
                                            );
    
                        $insert = $this->CommonModel->common_insert_data("products",$insert_data);
                        if($insert != false)
                        {
                            $count++;
                        }
                    }
                }

                $val = ['status' => '1','message' => $count.' rows successfully added.'];
                echo json_encode($val);
                die;
            }
            else
            {
                $val = ['status' => '0','message' => 'Something Went Wrong.'];
                echo json_encode($val);
                die;
            }
        }
        else
        {
            $val = ['status' => '0','message' => 'Something Went Wrong.'];
            echo json_encode($val);
            die;
        }
        
        
    }
    
    public function upload_product_images()
    {
        $count = count($_FILES['product_image']['size']);
        // if (empty($_FILES['product_image']['name'])) 
        // {
        //     $val = ['status' => '0','message' => 'Please Select Images.'];
        //     echo json_encode($val);
        //     die; 
        // }
        // else
        // {
        //     $val = ['status' => '1','message' => 'All images are successfully added.'];
        //     echo json_encode($val);
        //     die;
        // }


        // // if($count-1 == 0)
        // // {
        // //     $val = ['status' => '0','message' => 'Please Select Images.'];
        // //     echo json_encode($val);
        // //     die;
        // // }
     
        foreach($_FILES as $key=>$value)
        for($s=0; $s <= $count-1; $s++)
        {
            

            $_FILES['product_image']['name']=   $value['name'][$s];
            $_FILES['product_image']['type']    = $value['type'][$s];
            $_FILES['product_image']['tmp_name'] = $value['tmp_name'][$s];
            $_FILES['product_image']['error']       = $value['error'][$s];
            $_FILES['product_image']['size']    = $value['size'][$s];

            
            $file_destination ='uploads/products/'.$_FILES['product_image']['name'];
            move_uploaded_file($_FILES['product_image']['tmp_name'], $file_destination);


        }
        
        $val = ['status' => '1','message' => 'All images are successfully added.'];
        echo json_encode($val);
        die;
    }


}