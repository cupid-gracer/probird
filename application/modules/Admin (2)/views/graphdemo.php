<?php include('common/header.php');?>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css'>
<style type="text/css">
  .content-carousel {width: 100%;display: block;margin: 0 auto;}
  .owl-prev, .owl-next {width: 22px;position: absolute;top: 34%;}
  .owl-prev {left: 1%;}
  .owl-next {right: 1%;}
  .owl-prev i, .owl-next i {color: #fff;font-size: 45px;}
  .owl-carousel .owl-item > div {margin-left: 0px;}
  .owl-carousel .owl-item img {margin-left: 0px;}
  .top-left {position: absolute;top: 8px;left: 35px;color: #004366;font-weight: bold;}
  .get_cluster_time {text-align: center;color: #004366;font-weight: bolder;}
  .owl-stage img { /*height: 25vh;*/}
  .get_tab_data_side img {width: 100%;/*height: 13vh;*/}
  .get_tab_data_side .custom_slide {position: relative;margin-bottom: 25px;cursor: pointer;}
  .get_tab_data_side .custom_slide .top_camera_right {position: absolute;top: 8px;right: 16px;color: #004366;font-weight: bold;}
  .get_cluster_resp {height: auto;}
  .main_section3{position: relative;}
  .loaderpostion {display: none;position: absolute;z-index: 9;width: 98%;height: 98%;background: #ffffffde;text-align: center;margin: 0 auto;top:10px;left:10px;}
  .loaderpostion img {margin: 0 auto;position: absolute;top: 32%;left: 0;right: 0;width: 100px !important;}
  .lastslide_item {text-align: center;background-color: #77BFE3;}
  .lastslide_item a {color: #fff;font-size: 22px;padding: 10%;display: block;}

  /* Button used to open the contact form - fixed at the bottom of the page */
.open-button {background-color: #555;color: white;padding: 16px 20px;border: none;cursor: pointer;opacity: 0.8;position: fixed;bottom: 23px;right: 28px;width: 280px;}
/* The popup form - hidden by default */
.form-popup {display: none;position: relative;top: 9%;border: 3px solid #f1f1f1;z-index: 9;}
/* Add styles to the form container */
.form-container {max-width: 100%;padding: 10px;background-color: white;}

/* Set a style for the submit/login button */
.form-container .btn {background-color: #04AA6D;color: white;padding: 16px 20px;border: none;cursor: pointer;
width: 100%;margin-bottom:10px;opacity: 0.8;}
/* Add a red background color to the cancel button */
.form-container .cancel {background-color: red;}
/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {opacity: 1;}
</style>
<section>
  <div class="main_section">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-9">
          <?php
            /*$dir    = '/media/Capespigne';
            $files1 = scandir($dir);
            $files2 = scandir($dir, 1);*/

            /*echo "<pre>";
            print_r($get_bird_data);
            echo "</pre>";*/
          ?>
          <div class="main_section3">
            <div id="wait" class="loaderpostion">
              <img src="https://dev.infosparkles.com/drivenn/wp-content/themes/drivenn/assets/images/loading-gif-png-5.gif">
            </div>

            <!-- <video width="320" height="240" controls>
              <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
              <source src="movie.ogg" type="video/ogg">
              Your browser does not support the video tag.
            </video> -->

            <div class="Bird_Detaction_graph">
              <h3>Bird Detection</h3> 
              <div class="row">
                  <div class="col-md-12">
                    <div id="myDiv" style="width:100%;"></div>
                  </div>
              </div> 
            </div>
          </div>
        </div>
        <div class="col-md-3">

          <!-- <div class="form-popup1" id="myForm1">
            <div class="form-container">
              <h3>Video</h3>
              <video id="videoplayer1" width="240" height="160" controls autoPlay="autoPlay">
                  <source id="video_res_1" src="http://82.65.139.127/media/Capespigne/80/2021-12-02/Videos/CAP-80_2021-12-02_13h24m33ss.mp4" type="video/mp4">
              </video>
            </div>
          </div> -->

          <div class="form-popup" id="myForm">
            <div class="form-container">
              <h3>Video</h3>
              <video id="videoplayer100" width="100%" height="100%" controls autoPlay="autoPlay">
                  <source id="video_res_100" src="" type="video/mp4">
              </video>
              <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
            </div>
          </div>

          <div class="form-popup" id="video_not_found">
            <div class="form-container">
              <h3>Video Not Found</h3>
              <button type="button" class="btn cancel" onclick="close_video_not_found()">Close</button>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
</section>
<?php include('common/footer.php');?>


<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js'></script>

<script type="text/javascript">
  var data_arrs_time = [];
  var data_arrs_date = [];
  var data_video = [];
  <?php foreach ($get_bird_data as $key => $value) { ?>
    data_arrs_time['<?php echo $key; ?>'] = '<?php echo $value['birdtime'] ?>';
    data_arrs_date['<?php echo $key; ?>'] = '<?php echo $value['birddate'] ?>';
    data_video['<?php echo $key; ?>'] = '<?php echo $value['opc_order_id']; ?>';
  <?php  } ?>
  console.log(data_arrs_time);

  var myPlot = document.getElementById('myDiv'),
  x = data_arrs_date,
  y = data_arrs_time,
  z = data_video,
  data = [{
          x:x, 
          y:y, 
          z:z, 
          type:'scatter',
          mode:'markers'
        }],
  layout = {
    hovermode:'closest',
    title:''
  };

  Plotly.newPlot('myDiv', data, layout);
  Plotly.relayout( "myDiv", {
      'xaxis.autorange': true,
  });
  myPlot.on('plotly_click', function(data){
      var opc_order_id = '';
      for(var i=0; i < data.points.length; i++){
        //console.log(data.points[i].data.z[data.points[0].pointNumber]);
        opc_order_id = data.points[i].data.z[data.points[0].pointNumber];
        //alert(opc_order_id);
        openForm(opc_order_id);
      }
      //alert('Video not Available');
  });
</script>

<script>
  /*function loadVideo(video_url)
  {
    document.getElementById("myForm").style.display = "block";
    var video = document.getElementById('videoplayer100');
    var mp4 = document.getElementById('video_res_100').src = video_url;
    video.load();
    video.play();
  }*/

  function openForm(opc_order_id) {
    data = "opc_order_id="+opc_order_id;
    jQuery.ajax({
      type:'POST',
      url:'<?php echo base_url; ?>index.php/admin/get_video_by_opc_order_id',
      data : data,
      dataType: 'json',
      cache: false,
      processData: false,
      /*beforeSend: function(result){
        jQuery('#wait').show();
      },*/
      success:function(response){
        
        if(response.error){

        }else{
          //video01 = 'http://82.65.139.127/media/Capespigne/80/2021-12-02/Videos/CAP-80_2021-12-02_14h31m19ss.mp4';
          //loadVideo(video01);
          console.log(response.url);
          if(response.url){
            document.getElementById("video_not_found").style.display = "none";
            document.getElementById("myForm").style.display = "block";
            var video = document.getElementById('videoplayer100');
            var mp4 = document.getElementById('video_res_100').src = response.url;
            video.load();
            video.play();
          }else{
            document.getElementById("myForm").style.display = "none";
            document.getElementById("video_not_found").style.display = "block";
            
          }
        }
      }
    });
    return false;
  }

  function closeForm() {
    document.getElementById("myForm").style.display = "none";
  }

  function close_video_not_found() {
    document.getElementById("video_not_found").style.display = "none";
  }
</script>