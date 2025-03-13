    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div class="content">
            <h2 class="content-heading">Manage Category</h2>
            <!-- Dynamic Table Full Pagination -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Category <small>Table</small></h3>
                    <button type="button" class="btn btn-rounded btn-outline-secondary min-width-125 mb-10" data-toggle="modal" data-target="#category_modal">New Category</button>
                </div>
                <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                    <thead>
                    <tr>
                      <th class="text-center">ID</th>
                      <th>Category Name</th>
                      <th class="text-center" >Image</th>
                      <th class="d-none d-sm-table-cell" style="width: 15%;">Status</th>
                      <th class="text-center" style="width: 15%;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($category as $row): ?>
                          <tr>
                            <td class="text-center id"><?php echo $row->id; ?></td>
                            <td class="font-w600"><center><?php echo $row->name; ?></td>
                            <td class="d-none d-sm-table-cell text-center"><img src="<?=base_url()?>/uploads/categorys/<?php echo $row->image; ?>" height="85px" width="95px" alt="No Image"></td>
                            <?php
                              if($row->status == '1')
                              {
                                echo '<td><center><span class="badge bg-success">Active</span></td>';
                              }
                              else
                              {
                                echo '<td><center><span class="badge bg-danger">Inactive</span></td>';
                              }
                            ?>
                            <td class="text-center">
                              <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary edit_btn" data-toggle="tooltip" title="Edit">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <a type="button" href="<?= base_url() ?>/manage_category/delete/<?= $row->id ?>" class="btn btn-sm btn-secondary delete_btn" data-toggle="tooltip" title="Delete">
                                  <i class="fa fa-times"></i>
                                </a>
                              </div>
                            </td>
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

    <!-- Pop In Modal -->
    <div class="modal fade" id="category_modal" tabindex="-1" role="dialog" aria-labelledby="modal-popin" aria-hidden="true">
      <div class="modal-dialog modal-dialog-popin" role="document">
        <div class="modal-content">
          <form method="post" enctype="multipart/form-data" id="category_form" > 
          <!-- category_form -->
          <!-- action="<?= base_url() ?>/manage_products/add_user" -->
            <div class="block block-themed block-transparent mb-0">
              <div class="block-header bg-primary-dark">
                <h3 class="block-title">New Category</h3>
                <div class="block-options">
                  <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                    <i class="si si-close"></i>
                  </button>
                </div>
              </div>
              <div class="block-content">
                
                <div class="form-group">
                  <label>Category Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Category Name">
                </div>
                
                <div class="form-group">
                  <label class="form-label">Select Category Status</label>
                  <select class="form-control" name="status" id="status">
                    <option>Select Category Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>

                <div class=" form-group custom-file m-5">
                  <input type="file" class="custom-file-input form-control" id="image" name="image" data-toggle="custom-file-input">
                  <label class="custom-file-label form-label" for="image">Choose New Category Image</label>
                </div>
                <input class="form-control mb-3" type="hidden" name="created" id="created" value="<?php date_default_timezone_set("Asia/Kolkata"); echo date('Y-m-d H:i:s'); ?>">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-alt-success category_add_btn "> <i class="fa fa-check"></i> Save </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- END Pop In Modal -->

    <!-- Pop In Edit Modal -->
    <div class="modal fade" id="category_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-popin" aria-hidden="true">
      <div class="modal-dialog modal-dialog-popin" role="document">
        <div class="modal-content">
          <form method="post" enctype="multipart/form-data" id="category_update_form">
            <div class="block block-themed block-transparent mb-0">
              <div class="block-header bg-primary-dark">
                <h3 class="block-title">Update Category</h3>
                <div class="block-options">
                  <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                    <i class="si si-close"></i>
                  </button>
                </div>
              </div>
              <div class="block-content">
                
                <input type="hidden" class="form-control" id="update_id" name="update_id">
                <div class="form-group">
                  <label>Category Name</label>
                  <input type="text" class="form-control" id="update_name" name="update_name" placeholder="Category Name">
                </div>

                <div class="form-group">
                  <label class="form-label">Select Category Status</label>
                  <select class="form-control" name="update_status" id="update_status">
                    <option>Select Category Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>
                 
                <div class="form-group custom-file m-5">
                  <input type="file" class="custom-file-input form-control" id="update_image" name="update_image" data-toggle="custom-file-input">
                  <label class="custom-file-label form-label" for="image">Choose New Category Image</label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-alt-success category_update "> <i class="fa fa-check"></i> Save </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- END Pop In Edit Modal -->

<script>

  $(document).ready(function(){

    //Add Services  
    $("#category_form").attr('novalidate', 'novalidate');


    $(document).on('click', '.category_add_btn', function(e){
        var file_data = $('#image').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        var formData = new FormData($("#category_form")[0]);
        
        $("#category_form").validate({
          rules: {
            // name: {
            //     required: true
            // },
          },

          submitHandler: function(form)
          {
            $.ajax({
              url:'<?= base_url();?>/manage_category/insert',
              enctype: 'multipart/form-data',
              data: formData,
              processData: false,
              contentType: false,
              type: "POST",

              success: function (message)
              {
                obj = JSON.parse(message);

                var status = obj.status;

                if(status == 0)
                {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: obj.message,
                  })
                }
                else
                {
                  Swal.fire({
                    icon: 'success',
                    title: 'Good job!',
                    text: obj.message,
                  })
                  window.location = window.location.href;
                }
              }
            });
          }
        });
    });


      // Edit btn
    $(document).on('click','.edit_btn', function() {
      var id = $(this).closest('tr').find('.id').text();
      var file_data = $('#update_image').prop('files')[0];   
      var form_data = new FormData();                  
      form_data.append('file', file_data);
      var formData = new FormData($("#category_update_form")[0]);


      $.ajax({
          method:"POST",
          url:"<?= base_url();?>/manage_category/get_data_for_update",
          data:{
              'id' : id,
          },
          success: function(response){
            console.log(response);
            
            $.each(response, function(key, data){
              $('#update_id').val(data['id']);
              $('#update_name').val(data['name']);
              $('#update_status').val(data['status']);
              $("#category_edit_modal").modal('show');
            });
          },
      });
    });

    // Edit
    $("#category_update_form").attr('novalidate', 'novalidate');
    $(document).on('click', '.category_update', function(e){
      $("#category_update_form").validate({
        rules: { 
        },

        submitHandler: function(form)
        {
          $.ajax({
            url:'<?= base_url();?>/manage_category/update',
            enctype: 'multipart/form-data',
            data: new FormData(form),
            processData: false,
            contentType: false,
            type: "POST",

            success: function (message)
            {
              $('#category_edit_modal').modal('hide');
              $('#category_edit_modal').find('input').val('');
              
              obj = JSON.parse(message);

              var status = obj.status;

              if(status == 0)
              {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: obj.message,
                })
              }
              else
              {
                Swal.fire({
                  icon: 'success',
                  title: 'Good job!',
                  text: obj.message,
                })
                window.location = window.location.href;
              }
            }
          });
        }
      });
    });
  });
</script>