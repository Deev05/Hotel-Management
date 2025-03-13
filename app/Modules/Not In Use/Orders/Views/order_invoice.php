<?php

use App\Models\CommonModel;

$CommonModel = new CommonModel();
?>
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-body printableArea">
                <h3><b>INVOICE</b> <span class="pull-right">#<?= $orders->order_no ?></span></h3>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <address>
                                <h3> &nbsp;<b class="text-danger">OKKirana</b></h3>
                                <p class="text-muted m-l-5">E 104, Dharti-2,
                                    <br /> Nr' Viswakarma Temple,
                                    <br /> Talaja Road,
                                    <br /> Bhavnagar - 364002
                                </p>
                            </address>
                        </div>
                        <div class="pull-right text-right">
                            <address>
                                <h3>To,</h3>
                                <h4 class="font-bold">
                                    <?php
                                    // $CommonModel = new CommonModel();
                                    $filter = array("id" => $orders->user_id);
                                    $user_data = $CommonModel->get_single('user_master', $filter);
                                    ?>
                                    <?= $user_data->full_name ?>
                                </h4>
                                <p class="text-muted m-l-30">
                                    <?php
                                    $filter = array("id" => $orders->address_id);
                                    $user_address = $CommonModel->get_single('user_address', $filter);
                                    
                                    $city_id 		= $user_address->city_id;
                                    $pincode_id 	= $user_address->pincode_id;
                                    $area_id 		= $user_address->area_id;
                                    $locality_id 	= $user_address->locality_id;
                                    
                                    $filter = array("id" => $city_id);
                                    $citys = $CommonModel->get_single("city",$filter);
                                    $city = $citys->name; 
                                    
                                    $filter = array("id" => $pincode_id);
                                    $pincodes = $CommonModel->get_single("pincodes",$filter);
                                    $pincode = $pincodes->pincode; 
                                    
                                    $filter = array("id" => $area_id);
                                    $areas = $CommonModel->get_single("area",$filter);
                                    $area = $areas->area; 
                                    
                                    $filter = array("id" => $locality_id);
                                    $localitys = $CommonModel->get_single("locality",$filter);
                                    $locality = $localitys->locality; 
                            
                                    $is_default         = $user_address->is_default;
                                    $name        	    = $user_address->name;
                                    $contact            = $user_address->contact;
                                    $type        	    = $user_address->type;
                                    $delivery_address   = $user_address->address_line_one .", ". $user_address->address_line_two .", ". $locality . ", " .$area .", " . $city . ", ". $pincode;;

                                    
                                    ?>
                                    <?= $delivery_address ?>,
                                    

                                </p>
                                <p class="m-t-30"><b>Invoice Date :</b> <i class="fa fa-calendar"></i> <?= $orders->order_date ?></p>
                            </address>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive m-t-40" style="clear: both;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Product Name</th>
                                        <th class="text-right">Quantity</th>
                                        <th class="text-right">Unit Cost</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 0;
                                    foreach ($order_items as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= ++$count ?></td>
                                            <?php
                                            $filter = array("id" => $row->product_id);
                                            $product = $CommonModel->get_single('products', $filter);
                                            ?>
                                            <td><?= $product->product_name ?></td>
                                            <td class="text-right"> <?= $row->quantity ?> </td>
                                            <td class="text-right"> ₹ <?= $row->order_price ?> </td>
                                            <td class="text-right"> ₹ <?= $row->amount ?> </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="pull-right m-t-30 text-right">
                            <p>Total amount: ₹<?= $orders->total_before_discount ?></p>
                            <?php if ($orders->total_discount != "") : ?>
                                <p>Discount : ₹<?= $orders->total_discount ?> </p>
                            <?php endif ?>
                            <hr>
                            <h3><b>Total :</b> ₹<?= $orders->transaction_amount ?></h3>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="text-right">
                            <!-- <button class="btn btn-danger" type="submit"> Proceed to payment </button>
                            <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

<script src="<?= base_url() ?>/admin_theme/dist/js/pages/samplepages/jquery.PrintArea.js"></script>

<script>
    $(function() {
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    });
</script>