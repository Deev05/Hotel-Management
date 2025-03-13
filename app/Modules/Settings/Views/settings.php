<?php 
use App\Models\CommonModel;
?>
  
<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
          <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
            
            <!-- jQuery library -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
            
            <!-- Latest compiled JavaScript -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h3>Api Keys</h3>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">Id</th>
                      <th scope="col">Email</th>
                      <th scope="col">Password</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        if(!empty($api_keys))
                        {
                            foreach($api_keys as $row)
                            {
                    ?>
                                <tr>
                                  <th scope="row"><?php echo $row->id ;?></th>
                                  <td><?php echo $row->email ;?></td>
                                  <td><?php echo $row->password ;?></td>
                                </tr>
                    <?php
                            }
                        }
                      ?>
                  </tbody>
                </table>
            </div>
            
            
            <div class="row">
                <h3>Admin Users</h3>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">Id</th>
                      <th scope="col">Username</th>
                      <th scope="col">Password</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        if(!empty($admin_users))
                        {
                            foreach($admin_users as $row)
                            {
                    ?>
                                <tr>
                                  <th scope="row"><?php echo $row->id ;?></th>
                                  <td><?php echo $row->user_name ;?></td>
                                  <td><?php echo $row->password ;?></td>
                                </tr>
                    <?php
                            }
                        }
                      ?>
                  </tbody>
                </table>
            </div>        
            
            <div class="row">
                <form class="form-inline" action="<?php echo base_url(); ?>/settings/change_api" method="post">
                    <div class="form-group">
                        <label for="email">Id</label>
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                     <div class="form-group">
                        <label for="email">Password:</label>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Change Api</button>
                </form> 
                
                <br/><br/><br/>
                
                <form class="form-inline" action="<?php echo base_url(); ?>/settings/change_admin" method="post">
                    <div class="form-group">
                        <label for="email">Id</label>
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="form-group">
                        <label for="email">Username:</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                     <div class="form-group">
                        <label for="email">Password:</label>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-info">Change Admin</button>
                </form> 
            </div>
            
            
        </div>
       
        
        
    </body>
</html>
  
