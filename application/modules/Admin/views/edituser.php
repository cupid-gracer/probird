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

              <div class="alert success-msg alert-dismissible" id="successs_msg" style="display: none;">
                    <button type="button" class="close" id="close_btn">×</button>
                    User Detail Updated SuccessFully..... 
              </div>

              <div class="box box-primary">
                <!-- form start -->
                <form role="form" id="update_user" action="" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formname">
                  <div class="box-body">
                    <input type="hidden" name="UserID" value="<?php  echo $user['UserID']; ?>">
                    <div class="form-group" id="Inputfirstname">
                      <label for="firstname" class="required">First Name</label>
                      <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" value="<?php echo $user['firstname']; ?>">
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group" id="Inputlastname">
                      <label for="lastname" class="required">Last Name</label>
                      <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" value="<?php echo $user['lastname']; ?>">
                      <span class="help-block"></span>
                    </div>
                    <?php if($user['image']!=''){ ?>
                    <div class="form-group" id="InputUser_profile_show" style="float: left;width: 100%;">
                            <img class="img-responsive" src="<?php echo base_url.'uploads/UserProfile/thumbnail/'.$user['image']); ?>">
                    </div>
                    <?php } ?>
                    <div class="form-group" id="Inputprofileimage">
                      <label for="picture" class="">Profile Image</label>
                      <table id="table" width="100%" style="margin: 0 auto;">
                        <thead>
                        </thead>
                        <tbody>
                          <tr class="add_row default_file">
                            <td width="70%">
                              <input class="coverimage" name='image' type='file' id="files" />
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
                      <span class="help-block"></span>
                    </div> 
                    <div class="form-group" id="Inputusername">
                      <label for="username" class="required">User Name</label>
                      <input type="text" class="form-control" id="username" name="username" placeholder="User Name" value="<?php echo $user['username']; ?>" disabled="disabled" autocomplete="off">
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group" id="Inputemail">
                      <label for="email" class="required">Email Address</label>
                      <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?php echo $user['email']; ?>" disabled="disabled" autocomplete="off">
                      <span class="help-block"></span>
                    </div>
                   
                    <div class="form-group" id="Inputuserrole">
                      <label for="userrole" class="required">Role</label>
                      <select id="userrole" name="userrole" class="form-control">
                          <option value="0" <?php if($user['userrole'] == 0){ echo 'selected="selected"'; } ?>  >Customer</option>
                          <option value="1" <?php if($user['userrole'] == 1){ echo 'selected="selected"'; } ?> >Administrator</option>
                      </select>
                      <span class="help-block"></span>
                    </div>
                    <div class="form-group" id="Inputuserstatus">
                      <label for="userstatus" class="required">Status</label>
                      <select id="userstatus" name="userstatus" class="form-control">
                          <option value="0" <?php if($user['userstatus'] == 0){ echo 'selected="selected"'; } ?> >Inactive</option>
                          <option value="1" <?php if($user['userstatus'] == 1){ echo 'selected="selected"'; } ?> >Active</option>
                      </select>
                      <span class="help-block"></span>
                    </div>

                    <?php 
                      

                      if($current_user == $user['UserID'])
                      {
                        ?>
                          <div class="form-group" id="Inputcheck_password">
                            <label><input type="checkbox" name="check_password" id="check_password" value="change_password_selected" > Change Password</label>
                            <span class="help-block"></span>
                          </div>
                          <div class="form-group" id="Inputoldpassword" style="display: none;">
                            <label for="oldpassword" class="required">Old Password</label>
                            <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Old Password" value="" autocomplete="off">
                            <span class="help-block"></span>
                          </div>
                          <div class="form-group" id="Inputnewpassword" style="display: none;">
                            <label for="newpassword" class="required">New Password</label>
                            <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password" value="" autocomplete="off">
                            <span class="help-block"></span>
                          </div>

                          <div class="form-group" id="Inputconfirmpassword" style="display: none;">
                            <label for="confirmpassword" class="required">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" value="" autocomplete="off">
                            <span class="help-block"></span>
                          </div>

                        <?php
                      }
                      else
                      {
                        //echo 'You are not eligible for Change password';
                      }

                    ?>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
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