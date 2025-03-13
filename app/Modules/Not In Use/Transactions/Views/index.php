<?php
use App\Models\CommonModel;
?>
<!-- ============================================================= -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    
    <div class="card">
        <div class="card-body">
       
        
                <div class="form-body">
                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                         <select class="form-control" name="service_provider_id" id="service_provider_id" autocomplete="off">    
                                            <option value=""> Select Service Provider </option>
                                            <?php
                                                foreach($service_providers as $row)
                                                {
                                            ?>
                                                    <option value="<?php echo $row->id?>"> <?php echo $row->name?> </option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                         <select class="form-control" name="type" id="type" autocomplete="off">    
                                            <option value=""> Select Type </option>
                                            <option value="credit"> Credit </option>
                                            <option value="deposite"> Deposite </option>
                                            <option value="penalty"> Penalty </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar"></i></span>
                                            </div>
                                            <input id="date_range" type='text' class="form-control dateLimit" value="" />
                                        </div>
                                    </div>
                                </div>

                                <div  class="col-md-2">
                                     <div class="form-actions">
                                        <div class="text-right">
                                            <button id="filter_button" type="button" class="btn btn-info">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      

                        </div>
                        
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                  
                                    <div class="card">
                                        <div class="d-flex flex-row">
                                            <div class="p-10 bg-primary">
                                                <h3 class="text-white box m-b-0"><i class="ti-timer"></i></h3>
                                            </div>
                                            <div class="p-10">
                                                <h3 class="m-b-0" id="total_credit"></h3>
                                                <span>Total Credit</span>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="d-flex flex-row">
                                            <div class="p-10 bg-danger">
                                                <h3 class="text-white box m-b-0"><i class="ti-timer"></i></h3>
                                            </div>
                                            <div class="p-10">
                                                <h3 class="m-b-0" id="total_penalty"></h3>
                                                <span >Total Penalty</span>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="d-flex flex-row">
                                            <div class="p-10 bg-success">
                                                <h3 class="text-white box m-b-0"><i class="ti-timer"></i></h3>
                                            </div>
                                            <div class="p-10">
                                                <h3 class="m-b-0" id="total_payable"></h3>
                                                
                                                <span>Total Payable</span>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <div  class="col-md-2">
                                     <div class="form-actions">
                                        <div class="text-right">
                                            <button id="pay_button" type="button" class="btn btn-info">Pay Now</button>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                      

                        </div>
                    </div>
                    
                </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered show-child-rows w-100">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <!-- <th>No.</th> -->
                                    <th hidden>Id</th>
                                    <th>Applicantion No</th>
                                    <th>Service Provider</th>
                                    <th>Type</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Payment Mode</th>
                                    <th>Transaction Id</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->                 
    <div  class="modal fade payment_summary_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="summary_details">
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label>Final Amount To Pay Service Provider</label>
                        <select name="payment_mode" id="payment_mode" class="form-control" autocomplete="off">
                            <option value="">Please choose Payment Mode</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Bank NEFT">Bank NEFT</option>
                            <option value="Bank IMPS">Bank IMPS</option>
                            <option value="UPI">UPI</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label>Transaction Id/Reference Id</label>
                        <input type="text" class="form-control" name="transaction_id" id="transaction_id" value="" autocomplete="off">
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label>Total Payable Amount</label>
                        <input type="text" class="form-control" id="total_amount" name="total_amount" readonly>
                    </div>
                    
                    
                </div>
                
                
                

                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light" id="make_payment">Send</button>
                </div>
             
            </div>
        </div>
    </div>
    <!-- /.modal -->
  


  

    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

<script>
    $(document).ready(function() {
        
        var service_provider_id = "";
        var type = "";
        
        ///////////GET SERVICE PROVIDER ID///////////////
        $('#service_provider_id').on('change', function() {
          service_provider_id =  this.value;
          //table.draw();
          //alert( service_provider_id );
        });
        ///////////GET SERVICE PROVIDER ID///////////////
        
        ///////////GET SERVICE PROVIDER ID///////////////
        $('#type').on('change', function() {
          type =  this.value;
          //table.draw();
          //alert( service_provider_id );
        });
        ///////////GET SERVICE PROVIDER ID///////////////

        ////////////////// FOR DATE ///////////////////
        var filter_dates = "";
        $('.dateLimit').daterangepicker({
            dateLimit: {
                days: 30
            },
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
        
        $('#date_range').val('');
        
        ////////////////// FOR DATE ///////////////////

        ////////////////// Filter Button ///////////////////
        $("#filter_button").click(function() {
            filter_dates = $("#date_range").val();
            table.draw();
        });
        ////////////////// Filter Button ///////////////////
        
        ////////////  Reset btn //////////
        $(".reset_btn").click(function() {
            service_provider_id = "";
            type = "";
            filter_dates = "";
            table.draw();
        });
        ////////////  Reset btn //////////
        
        
        ////////////////// PAY Button ///////////////////
        $("#pay_button").click(function() {
            filter_dates = $("#date_range").val();
            
            if(service_provider_id == "")
            {
                alert("Please select service provider you want to pay");
            }
            else if(filter_dates == "")
            {
                alert("Please select date range");
            }
            else
            {
                
                $.ajax({
                    method: "POST",
                    url: "<?= base_url(); ?>/transactions/get_payment_summary",
                    data: {
                        'service_provider_id': service_provider_id,
                        'filter_dates': filter_dates,
                    },
                    success: function(message) {
                        obj = JSON.parse(message);
                        var status = obj.status;
                        if (status == 0) {
                            alert(obj.message);
                        } else {
        
                            $('#modal_title').html(obj.modal_title);
                            $('#summary_details').html(obj.summary_details);
                            $('#total_amount').val(obj.total_amount);
                            $(".payment_summary_modal").modal('show');  
                        }
                    },
                });
                
                
            } 
            
        });
        ////////////////// PAY Button ///////////////////
        
        /////Make Payment////////
        $("#make_payment").click(function() {
            var transaction_id = $('#transaction_id').val();
            var total_amount = $('#total_amount').val();
            var payment_mode = $('#payment_mode').find(":selected").val();

            
            if(transaction_id == "")
            {
                alert("Please enter transaction id");
            }
            else if(payment_mode == "")
            {
                alert("Please select payment mpde");
            }
            else
            {
                 $.ajax({
                    method: "POST",
                    url: "<?= base_url(); ?>/transactions/make_payment",
                    data: {
                        'service_provider_id': service_provider_id,
                        'filter_dates': filter_dates,
                        'transaction_id': transaction_id,
                        'payment_mode': payment_mode,
                        'total_amount': total_amount,
                    },
                    success: function(message) {
                        obj = JSON.parse(message);
                        var status = obj.status;
                        if (status == 0) {
                            toastr.error(obj.message);
                        } else {
                           
                             toastr.success(obj.message);
                            
                            $('#transaction_id').val('');
                            $('#total_amount').val('');
                            $('#payment_mode').val(0);
                              
                            $(".payment_summary_modal").modal('hide');  
                            
                            service_provider_id = "";
                            type = "";
                            filter_dates = "";
                            
                            table.draw();
                        }
                    },
                });
            }
             
           
             
        });
        
        /////Make Payment////////
        
        

        var table = $('.show-child-rows').DataTable({
                     dom: 'Bfrtip',
                                buttons: [
                                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "aaSorting": [ [0,"desc" ]],
                "serverSide": true,
                "processing": true,
                "start": 1,
                "end": 8,
                "pageLength": 10,
                "paging": true,
                "ajax": {
                    "url": "<?= base_url() ?>/transactions/get_data",
                    "type": 'POST',
                     "data": function(d) {
                            d.service_provider_id = service_provider_id;
                            d.type = type;
                            d.filter_dates = filter_dates;
                        },
                    "dataSrc": function(json) {
                    if (json.total_credit) {
                      
                        $("#total_credit").html(json.total_credit);
                        $("#total_penalty").html(json.total_penalty);
                        $("#total_payable").html(json.total_payable);
                    }
                    // You can also modify `json.data` if required
                    return json.data;
                },
                       
                },
                "columns": [{
                        "className": 'details-control',
                        "orderable": false,
                        "data": "no",
                        "defaultContent": 'number'
                    },
                    {
                        "className": 'id',
                        "visible": false,
                        // "orderable": true,
                        "data": "id",
                        "defaultContent": '',
                        "render": function(data) {
                            return data;
                        }
                    },
                    {
                        "data": "application_no"
                    },
                    
                    {
                        "data": "service_provider"
                    },
                    {
                        "data": "type"
                    },
                    {
                        "data": "credit"
                    },
                    {
                        "data": "debit"
                    },
                    {
                        "data": "payment_mode"
                    },
                    {
                        "data": "transaction_id"
                    },
                    {
                        "data": "created"
                    },
                  
                ],
               
            });
                    
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-secondary mr-1');

        setInterval(function() {
            table.draw();
        }, 120000);

    });

</script>