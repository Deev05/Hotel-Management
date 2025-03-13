
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                
                <a target="_blank" href="#">Graphionic</a>. 2023
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->


    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->
    <aside class="customizer">
        <a href="javascript:void(0)" class="service-panel-toggle">
            <i class="fa fa-spin fa-cog"></i>
        </a>
        <div class="customizer-body">
            <ul class="nav customizer-tab justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab
                                    " aria-controls="pills-home" aria-selected="true">
                        <i class="mdi mdi-wrench font-20"></i>
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <!-- Tab 1 -->
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="p-15 border-bottom">
                        <!-- Sidebar -->
                        <h5 class="font-medium m-b-10 m-t-10">Layout Settings</h5>
                        <div class="custom-control custom-checkbox m-t-10">
                            <input type="checkbox" class="custom-control-input" name="theme-view" id="theme-view">
                            <label class="custom-control-label" for="theme-view">Dark Theme</label>
                        </div>
                        
                    </div>
                    <div class="p-15 border-bottom">
                        <!-- Logo BG -->
                        <h5 class="font-medium m-b-10 m-t-10">Logo Backgrounds</h5>
                        <ul class="theme-color">
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link logobg" data-logobg="skin1"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link logobg" data-logobg="skin2"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link logobg" data-logobg="skin3"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link logobg" data-logobg="skin4"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link logobg" data-logobg="skin5"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link logobg" data-logobg="skin6"></a>
                            </li>
                        </ul>
                        <!-- Logo BG -->
                    </div>
                    <div class="p-15 border-bottom">
                        <!-- Navbar BG -->
                        <h5 class="font-medium m-b-10 m-t-10">Navbar Backgrounds</h5>
                        <ul class="theme-color">
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link navbarbg" data-navbarbg="skin1"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link navbarbg" data-navbarbg="skin2"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link navbarbg" data-navbarbg="skin3"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link navbarbg" data-navbarbg="skin4"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link navbarbg" data-navbarbg="skin5"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link navbarbg" data-navbarbg="skin6"></a>
                            </li>
                        </ul>
                        <!-- Navbar BG -->
                    </div>
                    <div class="p-15 border-bottom">
                        <!-- Logo BG -->
                        <h5 class="font-medium m-b-10 m-t-10">Sidebar Backgrounds</h5>
                        <ul class="theme-color">
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link sidebarbg" data-sidebarbg="skin1"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link sidebarbg" data-sidebarbg="skin2"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link sidebarbg" data-sidebarbg="skin3"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link sidebarbg" data-sidebarbg="skin4"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link sidebarbg" data-sidebarbg="skin5"></a>
                            </li>
                            <li class="theme-item">
                                <a href="javascript:void(0)" class="theme-link sidebarbg" data-sidebarbg="skin6"></a>
                            </li>
                        </ul>
                        <!-- Logo BG -->
                    </div>
                </div>
                <!-- End Tab 1 -->
            </div>
        </div>
    </aside>
    
    <script>
        <?php
            if(session()->has("message")){
        ?>
            window.onload = function() {
                if('<?= session("message") ?>' == 'Something Went Wrong!')
                {
                    toastr.error('<?= session("message") ?>');
                }
                else if('<?= session("message") ?>' == 'No Changes Found!')
                {
                    toastr.info('<?= session("message") ?>');
                }
                else
                {
                    toastr.success('<?= session("message") ?>');
                }

            };
        <?php
            }
        ?>
    </script>

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?=base_url()?>/admin_theme/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?=base_url()?>/admin_theme/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="<?=base_url()?>/admin_theme/dist/js/app.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/dist/js/app.init.js"></script>
    <script src="<?=base_url()?>/admin_theme/dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?=base_url()?>/admin_theme/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="<?=base_url()?>/admin_theme/dist/js/waves.js"></script>
    
    <!--Menu sidebar -->
    <script src="<?=base_url()?>/admin_theme/dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?=base_url()?>/admin_theme/dist/js/custom.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/libs/toastr/build/toastr.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/extra-libs/toastr/toastr-init.js"></script>
    
    <!--This page JavaScript -->
    <script src="<?=base_url()?>/admin_theme/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/libs/magnific-popup/meg.init.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/dist/js/pages/forms/select2/select2.init.js"></script>
    <?php if ($page_title == 'Pages' || $page_title == 'Add New Product' || $page_title == 'Update Product Details') : ?>
        <script src="<?=base_url()?>/admin_theme/assets/libs/ckeditor/ckeditor.js"></script>
        <script src=" <?=base_url()?>/admin_theme/assets/libs/ckeditor/samples/js/sample.js"></script>
    <?php endif ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/dist/js/pages/forms/mask/mask.init.js"></script>
    
    <!--chartis chart-->
    <script src="<?=base_url()?>/admin_theme/assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <!--c3 charts -->
    <script src="<?=base_url()?>/admin_theme/assets/extra-libs/c3/d3.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/extra-libs/c3/c3.min.js"></script>
    <!--chartjs -->
    <script src="<?=base_url()?>/admin_theme/assets/libs/raphael/raphael.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/libs/morris.js/morris.min.js"></script>

    <!--<script src="<?=base_url()?>/admin_theme/dist/js/pages/dashboards/dashboard1.js"></script>-->

    <!-- Plugins -->

    <script src="<?=base_url()?>/admin_theme/assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/dist/js/pages/datatable/datatable-basic.init.js"></script>

    <!-- New Added -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
    
    
    <script src="<?=base_url()?>/admin_theme/assets/libs/moment/moment.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/libs/daterangepicker/daterangepicker.js"></script>
    <script src="<?=base_url()?>/admin_theme/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    
     <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/dist/js/pages/datatable/datatable-advanced.init.js"></script>
    
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="<?=base_url()?>/admin_theme/dist/js/cropper.js"></script>	 
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


    <script src="<?=base_url()?>/admin_theme/assets/libs/@claviska/jquery-minicolors/jquery.minicolors.min.js"></script>
    <script>
    $('.demo').each(function() {
        //
        // Dear reader, it's actually very easy to initialize MiniColors. For example:
        //
        //  $(selector).minicolors();
        //
        // The way I've done it below is just for the demo, so don't get confused
        // by it. Also, data- attributes aren't supported at this time...they're
        // only used for this demo.
        //
        $(this).minicolors({
            control: $(this).attr('data-control') || 'hue',
            defaultValue: $(this).attr('data-defaultValue') || '',
            format: $(this).attr('data-format') || 'hex',
            keywords: $(this).attr('data-keywords') || '',
            inline: $(this).attr('data-inline') === 'true',
            letterCase: $(this).attr('data-letterCase') || 'lowercase',
            opacity: $(this).attr('data-opacity'),
            position: $(this).attr('data-position') || 'bottom left',
            swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
            change: function(value, opacity) {
                if (!value) return;
                if (opacity) value += ', ' + opacity;
                if (typeof console === 'object') {
                    console.log(value);
                }
            },
            theme: 'bootstrap'
        });

    });
    </script>

    <script src="<?php echo base_url(); ?>/admin_theme/assets/libs/nestable/jquery.nestable.js"></script>
    
    <script src="<?php echo base_url(); ?>/admin_theme/assets/extra-libs/prism/prism.js"></script>
        
    <script src="<?php echo base_url(); ?>/admin_theme/dist/js/pages/samplepages/jquery.PrintArea.js"></script>


</body>

</html>