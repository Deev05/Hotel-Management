    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div class="content">
            <h2 class="content-heading">Manage Visitor</h2>
            <!-- Dynamic Table Full Pagination -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Visitor <small>Table</small></h3>
                    <button type="button" class="btn btn-rounded btn-outline-secondary min-width-125 mb-10 refresh_btn" data-toggle="modal" data-target="#products_modal">Refresh</button>
                </div>
                <div class="block-content block-content-full">
                <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                    <thead>
                    <tr>
                      <th class="text-center">ID</th>
                      <th>Ip</th>
                      <th class="text-center" style="width: 15%;">Agent Details</th>
                      <th class="text-center" style="width: 15%;">Created</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($visitor as $row): ?>
                          <tr>
                            <td class="text-center id"><?php echo $row->id; ?></td>
                            <td class="font-w600"><?php echo $row->ip; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo $row->agent_details; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo $row->created; ?></td>
                          </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                </div>
            </div>
            <!-- END Dynamic Table Full Pagination -->
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->

<script>

    $(document).on('click', '.refresh_btn', function(e){
        // alert();
        window.location = window.location.href;

    });


</script>