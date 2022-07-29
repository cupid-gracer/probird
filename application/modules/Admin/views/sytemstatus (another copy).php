<?php include('common/header.php');?>
  
<section>
    <div class="System_status">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-lg-12">
            <div class="System_status_section1">
              <?php foreach ($get_wind_turbine as $key => $value) { ?>
              <div class="box">
                <h3><?php echo $value['Name']; ?></h3> <img src="<?php echo base_url; ?>adminasset/images/fan_brown.png">
                <ul>
                  <li>Camera NE-72 
                  <?php if (!empty($computers)) { ?>     
                    <span>OK</span>
                  <?php } ?>  
                  </li>
                  <!-- <li>Camera NE-72<span>OK</span></li>    --> 
                  <li>PC E7 <span>OK</span></li>
                  <li>Probird E7<span>OK</span></li>
                  <li>4G<span>OK</span></li>
                  <!--<?php foreach ($computers as $key_computer => $value_computer) { ?>
                  	<li><?php var_dump($value_computer); ?></li>
                  <?php } ?>-->
                </ul>
              </div>
              <?php } ?>
           <!--    <div class="box">
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
              </div> -->
            
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php include('common/footer.php');?>
