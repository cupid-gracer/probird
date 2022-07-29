
<script type="text/javascript" src="/adminasset/js/global/plugins.bundle.js"></script>
<script type="text/javascript" src="/adminasset/js/global/prismjs.bundle.js"></script>
<script type="text/javascript" src="/adminasset/js/global/scripts.bundle.min.js"></script>


<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<!-- Bootstrap core JS-->
<!-- <script src="<?php //echo base_url; ?>adminasset/js/bootstrap.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
<!-- <script src="<?php echo base_url; ?>adminasset/js/fontawesome.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"> -->
</script>
<script type="text/javascript">

  $(document).ready(function() {
    $("body").on("click", "ul.tabs li", function() {
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

  $('#ulCategory').on('click', 'li', function() {
    $('#ulCategory li.active').removeClass('active');
    $(this).addClass('active');
  });

</script>
 
<script>var HOST_URL = "<?php echo(base_url);?>";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
</body>

</html>
