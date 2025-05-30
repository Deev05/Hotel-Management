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
                <div class="row">
                    <div class="col-md-6">
                        <h3><b>INVOICE</b> <span class="pull-right">#<?= $purchase_details->reference_no ?></span></h3>
                    </div>
                    <div class="col-md-6 pull-right text-right">
                        <p><b>Invoice Date :</b> <i class="fa fa-calendar"></i> <?= $purchase_details->date ?></p>
                    </div>
                </div>
                
                
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="pull-left">
                            <address>
                                <img width="80px" src="<?php echo base_url(); ?>uploads/setting/<?php echo $setting->logo; ?>">
                                <!--<h3> &nbsp;<b class="text-danger">OKKirana</b></h3>-->
                                <h4 class="font-bold"><?php echo $setting->headline; ?></h4>
                                <div class="col-md-6" style="float:left;">
                                    <p><?php echo $setting->address; ?></p>
                                    <p class="font-bold">GSTN/UIN : <?php echo $setting->gst_no; ?></p>
                                </div>
                            </address>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="pull-right text-right">
                            <address>
                                <h3>To,</h3>
                                <h4 class="font-bold">
                                    <?php
                                    // $CommonModel = new CommonModel();
                                    $filter = array("id" => $purchase_details->supplier_id);
                                    $supplier_data = $CommonModel->get_single('suppliers', $filter);
                                    ?>
                                    <?= $supplier_data->name ?>
                                </h4>
                                
                                <div class="col-md-6" style="float:right;">
                                    <p><?php $delivery_address   = $supplier_data->address .", ". $supplier_data->state .", ". $supplier_data->city ;?>
                                        <?= $delivery_address ?></p>
                                    <p class="font-bold">GSTN/UIN : <?php echo $supplier_data->gst_no; ?></p>
                                </div>
                            </address>
                        </div>
                    </div> 
                        
                    
                    <div class="col-md-12">
                        <div class="table-responsive m-t-40" style="clear: both;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sr. No</th>
                                        <th>Item</th>
                                        <th>HSN Code</th>
                                        <th class="text-right">Qty</th>
                                        <th class="text-right">Rate</th>
                                        <th class="text-right">Tax</th>
                                        <th class="text-right">SGST</th>
                                        <th class="text-right">CGST</th>
                                        <th class="text-right">IGST</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $count = 0;
                                    $total_sgst = 0;
                                    $total_cgst = 0;
                                    $total_igst = 0;
                                    $sub_total = 0.00;
                                    foreach ($purchase_items as $row) : ?>
                                        <tr>
                                            
                                            <?php
                                                $filter = array("id" => $row->product_id);
                                                $product = $CommonModel->get_single('products', $filter);
                                                
                                                $filter         = array("id" => $product->tax_id);
                                                $tax_details   = $CommonModel->get_single('tax_rates',$filter);
                                                
                                                
                                                $total_sgst += $row->sgst;
                                                $total_cgst += $row->cgst;
                                                $total_igst += $row->igst;
                                                
                                                $sub_total += $row->net_unit_cost *  $row->quantity;

                                            ?>
                                            
                                            
                                            <td class="text-center"><?= ++$count ?></td>
                                            <td><?= $product->product_name ?></td>
                                            <td><?= $product->hsn_code ?></td>
                                            <td class="text-right"> <?= $row->quantity ?> </td>
                                            <td class="text-right"> ₹ <?= $row->net_unit_cost ?> </td>
                                            <td class="text-right"> <?= $tax_details->tax_rate ?>% </td>
                                            <td class="text-right"> ₹ <?= $row->sgst ?> </td>
                                            <td class="text-right"> ₹ <?= $row->cgst ?> </td>
                                            <td class="text-right"> ₹ <?= $row->igst ?> </td>
                                            <td class="text-right"> ₹ <?= $row->net_unit_cost *  $row->quantity ?> </td>
                                            
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Sr. No</th>
                                        <th>Item</th>
                                        <th>HSN Code</th>
                                        <th class="text-right">Qty</th>
                                        <th class="text-right">Rate</th>
                                        <th class="text-right">Tax</th>
                                        <th class="text-right"><?php echo $total_sgst; ?></th>
                                        <th class="text-right"><?php echo $total_cgst; ?></th>
                                        <th class="text-right"><?php echo $total_igst; ?></th>
                                        <th class="text-right"><?php echo $sub_total; ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                      
                        <div class="pull-right m-t-30 text-right">
                            <!--<p>Sub - Total amount: $13,848</p>-->
                            <!--<p>vat (10%) : $138 </p>-->
                            <hr>
                            <h3><b>Total :</b> ₹<?php echo $sub_total; ?></h3>
                        </div>
                       
                       
                        <div class="clearfix"></div>
                        <hr>
                        <div class="text-right">
                            <a class="btn btn-default btn-outline" href="<?php echo base_url(); ?>purchases/print/<?php echo $purchase_details->id?>"> <i class="fa fa-print"></i> Print </a>
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