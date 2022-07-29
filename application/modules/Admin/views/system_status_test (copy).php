<?php include('common/header.php');?>
<style type="text/css">
  /*.pid_image{margin: 198px 10px !important;}
  .box.pid_image h3 {position: absolute;top: -73%;left: 60px;}*/
  .pid_image:after{right: 120px!important;}
  .System_status_section1 .box ul {height: 135px;overflow: auto;}
  .System_status_section1 .box ul:hover {cursor: all-scroll;}
</style>  
<section>
    <div class="System_status">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-lg-12" >
            <?php 
              /*echo "<pre>";
              print_r($get_system_status);
              echo "</pre>";*/
            ?>
          </div>
          <div class="col-md-12 col-lg-12" >
            <div class="System_status_section1">
              <?php 
                $html = '';
                foreach ($get_system_status as $key => $system_status_value) {
                   $active_cls = '';
                   $pc_status = 'DOWN';
                   $wind_turbine_active_img = 'fan_brown.png';

                    $default_timezone = date_default_timezone_get();
                    $date = new DateTime("now", new DateTimeZone($default_timezone) );
                    $Current_time =  $date->format('Y-m-d H:i:s');

                    /*$current_time_after = strtotime($date->format('Y-m-d H:i:s'));
                    $current_time_after = $current_time_after + (1 * 60);
                    $Current_time = date("Y-m-d H:i:s", $current_time_after);*/

                    $before_30_time = strtotime($date->format('Y-m-d H:i:s'));
                    $before_30_time = $before_30_time - (3 * 60);
                    $Before_time = date("Y-m-d H:i:s", $before_30_time);

                   if($system_status_value['system_status_count'] > 0){
                    $system_status_value['system_status_count']['TimeStamp'];
                     if( $Current_time >= $system_status_value['system_status_count']['TimeStamp'] &&  $Before_time <= $system_status_value['system_status_count']['TimeStamp'] ){
                       //$html.='<p>Yes</p>';
                        $active_cls = 'active';
                        $pc_status = 'OK';
                        $wind_turbine_active_img = 'fan_green.png';
                     }else{
                       //$html.='<p>No</p>';
                     }
                   }
                   $html.='<div class="box '.$active_cls.'">';
                   //$html.='<p>Count = '.$system_status_value['system_status_count'].'</p> ';
                   $html.='<h3>'.$system_status_value['wind_turbine_name'].'</h3> ';
                   $html.='<img src="'.base_url.'adminasset/images/'.$wind_turbine_active_img.'">';
                   $html.='<ul>';
                   //$html.='<li>Camera NE-72 <span>OK</span></li>';
                   if($system_status_value['cameras'] != ''){
                     foreach ($system_status_value['cameras'] as $key => $camera_val) {
                        $html.='<li>'.$camera_val['Name'].' <span>OK</span></li>';
                     }
                   }
                   $html.='<li>'.$system_status_value['computer_name'].' <span>'.$pc_status.'</span></li>';

                   $script_arr = array();
                   if($system_status_value['system_status_scripts'] != ''){
                     foreach ($system_status_value['system_status_scripts'] as $key => $script_val) {
                        $script_arr[] = $script_val['Type'];
                        //$html.='<li>'.$script_val['Type'].' <span>OK</span></li>';
                     }

                      $unique_data = array_unique($script_arr);
                      foreach($unique_data as $val) {
                        $html.='<li>'.$val.' <span>OK</span></li>';
                      }

                   }
                   
                   $html.='</ul>';
                   $html.='</div>';
                }
                echo  $html;
              ?>

              <div class="box pid_image">
                <h3>PDL</h3>  
                <div class="manage_space"></div>
                <img src="<?php echo base_url; ?>adminasset/images/pld_img_new.png">
                <ul>
                  <!-- <li>PCDPL <span>OK</span></li> -->
                  <?php 
                  foreach ($get_pdl_names as $key => $pdl_name_value) {
                    ?>
                    <li><?php echo $pdl_name_value['Name']; ?> <span>OK</span></li>
                    <?php
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-lg-12" style="display: none;">
            <div class="System_status_section1">
              <div class="box">
                <h3>E7</h3> <img src="<?php echo base_url; ?>adminasset/images/fan_brown.png">
                <ul>
                  <li>Camera NE-72 <span>OK</span></li>
                  <li>Camera NE-72 <span>OK</span></li>
                  <li>PC E7 <span>OK</span></li>
                  <li>Probird E7<span>OK</span></li>
                  <li>4G<span>OK</span></li>
                </ul>
              </div>

              <div class="box">
                <h3>E7</h3> <img src="<?php echo base_url; ?>adminasset/images/fan_brown.png">
                <ul>
                  <li>Camera NE-72 <span>OK</span></li>
                  <li>Camera NE-72 <span>OK</span></li>
                  <li>PC E7 <span>OK</span></li>
                  <li>Probird E7<span>OK</span></li>
                  <li>4G<span>OK</span></li>
                </ul>
              </div>

              <div class="box">
                <h3>E7</h3> <img src="<?php echo base_url; ?>adminasset/images/fan_brown.png">
                <ul>
                  <li>Camera NE-72 <span>OK</span></li>
                  <li>Camera NE-72 <span>OK</span></li>
                  <li>PC E7 <span>OK</span></li>
                  <li>Probird E7<span>OK</span></li>
                  <li>4G<span>OK</span></li>
                </ul>
              </div>

              <div class="box">
                <h3>E7</h3> <img src="<?php echo base_url; ?>adminasset/images/fan_brown.png">
                <ul>
                  <li>Camera NE-72 <span>OK</span></li>
                  <li>Camera NE-72 <span>OK</span></li>
                  <li>PC E7 <span>OK</span></li>
                  <li>Probird E7<span>OK</span></li>
                  <li>4G<span>OK</span></li>
                </ul>
              </div>
          
              <div class="box active">
                <h3>E7</h3> <img src="<?php echo base_url; ?>adminasset/images/fan_green.png">
                <ul>
                  <li>Camera NE-72 <span>OK</span></li>
                  <li>Camera NE-72 <span>OK</span></li>
                  <li>PC E7 <span>OK</span></li>
                  <li>Probird E7<span>OK</span></li>
                  <li>4G<span>OK</span></li>
                </ul>
              </div>

              <div class="box active">
                <h3>E7</h3> <img src="<?php echo base_url; ?>adminasset/images/fan_green.png">
                <ul>
                  <li>Camera NE-72 <span>OK</span></li>
                  <li>Camera NE-72 <span>OK</span></li>
                  <li>PC E7 <span>OK</span></li>
                  <li>Probird E7<span>OK</span></li>
                  <li>4G<span>OK</span></li>
                </ul>
              </div>
             
              <div class="box_detail">
                <ul>
                  <li>PCDPL <span>OK</span></li>
                  <li>ProBird E1 - E2 HS</li>
                  <li>Alarm mail sent the 2021-08-11 at 09:15:20</li>
                  <li>Connexion OPC E1 - E2 <span>OK</span></li>
                  <li>Connexion OPC E3 - E4 - E5 - E6 - E7<span> OK</span></li>
                </ul>
              </div> 
            
            
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
<?php //include('common/footer.php');?>
