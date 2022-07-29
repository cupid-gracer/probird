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

</style>
<section>
  <div class="reporting_section">



    <div class="accordion accordion-toggle-arrow" id="accordionExample1">
      <div class="card">
        <div class="card-header">
          <div class="card-title" data-toggle="collapse" data-target="#collapseOne1">
            Global data from the 02/03/2022 to the <?php echo date('d/m/Y') ?>
          </div>
        </div>
        <div id="collapseOne1" class="collapse show" data-parent="#accordionExample1">
          <div class="card-body">
            <div class="row" style="border-bottom:1px gray solid">
                <div class="col-md-4 col-sm-12  inner-row">
                  <div class="row">
                    <div class="col-md-12 col-lg-4">
                      <div class="circle-parent">
                        <div id="circle-progress-stop-duration" class="circle-progress" data-percent="90"></div>
                        <div class="percent_name">
                          <p>2 h 35 m /</p>
                          <p>542 h 12 m</p>
                        </div>
                      </div>
                      <div class="prgress-title">Stop Duration</div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                      <div class="circle-parent">
                        <div id="circle-progress-production-loss" class="circle-progress" data-percent="97"></div>
                        <div class="percent_name">
                          <p>10 MW.h /</p>
                          <p>1200 MW.h</p>
                        </div>
                      </div>
                      <div class="prgress-title">Production Loss</div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                      <div class="circle-parent">
                        <div id="circle-progress-sound-duration" class="circle-progress" data-percent="95"></div>
                        <div class="percent_name">
                          <p>8 h 32 m /</p>
                          <p>542 h 12 m</p>
                        </div>
                      </div>
                      <div class="prgress-title">Sound Duration</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-12  inner-row">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="circle-parent">
                        <div id="circle-progress-data-availability" class="circle-progress" data-percent="98"></div>
                        <div class="percent_name">
                          <p class="percent-value">98%</p>
                        </div>
                      </div>
                      <div class="prgress-title">Sound Duration</div>
                    </div>
                    <div class="col-md-6">
                      <div class="circle-parent">
                        <div id="circle-progress-com-availability" class="circle-progress" data-percent="99"></div>
                        <div class="percent_name">
                          <p class="percent-value">99%</p>
                        </div>
                      </div>
                      <div class="prgress-title">Sound Duration</div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5 col-sm-12" style="display: flex; flex-direction:column; justify-content:center; padding-right:5%">
                  <div class="row">
                    <div class="col col-summary">
                      <div class="summary-item">
                        <p>Total detection number : </p>
                        <p>20140</p>
                      </div>
                      <div class="summary-item">
                        <p>Total stop number : </p>
                        <p>1568</p>
                      </div>
                      <div class="summary-item">
                        <p>Total sound number : </p>
                        <p>2548</p>
                      </div>
                    </div>
                    <div class="col col-summary">
                      <div class="summary-item">
                        <p>Average false negative : </p>
                        <p>2 %</p>
                      </div>
                      <div class="summary-item">
                        <p>Average false positive : </p>
                        <p>12 %</p>
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
                <div class="col-md-7 col-sm-12">
                  <div id="wt-1" class="wt-graph"></div>
                  <div id="wt-2" class="wt-graph"></div>
                  <div id="wt-3" class="wt-graph"></div>
                  <div id="wt-4" class="wt-graph"></div>
                  <div id="wt-5" class="wt-graph"></div>
                  <div id="wt-6" class="wt-graph"></div>
                  <div id="wt-7" class="wt-graph"></div>
                  <div id="wt-8" class="wt-graph"></div>
                  <div id="wt-9" class="wt-graph"></div>
                  <div id="wt-10" class="wt-graph"></div>
                  <div id="wt-11" class="wt-graph"></div>
                  <div id="wt-12" class="wt-graph"></div>
                </div>
                <div class="col-md-5 col-sm-12 ">
                  <div class="calendar-date-range">
                    <div class="input-group" id="kt_daterangepicker" style="padding-right: 80px;">
                      <input type="text" class="form-control" readonly name="daterangepicker" placeholder="Select date range" />
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                      </div>
                    </div>
                    <img id="wt-pannel-download" class="pdf-download" src="/adminasset/images/pdf-download.png" style="top: 0px;" />
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
                  <div class="calendar-date-range">
                    <div class="input-group" id="kt_daterangepicker2" style="padding-right: 80px;">
                      <input type="text" class="form-control" readonly name="daterangepicker" placeholder="Select date range" />
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                      </div>
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
<script type="text/javascript" src="/adminasset/js/pages/record/form-widgets.js"></script>

<script type='text/javascript'>
  $('.pdf-download').click(function(){
    toastr.info('coming soon!')
  })
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var size = 120,
      scaleLength = 0,
      lineWidth = 16,
      lineCap = 'butt',
      animate = 2000;

    $(function() {
      $('#circle-progress-stop-duration').easyPieChart({
        size: size,
        scaleLength: scaleLength,
        lineWidth: lineWidth,
        lineCap: lineCap,
        animate: animate,
        barColor: "#00A1FF",
        trackColor: '#FFC400',

      });

      $('#circle-progress-production-loss').easyPieChart({
        size: size,
        scaleLength: scaleLength,
        lineWidth: lineWidth,
        lineCap: lineCap,
        animate: animate,
        barColor: "#00A1FF",
        trackColor: '#FF6600',

      });

      $('#circle-progress-sound-duration').easyPieChart({
        size: size,
        scaleLength: scaleLength,
        lineWidth: lineWidth,
        lineCap: lineCap,
        animate: animate,
        barColor: "#00A1FF",
        trackColor: 'white',

      });

      $('#circle-progress-data-availability').easyPieChart({
        size: size,
        scaleLength: scaleLength,
        lineWidth: lineWidth,
        lineCap: lineCap,
        animate: animate,
        barColor: "#94CEFD",
        trackColor: '#727272',

      });

      $('#circle-progress-com-availability').easyPieChart({
        size: size,
        scaleLength: scaleLength,
        lineWidth: lineWidth,
        lineCap: lineCap,
        animate: animate,
        barColor: "#94CEFD",
        trackColor: '#FFF',

      });
    });
  });
</script>
<script>
  $(function() {

    var trace1 = {
      x: ['WT1', 'WT2', 'WT3', 'WT4', 'WT5', 'WT6', 'WT7', 'WT8', 'WT9', 'WT10', 'WT11', 'WT12'],
      y: [102, 201, 304, 504, 465, 326, 421, 236, 469, 518, 325, 425],
      marker: {
        color: '#94CEFD',
        line: {
          width: 1
        }
      },
      name: 'Total sound number',
      type: 'bar'
    };

    var trace2 = {
      x: ['WT1', 'WT2', 'WT3', 'WT4', 'WT5', 'WT6', 'WT7', 'WT8', 'WT9', 'WT10', 'WT11', 'WT12'],
      y: [32, 31, 44, 54, 85, 66, 51, 46, 89, 38, 45, 65],
      name: 'Total stop number',
      marker: {
        color: '#59D2BD',
        line: {
          width: 1
        }
      },
      type: 'bar'
    };

    var data = [trace1, trace2];

    var layout = {
      barmode: 'stack',
      title: {
        text: 'Sound & Stop per wind turbine',
        font: {
          family: 'Times New Roman',
          size: 24
        },
        xref: 'paper',
        x: 0.05,
      }
    };
    var config = {
      responsive: true
    }
    Plotly.newPlot('sound_stop_graph', data, layout, config);

  });

  $(function() {

    var trace1 = {
      x: ['Cam22', 'Cam23', 'Cam24', 'Cam32', 'Cam33', 'Cam34', 'Cam35', 'Cam36', 'Cam42', 'Cam43', 'Cam44', 'Cam45', 'Cam46', 'Cam48', 'Cam52', 'Cam53', 'Cam54', 'Cam62', 'Cam63', 'Cam64', 'Cam65', 'Cam66', 'Cam72', 'Cam73', 'Cam74', 'Cam75', 'Cam76', 'Cam77', 'Cam78', 'Cam82', 'Cam84',  'Cam92',  'Cam94',  'Cam102',  'Cam103',  'Cam104', ],
      y: [800, 654, 902, 1200, 301, 509, 105, 102, 201, 304, 504, 465, 948, 305, 799, 125, 1400, 1000, 405, 326, 421, 236, 469, 1436, 215, 625, 405,865, 250, 129, 948, 674, 584,236, 469, 1436],
      marker: {
        color: '#94CEFD',
        line: {
          width: 1
        }
      },
      type: 'bar'
    };

    var data = [trace1];

    var layout = {
      barmode: 'stack',
      title: {
        text: 'Detection per camera',
        font: {
          family: 'Times New Roman',
          size: 24
        },
        xref: 'paper',
        x: 0.05,
      }
    };
    var config = {
      responsive: true
    }
    Plotly.newPlot('detection_graph', data, layout, config);

  });
</script>

<script type='text/javascript'>
  $(function() {
    for(var i = 1; i <= 12; i++){
      var x = [], status_y = [], sound_y = [], stops_y = [], prod_y = [], wind_speed_y = [], rpm_y = [], max = 14, min = 0;
      for(var j = 0; j < 72 / 3; j++){
        x.push(j);
        status_y.push(Math.random() * (max - min) + min);
        sound_y.push(Math.random() * (max - min) + min);
        stops_y.push(Math.random() * (max - min) + min);
        prod_y.push(Math.random() * (max - min) + min);
        wind_speed_y.push(Math.random() * (max - min) + min);
        rpm_y.push(Math.random() * (max - min) + min);
      }

      var status = {
        x: x,
        y: status_y,
        marker: {
          color: '#7E7E7E',
          line: {
            width: 1
          }
        },
        name: 'Status',
        type: 'scatter'
      };

      var sound = {
        x: x,
        y: sound_y,
        marker: {
          color: '#D9D9D9',
          line: {
            width: 1
          }
        },
        name: 'Sound',
        type: 'scatter'
      };

      var stops = {
        x: x,
        y: stops_y,
        marker: {
          color: '#EC7D31',
          line: {
            width: 1
          }
        },
        name: 'Stops',
        type: 'scatter'
      };

      var wind_speed = {
        x: x,
        y: wind_speed_y,
        marker: {
          color: '#9DC2E6',
          line: {
            width: 1
          }
        },
        name: 'Wind Speed',
        type: 'scatter'
      };

      var rpm = {
        x: x,
        y: rpm_y,
        marker: {
          color: '#4472C3',
          line: {
            width: 1
          }
        },
        name: 'RPM',
        type: 'scatter'
      };

      var prod = {
        x: x,
        y: prod_y,
        marker: {
          color: '#FFBF00',
          line: {
            width: 1
          }
        },
        name: 'Prod',
        type: 'scatter'
      };

      var data = [status, sound, stops, wind_speed, rpm, prod];

      var layout = {
        barmode: 'stack',
        title: {
          text: 'WT '+i,
          font: {
            family: 'Times New Roman',
            size: 24,
            weight: 'bold'
          },
          xref: 'paper',
          x: 0.01,
        }
      };
      var config = {
        responsive: true
      }
      Plotly.newPlot('wt-'+i, data, layout, config);
    }
  });
</script>


<script type='text/javascript'>

  $(function(){
    for(let i = 0; i < 36; i++){
      let graph_item = '<div id="cam-' + i +'" class="wt-graph"></div>';
      $('.cam-graph-panel').append(graph_item);
    }
  })

  $(function() {
    var cams = ['Cam 22','Cam 23','Cam 24','Cam 32','Cam 33','Cam 34','Cam 35','Cam 36','Cam 42','Cam 43','Cam 44','Cam 45','Cam 46','Cam 48','Cam 52','Cam 53','Cam 54','Cam 62','Cam 63','Cam 64','Cam 65','Cam 66','Cam 72','Cam 73','Cam 74','Cam 75','Cam 76','Cam 77','Cam 78','Cam 82','Cam 84','Cam 92','Cam 94','Cam 102','Cam 103','Ca 104'];
    
    for(var i = 0; i < 36; i++){
      var x = [], danger_y = [], stops_y = [], visi_y = [], max = 14, min = 0;
      for(var j = 0; j < 36; j++){
        x.push(j);
        danger_y.push(Math.random() * (max - min) + min);
        stops_y.push(Math.random() * (max - min) + min);
        visi_y.push(Math.random() * (max - min) + min);
      }

      var danger = {
        x: x,
        y: danger_y,
        marker: {
          color: '#4472C3',
          line: {
            width: 1
          }
        },
        name: 'Danger',
        type: 'bar'
      };

      var stops = {
        x: x,
        y: stops_y,
        marker: {
          color: '#EC7D31',
          line: {
            width: 1
          }
        },
        name: 'Stops',
        type: 'bar'
      };

      var visi = {
        x: x,
        y: visi_y,
        marker: {
          color: '#A5A5A5',
          line: {
            width: 1
          }
        },
        name: 'Visi',
        type: 'scatter'
      };

      var data = [danger, stops, visi];

      var layout = {
        barmode: 'stack',
        title: {
          text: cams[i],
          font: {
            family: 'Times New Roman',
            size: 24,
            weight: 'bold'
          },
          xref: 'paper',
          x: 0.01,
        }
      };
      var config = {
        responsive: true
      }
      Plotly.newPlot("cam-" + [i], data, layout, config);
    }
  });
</script>