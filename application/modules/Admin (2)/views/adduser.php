<?php include('common/header.php');?>
<div class="wrapper">
    <?php include('common/topbar.php');?>
    <?php include('common/left_sidebar.php');?>  
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><?php echo $heading_title; ?></h1>
      </section>
      <!-- Main content -->
      <section class="content">
        <!-- Info boxes -->
        <div class="row">

            <div class="col-md-6">
              <div class="box box-primary">
                <!-- form start -->
                <form role="form" id="adduser" action="" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formname">
                  <div class="box-body">
                    <div class="form-group" id="Inputfirstname">
                      <label for="firstname" class="required">First Name</label>
                      <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name">
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group" id="Inputlastname">
                      <label for="lastname" class="required">Last Name</label>
                      <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name">
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group" id="Inputimage">
                      <label for="picture" class="">Profile Image</label>
                      <table id="table" width="100%" style="margin: 0 auto;">
                        <thead>
                        </thead>
                        <tbody>
                          <tr class="add_row default_file">
                            <td width="70%">
                              <input class="coverimage" name='image' type='file' id="files"  />
                            </td>
                            <td class="text-center" width="10%">
                              <div class="imagePreview" style="display: none;"></div>
                            </td>
                            <td width="20%"></td>
                          </tr>
                        </tbody>
                        <tfoot>
                        </tfoot>  
                      </table>
                      <!-- <input type="file" id="survey_picture" name="survey_picture" value="">-->
                      <span class="help-block"></span>
                    </div> 
                    <div class="form-group" id="Inputusername">
                      <label for="username" class="required">User Name</label>
                      <input type="text" class="form-control" id="username" id="username" name="username" placeholder="User Name">
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group" id="Inputemail">
                      <label for="email" class="required">Email Address</label>
                      <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group" id="Inputpassword">
                      <label for="password" class="required">Password</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                      <span class="help-block"></span>
                    </div>                    
                    <div class="form-group" id="Inputconfirmpassword">
                      <label for="confirmpassword" class="required">Confirm Password</label>
                      <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password">
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group" id="Inputuserrole">
                      <label for="userrole" class="required">Role</label>
                      <select id="userrole" name="userrole" class="form-control">
                          <option value="0">Customer</option>
                          <option value="1">Administrator</option>
                      </select>
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group" id="Inputuserstatus">
                      <label for="userstatus" class="required">Status</label>
                      <select id="userstatus" name="userstatus" class="form-control">
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                      </select>
                      <span class="help-block"></span>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
              <!-- /.box -->
              </div>
          <div class="col-md-6">
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <?php include('common/footer_content.php');?>
    <?php include('common/sidebar_control.php');?> 
</div>
<!-- ./wrapper -->
<?php include('common/footer.php');?>