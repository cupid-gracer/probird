<?php include('common/header_outer.php');?>
   <style type="text/css">
      .has-error .help-block {
          color: red;
          font-weight: 600;
          font-size: 12px;
      }
   </style>
<main>
      <div class="login_section">
         <div class="container">
            <div class="row">
               <div class="col-md-3"> </div>
               <div class="col-md-6">
                  <div class="login_form1"> </div>
                  <div class="logo_div1"> <img src="<?php echo base_url; ?>adminasset/images/pro-bird-icon.png"> <img src="<?php echo base_url; ?>adminasset/images/logo.png" class="logo"> </div>
                  <div class="login_form2">
                     <h1>Login to dashboard</h1>
                     <form id="userlogin" action="" method="post" class="loginform">
                        <div class="main_filed">
                           <div class="col-md-12 form-group" id="Inputusernamepassword">
                             <span class="help-block"></span>
                           </div>
                        </div>   
                        <div class="main_filed">
                           <div class="col-md-12 form-group" id="Inputusername">
                              <input type="text" class="filed" placeholder="User name" id="Name" name="username"> <img src="<?php echo base_url; ?>adminasset/images/user.png"> 
                              <span class="help-block"></span>
                           </div>
                        </div>
                        <div class="main_filed form-group" id="Inputpassword">
                           <div class="col-md-12">
                              <input type="password" placeholder="Password" class="filed" id="password" name="password"> <img src="<?php echo base_url; ?>adminasset/images/password.png"> 
                              <span class="help-block"></span>
                           </div>
                        </div>
                        <div class="main_filed">
                           <div class="col-md-12">
                              <input type="checkbox" value="lsRememberMe" id="rememberMe">
                              <label for="rememberMe">Remember</label>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form_button">
                              <button type="submit">Login</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="col-md-3"> </div>
            </div>
         </div>
      </div>
   </main>
<?php include('common/footer_outer.php');?>

