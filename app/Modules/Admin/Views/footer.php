
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
    
        <script src="<?=base_url()?>/admin_theme/assets/libs/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <script src="<?php echo base_url(); ?>/admin_theme/assets/libs/nestable/jquery.nestable.js"></script>
    
    <script src="<?php echo base_url(); ?>/admin_theme/assets/extra-libs/prism/prism.js"></script>
        
    <script src="<?php echo base_url(); ?>/admin_theme/dist/js/pages/samplepages/jquery.PrintArea.js"></script>
    
    <script src="<?php echo base_url(); ?>/admin_theme/assets/libs/chartjs/dist/Chart.min.js"></script>
    
    <script src="<?php echo base_url(); ?>/admin_theme/assets/libs/tinymce/tinymce.min.js"></script>
    <script src="<?php echo base_url(); ?>/admin_theme/assets/libs/tinymce/themes/modern/theme.min.js"></script>


    <script>
    $(document).ready(function() {

        if ($("#mymce").length > 0) {
            tinymce.init({
                selector: "textarea#mymce",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        }
    });
    </script>





</body>

</html>