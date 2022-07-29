<?php include('common/header.php');?>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css'>
<link href="//vjs.zencdn.net/5.11/video-js.min.css" rel="stylesheet">
<link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
<script src="//vjs.zencdn.net/5.11/video.min.js"></script>
<style type="text/css">
  .content-carousel {width: 100%;display: block;margin: 0 auto;}
  .owl-prev, .owl-next {width: 22px;position: absolute;top: 34%;}
  .owl-prev {right: 1.2%;}
  .owl-next {left: 1%;}
  .owl-prev i, .owl-next i {color: #fff;font-size: 45px;}
  .owl-carousel .owl-item > div {margin-left: 0px;width: 100%;position: relative;}
  .owl-carousel .owl-item img {margin-left: 0px;}
  .top-left {position: absolute;top: 8px;left: 20px;color: #004366;font-weight: bold;}
  .get_cluster_time {text-align: center;color: #004366;font-weight: bolder;direction: ltr;}
  .owl-stage img { /*height: 25vh;*/}
  .get_tab_data_side img {width: 100%;/*height: 13vh;*/}
  .get_tab_data_side .custom_slide {position: relative;margin-bottom: 25px;cursor: pointer;}
  .get_tab_data_side .custom_slide .top_camera_right {position: absolute;top: 8px;right: 16px;color: #004366;font-weight: bold;}
  .get_cluster_resp {height: auto;}
  .main_section3{position: relative;}
  
  .lastslide_item {text-align: center;background-color: #008bcb;}
  .lastslide_item a {color: #fff;font-size: 22px;padding: 10%;display: block;}
  .main_section .range_section table tr td {position: relative;}
  span.active_gray_bg {background: #ddd;height: 100%;width: 100%;display: block;position: absolute;top: 0;left: 0;margin: 1px;}
  .active_blue_cls {background: #77BFE3 !important;}
  .range_section .tab-pane.active.in table tr td:nth-child(2) .active_gray_bg {background: #77BFE3 !important;}
  .main_section .modal-header {display: inline-block;padding: 8px 15px;}
  .main_section .modal-dialog {max-width: 50% !important;}
  .modal-backdrop {background-color: #000000b3;}
</style>

<section>
  <div class="main_section">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-lg-3">
          <div class="left_section">
            
            <ul class="Cluster">
              <?php 
                $count = 1;
                foreach ($get_clusters as $key => $value) {
                  ?>
                  <li class="cluster-list <?php if($count == 1){ echo 'active'; } ?>">
                    <a data-toggle="tab" href="#cluster-tab-<?php echo $value['ID']; ?>" aria-expanded="false" data-id="<?php echo $value['ID']; ?>" class="cluster_btn" >
                      <?php echo $value['Name']; ?> 
                    </a>
                  </li>
                  <?php
                  $count++;
                }
              ?>
            </ul>
            
            <div class="range_section tab-content">
              <?php 
                $count1 = 1;
                if(count($get_clusters) > 0){
                  foreach ($get_clusters as $key => $value) {
                    $active_blue_cls='';
                    if($count1 == 1){ $active_blue_cls = 'active_blue_cls'; } 
                    ?>
                    <div id="cluster-tab-<?php echo $value['ID']; ?>" class="tab-pane <?php if($count1 == 1){ echo 'in active'; } ?>">
                      <ul>
                        <li >
                          <a data-toggle="tab" href="#tab-cluster-detail-<?php echo $value['ID']; ?>">
                            <img src="<?php echo base_url; ?>adminasset/images/image3_blue.png" class="image1">
                            <img src="<?php echo base_url; ?>adminasset/images/image3.png" class="image2">
                          </a>
                        </li>
                        <li class="active">
                          <a data-toggle="tab" href="#tab-map-<?php echo $value['ID']; ?>">
                            <img src="<?php echo base_url; ?>adminasset/images/address_blue.png" class="image1">
                            <img src="<?php echo base_url; ?>adminasset/images/address_white.png" class="image2">
                          </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div id="tab-map-<?php echo $value['ID']; ?>" class="tab-pane in active">
                           <img src="<?php echo base_url; ?><?php echo $value['cluster_img_path']; ?>">
                        </div>

                        <div id="tab-cluster-detail-<?php echo $value['ID']; ?>" class="tab-pane">
                          <table class="table table-bordered" align="center" style="margin-top: 40px;">
                            <thead>
                              <tr>
                                <th>Camera Name</th>
                                <?php 
                                if(count($get_clusters) > 0){
                                  foreach ($get_clusters as $key => $get_cluster) {
                                    echo "<th>".$get_cluster['Name']."</th>";
                                  }
                                }
                                ?>
                              </tr>
                            </thead>
                            <tbody>
                              <input type="hidden" name="cluster_ids" class="cluster_unique" id="cluster_uniques" value="">
                              <?php

                                if(count($get_camera_clusters) > 0){
                                  $camera_count = 1;
                                  foreach ($get_camera_clusters as $key => $get_camera_cluster) {
                                    $row_active = '';
                                    ?>
                                    <tr class="<?php  //if($camera_count == 1){ echo 'active_blue_cls';} ?>" data-camera-id="<?php echo $get_camera_cluster['camera_id']; ?>" >
                                      <td><?php echo $get_camera_cluster['camera_name']; ?></td>
                                      <?php 
                                        foreach ($get_clusters as $key => $get_cluster) { 
                                        ?>
                                        <td class="" >
                                          <?php 
                                            foreach ($get_camera_cluster['clusters'] as $key => $cluster_value) {
                                              if($get_cluster['ID'] == $cluster_value['cluster_id']){
                                                echo "<span class='active_gray_bg clustre-".$get_cluster['ID']." '></span>";
                                              }
                                            }
                                          ?>
                                        </td>
                                      <?php } ?>
                                    </tr>
                                    <?php
                                    $camera_count++;
                                  }
                                }
                                /*if(count($get_cameras) > 0){
                                  foreach ($get_cameras as $key => $value01) {
                                    ?>
                                      <tr class="<?php if($value['ID'] == $value01['Cluster_ID']){ echo 'active_bg_cls';} ?>" >
                                        <td>
                                          <label for="volume"><?php echo $value01['Name']; ?></label>
                                        </td>
                                        <?php 
                                          foreach ($get_clusters as $key => $value02) {
                                            ?>
                                            <td class="<?php if($value02['ID'] == $value01['Cluster_ID']){ echo 'gray_bg';} ?>" >
                                            </td>
                                            <?php
                                          }
                                        ?>
                                      </tr>
                                    <?php
                                  }
                                }*/
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <?php
                    $count1++;
                  }
                }
              ?>
              <div id="wait-cluster"  class="loading-bar">
                <div class="circle-wrap">
                  <div class="circle">
                    <div class="mask full">
                      <div class="fill"></div>
                    </div>
                    <div class="mask half">
                      <div class="fill"></div>
                    </div>
                    <div class="inside-circle">
                    <div class="progress-title"></div>    
                    <div>
                      <span class="percent-value">0</span>%
                    </div>    
                  </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
        <div class="col-lg-9 col-md-12">
          <div class="right_section">
            
            <div class="row">
              <div class="col-md-3">
                <div class="get_tab_data_side"> 
                  <?php 
                    $media_img_count = 1;
                    if(count($get_medias_images) > 0){
                      foreach ($get_medias_images as $key01 => $get_medias_image) {
                        if($media_img_count == 1){
                          $media_img_count01 = 1;
                          foreach ($get_medias_image as $key => $value06) {
                            ?>
                            <div class="custom_slide" data-id="<?php echo $value06['WT_pack_ID']; ?>" >
                              <div class="top_camera_right" data-name="<?php echo $value06['camera_name']; ?>" >
                                <?php echo $value06['camera_name']; ?>
                              </div>
                              <img src="<?php echo $value06['path']; ?>">
                            </div>
                            <?php
                            $media_img_count01++;
                          }
                        }
                        $media_img_count++;
                      }
                    }
                  ?>
                </div>
                
                <div id="wait-turbine-thumbnails"  class="loading-bar">
                  <div class="circle-wrap">
                    <div class="circle">
                      <div class="mask full">
                        <div class="fill"></div>
                      </div>
                      <div class="mask half">
                        <div class="fill"></div>
                      </div>
                      <div class="inside-circle">
                      <div class="progress-title"></div>    
                      <div>
                        <span class="percent-value">0</span>%
                      </div>    
                    </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-9">

                <div class="get_cluster_resp">
                  <div id="tt" class="carousel slide" style="min-height: 200px;" data-interval="false" data-wrap="false" data-ride="carousel" data-pause="hover">
                    <div class="carousel-inner">
                      <?php if(count($getitems_first_five_images) > 0){ ?>
                        <div class="carousel-item lastslide_item">
                            <a id="load_more" href="#">
                              Load more
                            </a>
                          </div>
                        <?php
                          $getitems_first_five_images = array_slice($getitems_first_five_images, 0, 10); 
                          $getitems_first_five_images = array_reverse($getitems_first_five_images);
                          foreach ($getitems_first_five_images as $key => $getitems_first_five_image) {
                            ?>
                              <div class="carousel-item slide_item000 <?php if ($key == (count($getitems_first_five_images) -1)) echo 'active'?>" data-ID="<?php echo $getitems_first_five_image['ID']; ?>" data-wtpackid="<?php echo $getitems_first_five_image['WT_pack_ID']; ?>">
                                  <div class="top-left" data-name="<?php echo $getitems_first_five_image['camera_name']; ?>" >
                                    <?php echo $getitems_first_five_image['camera_name']; ?>
                                  </div>
                                  
                                  <!-- <img class="d-block w-100"  src="http://82.65.139.127/media/Capespigne/85_86/2022-07-13/Pictures/CAP-85-86_2022-07-13_08h16m08ss.jpg" alt="<?php echo $getitems_first_five_image['camera_name']; ?>"> -->
                                  <img class="d-block w-100 imgshow"  src="<?php echo base_url; ?><?php echo $getitems_first_five_image['Path']; ?>" alt="<?php echo $getitems_first_five_image['camera_name']; ?>">
                                  <div class="get_cluster_time">
                                    <?php  
                                      if (!empty(@$getitems_first_five_image['File_name'])) {
                                        $expl_un = explode('_', @$getitems_first_five_image['File_name']);
                                        $date = $expl_un[1];
                                        $expl_dot = explode('.', $expl_un[2]);
                                        $time = $expl_dot[0];
                                        echo $Newtime = $date.' '.$time;
                                      }
                                    ?>
                                  </div>
                              </div>
                              <?php
                          }
                        }
                        ?>
                    </div>
                    <a class="carousel-control-next" href="#tt" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                    <a class="carousel-control-prev" href="#tt" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>

                    
                    <div id="wait-turbine-images"  class="loading-bar">
                      <div class="circle-wrap">
                        <div class="circle">
                          <div class="mask full">
                            <div class="fill"></div>
                          </div>
                          <div class="mask half">
                            <div class="fill"></div>
                          </div>
                          <div class="inside-circle">
                          <div class="progress-title"></div>    
                          <div>
                            <span class="percent-value">0</span>%
                          </div>    
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="main_section3">
                  <div id="wait" class="loaderpostion">
                    <img src="<?php echo base_url.'adminasset/images/loading-gif-png-5.gif'; ?>">
                  </div>
                  <div class="Bird_Detaction_graph">
                    <h3>Bird Detections</h3> 
                    <div class="row">
                        <div class="col-md-12">
                          <!-- <div id="myPlot" style="width:100%;"></div> -->
                          <div id="myDiv" style="width:100%;"></div>
                        </div>
                    </div> 

                    <div id="wait-bird-graph"  class="loading-bar">
                      <div class="circle-wrap">
                        <div class="circle">
                          <div class="mask full">
                            <div class="fill"></div>
                          </div>
                          <div class="mask half">
                            <div class="fill"></div>
                          </div>
                          <div class="inside-circle">
                          <div class="progress-title"></div>    
                          <div>
                            <span class="percent-value">0</span>%
                          </div>    
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                        <div id="myModal" class="modal fade0" role="dialog" style="background-color: rgba(0,0,0,0.9);align-items: center;">
                          <div class="modal-dialog" style="max-width: 70% !important; height:90vh; align-items:center; display:flex;">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title" style="display: flex; align-items:center; justify-content:space-between;">
                                  <span>Video</span>
                                  <span id="video-name"></span>
                                  <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                                </h4>
                              </div>
                              <div class="modal-body">
                                <div class="form-popup" id="myForm">
                                    <video id="videoplayer100" width="100%" height="100%" controls autoPlay="autoPlay" style="border-radius: 5px;">
                                      <source id="video_res_100" src="" type="video/mp4" >
                                    </video>
                                </div>

                                <div class="form-popup" id="video_not_found">
                                    <center><h3>Video Not Found</h3></center>
                                </div>
                                
                              </div>
                              <div class="modal-footer" style="padding-top:0px; padding-bottom:3px;">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="modal_popup_id" style="display: none;"> Open Modal </button>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- The Modal -->
<div id="imgViewModal" class="modal">
  <div style="text-align: center; margin-top:100px">
    <span id="caption" style="color:white; font-size:25px;height:auto;"></span>
    <img class="modal-content" id="imgView">
  </div>
</div>



</section>

<?php include('common/footer.php');?>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js'></script>

<script type="text/javascript">
  jQuery(document).ready(function(){

  let progress_bird_grapah = rotateProgress("", 1, "wait-bird-graph", 99)
  let progress_cluster = rotateProgress("", 0.2, "wait-cluster", 100)
  
  var data_arrs_time = [];
  var data_arrs_date = [];
  var data_video = [];
  var arr_text = [];
  <?php 
  foreach ($get_bird_data as $key => $value) {
   ?>

  
    data_arrs_date['<?php echo $key; ?>'] = '<?php echo $value['birddate'] ?>';
    data_arrs_time['<?php echo $key; ?>'] = '<?php echo $value['birdtime'] ?>';
    data_video['<?php echo $key; ?>'] = '<?php echo $value['opc_order_id']; ?>';
    arr_text['<?php echo $key; ?>'] = '<?php echo $value['text']; ?>';
  <?php  } ?>

 

  var myPlot = document.getElementById('myDiv'),
  x = data_arrs_date,
  y = data_arrs_time,
  z = data_video,
  data = [{
          x:x, 
          y:y,  
          z:z, 
          text:arr_text,
          hovertemplate: '%{text}<extra></extra>',
          type:'scatter',
          mode:'markers',
          marker:{size:6}, 
        }],
  layout = {
    yaxis: {
      autotick: false,
      ticks: 'outside',
      tick0: 0,
      dtick: 1,
      tickcolor: '#fff'
    },
    hovermode:'closest',
    title:''
  };

  Plotly.newPlot('myDiv', data, layout, {scrollZoom: true});
  Plotly.relayout( "myDiv", {
      'xaxis.autorange': true,
  });
  myPlot.on('plotly_click', function(data){
      var opc_order_id = '';
      for(var i=0; i < data.points.length; i++){
        opc_order_id = data.points[i].data.z[data.points[0].pointNumber];
        //alert(opc_order_id);
        openForm(opc_order_id);
      }
      //alert('Video not Available');
  });

  clearProgress("", 'wait-bird-graph', progress_bird_grapah)
  });

  function recursive(){
        $('#load_more').click((e)=>{
          var id = $('.carousel-item:nth-child(2)').data('id');
          var WT_pack_ID = $('.carousel-item:nth-child(2)').data('wtpackid');
          data = {'WT_pack_ID': WT_pack_ID, 'ID':id };
          jQuery.ajax({
            type:'POST',
            url:'<?php echo base_url; ?>index.php/admin/get_slider_by_wt_pack_id',
            data : data,
            datatype: 'JSON',
            success:function(result){
              $('.carousel-item').first().remove();
              var response = JSON.parse(result);
              turbine_data = response.tab_data;
              $('.carousel-inner').prepend(renderCarousel(turbine_data))
              
              rotateProgress("", 10, "wait-turbine-images", 100)
              init()
            }
          });
        })
    }
    

</script>

<script>
  function openForm(opc_order_id) {
    var cluster_idd = jQuery("#cluster_uniques").val();
    
    data = "opc_order_id="+opc_order_id + "&cluster_idd="+cluster_idd;
    jQuery.ajax({
      type:'POST',
      url:'<?php echo base_url; ?>index.php/admin/get_video_by_opc_order_id',
      data : data,
      dataType: 'json',
      headers: {Range: "bytes=0-10000"},
      cache: false,
      processData: false,
      /*beforeSend: function(result){
        jQuery('#wait').show();
      },*/
      success:function(response){
              if(response.error){
            // $("#modal_popup_id").trigger("click");
            // document.getElementById("myForm").style.display = "none";
            $('#video-name').text("")
            // document.getElementById("video_not_found").style.display = "block";
            toastr.info("No video file");
        }else{
          /*video01 = 'http://82.65.139.127/media/Capespigne/80/2021-12-02/Videos/CAP-80_2021-12-02_14h31m19ss.mp4';
          loadVideo(video01);*/
          if(response.url){
            $("#modal_popup_id").trigger("click");
            // let videoName = response.url.split('/')[-1].split('_')[1] + ' ' + response.url.split('/')[-1].split('_')[2].split('.')[0]
            $('#video-name').text(response.videoName)
            document.getElementById("video_not_found").style.display = "none";
            document.getElementById("myForm").style.display = "block";
            var video = document.getElementById('videoplayer100');
            var mp4 = document.getElementById('video_res_100').src = response.url;
            video.load();
            video.play();
          }else{
            // $("#modal_popup_id").trigger("click");
            $('#video-name').text("")
            // document.getElementById("myForm").style.display = "none";
            // document.getElementById("video_not_found").style.display = "block";
            toastr.info("No video file");

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

  jQuery(document).ready(function(){
    jQuery(".modal-footer > button, .modal-title button").click(function() {
      jQuery('#videoplayer100').get(0).pause();
      document.getElementById('video_res_100').src = '';
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $(".owl-carousel").owlCarousel({    
      loop:false,
      items:1,
      margin:0,
      autoplay:false,
      nav:true,
      rtl:true,
      navText : ['<i class="fa fa-angle-right" aria-hidden="true"></i>','<i class="fa fa-angle-left" aria-hidden="true"></i>']
    });
    setTimeout(() => {
      let progress_turbine_images = rotateProgress("", 10, "wait-turbine-images", 100)
    }, 1000);
  });
</script>

<script type="text/javascript">
  function load_graph(data){
   
    var progress_bird_grapah = rotateProgress("", 1, "wait-bird-graph", 99)
    jQuery.ajax({
      type:'POST',
      url:'<?php echo base_url; ?>index.php/admin/get_graph_by_cluster',
      data : data,
      datatype: 'JSON',
      beforeSend: function(result){
        // jQuery('#wait').show();
      },
      success:function(result){

        var response = JSON.parse(result);
        if(response.cluster_graph_data){
          jQuery('#wait').hide();
          var data_arrs_time = [];
          var data_arrs_date = [];
          var data_video = [];
          var arr_text = [];
          jQuery.each( response.cluster_graph_data, function( index, value ) {
              data_arrs_time[index] = value.birdtime;
              data_arrs_date[index] = value.birddate;
              data_video[index] = value.opc_order_id;
              arr_text[index] = value.text;
          });

          var myPlot = document.getElementById('myDiv'),
          x = data_arrs_date,
          y = data_arrs_time,
          z = data_video,
          data = [{
                  x:x, 
                  y:y, 
                  z:z, 
                  text:arr_text,
                  hovertemplate: '%{text}<extra></extra>',
                  type:'scatter',
                  mode:'markers',
                  marker:{size:6},
                }],
          layout = {
            yaxis: {
              autotick: false,
              ticks: 'outside',
              tick0: 0,
              dtick: 1,
              tickcolor: '#fff'
            },
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
                opc_order_id = data.points[i].data.z[data.points[0].pointNumber];
                openForm(opc_order_id);
              }
          });
        }
        clearProgress("", 'wait-bird-graph', progress_bird_grapah)
      }
    });
  }

  jQuery(document).ready(function(){
    jQuery(".cluster_btn").click(function() {
      let isLoading = $('#wait-turbine-images').css('display') != 'none'
      if(isLoading){
        toastr.info('Please attempt this action after loading.')
        return;
      }
      var progress_cluster = rotateProgress("", 0.2, "wait-cluster", 100)
      var progress_thumbnails = rotateProgress("", 0.5, "wait-turbine-thumbnails", 99)
      
      $('.cluster-list').each(function(){
        $(this).removeClass('active')
      })
      $(this).closest('li').addClass('active')
      
      var ClusterID = jQuery(this).data("id");

      $('.tab-pane').each(function(){
        $(this).removeClass('active')
      })
      $('#cluster-tab-'+ClusterID).addClass('active')
      $('#tab-map-'+ClusterID).addClass('active')

      jQuery('.cluster_unique').val(ClusterID);
      jQuery('.active_gray_bg').removeClass('active_blue_cls');
      jQuery('.clustre-'+ClusterID).addClass('active_blue_cls');
      if(ClusterID !=''){
        data = {'ClusterID': ClusterID };
        jQuery.ajax({
          type:'POST',
          url:'<?php echo base_url; ?>index.php/admin/get_wt_packs_in_cluster',
          data : data,
          datatype: 'JSON',
          success:function(result){
            var response = JSON.parse(result);
            // jQuery('.get_cluster_resp').html(response.tab_data);
            turbine_data = response.tab_data;
            $('.carousel-inner').html(renderCarousel(turbine_data))
              init()
            rotateProgress("", 10, "wait-turbine-images", 100)
            
            jQuery('.get_cluster_time').html(response.tab_data_img);
            jQuery('.get_tab_data_side').html(response.tab_data_side);

            clearProgress("", "wait-turbine-thumbnails", progress_thumbnails)
            if(response.tab_data != '' && response.tab_data_img != '' && response.tab_data_side != ''){
              load_graph(data);
            }
          }
        });
      }
    });
  });
</script>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery("body").on("click", ".custom_slide", function() {
      let isLoading = $('#wait-turbine-images').css('display') != 'none'
      if(isLoading){
        toastr.info('Please attempt this action after loading.')
        return;
      }
      var WT_pack_ID = jQuery(this).data("id");
      if(WT_pack_ID !=''){
        data = {'WT_pack_ID': WT_pack_ID };
        jQuery.ajax({
          type:'POST',
          url:'<?php echo base_url; ?>index.php/admin/get_slider_by_wt_pack_id',
          data : data,
          datatype: 'JSON',
          success:function(result){
            var response = JSON.parse(result);
            turbine_data = response.tab_data;
            $('.carousel-inner').html(renderCarousel(turbine_data))
            init()
            rotateProgress("", 10, "wait-turbine-images", 100)
          }
        });

      }
    });

    
  });
</script>

<script type="text/javascript">
  function rotateProgress(title, time, id = "", value = 99){
    if(id !="") id = "#"+id
    if(id != "") $(id).css({display:"flex"})
    let percent = 0
    time = time * 10;
    var progress = setInterval(()=>{
      percent += 1;
      setProgress(percent, title, id)
      if(percent >= value) clearInterval(progress); 
      
    }, time);
    return progress;
  }

  function setProgress(percent, title="", id=""){
    $(id + ' .progress-title').text(title)
    $(id + ' .mask.full,' + id + ' .circle .fill').css({transform: 'rotate('+ 1.8 * percent +'deg)'})
    $(id + ' .percent-value').text(percent);
    if(percent >= 100 && id != "") {
        setTimeout(()=>{
          $(id).css({display:"none"})
        },1000)
      }
  }

  function clearProgress(title, dom_id="", interval_id){
    clearInterval(interval_id)
    setProgress(100, "", '#'+dom_id)
  }
</script>

<script type="text/javascript">
  function renderCarousel(data){
    data = data.reverse();
    var html = `<div class="carousel-item lastslide_item"><a id="load_more" href="#">Load more</a></div>`
    data.forEach((turbine, idx) => {
      html += `<div class="carousel-item slide_item000 `+ (data.length == (idx + 1)? "active": "") +`" data-id="${turbine.ID}" data-wtpackid="${turbine.WT_pack_ID}">
                <div class="top-left" data-name="${turbine.camera_name}" >${turbine.camera_name}</div>
                <img class="d-block w-100 imgshow"  src="${turbine.Path}" alt="${turbine.camera_name}">
                <div class="get_cluster_time">`
      if (turbine.File_name != null) {
        let expl_un = turbine.File_name.split('_');
        let date = expl_un[1];
        let expl_dot = expl_un[2].split('.');
        let time = expl_dot[0];
        let Newtime = date + ' ' + time;
        html += Newtime;
      }
      html += `</div></div>`;
    });

    return html;
  }
</script>

<script type="text/javascript">
  function imageView(){
    
    // Get the modal
    var modal = document.getElementById('imgViewModal');

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById('myImg');
    var modalImg = document.getElementById("imgView");
    var captionText = document.getElementById("caption");

    $('.imgshow').click(function(){
      modal.style.display = "flex";
      modalImg.src = $(this).attr('src');
      modalImg.alt = $(this).attr('alt');
      captionText.innerHTML = $(this).attr('alt')+'<br>'+$(this).next().text();
    })


    // When the user clicks on <span> (x), close the modal
    modal.onclick = function() {
      modalImg.className += " out";
        setTimeout(function() {
          modal.style.display = "none";
          modalImg.className = "modal-content";
        }, 400);
        
    }
  }

  function init(){
    imageView()
    recursive()
  }
  $(document).ready(()=>{
    init()
  })

</script>