<?php include('common/header.php');?>
<section>
  <div class="register_section">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="upload_section1">
            <h2>Uplaod Register File</h2>
            <?php 
              $MsgHtml = '';
              if(count($upload_msg) > 0){
                if($upload_msg['error'] == 'false'){
                  $MsgHtml.='<div class="alert alert-success">';
                  $MsgHtml.='<strong>Success!</strong>'.$upload_msg['msg'].' ';
                  $MsgHtml.='</div>';
                }else{
                  $MsgHtml.='<div class="alert alert-danger">';
                  $MsgHtml.='<strong>Error!</strong>'.$upload_msg['msg'].' ';
                  $MsgHtml.='</div>';
                }
                /*echo "<pre>";
                print_r($upload_msg);
                echo "</pre>";*/
              }
              echo $MsgHtml;
            ?>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <input type="file" name="report_file" class="form-control">
              </div>

              <div class="form-group">
                <button type="submit" class="upload_file">Upload File</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include('common/footer.php');?>
