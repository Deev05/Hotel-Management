<?php 
use App\Models\CommonModel;
?>
			<!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                <!-- basic table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered show-child-rows w-100" id="usermaster">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Full Name</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Contact</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="customer_datas">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            
            <script>
                $(document).ready(function() {
             
                    
                    var table = $('#usermaster').DataTable({
            
                            "aaSorting": [ [0,"desc" ]],
                            "serverSide": true,
                            "processing": true,
                            "start": 1,
                            "end": 8,
                            "pageLength": 10,
                            "paging": true,
                            "ajax": {
                                "url": "<?= base_url() ?>/usermaster/get_usermaster",
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
                                    "data": "id",
                                    "defaultContent": '',
                                    "render": function(data) {
                                        return data;
                                    }
                                },
            
                                {
                                    "data": "firstname"
                                }, {
                                    "data": "lastname"
                                },
                                {
                                    "data": "email"
                                },
                                {
                                    "data": "contact"
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
                    var url = "<?= base_url() ?>/usermaster/single_details/" + data;
                    return '<div class="btn-group">' +
                        '<a href="' + url + '" class="btn btn-info" >' +
                        '<i class="ti-eye"></i>' +
                        '</a>';
                },
                                },
                            ],
                        });
                                
                    $(document).on('click', '.status', function() {
                    var id = table.row($(this).closest('tr')).data().id;
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url(); ?>/usermaster/change_status/" + id,
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

       