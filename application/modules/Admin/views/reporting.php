<?php include('common/header.php'); ?>
<style>
  .circle-progress {
    transform: rotate(50deg);
  }

  .circle-parent {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .circle-parent p {
    margin: 0;
    font-size: 13px;
    color: black;
  }

  .percent_name {
    position: absolute;
    flex-direction: column;
  }

  .percent-value {
    font-size: 25px !important;
  }

  .card-title {
    font-weight: bold !important;
    font-size: 20px;
    background-color: #008bcb;
    color:white !important;
  }

  .card-title.collapsed{
    background-color: #77bfe347;
    color:gray !important;
  }
  .card-title:after{
    color: black !important;
  }

  .card-body {
    border: 1px gray solid;
    padding-left: 0 !important;
    padding-right: 0 !important;
  }

  .card-body .row {
    margin: 0;
    padding: 0;
  }

  #collapseOne1 .card-body {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
  }

  .prgress-title {
    font-size: 17px;
    font-weight: bold;
    text-align: center;
  }

  .inner-row {
    border-right: 1px gray solid;
    padding: 20px 0 !important;
  }

  .col-summary {
    padding-right: 50px;
  }

  .summary-item {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    font-size: 17px;
  }

  .pdf-download{
    position: absolute;
    top: 80px;
    right:10px;
    cursor:pointer;
    width: 50px;
  }

  .over-panel{
    height: 600px;
    overflow-y: auto;

  }

  .calendar-date-range{
    position: sticky;
    top: 40px;
  }

  .circle{
    display: none;
  }

  .range_type{
    margin-bottom: 15px !important;
  }

 .range_type li{
   display: inline-block;
   margin-right: 10px;
 }

 

</style>
<section>
  <div class="reporting_section">



    <div class="accordion accordion-toggle-arrow" id="accordionExample1">
      <div class="card">
        <div class="card-header">
          <div id="first-title" class="card-title" data-toggle="collapse" data-target="#collapseOne1">
            Global data from the <?php echo date('d/m/Y', strtotime($start_date));?> to the <?php echo date('d/m/Y', strtotime($end_date)); ?>
          </div>
        </div>
        <div id="collapseOne1" class="collapse show" data-parent="#accordionExample1">
          <div class="card-body">
            <div class="row" style="border-bottom:1px gray solid">
                <div class="col-md-4 col-sm-12  inner-row">
                  <div  id="first_progress_section" class="row">
                    <div class="col-md-12 col-lg-4 circle">
                      <div class="circle-parent">
                        <div id="circle-progress-stop-duration" class="circle-progress" data-percent="<?php echo (($stats['uptime'] - $stats['downtime'])/$stats['uptime'])*100?>"></div>
                        <div class="percent_name">
                          <p><?php echo floor($stats['downtime']/3600).' h '. floor(($stats['downtime']/60) %60 ).' m';?>/</p>
                          <p><?php echo floor($stats['uptime']/3600).' h '. floor(($stats['uptime']/60) %60 ).' m';?></p>
                        </div>
                      </div>
                      <div class="prgress-title">Stop Duration</div>
                    </div>
                    <div class="col-md-12 col-lg-4 circle">
                      <div class="circle-parent">
                        <div id="circle-progress-production-loss" class="circle-progress" data-percent="<?php echo (($stats['EPA'] - $stats['LPA'])/$stats['EPA'])*100?>"></div>
                        <div class="percent_name">
                          <p><?php echo floor($stats['LPA']/1000000) > 0 ? floor($stats['LPA']/1000000).' MW.h':floor($stats['LPA']/1000).' KW.h' ;?> /</p>
                          <p><?php echo floor($stats['EPA']/1000000) > 0 ? floor($stats['EPA']/1000000).' MW.h':floor($stats['EPA']/1000).' KW.h' ;?></p>
                        </div>
                      </div>
                      <div class="prgress-title">Production Loss</div>
                    </div>
                    <div class="col-md-12 col-lg-4 circle" >
                      <div class="circle-parent">
                        <div id="circle-progress-sound-duration" class="circle-progress" data-percent="<?php echo (($stats['uptime'] - $stats['sound_time'])/$stats['uptime'])*100?>"></div>
                        <div class="percent_name">
                          <p><?php echo floor($stats['sound_time']/3600).' h '. floor(($stats['sound_time']/60) %60 ).' m';?>(*)/</p>
                          <p><?php echo floor($stats['uptime']/3600).' h '. floor(($stats['uptime']/60) %60 ).' m';?></p>
                        </div>
                      </div>
                      <div class="prgress-title">Sound Duration</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-12  inner-row">
                  <div id="second_progress_section" class="row">
                    <div class="col-md-6 circle">
                      <div class="circle-parent">
                        <div id="circle-progress-data-availability" class="circle-progress" data-percent="<?php echo ($stats['img_number']/$stats['expected_img_number'])*100?>"></div>
                        <div class="percent_name">
                          <p class="percent-value"><?php echo round(($stats['img_number']/$stats['expected_img_number'])*100,1)?>%</p>
                        </div>
                      </div>
                      <div class="prgress-title">Data availability</div>
                    </div>
                    <div class="col-md-6 circle">
                      <div class="circle-parent">
                        <div id="circle-progress-com-availability" class="circle-progress" data-percent="<?php echo ($stats['wt_data_number']/$stats['expect_wt_data_number'])*100?>"></div>
                        <div class="percent_name">
                          <p class="percent-value"><?php echo round(($stats['wt_data_number']/$stats['expect_wt_data_number'])*100,1)?>%</p>
                        </div>
                      </div>
                      <div class="prgress-title">Com availability</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5 col-sm-12" style="display: flex; flex-direction:column; justify-content:center; padding-right:5%">
                  <div id="third_section" class="row" >
                    <div class="col col-summary">
                      <div class="summary-item">
                        <p>Total detection number : </p>
                        <p><?php echo $stats['detection_number']?></p>
                      </div>
                      <div class="summary-item">
                        <p>Total stop number : </p>
                        <p><?php echo $stats['stop_number']?></p>
                      </div>
                      <div class="summary-item">
                        <p>Total sound number : </p>
                        <p><?php echo $stats['sound_number'] == ""?"0":$stats['sound_number']  ?></p>
                      </div>
                    </div>
                    <div class="col col-summary">
                      <div class="summary-item">
                        <p>Average false negative : </p>
                        <p>2 %(*)</p>
                      </div>
                      <div class="summary-item">
                        <p>Average false positive : </p>
                        <p>12 %(*)</p>
                      </div>
                    </div>
                  </div>
                </div>

            </div>
            <div class="row">
              <div class="col-md-6 col-sm-12" style="border-right:1px gray solid">
                <div class="row">
                  <div id="detection_graph" style="height: 400px; width: 100%;"></div>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="row" style="padding-right:150px">
                  <div id="sound_stop_graph" style="height: 400px; width: 100%;"></div>
                </div>
              </div>
            </div>
          </div>
          <div id="first_section_loading"  class="loading-bar">
            <div class="circle-wrap">
              <div class="circle" style="display: block;">
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
        <img id="global-pannel-download" class="pdf-download" src="/adminasset/images/pdf-download.png"/>
      </div>
      <div class="card">
        <div class="card-header">
          <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo1">
            WT analysis
          </div>
        </div>
        <div id="collapseTwo1" class="collapse" data-parent="#accordionExample1">
          <div class="card-body">
            <div class="over-panel">
              <div class="row">
                <div id="second-pdf" class="col-md-7 col-sm-12">  
                </div>
                <div class="col-md-5 col-sm-12 ">
                  <div class="calendar-date-range">
                    <ul id="wt_chart_type" class="range_type">
                      <li>
                        <input type="radio" name="chart_type_wt" value="day" checked/>
                        <label>Day</label>
                      </li>
                      <li>
                        <input type="radio" name="chart_type_wt" value="minute"/>
                        <label>Minute</label>
                      </li>
                    </ul>
                    <div class="input-group" id="wt_kt_daterangepicker" style="padding-right: 80px;">
                      <input type="text" class="form-control" readonly name="daterangepicker" placeholder="Select date range" />
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                      </div>
                      <input type="hidden" id="wt_start_time"/>
                      <input type="hidden" id="wt_end_time"/>
                    </div>
                    <button id="btn_wt_chart_view" class="btn btn-primary" style="margin-top: 20px;">Chart View</button>
                    <img id="wt-pannel-download" class="pdf-download" src="/adminasset/images/pdf-download.png" style="top: 20px;" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="wt_graph_loading"  class="loading-bar">
            <div class="circle-wrap">
              <div class="circle" style="display: block;">
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
      <div class="card">
        <div class="card-header">
          <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree1">
            Camera analysis
          </div>
        </div>
        <div id="collapseThree1" class="collapse" data-parent="#accordionExample1">
          <div class="card-body">
            <div class="over-panel">
              <div class="row">
                <div class="col-md-7 col-sm-12 cam-graph-panel">
                </div>
                <div class="col-md-5 col-sm-12 ">
                  <ul id="cam_chart_type" class="range_type">
                      <li>
                        <input type="radio" name="chart_type_cam" value="day" checked>
                        <label>Day</label>
                      </li>
                      <li>
                        <input type="radio" name="chart_type_cam" value="minute" >
                        <label>Minute</label>
                      </li>
                    </ul>
                  <div class="calendar-date-range">
                    <div class="input-group" id="cam_kt_daterangepicker" style="padding-right: 80px;">
                      <input type="text" class="form-control" readonly name="daterangepicker" placeholder="Select date range" />
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                      </div>
                      <input type="hidden" id="cam_start_time"/>
                      <input type="hidden" id="cam_end_time"/>
                    </div>
                    <img id="cam-pannel-download" class="pdf-download" src="/adminasset/images/pdf-download.png" style="top: 0px;" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</section>
<?php include('common/footer.php'); ?>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<!-- <script type="text/javascript" src="/adminasset/js/global/html2pdf.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js" ></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="http://html2canvas.hertzen.com/dist/html2canvas.min.js" ></script>

<script type="text/javascript">
  var sound_number_x = [<?php foreach($sound_stop_number as $item ){echo "'WT".$item['wind_turbine_id']."',";}?>];
  var sound_number_y = [<?php foreach($sound_stop_number as $item ){echo ($item['sound_number']==""? "0,":$item['sound_number']);}?>];
  var stop_number_y = [<?php foreach($sound_stop_number as $item ){echo $item['stop_number'].",";}?>];

  var detect_cam_x = [<?php foreach($sound_stop_number as $item ){echo "'Cam".$item['cam_name']."',";}?>];
  var detect_cam_y =  [<?php foreach($sound_stop_number as $item ){echo $item['detection_number'].",";}?>];

  var first_pdf_period = "<?php echo date('d/m/Y', strtotime($start_date));?> - <?php echo date('d/m/Y', strtotime($end_date)); ?>";
</script>


<script type="text/javascript" src="/adminasset/js/pages/reporting/daterangepicker.js"></script>
<script type="text/javascript" src="/adminasset/js/pages/reporting/reporting.js"></script>
