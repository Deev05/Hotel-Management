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

                <!-- Notifaction Form -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-body">
                            <h4 class="card-title">Add New Notifications</h4>
                            <!-- <h5 class="card-subtitle"> All bootstrap element classies </h5> -->
                            <form class="form-horizontal m-t-30" id="notification_form" action="<?= base_url("/manage_notification/send_notification_all") ?>" method="POST">
                                
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="New Notification Title Here...">
                                </div>
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control" name="message" id="message" rows="5" placeholder="New Notification Message Here..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Image Link (Optional)</label>
                                    <input class="form-control" name="image" id="image" type="text" placeholder="Image Link Here..." >
                                </div>

                                <div class="row show-grid">
                                    <div class="col-xs-6 col-sm-4"></div>
                                    <div class="col-xs-6 col-sm-4">
                                        <div class="form-actions">
                                        <div class="card-body">
                                            <button type="submit" name="submit" value="Submit" class="btn btn-success submit"> <i class="fa fa-check"></i> Send</button>
                                        </div>
                                    </div>

                                    </div>
                                    <div class="col-xs-6 col-sm-4"></div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Notifaction Image Form -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-body">
                            <h4 class="card-title">Add New Notifications Image</h4>
                            <!-- <h5 class="card-subtitle"> All bootstrap element classies </h5> -->
                            <form class="form-horizontal m-t-30" id="notification_image_form" action="<?= base_url('manage_notification/notification_image_upload') ?>" method="POST" enctype="multipart/form-data">
                                
                                <div class="form-group col-md-12">
                                    <label>Notifications Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>

                                <div class="row show-grid">
                                    <div class="col-xs-6 col-sm-4"></div>
                                    <div class="col-xs-6 col-sm-4">
                                        <div class="form-actions">
                                            <div class="card-body">
                                                <button type="submit" name="submit" value="Submit" class="btn btn-success submit"> <i class="fa fa-check"></i> Save</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4"></div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- basic table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Image</th>
                                                <th>Copy Link</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $count = 0; foreach($notification_images as $row): ?>
                                                <tr>
                                                    <td><center><?php echo ++$count; ?></center></td>
                                                    
                                                    
                                                    
                                                    <td><center><img src="<?=base_url()?>/uploads/notification/<?php echo $row->image; ?>" height="75px" width="75px" alt="No Image"></center></td>
                                                    
                                                    <td><center><button type="button" onclick="fun(this.getAttribute('data-url'));" data-url="<?php echo $row->image; ?>" class="btn btn-secondary btn-circle btn-lg"><i class="far fa-copy"></i> </button></center></td>
                                                    <td>
                                                        <center>
                                                            <a href="<?= base_url('manage_notification/notification_image_delete/'. $row->id) ?>" class="btn btn-danger btn-circle btn-lg"><i class="fa fa-trash"></i></a>
                                                        </center>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
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

            if ($("#notification_image_form").length > 0) {
                $("#notification_image_form").validate({
                    rules: {
                        image: {
                            required: true
                        },
                    },
                    messages: {
                        image: {
                            required: "Image Is Required",
                        },
                    },
                })
            }

            if ($("#notification_form").length > 0) {
                $("#notification_form").validate({
                    rules: {
                        title: {
                            required: true
                        },
                        message: {
                            required: true
                        },
                    },
                    messages: {
                        title: {
                            required: "Title Is Required",
                        },
                        message: {
                            required: "Message Is Required",
                        },
                    },
                })
            }

            function fun(one) {
                var copyText = '<?php echo base_url(); ?>/uploads/notification/' + one;
                document.getElementById("image").value = copyText;
            }

        </script>