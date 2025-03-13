<!--=====================================
            BANNER PART START
=======================================-->
<section class="single-banner inner-section" style="background: url(<?= base_url() ?>/uploads/meta_data/<?php echo $meta->intro_banner; ?>) no-repeat center;">
    <div class="container">
        <h2>Contact Us</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contact Us </li>
        </ol>
    </div>
</section>
<!--=====================================
            BANNER PART END
=======================================-->


        <!--=====================================
                    CONTACT PART START
        =======================================-->
        <section class="inner-section contact-part">
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
                    <div class="col-md-6 col-lg-4">
                        <div class="contact-card">
                            <i class="icofont-location-pin"></i>
                            <h4>head office</h4>
                            <p><?= $setting->address ?></p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="contact-card active">
                            <i class="icofont-phone"></i>
                            <h4>phone number</h4>
                            <p>
                                <a href="tel:<?= $setting->contact ?>"><?= $setting->contact ?></a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="contact-card">
                            <i class="icofont-email"></i>
                            <h4>Support mail</h4>
                            <p>
                                <a href="mailto:<?= $setting->email ?>"><?= $setting->email ?></a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3654.3406974350205!2d90.48469931445422!3d23.663771197998262!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b0d5983f048d%3A0x754f30c82bcad3cd!2sJalkuri%20Bus%20Stop!5e0!3m2!1sen!2sbd!4v1605354966349!5m2!1sen!2sbd" aria-hidden="false" tabindex="0"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form class="contact-form" id="form" action="<?= base_url('contact/create') ?>" method="POST">
                            <h4>Drop Your Thoughts</h4>
                            <div class="form-group">
                                <div class="form-input-group">
                                    <input class="form-control" type="text" id="name" name="name" placeholder="Your Name">
                                    <i class="icofont-user-alt-3"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-input-group">
                                    <input class="form-control" type="email" id="email" name="email" placeholder="Your Email">
                                    <i class="icofont-email"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-input-group">
                                    <input class="form-control" type="text" id="subject" name="subject" placeholder="Your Subject">
                                    <i class="icofont-book-mark"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-input-group">
                                    <textarea class="form-control" id="message" name="message" placeholder="Your Message"></textarea>
                                    <i class="icofont-paragraph"></i>
                                </div>
                            </div>
                            <button type="submit" class="form-btn-group">
                                <i class="fas fa-envelope"></i>
                                <span>send message</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!--=====================================
                    CONTACT PART END
        =======================================-->


        <script>
            if ($("#form").length > 0) {
                $("#form").validate({
                    rules: {
                        name: {
                            required: true
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        subject: {
                            required: true
                        },
                        message: {
                            required: true
                        },

                    },
                    messages: {
                        name: {
                            required: "Name Is Required",
                        },
                        email: {
                            required: "Email Is Required",
                        },
                        subject: {
                            required: "Subject Is Required",
                        },
                        message: {
                            required: "Message Is Required",
                        },

                    },
                })
            }
        </script>