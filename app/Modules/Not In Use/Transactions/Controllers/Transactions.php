<?php 
namespace App\Modules\Transactions\Controllers;
use App\Controllers\BaseController;
use App\Models\CommonModel;


class Transactions extends BaseController {

    public function __construct()
    {
     	$this->CommonModel = new CommonModel();
        $this->table = "transactions";
        
        $session = session()->get('mySession');
        if($session == "")
        {
            header('location:/admin_login');
            exit();
        }
	}

    // Index
    public function index()
    {

        $data['page_title'] = 'Transactions';
        $data['page_headline'] = 'Transactions';


        $filter = array( 'id' => 1 );
        $data['setting'] = $this->CommonModel->get_single('setting',$filter);
        
        $query                      = "SELECT * FROM service_providers WHERE  status = 1 and is_deleted = 0"; 
        $data['service_providers']  = $this->CommonModel->custome_query($query);

        echo view('App\Modules\Admin\Views\header', $data);
        echo view('App\Modules\Admin\Views\sidebar', $data);
        echo view('App\Modules\Transactions\Views\index', $data);
        echo view('App\Modules\Admin\Views\footer', $data);
		
    }
    
    public function get_data()
    {
       
        $service_provider_id = $this->request->getVar('service_provider_id');
        $type = $this->request->getVar('type');
        $filter_dates = $this->request->getVar('filter_dates');
        $startdate = "";
        $enddate = "";
       
       
        $where = '';
        $where .= " WHERE is_deleted = 0";
         ///////////SERVICE PROVIDER FILTER START
        if ($service_provider_id != "") {
            $where .= " AND service_provider_id = $service_provider_id ";
        }
        ///////////SERVICE PROVIDER FILTER ENDS
        
         /////////// TYPE FILTER START
        if ($type != "") {
            $where .= " AND type = '$type' ";
        }
        /////////// TYPE FILTER ENDS
        
        
        ///////////ORDER DATEWISE FILTER STARTS
        if (!empty($filter_dates)) {
            $split = explode('-', $filter_dates);

            #check make sure have 2 elements in array
            $count = count($split);
            if ($count <> 2) {
                #invalid data
            }

            $start = $split[0];

            $startdate = str_replace('/', '-', $start);
            $startdate = date('Y-m-d', strtotime($startdate));

            $end = $split[1];

            $enddate = str_replace('/', '-', $end);
            $enddate = date('Y-m-d', strtotime($enddate));


            if($service_provider_id == ""){

            }

            $where .= " AND (DATE(created) BETWEEN '$startdate' AND '$enddate') ";
        }
        ///////////ORDER DATEWISE FILTER ENDS
        

        if (!empty($_REQUEST['search']['value'])) {
            $where .= " And ( type LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            // $where .= " or ( contact LIKE '%" . $_REQUEST['search']['value'] . "%' )";
            // $where .= " or ( email LIKE '%" . $_REQUEST['search']['value'] . "%' )";
        }

        $totalRecordsSql = "SELECT * FROM transactions $where;";

        $res = $this->CommonModel->custome_query($totalRecordsSql);
        $totalRecords = count($res);
   
        $columns = array( 
            0 => 'id',
            1 => 'id',
            2 => 'applicant_no',
            3 => 'type',
            4 => 'amount',
            5 => 'created',
        );

        $sql = "SELECT *";
        $sql .= " FROM transactions $where";
        $sql .= " ORDER BY " . $columns[$_REQUEST['order'][0]['column']] . "   " . $_REQUEST['order'][0]['dir'] . "  LIMIT " . $_REQUEST['start'] . " ," . $_REQUEST['length'] . "   ";

        $result = $this->CommonModel->custome_query($sql);

        $data_array = array();
        $count      = 0;
        
        $total_credit   = 0;
        $total_penalty  = 0;
        $total_payable  = 0;
        
        foreach ($result as  $row) 
        {
            $filter = array("id" => $row->service_provider_id);
            $service_provider = $this->CommonModel->get_single("service_providers",$filter);
            $data['service_provider'] = $service_provider->name;
  
            if($row->application_id == 0)
            {
               $data['application_no'] = "" ; 
            }
            else
            {
                $filter = array("id" => $row->application_id);
                $application = $this->CommonModel->get_single("sop_applications",$filter);
                $data['application_no'] = $application->application_no;
            }
            
            
            
            $data['transaction_id'] = $row->transaction_id;
            $data['payment_mode'] = $row->payment_mode;

            $data['no']         = ++$count;
            $data['id']         = $row->id;
            $data['type']       = $row->type;
            
            if($row->type == "credit" || $row->type == "benefit")
            {
                $data['credit']     = $row->amount;
                $data['debit']      = "";
                
                if($row->payment_status == "unpaid")
                {
                    $total_credit       += $row->amount;
                }
                
            }
            else
            {
                $data['credit']     = "";
                $data['debit']      = $row->amount;  
            }
            
            if($row->type == "penalty")
            {
               
                if($row->payment_status == "unpaid")
                {
                    $total_penalty       += $row->amount; 
                }
            }
            
            $data['amount']     = $row->amount;
            $data['created']    = $row->created;
  
            array_push($data_array, $data);
            
            $total_payable = $total_credit - $total_penalty;
        }

        $json_data = array(
            "draw"            => intval($_REQUEST['draw']),
            "recordsTotal"    => intval($totalRecords),
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data_array,
            "total_credit"    => "$total_credit",
            "total_penalty"   => "$total_penalty",
            "total_payable"   => "$total_payable",
        );

        return json_encode($json_data);
    }
    
    
    public function get_payment_summary()
    {
        $dates                  = $this->request->getVar('filter_dates');
        $service_provider_id    = $this->request->getVar('service_provider_id');
        
        $split = explode('-', $dates);

        #check make sure have 2 elements in array
        $count = count($split);
        if ($count <> 2) {
            #invalid data
        }

        $start = $split[0];

        $startdate = str_replace('/', '-', $start);
        $startdate = date('Y-m-d', strtotime($startdate));

        $end = $split[1];

        $enddate = str_replace('/', '-', $end);
        $enddate = date('Y-m-d', strtotime($enddate));

        $filter = array("id" => $service_provider_id);
        $service_provider = $this->CommonModel->get_single("service_providers",$filter);

 
        ////////////////  Model  ///////////////////////
        $modal_title = 'Payment Summary of ' . $service_provider->name. ' Between '.$startdate. " And ".$enddate;
        

        // if($application->payment_status == 1)
        // {
        //     $payment_status = "Paid";
        //     $payment_desc = "label-primary";
        // }
        // else
        // {
        //     $payment_status = "Unpaid";
        //     $payment_desc = "label-danger";
        // }
        
        
        $summary_details = '<div class="row">';
       


        $query = "select * from transactions where service_provider_id = $service_provider_id and type <> 'deposite' and payment_status = 'unpaid' AND (DATE(created) BETWEEN '$startdate' AND '$enddate')";
        $transactions = $this->CommonModel->custome_query($query);
        
         $summary_details .= '<div class="col-12">
         
                                        <p class="text-danger">Note : Below transactions are unpaid</p>
                                        
                                        <div class="list-group" style="margin-bottom: 15px;">
                                            <table class="table table-bordered table-responsive-lg">
                                                <thead>
                                                    <th>No.</th>
                                                    <th>Application No.</th>
                                                    <th>Type</th>
                                                    <th>Credit</th>
                                                    <th>Debit</th>
                                                </thead>
                                                <tbody>
                                        ';
        $count          = 0;
        $total_credits  = 0;
        $total_penalty  = 0;
        $total_payable  = 0;
        
        
        foreach($transactions as $row)
        {
            $filter = array("id" => $row->application_id);
            $application = $this->CommonModel->get_single("sop_applications",$filter);
            $application_no = $application->application_no;
            
            $summary_details .= '<tr>';
            $summary_details .= '<td>'.++$count.'</td>';
            $summary_details .= '<td>'.$application_no.'</td>';
            $summary_details .= '<td>'.$row->type.'</td>';
            
            if($row->type == "credit" || $row->type == "benefit")
            {
                $summary_details .= '<td>'.$row->amount.'</td>';
                $summary_details .= '<td></td>';
                
                $total_credits += $row->amount;
            }
            else
            {
                $summary_details .= '<td></td>';
                $summary_details .= '<td>'.$row->amount.'</td>';
                
                $total_penalty += $row->amount;
            }
            
            $summary_details .= '</tr>';
        }
        
        
        
        $summary_details .=     '</thead>';
        $summary_details .=     '</table>';
        
        $summary_details .=     '</div>';
        $summary_details .= '</div>';
        
        $summary_details .= '<br>';
        $summary_details .= '</div>';
        
        $total_payable = $total_credits - $total_penalty;
        
        $summary_details .= '   <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card bg-info">
                                            <div class="d-flex flex-row">
                                                <div class="text-white align-self-center p-10">
                                                    <h3 class="m-b-0">'.$total_credits.'</h3>
                                                    <span>Total Credits</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card bg-danger">
                                            <div class="d-flex flex-row">
                                                <div class="text-white align-self-center p-10">
                                                    <h3 class="m-b-0">'.$total_penalty.'</h3>
                                                    <span>Total Penalty</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card bg-success">
                                            <div class="d-flex flex-row">
                                                <div class="text-white align-self-center p-10">
                                                    <h3 class="m-b-0">'.$total_payable.'</h3>
                                                    <span>Total Payable</span>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        ';

        $result_html = '';
        $count = 0;

        $message = ['status' => '1', 'message' => 'Data Fetched!', 'total_amount' => $total_payable, 'summary_details' => $summary_details, 'modal_title' => $modal_title];
        echo json_encode($message);
        die;
        return $this->response->setJSON($message);
    }
    
    public function make_payment()
    {
        $dates                  = $this->request->getVar('filter_dates');
        $service_provider_id    = $this->request->getVar('service_provider_id');
        $transaction_id         = $this->request->getVar('transaction_id');
        $payment_mode           = $this->request->getVar('payment_mode');
        $total_amount           = $this->request->getVar('total_amount');

        $split = explode('-', $dates);

        #check make sure have 2 elements in array
        $count = count($split);
        if ($count <> 2) {
            #invalid data
        }

        $start = $split[0];

        $startdate = str_replace('/', '-', $start);
        $startdate = date('Y-m-d', strtotime($startdate));

        $end = $split[1];

        $enddate = str_replace('/', '-', $end);
        $enddate = date('Y-m-d', strtotime($enddate));
        
        $insert_data = array(
                                "application_id"        => 0,
                                "service_provider_id"   => $service_provider_id,
                                "type"                  => "deposite",
                                "amount"                => $total_amount,
                                "transaction_id"        => $transaction_id,
                                "payment_status"        => "paid",
                                "payment_mode"          => $payment_mode,
                                "created"               => date("Y-m-d H:i:s"),
                                "remark"                => "Payment between $startdate and $enddate",
                            );

        $insert = $this->CommonModel->common_insert_data("transactions",$insert_data);
        

        if($insert != false)
        {
            $query = "update transactions set transaction_id = '$transaction_id', payment_status = 'paid', payment_mode = '$payment_mode' where service_provider_id = $service_provider_id and payment_status = 'unpaid' AND (DATE(created) BETWEEN '$startdate' AND '$enddate')";
            $update = $this->CommonModel->custom_update($query);
            // print_r($update);
            // die;
            
            if($update != false)
            {
                $message = ['status' => '1', 'message' => 'Payment sent successfully'];
                echo json_encode($message);
                die;
            }
            else
            {
                $message = ['status' => '0', 'message' => 'Oops ! Something went wrong'];
                echo json_encode($message);
                die;
            }
            
        }
        else
        {
            $message = ['status' => '0', 'message' => 'Oops ! Something went wrong'];
            echo json_encode($message);
            die;
        } 
    }
    
    
}