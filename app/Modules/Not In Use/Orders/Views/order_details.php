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

        <div class="col-6">

            <div class="button-group d-flex justify-content-end">

                <!-- <button type="button" class="btn waves-effect waves-light btn-lg btn-rounded btn-primary">Invoice </button> -->

                <a href="<?= base_url('orders/order_invoice/' . $orders->id) ?>" class="btn waves-effect waves-light btn-lg btn-rounded btn-primary">Invoice </a>

            </div>

        </div>

        <div class="col-6">

            <div class="button-group d-flex justify-content-start">

                <a href="<?php echo base_url(); ?>orders/send_invoice_email" class="btn waves-effect waves-light btn-lg btn-rounded btn-info">Send Invoice </a>

            </div>

        </div>

    </div>

    <div class="row mt-5">

        <div class="col-12">

            <div class="card">

                <div class="card-body">

                    <!-- .row -->

                    <div class="row">

                        <div class="col-6">

                            <div class="list-group">

                                <p class="list-group-item"><i class="fas fa-user m-r-10"></i> Full Name : <?= $user_details->full_name ?> </p>

                                <p class="list-group-item"><i class="fas fa-envelope m-r-10"></i> Email : <?= $user_details->email ?> </p>

                                <p class="list-group-item"><i class="fas fa-phone m-r-10"></i> Phone : <?= $user_details->contact ?> </p>

                                <p class="list-group-item"><i class="fas fa-calendar-alt m-r-10"></i> Order Date : <?= $orders->order_date ?> </p>

                                <p class="list-group-item"><i class="fas fa-map-pin m-r-10"></i> Delivery Address : <?= $delivery_address ?> </p>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="list-group">

                                <p class="list-group-item"><i class="fas fa-file-alt m-r-10"></i> Order Number : <?= $orders->order_no ?></p>

                                <p class="list-group-item"><i class="far fa-dot-circle m-r-10"></i> Order Status : <span class="label <?= $status_label ?> font-weight-100"><?= $order_status ?></span></p>

                                <p class="list-group-item"><i class="far fa-credit-card m-r-10"></i> Payment Mode : <span class="label <?= $payment_type_label ?> font-weight-100"><?= $payment_type_desc ?></span></p>

                                <p class="list-group-item"><i class="far fa-dot-circle m-r-10"></i> Payment Status : <span class="label <?= $payment_statuse_label ?> font-weight-100"><?= $payment_status_desc ?></span></p>

                                <p class="list-group-item"><i class="fas fa-shopping-bag m-r-10"></i> Order Total : <?= $orders->transaction_amount ?> </p>

                            </div>

                        </div>

                    </div>

                    <!-- / .row -->

                </div>

            </div>

        </div>

    </div>





    <div class="row">

        <div class="col-12">

            <h4 class="card-title"><?= $summary_title ?></h4>

            <div class="card">

                <div class="card-body">

                    <!-- .row -->

                    <div class="row">

                        <div class="col-lg-4 col-md-4">

                            <button class="btn waves-effect waves-light btn-info add_product">Add Product</button>

                        </div>



                        <!-- sample modal content -->

                        <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                            <div class="modal-dialog">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <h4 class="modal-title">Add New Product In Order No. <?= $order_no ?></h4>

                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                                    </div>

                                    <form id="insert_product" method="POST" action="<?= base_url() ?>/orders/insert_product" enctype="multipart/form-data">

                                        <div class="modal-body">

                                            <div class="form-group col-md-12">

                                                <label>Select Category</label> <br>

                                                <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="category_id" id="category_id">

                                                    <option disabled selected>Select</option>

                                                    <?php

                                                    $filter = array("is_deleted" => 0);

                                                    $category   = $CommonModel->get_by_condition('categories', $filter);

                                                    foreach ($category as $row) :

                                                    ?>

                                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>

                                                    <?php

                                                    endforeach

                                                    ?>

                                                </select>

                                            </div>



                                            <div class="form-group col-md-12">

                                                <label>Select Product</label> <br>

                                                <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="product" id="product">

                                                    <option disabled selected>Select</option>

                                                </select>

                                            </div>



                                            <div class="form-group col-md-12">

                                                <label for="recipient-name" class="control-label">Quantity</label>

                                                <input type="number" class="form-control" name="quantity" id="quantity">

                                            </div>

                                            <div class="form-group col-md-12">

                                                <input type="hidden" class="form-control" name="user_id" id="user_id">

                                            </div>

                                            <div class="form-group col-md-12">

                                                <input type="hidden" class="form-control" name="order_id" id="order_id">

                                            </div>

                                        </div>

                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                                            <button type="submit" class="btn btn-danger waves-effect waves-light">Save</button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                        <!-- /.modal -->



                    </div>

                    <!-- .row -->

                    <div class="row">

                        <!-- .col -->

                        <div class="col-12">

                            <form class="m-t-25" id="form" method="POST" action="<?= base_url('orders/update_order_summary/' . $orders->id) ?>" enctype="multipart/form-data">

                                <!-- <h4 class="card-title">Text Color Classes</h4> -->

                                <table class="table table-bordered">

                                    <thead>

                                        <tr>

                                            <th class="text-nowrap">Title</th>

                                            <th class="text-nowrap">Amount</th>

                                            <th>Edit Order Summary</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <tr>

                                            <td class="text-nowrap"><b> Cart Total </b> </td>

                                            <td class="text-muted"><span class="label label-primary font-weight-100">₹<?= $orders->cart_total ?></td>

                                            <td class="text-muted">

                                                <div class="form-group col-md-12">

                                                    <input type="text" name="cart_total" id="cart_total" class="form-control" value="<?= $orders->cart_total ?>">

                                                </div>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td class="text-nowrap"><b> Delivery Charge </b> </td>

                                            <td class="text-muted"><span class="label label-success font-weight-100">₹<?= $orders->delivery_charge ?></td>

                                            <td class="text-muted">

                                                <div class="form-group col-md-12">

                                                    <input type="text" name="delivery_charge" id="delivery_charge" class="form-control" value="<?= $orders->delivery_charge ?>">

                                                </div>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td class="text-nowrap"><b> Grand Total </b> </td>

                                            <td class="text-muted"><span class="label label-info font-weight-100">₹<?= $orders->transaction_amount ?></td>

                                            <td class="text-muted">

                                                <div class="form-group col-md-12">

                                                    <input type="text" name="transaction_amount" id="transaction_amount" class="form-control" value="<?= $orders->transaction_amount ?>">

                                                </div>

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                                <div class="alert alert-danger alert-rounded">Note : Anything you change it will be reflect all the data linked to this order</div>

                                <div class="col-lg-4 col-md-4">

                                    <button type="submit" class="btn waves-effect waves-light btn-warning btn-warning">Change Order Summary Details</button>

                                </div>

                            </form>

                        </div>

                        <!-- /.col -->

                    </div>

                    <!-- /.row -->

                </div>

            </div>

        </div>

    </div>





    <!-- ============================================================== -->

    <!-- Table -->

    <!-- ============================================================== -->

    <div class="row">

        <div class="col-md-12">

            <div class="card">

                <div class="card-body">

                    <h5 class="card-title"><?= $items_title ?></h5>

                    <div class="table-responsive">

                        <table class="table table-bordered">

                            <thead>

                                <tr>

                                    <th>Photo</th>

                                    <th>Product</th>

                                    <th>MRP</th>

                                    <th>Sell Price</th>

                                    <th>Quantity</th>

                                    <th>Unit Price</th>

                                    <th>Before Discount</th>

                                    <th>Discount</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php



                                $mrp_total = 0;

                                $sell_total = 0;

                                $qty_total = 0;

                                $order_item_total = 0;

                                $befor_discount_total = 0;

                                $after_discount_total = 0;







                                foreach ($order_items as $row) {

                                    $filter = array('id' => $row->product_id);

                                    $product =  $CommonModel->get_single('products', $filter);



                                    $mrp_total += (int)$row->actual_price;

                                    $sell_total += (int)$row->order_price;

                                    $qty_total += (int)$row->quantity;

                                    $order_item_total += (int)$row->amount;

                                    $befor_discount_total += (int)$row->actual_price * (int)$row->quantity;

                                    $after_discount_total += (int)$row->discount;



                                ?>

                                    <tr>

                                        <td><img src="<?= base_url() ?>/uploads/products/<?= $product->product_image; ?>" alt="iMac" width="80"></td>

                                        <td><?= $product->product_name ?></td>

                                        <td>₹<?= $row->actual_price ?></td>

                                        <td>₹<?= $row->order_price ?></td>

                                        <td><?= $row->quantity ?></td>

                                        <td class="font-500">₹<?= $row->amount ?></td>

                                        <td>₹<?php echo (int)$row->actual_price * (int)$row->quantity; ?></td>

                                        <td>₹<?= $row->discount ?></td>

                                    </tr>

                                <?php

                                }

                                ?>

                                <tr>

                                    <td colspan="2" class="font-500" align="right">Total</td>

                                    <td class="font-500">₹<?= $mrp_total ?></td>

                                    <td class="font-500">₹<?= $sell_total ?></td>

                                    <td class="font-500"><?= $qty_total ?></td>

                                    <td class="font-500">₹<?= $order_item_total ?></td>

                                    <td class="font-500">₹<?= $befor_discount_total ?></td>

                                    <td class="font-500">₹<?= $after_discount_total ?></td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ============================================================== -->

    <!-- End TABLE Content -->

    <!-- ============================================================== -->





    <!-- ============================================================== -->

    <!-- End PAge Content -->

    <!-- ============================================================== -->

</div>

<!-- ============================================================== -->

<!-- End Container fluid  -->

<!-- ============================================================== -->


<script>
    $(document).on('click', '.add_product', function() {
        user_id = <?= $user_details->id ?>;
        order_id = <?= $orders->id ?>;
        $('#user_id').val(user_id);
        $('#order_id').val(order_id);

        $("#responsive-modal").modal('show');
        return false;
        var id = tableChildRows.row($(this).closest('tr')).data().id;
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/orders/get_order_data",
            data: {
                'id': id,
            },
            success: function(message) {
                obj = JSON.parse(message);
                var status = obj.status;

                if (status == 0) {
                    alert(obj.message);
                } else {

                    $(".bs-example-modal-lg").modal('show');
                    $('#modal_title').html(obj.modal_title);
                    $('#order_details').html(obj.order_details);
                    $('#order_datas').html(obj.table_data);

                }
            },
        });
    })

    //////// Model Dropdown ////////
    $(document).ready(function() {

        $('#category_id').change(function() {
            var category_id = $(this).val();

            $.ajax({
                url: "<?= base_url() ?>/orders/get_product",
                method: "post",
                data: {
                    category_id: category_id
                },
                dataType: "json",
                success: function(response) {
                    // Remove options
                    $("#product").find("option").not(":first").remove();
                    // Add options
                    $.each(response, function(index, data) {
                        $("#product").append(
                            '<option value="' +data["id"] +'">' +data["product_name"] +"</option>"
                        );
                    });
                },
            });

        });

    });

    if ($("#insert_product").length > 0) {
        $("#insert_product").validate({
            rules: {
                category_id: {
                    required: true
                },
               
                product: {
                    required: true
                },
                quantity: {
                    required: true
                },
            },
            messages: {
                category_id: {
                    required: "Selecting Category is required",
                },
                product: {
                    required: "Product Name is required",
                },
                quantity: {
                    required: "Quantity is required",
                },
            },
        })
    }
</script>