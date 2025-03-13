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
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- col no. 1 -->
                    <!-- ============================================================== -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <?php

                                    if(is_numeric($update_id))
                                    {
                                        $action = base_url('/manage_slider/create/'.$update_id);
                                    }
                                    else
                                    {
                                        $action = base_url('/manage_slider/create');

                                    };
                                ?>
                                <form class="m-t-25" id="form" method="POST" action="<?= $action ?>" enctype="multipart/form-data">

                                    <div class="form-group col-md-12">
                                        <label>Select Slider Type</label>
                                        <select name="type" class="form-control custom-select">
                                            <option value="">Please Select Type</option>
                                            <option value="top" <?php if($type == "top"){ echo "selected"; } ?>>Top</option>
                                            <option value="bottom" <?php if($type == "bottom"){ echo "selected"; } ?>>Bottom</option>
                                            <option value="website_top" <?php if($type == "website_top"){ echo "selected"; } ?>>Website Top Banner</option>
                                            <option value="website_bottom" <?php if($type == "website_bottom"){ echo "selected"; } ?>>Website Bottom Banner</option>
                                        </select>
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>Select Sub Sub Category</label> <br>
                                        <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="sub_sub_category_id" id="sub_sub_category_id">
                                            <option disabled selected>Select</option>
                                        <?php 
     	                                    $CommonModel = new CommonModel();
                                            $filter = array("is_deleted" => 0, "status" => 1);
                                            $sub_category   = $CommonModel->get_by_condition('sub_sub_category', $filter);                                            
                                            foreach($sub_category as $row):
                                        ?>
                                                <option value="<?= $row->id ?>" <?php if($row->id == $sub_sub_category_id) { echo 'selected';} ?>><?= $row->sub_sub_category_name ?></option>
                                        <?php
                                            endforeach
                                        ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Slider Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>

                                    <?php
                                        if($image)
                                        {
                                    ?>
                                            <div class="form-group col-md-12">
                                                <label>Slider current Image</label>
                                                <div class="el-card-avatar el-overlay-1 mb-2 ml-2"> 
                                                    <img src="<?=base_url()?>/uploads/slider/<?= $image; ?>" height="85px" width="95px" alt="Image" />
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    ?>

                                    <div class="form-actions">
                                        <div class="card-body">
                                            <button type="submit" name="submit" value="Submit" class="btn btn-success submit"> <i class="fa fa-check"></i> Save</button>
                                            <a href="<?= base_url('manage_slider') ?>" class="btn btn-dark">Cancel</a>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- col no. 2 -->
                    <!-- ============================================================== -->

                    <!-- <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <label>Main Category Image</label>
                                
                                <div class="card">
                                    <div class="el-card-item">
                                        <div class="el-card-avatar cropie-demo" id="cropie-demo">

                                        </div>
                                    </div>
                                </div>

                                <div class="" style="padding-top:30px;">
                                    <button class="btn btn-success upload-result">Image </button>
                                </div>


                                <div class="card mt-3" style="background:#e1e1e1;height:500px;width:300px;">
                                    <div class="el-card-item">
                                        <div class="el-card-avatar image-preview" id="cropie-demo" style="background:#e1e1e1;height:430px;width:300px;">

                                        </div>
                                    </div>
                                </div>

                                <div class="">
                                    <div id="image-preview"
                                        style="background:#e1e1e1;height:430px;width:300px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- ============================================================== -->
                    <!-- End col no. 2 -->
                    <!-- ============================================================== -->

                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

            <!-- <script type="text/javascript">

                $uploadCrop = $('.cropie-demo').croppie({
                    enableExif: true,
                    viewport: {
                        width: 300,
                        height: 450,
                        type: 'square'
                    },
                    boundary: {
                        width: 430,
                        height: 500
                    }
                });


                $('#image').on('change', function() {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $uploadCrop.croppie('bind', {
                            url: e.target.result
                        }).then(function() {
                            console.log('jQuery bind complete');
                        });
                    }
                    reader.readAsDataURL(this.files[0]);
                });


                $('.upload-result').on('click', function(ev) {
                    $uploadCrop.croppie('result', {
                        type: 'canvas',
                        size: 'viewport'
                    }).then(function(resp) {
                        $.ajax({
                            url: "<?php echo base_url('manage_main_category/create') ?>",
                            type: "POST",
                            data: {
                                "image": resp
                            },
                            success: function(data) {
                                html = '<img src="' + resp + '" />';
                                $(".image-preview").html(html);
                            }
                        });
                    });
                });

            </script> -->

    <script>
        if ($("#form").length > 0) {
            $("#form").validate({
                rules: {
                    type: {
                        required: true
                    },
                    // image: {
                    //     required: true
                    // },
                },
                messages: {
                    slider_heading: {
                        required: "Slider Heading Is Required",
                    },
                    // image: {
                    //     required: "Slider Image Is Required",
                    // },
                },
            })
        }
    </script>