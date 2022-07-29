<?php include('common/header.php');?>
<style type="text/css">
  .pid_image:after{/*right: 120px!important;*/}
  .System_status_section1 .box ul {height: 220px; overflow: auto; padding:20px;}
  .System_status_section1 .box ul.innerScript {height: 130px;overflow: auto; border-width: 0px;}
  .System_status_section1 .box ul:hover {cursor: pointer;}

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
          <div class="col-md-12 col-lg-12">
            <input type="hidden" id="interval_time" value="<?= INTERVAL_TIME ?>"/>
            <div class="System_status_section1">

              <?php
                $html = '';
                $connect_count = 1;
                $first_connect = true;
                foreach ($wind_turbines as $key => $wind_turbine) {
                  if(($key)%6 == 0) $html.= '<div class="row boxes">';
                  $html.='<div class="box '.($wind_turbine['active']? 'turbine-active' :'turbine-inactive').'">';
                  $html.='<h3>'.$wind_turbine['Name'].'</h3> ';
                  $html.='<img src="'.base_url.'adminasset/images/'.(($wind_turbine['Type'] == 'PDL' )? ($wind_turbine['active']? 'pld_green.png': 'pld_img_new.png') : ($wind_turbine['active']? 'fan_green.png': 'fan_brown.png')).'">';

                  if(count($wind_turbine['computers'])){
                    $html.='<ul>';
                    foreach ($wind_turbine['computers'] as $computer) {
                      $html.='<li style="color:#008bcb">'.$computer['c_name'].'</li>';
                      if(count($computer['script'])){
                        foreach ($computer['script'] as $sc) {
                          $html.='<li style="'.($sc['status']? 'color:green':'color:gray' ).'">'.$sc['sc_name'].'</li>';
                        }
                      }
                    }
                    $html.='</ul>';
                    if(!$first_connect){
                      // $html.='<div class="connect" style="width:'. ($connect_count * 170  ).'px !important;"></div>';
                    }
                    $first_connect = false;
                    $connect_count = 0;
                  }
                  else{
                    $html.='<ul style="border:0px"></ul>';
                  }
                  $html.='</div>';
                  $connect_count++;
                  if(($key)%6 == 5) $html.= '</div>';
                }
                for ($i=0; $i < (6 - count($wind_turbines)%6); $i++) { 
                  $html.='<div class="box"></div>';
                }
                if(count($wind_turbines)%6 != 5 ) $html.= '</div>';
                echo($html);
              ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php include('common/footer.php');?>

<script type="text/javascript" src="/adminasset/js/systemstatus.js"></script>