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

        <div class="row">
          <div class="col-md-12">
              <?php $success = $this->session->flashdata('success');  ?>
              <?php if(isset($success)){ ?>
              <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4 style="margin-bottom: 0;">
                    <i class="icon fa fa-check"></i> <?php echo $this->session->flashdata('success'); ?>
                  </h4>
               </div>
              <?php  } ?>
          </div>
        </div> 
        <!-- Info boxes -->
        <div class="row">
          
          <div class="col-md-12">
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>User Name</th>
                    <th>Email Address</th>
                    <th> Action</th>
                  </tr>
                  <?php foreach ($users as $key => $value) { ?>
                      <tr>
                        <td><?php echo $value->UserID; ?></td>
                        <td><?php echo $value->firstname; ?></td>
                        <td><?php echo $value->lastname; ?></td>
                        <td><?php echo $value->username; ?></td>
                        <td><?php echo $value->email; ?></td>
                        <td>
                          <a href="<?php echo base_url(); ?>admin/edituser/<?php echo $value->UserID; ?>"> 
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
                          </a> 
                          <a href="<?php echo base_url(); ?>admin/deleteuser/<?php echo $value->UserID; ?>"> 
                            <i class="fa fa-trash-o" aria-hidden="true" onClick="return doconfirm();"></i> 
                          </a>
                        </td>
                      </tr>
                  <?php }  ?>    
                </table>
              </div>

              <div class="pagination_main"><?php echo $links; ?></div>

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