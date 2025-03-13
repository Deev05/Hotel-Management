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
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="m-t-25" id="form" method="POST" action="<?= base_url('manage_page') ?>" enctype="multipart/form-data">

                        <input type="hidden" name="id" id="id" class="form-control" value="<?= $id ?>">

                        <div class="form-group col-md-12">
                            <label>About</label>
                            <textarea name="about" id="about" rows="15" class="ckeditor" placeholder="About Content Here...">
                                            <?= $about ?>
                                        </textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Terms Condition</label>
                            <textarea name="terms_condition" id="terms_condition" rows="15" class="ckeditor" placeholder="Terms Condition Content Here...">
                                            <?= $terms_condition ?>
                                        </textarea>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <label>Privacy Policy</label>
                            <textarea name="privacy_policy" id="privacy_policy" rows="15" class="ckeditor" placeholder="Privacy Policy Content Here...">
                                            <?= $privacy_policy ?>
                                        </textarea>
                        </div>

                      

                        <div class="form-actions">
                            <div class="card-body">
                                <button type="submit" name="submit" value="Submit" class="btn btn-success submit"> <i class="fa fa-check"></i> Save</button>
                            </div>
                        </div>

                    </form>
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
    $(".phone").inputmask("(999) 999-9999")


    if ($("#form").length > 0) {
        $("#form").validate({
            rules: {
                slider_heading: {
                    required: true
                },
            },
            messages: {
                slider_heading: {
                    required: "Slider Heading Is Required",
                },
            },
        })
    }
</script>