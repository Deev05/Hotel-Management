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
                
                <div class="text-left">
                    <button type="submit" class="btn btn-info add_package_button" name="add_package_button">Add Package</button>
                </div>
                <br/>

               
                <!-- basic table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered show-child-rows w-100">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th hidden>Id</th>
                                                <th>Service Name</th>
                                                <th>Country</th>
                                                <th>Package Name</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Add Package modal content -->
                <div id="add_package_modal" class="modal fade add_package bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Add New Package </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <form id="add_package_form" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">SOP Serice</label>
                                                    <select name="sop_service_id" id="sop_service_id" class="form-control select2" style="height: 36px;width: 100%;">
                                                        <option value="" >Select SOP Service</option>
                                                        <?php
                                                            $filter = array("status" => 1);
                                                            $sop_services = $CommonModel->get_by_condition("sop_services",$filter);

                                                            if(!empty($sop_services))
                                                            {
                                                                foreach($sop_services as $row)
                                                                {
                                                        ?>
                                                                    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                                        <?php
                                                                }    
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group col-md-12">
                                                    <label>Select Country</label> <br>
                                                    <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="sop_country_id" id="sop_country_id">
                                                        <option value="">Select Country</option>
                                                        <?php
                                                            $filter = array("status" => 1);
                                                            $sop_countries = $CommonModel->get_by_condition("sop_countries",$filter);

                                                            if(!empty($sop_countries))
                                                            {
                                                                foreach($sop_countries as $row)
                                                                {
                                                        ?>
                                                                    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                                        <?php
                                                                }    
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label>Select Package</label> <br>
                                                    <select class="form-control custom-select" style="width: 100%; height:36px;" name="package_name" id="package_name">
                                                        <option value="">Select Package</option>
                                                        <option value="24 Hours">24 Hours</option>
                                                        <option value="48 Hours">48 Hours</option>
                                                        <option value="72 Hours">72 Hours</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="recipient-name" class="control-label">Package Price</label>
                                                    <input type="text" class="form-control" name="package_price" id="package_price">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>   

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger waves-effect waves-light add_package">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Add Package modal Ends -->
                
                
                <!-- Edit Package modal content -->
                    <div id="responsive-modal" class="modal fade edit_sop_package" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> Update Details </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <form id="update_country_form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">

                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">SOP Services</label>
                                            <select name="edit_sop_service" id="edit_sop_service" class="form-control">
                                                <option value="">Select SOP Service</option>
                                                <?php
                                                    $filter = array("status" => 1,"is_deleted" => 0);
                                                    $services = $CommonModel->get_by_condition("sop_services",$filter);

                                                    if(!empty($services))
                                                    {
                                                        foreach($services as $row)
                                                        {
                                                ?>
                                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                                <?php
                                                        }    
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Select Country</label> <br>
                                            <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="edit_country" id="edit_country">
                                                <option value="">Select Country</option>
                                                <?php
                                                    $filter = array("status" => 1,"is_deleted" => 0);
                                                    $countries = $CommonModel->get_by_condition("sop_countries",$filter);

                                                    if(!empty($countries))
                                                    {
                                                        foreach($countries as $row)
                                                        {
                                                ?>
                                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                                <?php
                                                        }    
                                                    }
                                                ?>
                                            
                                            </select>
                                        </div>
                                        
                                        
                                       <div class="form-group col-md-12">
                                            <label>Select Package</label> <br>
                                            <select class="form-control custom-select" style="width: 100%; height:36px;" name="edit_package_name" id="edit_package_name">
                                                <option value="">Select Package</option>
                                                <option value="24 Hours">24 Hours</option>
                                                <option value="48 Hours">48 Hours</option>
                                                <option value="72 Hours">72 Hours</option>
                                            </select>
                                        </div>
                                       
                                       
                                        <div class="form-group col-md-12">
                                            <label for="recipient-name" class="control-label">Price</label>
                                            <input type="text" class="form-control" name="edit_price" id="edit_price">
                                        </div>
                                     
                                        <div class="form-group col-md-12">
                                            <input type="hidden" class="form-control" name="sop_package_id" id="sop_package_id" value="">
                                        </div>
                
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger waves-effect waves-light update_package">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /Edit Package modal -->


                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->         
            
            

                
                
  
            
            
            
            
            
<script>

$(document).ready(function() {


    
    ///////DATATABLE///////////////

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
                    "url": "<?= base_url() ?>/soppackages/get_packages",
                    "type": 'POST',
    
                    "data": function(d) {
                    }
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
                        "data": "sop_service_name",
                    },
                    
                     {
                        "data": "sop_country",
                    },

                    {
                        "data": "package_name",
                    },

                    {
                        "data": "package_price",
                    },
                    
                     {
                        "orderable": false,
                        "data": "status",
                        "render": function(data) {
                            
                             if (data == 0) {
                                return '<div class="text-center"><span class="badge badge-pill badge-warning custom_pointer status">Inactive</span></div>';
                            } else if (data == 1) {
                                return '<div class="text-center"><span class="badge badge-pill badge-primary custom_pointer status">Active</span></div>';
                            }
                           
                        }
                    },
                    
                    {
                        "data": "created"
                    },
                    {
                        "orderable": false,
                        "data": "id",
                        "render": function(data) {
                            return '<div class="text-center">' +
         
                                '<a href="javascript:void(0)" class="btn btn-info edit_package_modal">' +
                                '<i class="fa fa-pencil-alt"></i>' +
                                '</a>' +

                                '<a href="javascript:void(0)" class="btn btn-danger delete_button">' +
                                '<i class="fa fa-trash"></i>' +
                                '</a>' +
                            
                                '</div>';  
                        },
                    },
                ],
    });
    
    $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-secondary mr-1');

                    
    ///Add Package Form Model Open
    $(document).on('click', '.add_package_button', function(e) {
        
        
        $('#category_id').select2({
            dropdownParent: $('#add_package_modal')
        });
        
         $('#suppliers').select2({
            dropdownParent: $('#add_package_modal')
        });
        
        $("#add_package_modal").modal('show');

    })

    $('#add_package_form').validate({ 
        rules: {
            sop_service_id: {
                required: true
            },
            sop_country_id: {
                required: true
            },
            package_name: {
                required: true
            },
            package_price: {
                required: true
            },
    
        },

		submitHandler: function(form) 
		{
		    
		 
            var form_data = new FormData();                  
   
            var formData = new FormData($("#add_form")[0]);

			$.ajax({

				url: '<?php echo base_url(); ?>/soppackages/add_package',

				enctype: 'multipart/form-data',
				data:new FormData(form),  
				processData: false,
				contentType: false,
				type: "POST",

				success: function(message) 
				{

					obj = JSON.parse(message);

					var status = obj.status;
					
					if(status == 0)
					{
						alert(obj.message);
					}
					else
					{
						//alert(obj.message);
						$('#add_package_modal').modal('hide');
						$('#add_package_form').trigger("reset");
			
						
					    table.draw();
					}
				}               
			});
		}
    });

    //Delete Package//
    $(document).on('click', '.delete_button', function() {
        var id = table.row($(this).closest('tr')).data().id;
       
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/soppackages/delete/" + id,
            success: function(message) {
                table.draw();
                obj = JSON.parse(message);
                var status = obj.status;

                if (status == 0) {
                    toastr.error(obj.message);
                } else {
                    toastr.success(obj.message);
                }
            },
        });
    });
    
    //Pacakge Edit Modal
    $(document).on('click', '.edit_package_modal', function(e) {
        var id                  = table.row($(this).closest('tr')).data().id;
        var package_name        = table.row($(this).closest('tr')).data().package_name;
        var package_price       = table.row($(this).closest('tr')).data().package_price;
        var sop_country         = table.row($(this).closest('tr')).data().sop_country;
        var service_name        = table.row($(this).closest('tr')).data().sop_service_name;
        var country_name        = table.row($(this).closest('tr')).data().country_name;
        var sop_service_id      = table.row($(this).closest('tr')).data().sop_service_id;

        // alert(country_name);
        // alert(sop_service_id);

        e.preventDefault();
         
        $('#sop_package_id').val(id);

        $('#edit_price').val(package_price);

        $('#edit_sop_service option').filter(function() {
            return this.textContent == service_name
        }).prop('selected', true);
        
        $('#edit_country option').filter(function() {
            return this.textContent == country_name
        }).prop('selected', true);
        
        
         $('#edit_package_name option').filter(function() {
            return this.textContent == package_name
        }).prop('selected', true);
        
        $("#responsive-modal").modal('show');

    })
    

    
    //Update Package
    $(document).on('click', '.update_package', function(e) {
        $("#update_country_form").validate({
            rules: {
                edit_package_name: {
                    required: true
                },
            },
    
            submitHandler: function(form) {
                $.ajax({
                    url: '<?= base_url(); ?>/soppackages/update_package',
                    enctype: 'multipart/form-data',
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    type: "POST",
    
                    success: function(message) {
                        // return false;
                        $('#responsive-modal').modal('hide');
                        $('#responsive-modal').find('input').val('');
                        table.draw();
    
                        obj = JSON.parse(message);
                        var status = obj.status;
                        if (status == 0) {
                            toastr.error(obj.message);
                        } else {
                            toastr.success(obj.message);
                        }
                    }
                });
            }
        });
    });

        $(document).on('click', '.status', function() {
        var id = table.row($(this).closest('tr')).data().id;
        $.ajax({
            method: "POST",
            url: "<?= base_url(); ?>/soppackages/change_status/" + id,
            success: function(message) {
                table.draw();
                obj = JSON.parse(message);
                var status = obj.status;

                if (status == 0) {
                    toastr.error(obj.message);
                } else {
                    toastr.success(obj.message);
                }
            },
        });
    });


});
</script>


       