
  $(document).ready(function() {
    $('ul.tabs li').click(function() {
      var tab_id = $(this).attr('data-tab');
      $('ul.tabs li').removeClass('current');
      $('.tab-content').removeClass('current');
      $(this).addClass('current');
      $("#" + tab_id).addClass('current');
    })
  })
  
 
  

 $(document).ready(function(){
  $('.mymultiplediv').click(function() {

      myvar = this.id;
      $("div.mydiv").hide();
      $('#div'+myvar).show();
  });
 });

 
  $('.list-inline').on('click', 'li', function() {
  $('.list-inline li.active').removeClass('active');
  $(this).addClass('active');
  });

  function openNav() {
    document.getElementById("mySidenav").style.width = "220px";
  }

  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
  }

  var chart1 = new CanvasJS.Chart("chartContainer1", {
    title: {
      // text: "Live Data"
    },
    axisY: {
      gridThickness: 0,
      stripLines: [{
        value: 0,
        showOnTop: true,
        thickness: 0
      }]
    },
    axisX: {
      gridThickness: 0,
      stripLines: [{
        value: "text",
        showOnTop: true,
        thickness: 0
      }]
    },
    data: [{
      type: "column",
      color: "#008BCB",
      dataPoints: [{
        x: 10,
        y: 71
      }, {
        x: 20,
        y: 55
      }, {
        x: 30,
        y: 50
      }, {
        x: 40,
        y: 65
      }, {
        x: 50,
        y: 95
      }, {
        x: 60,
        y: 68
      }, {
        x: 70,
        y: 28
      }, {
        x: 80,
        y: 34
      }, {
        x: 90,
        y: 14
      }]
    }]
  });
  var chart2 = new CanvasJS.Chart("chartContainer2", {
    title: {
      // text: "Live Data"
    },
    axisY: {
      gridThickness: 0,
      stripLines: [{
        value: 0,
        showOnTop: true,
        thickness: 0
      }]
    },
    axisX: {
      gridThickness: 0,
      stripLines: [{
        value: "text",
        showOnTop: true,
        thickness: 0
      }]
    },
    data: [{
      type: "column",
      color: "#008BCB",
      dataPoints: [{
        x: 10,
        y: 71
      }, {
        x: 20,
        y: 55
      }, {
        x: 30,
        y: 50
      }, {
        x: 40,
        y: 65
      }, {
        x: 50,
        y: 95
      }, {
        x: 60,
        y: 68
      }, {
        x: 70,
        y: 28
      }, {
        x: 80,
        y: 34
      }, {
        x: 90,
        y: 14
      }]
    }]
  });
  var chart3 = new CanvasJS.Chart("chartContainer3", {
    title: {
      // text: "Live Data"
    },
    axisY: {
      gridThickness: 0,
      stripLines: [{
        value: 0,
        showOnTop: true,
        thickness: 0
      }]
    },
    axisX: {
      gridThickness: 0,
      stripLines: [{
        value: "text",
        showOnTop: true,
        thickness: 0
      }]
    },
    data: [{
      type: "column",
      color: "#008BCB",
      dataPoints: [{
        x: 10,
        y: 71
      }, {
        x: 20,
        y: 55
      }, {
        x: 30,
        y: 50
      }, {
        x: 40,
        y: 65
      }, {
        x: 50,
        y: 95
      }, {
        x: 60,
        y: 68
      }, {
        x: 70,
        y: 28
      }, {
        x: 80,
        y: 34
      }, {
        x: 90,
        y: 14
      }]
    }]
  });
  var chart4 = new CanvasJS.Chart("chartContainer4", {
    title: {
      // text: "Live Data"
    },
    axisY: {
      gridThickness: 0,
      stripLines: [{
        value: 0,
        showOnTop: true,
        thickness: 0
      }]
    },
    axisX: {
      gridThickness: 0,
      stripLines: [{
        value: "text",
        showOnTop: true,
        thickness: 0
      }]
    },
    data: [{
      type: "column",
      color: "#008BCB",
      dataPoints: [{
        x: 10,
        y: 71
      }, {
        x: 20,
        y: 55
      }, {
        x: 30,
        y: 50
      }, {
        x: 40,
        y: 65
      }, {
        x: 50,
        y: 95
      }, {
        x: 60,
        y: 68
      }, {
        x: 70,
        y: 28
      }, {
        x: 80,
        y: 34
      }, {
        x: 90,
        y: 14
      }]
    }]
  });
  var chart5 = new CanvasJS.Chart("chartContainer5", {
    title: {
      // text: "Live Data"
    },
    axisY: {
      gridThickness: 0,
      stripLines: [{
        value: 0,
        showOnTop: true,
        thickness: 0
      }]
    },
    axisX: {
      gridThickness: 0,
      stripLines: [{
        value: "text",
        showOnTop: true,
        thickness: 0
      }]
    },
    data: [{
      type: "column",
      color: "#008BCB",
      dataPoints: [{
        x: 10,
        y: 71
      }, {
        x: 20,
        y: 55
      }, {
        x: 30,
        y: 50
      }, {
        x: 40,
        y: 65
      }, {
        x: 50,
        y: 95
      }, {
        x: 60,
        y: 68
      }, {
        x: 70,
        y: 28
      }, {
        x: 80,
        y: 34
      }, {
        x: 90,
        y: 14
      }]
    }]
  });
  var chart6 = new CanvasJS.Chart("chartContainer6", {
    title: {
      // text: "Live Data"
    },
    axisY: {
      gridThickness: 0,
      stripLines: [{
        value: 0,
        showOnTop: true,
        thickness: 0
      }]
    },
    axisX: {
      gridThickness: 0,
      stripLines: [{
        value: "text",
        showOnTop: true,
        thickness: 0
      }]
    },
    data: [{
      type: "column",
      color: "#008BCB",
      dataPoints: [{
        x: 10,
        y: 71
      }, {
        x: 20,
        y: 55
      }, {
        x: 30,
        y: 50
      }, {
        x: 40,
        y: 65
      }, {
        x: 50,
        y: 95
      }, {
        x: 60,
        y: 68
      }, {
        x: 70,
        y: 28
      }, {
        x: 80,
        y: 34
      }, {
        x: 90,
        y: 14
      }]
    }]
  });
  chart1.render();
  chart2.render();
  chart3.render();
  chart4.render();
  chart5.render();
  chart6.render();
 
  $('#ulCategory').on('click', 'li', function() {
    $('#ulCategory li.active').removeClass('active');
    $(this).addClass('active');
  });

  $(document).ready(function() {
    $(function() {
      $('.chart_demo').easyPieChart({
        size: 80,
        scaleLength: 0,
        lineWidth: 12,
        lineCap: "square",
        animate: 2000,
        barColor: "#008BCB"
      });
    });
  });
  

 