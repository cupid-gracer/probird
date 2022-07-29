<?php include('common/header.php');?>
<section>
    <div class="register_section">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-12">
              <?php $success = $this->session->flashdata('success');  ?>
              <?php if(isset($success)){ ?>
              <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4>
                    <i class="icon fa fa-check"></i> 
                    <?php echo $this->session->flashdata('success'); ?>
                  </h4>
               </div>
              <?php  } ?>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="register_section1">

              <div class="register_inner_box">
                <h1>Registers</h1>
                <?php 
                  if($this->session->userdata('user_role') == 1){
                    ?>
                    <div class="add_file_btn" style="top: 15px;">
                      <a href="<?php echo base_url('admin/upload/register/'); ?>" >Add Register File</a>
                    </div>
                    <?php
                  }
                ?>
                <?php 
                  $DownLoadImage1 = base_url.'adminasset/images/download1.png';
                  $DownLoadImage2 = base_url.'adminasset/images/download2.png';

                  $RegisterHtml = '';
                  $RegisterHtml.='<ul>';
                  $final_arrs = array();
                  $main_directory = '/media/Capespigne/docs';
                  $scanned_directory = array_diff(scandir($main_directory), array('..', '.'));
                  if(in_array('Register',$scanned_directory)){
                    $scanned_directory = array_diff(scandir($main_directory.'/Register/'), array('..', '.'));
                    /*echo "<pre>";
                    print_r($scanned_directory);
                    echo "</pre>";*/
                    foreach ($scanned_directory as $key => $scanned_value) {
                      $RegisterHtml.='<li>';
                      $RegisterHtml.='<a href="'.$main_directory.'/Register/'.$scanned_value.'" download>';
                      $RegisterHtml.='<i class="fa fa-file" aria-hidden="true"></i>';
                      $RegisterHtml.='<span>'.$scanned_value.'</span>';
                      $RegisterHtml.='<img src="'.$DownLoadImage1.'" class="image1">';
                      $RegisterHtml.='<img src="'.$DownLoadImage2.'" class="image2">';
                      $RegisterHtml.='</a>';
                      $RegisterHtml.='</li>';
                    }
                  }
                  $RegisterHtml.='</ul>';
                  echo $RegisterHtml;
                ?>
              </div>
              <hr>
              <div class="register_inner_box">
                <h2>Reports</h2>
                <?php 
                  if($this->session->userdata('user_role') == 1){
                    ?>
                    <div class="add_file_btn">
                      <a href="<?php echo base_url('admin/upload/reporting/'); ?>" >Add Report File</a>
                    </div>
                    <?php
                  }
                ?>
                <?php 
                  $RepportHtml = '';
                  $RepportHtml.='<ul>';
                  $final_arrs = array();
                  $main_directory = '/media/Capespigne/docs';
                  $scanned_directory = array_diff(scandir($main_directory), array('..', '.'));
                  if(in_array('Repport',$scanned_directory)){
                    $scanned_directory = array_diff(scandir($main_directory.'/Repport/'), array('..', '.'));
                    /*echo "<pre>";
                    print_r($scanned_directory);
                    echo "</pre>";*/
                    foreach ($scanned_directory as $key => $scanned_value) {
                      $RepportHtml.='<li>';
                      $RepportHtml.='<a href="'.$main_directory.'/Repport/'.$scanned_value.'" download>';
                      $RepportHtml.='<i class="fa fa-file" aria-hidden="true"></i>';
                      $RepportHtml.='<span>'.$scanned_value.'</span>';
                      $RepportHtml.='<img src="'.$DownLoadImage1.'" class="image1">';
                      $RepportHtml.='<img src="'.$DownLoadImage2.'" class="image2">';
                      $RepportHtml.='</a>';
                      $RepportHtml.='</li>';
                    }
                  }
                  $RepportHtml.='</ul>';
                  echo $RepportHtml;
                ?>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php include('common/footer.php');?>
<script type="text/javascript">
  $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert-success").slideUp(500);
  });
</script>