
<!--=====================================
            BANNER PART START
=======================================-->
<section class="single-banner inner-section" style="background: url(<?= base_url() ?>/uploads/meta_data/<?php echo $meta->intro_banner; ?>) no-repeat center;">
    <div class="container">
        <h2>Return Policy</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Return Policy</li>
        </ol>
    </div>
</section>
<!--=====================================
            BANNER PART END
=======================================-->


        <!--=====================================
                    RETURN POLICY PART START
        =======================================-->
        <section class="inner-section privacy-part mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs">
                            <!--<li><a href="javascript:void(0)" class="tab-link active" data-bs-toggle="tab">descriptions</a></li>-->
                            <li><p class="tab-link active"><?= $meta->title ?></p></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?= $page->return_policy ?>
                    </div>
                </div>
            </div>
        </section>
        <!--=====================================
                    RETURN POLICY PART END
        =======================================-->