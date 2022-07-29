<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pro-Bird | <?php echo $heading_title; ?></title>
  <!-- Google font family link -->
  <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>adminasset/css/bootstrap.min.css"> -->

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>adminasset/css/global/plugins.bundle.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>adminasset/css/global/prismjs.bundle.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>adminasset/css/global/style.bundle.min.css">


  <!-- custom style css link -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>adminasset/css/style.css">
  <!-- responsive css link -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url; ?>adminasset/css/responsive.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+HK:wght@100;300;400;500;700;900&display=swap" 
  rel="stylesheet"> </head> -->

<body>
  <!-- header start here -->
 
  <header style="top: 0; position:sticky; z-index:1000;">
    <section>
      <div class="header-section">
        <div class="container-fluid">
          <div class="row">
            <!--  <div class="col-md-2"> -->
            <div class="site-logo" style="background-color: white;">
              <a href="<?php echo base_url('admin'); ?>"> <img src="<?php echo base_url; ?>adminasset/images/logo2.png" class="logo"> </a>
            </div>
            <!--  </div> -->
            <!--    <div class="col-md-10"> -->
            <div class="header-section-2">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-5">
                    <ul class="menu">
                      <!-- <li><a href="#">Bernagues</a></li> -->
                      <li><a href="#">Capespigne</a></li>
                      <!-- <li><a href="#">Wind farm</a></li> -->
                    </ul>
                  </div>
                  <div class="col-md-12 col-lg-3">
                    <div class="logo_section"> <img src="<?php echo base_url; ?>adminasset/images/pro-bird-icon.png" class="logo"></div>
                  </div>
                  <div class="col-md-6 col-lg-2">
                    <div class="user_Sectiion"><i class="fa fa-user"></i>
                      <h3><?php echo $Surname; ?></h3>
                      <p><?php echo $Name; ?></p>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-2">
                    <div class="notification_Sectiion">
                      <ul>
                        <li> <a href="#"><i class="fa fa-bell"></i><!-- <span>1</span> --></a> </li>
                        <li> <a href="<?php echo base_url().'admin/logout'; ?>"><i class="fas fa-sign-out-alt"></i></a> </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <!-- </div> -->
              <?php
                    $leftMenu =array();
                    $leftMenu['dashboard']['title'] = 'Real Time';
                    $leftMenu['dashboard']['url'] = base_url().'admin';
                    $leftMenu['dashboard']['icon'] = 'time1.png';
                    $leftMenu['dashboard']['a_icon'] = 'time2.png';

                    $leftMenu['sytemstatus']['title'] = 'System status';
                    $leftMenu['sytemstatus']['url'] = base_url().'admin/sytemstatus';
                    $leftMenu['sytemstatus']['icon'] = 'System1.png'; 
                    $leftMenu['sytemstatus']['a_icon'] = 'System2.png'; 

                    $leftMenu['record']['title'] = 'Records';
                    $leftMenu['record']['url'] = base_url().'admin/records';
                    $leftMenu['record']['icon'] = 'System1.png'; 
                    $leftMenu['record']['a_icon'] = 'System2.png'; 

                    $leftMenu['reporting']['title'] = 'Reporting';
                    $leftMenu['reporting']['url'] = base_url().'admin/reporting';
                    $leftMenu['reporting']['icon'] = 'Reporting1.png'; 
                    $leftMenu['reporting']['a_icon'] = 'Reporting2.png'; 

                    $leftMenu['register']['title'] = 'Register';
                    $leftMenu['register']['url'] = base_url().'admin/register';
                    $leftMenu['register']['icon'] = 'Register1.png'; 
                    $leftMenu['register']['a_icon'] = 'Register2.png'; 

                    $leftMenu['contact']['title'] = 'Contact';
                    $leftMenu['contact']['url'] = base_url().'admin/contact';
                    $leftMenu['contact']['icon'] = 'Contact1.png'; 
                    $leftMenu['contact']['a_icon'] = 'Contact2.png'; 
              ?>      
              <div class="main_menu">
                <div class="col-md-12">
                  <ul id="ulCategory">
                    <?php foreach ($leftMenu as $key => $value) { ?>
                      <?php if($key==$active){$activeClass = 'active ';}else{ $activeClass = ' '; } ?>
                      <li  class="<?php echo $activeClass; ?>">
                        <a href="<?php echo $value['url']; ?>"><img src="<?php echo base_url; ?>adminasset/images/<?php echo $value['icon']; ?>" class="image1"><img src="<?php echo base_url; ?>adminasset/images/<?php echo $value['a_icon']; ?>" class="image2"><span><?php echo $value['title']; ?></span></a>
                      </li>
                    <?php } ?>                    
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Mobie View-->
      <div class="mobile_nav_menu">
        <!--  <div class="container-fluid"> -->
        <div class="mobile_logo_section">
          <div class="row">
            <div class="site-logo">
              <a href="<?php base_url(); ?>/admin"><img src="<?php echo base_url; ?>adminasset/images/logo.png" class="logo"> </a>
            </div>
            <div class="logo_section">
              <a href="#"> <img src="<?php echo base_url; ?>adminasset/images/pro-bird-icon.png" class="logo"> </a>
            </div>
            <div class="user_Section">
              <!-- <i class="fa fa-user"></i> --><span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; </span> </div>
          </div>
        </div>
        <div class="mobile_menu1">
          <ul class="menu">
            <li><a href="#">Brenagues</a></li>
            <li><a href="#">Capespigne</a></li>
            <li><a href="#">wind fram</a></li>
          </ul>
        </div>
        <div class="mobile_menu2">
          <ul id="ulCategory">
            <?php foreach ($leftMenu as $key => $value) { ?>
                <?php if($key==$active){$activeClass = 'active ';}else{ $activeClass = ' '; } ?>
                <li>
                  <a href="<?php echo $value['url']; ?>"> <img src="<?php echo base_url; ?>adminasset/images/<?php echo $value['icon']; ?>" class="image1"> <img src="<?php echo base_url; ?>adminasset/images/<?php echo $value['a_icon']; ?>" class="image2">
                    <p><?php echo $value['title']; ?></p>
                  </a>
                </li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <div id="nav_menu">
        <div id="mySidenav" class="sidenav"><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
          <div class="user_Section"><i class="fa fa-user"></i>
            <h3>Surname</h3>
            <p>Name</p>
          </div>
          <div class="notification_Section">
            <ul>
              <li> <a href="#"><i class="fa fa-bell"></i><span>1</span></a> </li>
              <li> <a href="<?php echo base_url().'admin/logout'; ?>"><i class="fa fa-sign-in"></i></a> </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- </div> -->
    </section>
  </header>
  <!-- header end here -->
