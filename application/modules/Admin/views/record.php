<?php include('common/header.php'); ?>
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css'> -->


<style type="text/css">
  .main_block .main_block_hour_section {
    top: 20px;
    z-index: 99;
  }

  .main_block .file_section {
    margin-top: 22px;
    position: unset;
  }

  .main_block .Data_Volume_section {
    top: 0px;
    position: relative;
  }

  .main_block_date_section input[type="text"],
  .main_block_hour_section input[type="text"] {
    width: 100%;
  }

  .main_section .left_section .Cluster>li label {
    width: 100%;
    cursor: pointer;
    padding: 10%;
    display: block;
    color: #fff;
    font-size: 72%;
    text-align: center;
    font-weight: 400;
    margin: 0;
  }

  .main_section .left_section .Cluster>li label>input[type=checkbox] {
    display: none;
  }

  .cluster_img {
    margin-bottom: 20px;
    position: relative;
  }

  .cluster_img p {
    margin-bottom: 0px;
    background: #fff9;
    position: absolute;
    padding: 4px 15px;
    color: #004366;
    font-weight: 600;
  }

  .record_section .Camera_Angles_select_section ul li label {
    position: relative;
    width: 100%;
  }

  .record_section .Camera_Angles_select_section ul li label>input[type=checkbox] {
    /* width: 15px;
    height: 15px; */
  }

  .record_section .Camera_Angles_select_section span {
    /* position: absolute; */
    margin-left: 25px;
  }

  .record_section .Camera_Angles_select_section input[type="checkbox"]:checked+span {
    color: #008BCB;
  }

  .main_block_date_section .ui-widget.ui-widget-content {
    width: 100%;
  }

  .main_block_date_section .ui-datepicker table {
    font-size: 12px;
  }

  .cluster-label{
    display: flex;
    align-items: center !important;
  }

  .checkbox_manage{
    display: block !important;
  }

  
.circle-wrap {
  margin: 150px auto;
  width: 150px;
  height: 150px;
  background: #fefcff;
  border-radius: 50%;
  border: 1px solid #cdcbd0;
}

.circle-wrap .circle .mask,
.circle-wrap .circle .fill {
  width: 150px;
  height: 150px;
  position: absolute;
  border-radius: 50%;
}

.circle-wrap .circle .mask {
  clip: rect(0px, 150px, 150px, 75px);
}

.circle-wrap .inside-circle {
  width: 122px;
  height: 122px;
  border-radius: 50%;
  background: #d2eaf1;
  line-height: 120px;
  text-align: center;
  margin-top: 14px;
  margin-left: 14px;
  color: #008bcb;
  position: absolute;
  z-index: 100;
  font-weight: 700;
  font-size: 2em;
}

.mask .fill {
  clip: rect(0px, 75px, 150px, 0px);
  background-color: #227ded;
}

.mask.full,
.circle .fill {
  transform: rotate(0deg);
}

.inside-circle{
  position: absolute;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.inside-circle div{
  line-height: 30px;
}

.percent-value{
  font-size: 35px;
}

.progress-title{
  font-size: 15px;
}
</style>


<section>
  <div class="main_section">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-lg-3">
          <div class="left_section">

            <form id="ClusterFormID">
              <ul class="Cluster">
                <?php
                $cluster_count = 1;
                foreach ($get_clusters as $key => $value) {
                  $cluster_check = '';
                  $active_class = '';
                  if ($cluster_count == 1) {
                    $cluster_check = "checked='checked'";
                    $active_class = 'active';
                  }

                ?>
                  <li class="<?php echo $active_class; ?>">
                    <label for="<?php echo 'Cluster-id-' . $value['ID']; ?>">
                      <input type="checkbox" name="ClusterIDs[]" value="<?php echo $value['ID']; ?>" data-id="<?php echo $value['ID']; ?>" id="<?php echo 'Cluster-id-' . $value['ID']; ?>" class="cluster_checkbox" <?php echo $cluster_check; ?>>
                        <?php echo $value['Name']; ?>
                    </label>
                  </li>
                <?php
                  $cluster_count++;
                }
                ?>
              </ul>
            </form>

            <div class="range_section">
              <?php
              $cluster_count = 1;
              foreach ($get_clusters as $key => $value) {
                $display_block = 'display:none;';
                if ($cluster_count == 1) {
                  $display_block = "display:block;";
                }
              ?>
                <div class="cluster_img" id="img-<?php echo $value['ID']; ?>" style="<?php echo $display_block; ?>">
                  <p><?php echo $value['Name']; ?></p>
                  <img src="<?php echo $value['cluster_img_path']; ?>">
                </div>
              <?php
                $cluster_count++;
              }
              ?>
            </div>

          </div>
        </div>
        <div class="col-md-12 col-lg-9">
        
        


          <div class="record_section">
            <div class="col-md-12">
              <h3>Camera Angles</h3>
              <form id="DownloadFormID" method="post">
                <div class="row manage section">
                  <div class="col-md-3">
                    <div class="Camera_Angles_select_section">
                      <div id="camera_loader" class="progress_loader">
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
                                <span class="percent-value" style="margin-left:0 !important">0</span>%
                              </div>    
                            </div>
                          </div>
                        </div>
                      </div>

                      <ul id="ulCategory" class="get_camera_resp">
                        <?php
                        $html_camera = '';
                        if ($get_wind_turbine_pack != '') {
                          $html_camera .= '<li>';
                          $html_camera .= '<label class="cluster-label" for="camera-id-' . $get_wind_turbine_pack['CameraID'] . '">';
                          $html_camera .= '<input type="checkbox" name="cluster_name[]" value="' . $get_wind_turbine_pack['CameraID'] . '" checked="checked" id="camera-id-' . $get_wind_turbine_pack['CameraID'] . '" >';
                          $html_camera .= '<span>' . $get_wind_turbine_pack['CameraName'] . '</span>';
                          $html_camera .= '</label>';
                          $html_camera .= '</li>';
                        }
                        echo $html_camera;
                        ?>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <?php $Get_Current_Date_Time = new DateTime("now", new DateTimeZone(DEFAULT_TIMEZONE)); ?>
                    <div class="main_block">

                      <div id="download_loader" class="progress_loader">
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
                        <!-- <img src="<?php echo base_url . 'adminasset/images/loading-gif-png-5.gif'; ?>"> -->
                      </div>

                      


                      <div class="form-group row">
                        <input type="hidden" id="from_datepicker" name="from_date" value="" />
                        <input type="hidden" id="to_datepicker" name="to_date" value="" />
                        <label class="col-form-label col-lg-12 col-sm-12 text-left">Date Range *</label>
                        <div class="col-lg-8 col-md-12 col-sm-12">
                          <div class="input-group" id="kt_daterangepicker">
                            <input type="text" class="form-control" readonly name="daterangepicker" placeholder="Select date range" />
                            <div class="input-group-append">
                              <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                            </div>
                          </div>
                          <span class="form-text text-muted">Select a date range</span>
                        </div>
                      </div>
                      <input id="timepicker_from" name="from_time" type="hidden" />
                      <input id="timepicker_to" name="to_time" type="hidden" />
                      <input id="filesize" type="hidden" />

                      <button type="button" class="data_volume_btn" style="margin-bottom: 15px;">
                        Calculate Data Volume
                      </button>

                      <button type="button" class="download_button" id="download_button" style="display: none;">
                        Download Files
                      </button>

                      <!-- <div class="main_block_date_section">
                        <div class="row">
                          <div class="col-md-4 col-lg-4">
                            <lable>Date</lable>
                            <br>
                            <input type="text" id="from_datepicker" name="from_date" value="<?php echo $Get_Current_Date_Time->format('Y-m-d'); ?>">
                            <div id="default_from_datepicker"></div>
                          </div>
                          <div class="col-md-4 col-lg-4">
                            <lable>Date</lable>
                            <br>
                            <input type="text" id="to_datepicker" name="to_date" value="<?php echo $Get_Current_Date_Time->format('Y-m-d'); ?>">
                            <div id="default_to_datepicker"></div>
                          </div>

                          <div class="col-md-4 col-lg-4">
                            <img src="<?php echo base_url; ?>adminasset/images/Group704.png">
                          </div>
                        </div>
                      </div>

                      <div class="main_block_hour_section">
                        <div class="row">
                          <div class="col-md-4">
                            <lable>Hour</lable>
                            <br>
                            <input value="<?php echo $Get_Current_Date_Time->format('H:i:s'); ?>" type="text" name="from_time" id="timepicker_from">
                          </div>
                          <div class="col-md-4">
                            <lable>Hour</lable>
                            <br>
                            <input value="<?php echo $Get_Current_Date_Time->format('H:i:s'); ?>" type="text" name="to_time" id="timepicker_to">
                          </div>
                          <div class="col-md-4">
                            <lable>&nbsp;</lable>
                            <br>
                            <button type="button" class="data_volume_btn" style="margin-bottom: 15px;">
                              Calculate Data Volume
                            </button>

                            <button type="submit" class="download_button">
                              Download Files
                            </button>
                          </div>
                        </div>
                      </div> -->

                      <div class="row">
                        <div class="col-md-8">
                          <div class="file_section">
                            <lable>Data Type</lable>
                            <ul>
                              <li>
                                <input type="radio" name="file_type" value="1" id="ExcelFileID">
                                <label for="ExcelFileID">Excel File</label>
                              </li>

                              <li>
                                <input type="radio" name="file_type" value="4" id="Picture_Video" checked>
                                <label for="Picture_Video">Picture + Video</label>
                              </li>

                              <li class="checkbox_manage">
                                <input type="checkbox" name="file_type_video_img[]" value="Picture" id="PicturesFileID" checked>
                                <label for="PicturesFileID">Stacked Pictures</label>
                              </li>
                              <li class="checkbox_manage">
                                <input type="checkbox" name="file_type_video_img[]" value="Video" id="VideosFileID" checked>
                                <label for="VideosFileID">Videos</label>
                              </li>

                              <!-- <li>
                                <input type="radio" name="file_type" value="2"  id="PicturesFileID">
                                <label for="PicturesFileID">Stacked Pictures</label>
                              </li>
                              <li>
                                <input type="radio" name="file_type" value="3" id="VideosFileID">
                                <label for="VideosFileID">Videos</label>
                              </li> -->
                            </ul>
                          </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-8">
                          <div class="Data_Volume_section">
                            <lable>Data Volume</lable>
                            <p><?php //echo $file_ext.' - '.$file_count; 
                                ?></p>
                            <h2 style="font-size: 16px;"></h2>
                          </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                      </div>

                    </div>

                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include('common/footer.php'); ?>

<!-- <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script> -->
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script> -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js'></script>
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js'></script> -->

<script type="text/javascript" src="/adminasset/js/pages/record/form-widgets.js"></script>
<!-- <script type="text/javascript" src="/adminasset/js/global/widgets.js"></script> -->

<script type="text/javascript">
  $("#default_from_datepicker").datepicker({
    changeMonth: true,
    changeYear: true,
    maxDate: 0,
    onSelect: function() {
      var dateText = $.datepicker.formatDate("yy-mm-dd", $(this).datepicker("getDate"));
      $('#from_datepicker').val(dateText);
    }
  });

  $("#default_to_datepicker").datepicker({
    changeMonth: true,
    changeYear: true,
    maxDate: 0,
    onSelect: function() {
      var dateText = $.datepicker.formatDate("yy-mm-dd", $(this).datepicker("getDate"));
      $('#to_datepicker').val(dateText);
    }
  });

  $("#timepicker_from, #timepicker_to").datetimepicker({
    format: 'HH:mm:ss',
    icons: {
      up: "fa fa-chevron-up",
      down: "fa fa-chevron-down"
    }
  });
</script>

<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery(".cluster_btn").click(function() {
      var Cluster_ID = jQuery(this).data("id");
      if (Cluster_ID != '') {
        data = {
          'Cluster_ID': Cluster_ID
        };
        jQuery.ajax({
          type: 'POST',
          url: '<?php echo base_url; ?>index.php/admin/get_cameras_by_clusterid',
          data: data,
          datatype: 'JSON',
          beforeSend: function(result) {
            jQuery('#wait').show();
          },
          success: function(result) {
            var response = JSON.parse(result);
            if (response.error) {

            } else {
              jQuery('#wait').hide();
              jQuery('.get_camera_resp').html(response.camera_list);
            }

          }
        });
      }
    });

    jQuery("body").on('click', '.Camera_Angles_select_section ul li label > input[type=checkbox]', function() {

      var radio_file_type = jQuery('.record_section .main_block ul li > input[type=radio]:checked').val();

      var values = [];
      $('input[name="cluster_name[]"]:checked').each(function() {
        values[values.length] = (this.checked ? $(this).val() : "");
      });
      $('.record_section .main_block .download_button').show();
      if (values == '') {
        $('.record_section .main_block .data_volume_btn').hide();
        $('.record_section .main_block .download_button').hide();
      } else {
        if (radio_file_type == 1) {
          $('.record_section .main_block .data_volume_btn').hide();
          $('.record_section .main_block .download_button').show();
        }

        if (radio_file_type == 4) {
          $('.record_section .main_block .data_volume_btn').show();
          $('.record_section .main_block .download_button').hide();
        }
      }

    });


    jQuery(".cluster_checkbox").click(function() {
      var Cluster_ID = jQuery(this).data("id");
      jQuery('#img-' + Cluster_ID).hide();
      jQuery(this).closest('li').removeClass('active');

      $(".cluster_checkbox").each(function(){
        var Cluster_ID = $(this).data("id");
        $(this).prop('checked', false);
        $(this).closest('li').removeClass('active');
        jQuery('#img-' + Cluster_ID).hide();
      });

      // if ($(this).is(":checked")) {
        $(this).prop('checked', true);
        jQuery(this).closest('li').addClass('active');
        jQuery('#img-' + Cluster_ID).show();
      // }
      var camera_loader = rotateProgress('loading...', 2, 'camera_loader');

      var formData = $("#ClusterFormID").serializeArray();
      if (formData != '') {
        data = formData;
        jQuery.ajax({
          type: 'POST',
          url: '<?php echo base_url; ?>index.php/admin/get_multiple_cameras_by_clusterids',
          data: data,
          datatype: 'JSON',
          beforeSend: function(result) {
          },
          success: function(result) {
            setProgress(100, '', 'camera_loader');
            clearInterval(camera_loader);
            var response = JSON.parse(result);
            if (response.error) {

            } else {
              jQuery('#wait').hide();
              jQuery('.get_camera_resp').html(response.camera_list);
            }

          }
        });
      } else {
        jQuery('.get_camera_resp').html('');
      }
    });

    jQuery(".record_section .main_block ul li > input[type=radio]").click(function() {
      var get_data_type = $(this).val();

      jQuery('.data_volume_btn').show();
      jQuery('.checkbox_manage').show();
      //jQuery('.download_button').hide();

      if (get_data_type == 1) {
        jQuery('.data_volume_btn').hide();
        jQuery('.checkbox_manage').hide();
        jQuery('.download_button').show();

      }
    });

  });


  // jQuery(document).ready(function() {
  //   jQuery("#DownloadFormID").submit(function() {
  //     jQuery('#download_loader').show();

  //     // jQuery.ajax({
  //     //   type: 'POST',
  //     //   url: '<?php echo base_url; ?>index.php/admin/records',
  //     //   dataType: 'json',
  //     //   data: jQuery('#DownloadFormID').serialize() + '&type=ajax',
  //     //   beforeSend: function(response) {
  //     //     jQuery('#download_loader').show();
  //     //   },
  //     //   success: function(response) {
  //     //     // alert(response);
  //     //     console.log(response);
  //     //     jQuery('#download_loader').hide();
  //     //     if (response.error) {
  //     //       if (response.error_msg) {
  //     //         //jQuery('.Data_Volume_section h2').show().text(response.error_msg).fadeOut(8000);
  //     //         jQuery('.Data_Volume_section h2').text(response.error_msg);
  //     //       }
  //     //     } else {
  //     //       jQuery('.Data_Volume_section h2').text('');
  //     //       //jQuery('.Data_Volume_section p').text(response.file_size_count);
  //     //     }
  //     //   }
  //     // });

  //   });
  // });

  jQuery(document).ready(function() {
    
    $('.download_button').click(function(e){
      e.preventDefault();

      if($('input[name=daterangepicker]').val() == "") {toastr.warning('Please select data range!'); return;}

      setProgress(0,'','download_loader');
      var filesize = $('#filesize').val();
      var time = (filesize / 2147483648) * 120;
      jQuery('#download_loader').show();

      var progress = rotateProgress('compressing...',time, 'download_loader');



      jQuery.ajax({
        type: 'POST',
        url: '<?php echo base_url; ?>index.php/admin/records',
        dataType: 'json',
        data: jQuery('#DownloadFormID').serialize() + '&download=true',
        success: function(response) {
          setProgress(100, 'compressing...', 'download_loader');
          clearInterval(progress);
         
          if (response.error) {
            if (response.error_msg) {
              toastr.error(response.error_msg);
            }
          } else {
            window.open(response.fileName,'_self');
          }
        }
      });
    });


    jQuery(".data_volume_btn").click(function() {
      setProgress(0,'','download_loader');
      if($('input[name=daterangepicker]').val() == "") {toastr.warning('Please select data range!'); return;}
      jQuery('.Data_Volume_section h2').text('');
      if (jQuery('.record_section .main_block ul li input[type=checkbox]').prop("checked") == true) {
        var progress = rotateProgress('calculating...',8, 'download_loader');
        $('#download_button').hide();

        jQuery.ajax({
          type: 'POST',
          url: '<?php echo base_url; ?>index.php/admin/records',
          dataType: 'json',
          data: jQuery('#DownloadFormID').serialize() + '&type=ajax',
          beforeSend: function(response) {
            jQuery('#download_loader').show();
          },
          success: function(response) {
            setProgress(100, 'calculating...', 'download_loader');
            clearInterval(progress);

            $('#download_button').hide();

            if (response.error) {
              if (response.error_msg) {
                //jQuery('.Data_Volume_section h2').show().text(response.error_msg).fadeOut(8000);
                jQuery('.Data_Volume_section h2').text(response.error_msg);
                jQuery('.Data_Volume_section p').text('');
              }
            } else {
              jQuery('.Data_Volume_section h2').text('');
              jQuery('.Data_Volume_section p').text(response.file_size_count);
              let msg = response.file_size_count;
              if(msg.indexOf('No') !== -1){
                $('#download_button').hide();
              }else{
                let filesize = msg.split('-')[0].split(' ')[0];
                let unit = msg.split('-')[0].split(' ')[1];
                if(unit == "GB" && filesize > 2){
                  toastr.info("You can't download this file because file size is over than 2 Gbytes");
                }else{
                  $('#filesize').val(response.filesize);
                  if(response.filesize > 0) $('#download_button').show();
                }
              }
            }
          },
        });
        return false;
      } else {

        toastr.warning('Please Select Stacked Pictures or Videos Checkbox');
      }
    });
  });
</script>

<script type="text/javascript">
  function rotateProgress(title, time, html_id){
    if($('#'+html_id).css('display') != 'none'){
      toastr.info('Please attempt this action after loading.')
      return
    }
    $('#'+html_id).show()
    let percent = 0
    time = time * 10;
    var progress = setInterval(()=>{
      percent += 1;
      setProgress(percent, title, html_id)
      if(percent > 99){
        clearInterval(progress);
        setTimeout(() => {
          $('#'+html_id).hide()
        }, 800);
      }
    }, time);
    return progress;
  }

  function setProgress(percent, title="", html_id = ""){
    $('#' + html_id +' .progress-title').text(title)
    $('#' + html_id +' .mask.full, #' + html_id + ' .circle .fill').css({transform: 'rotate('+ 1.8 * percent +'deg)'})
    $('#' + html_id +' .percent-value').text(percent);
    if(percent >= 100){
      setTimeout(() => {
        $('#'+html_id).hide()
      }, 800);
    }
  }
</script>