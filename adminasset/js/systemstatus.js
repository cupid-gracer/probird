$(document).ready(function() {
    let interval_time = $('#interval_time').val() * 60 * 1000;
    setInterval(() => {
        fetchDataRealTime();
    }, interval_time);

});

function fetchDataRealTime() {
    $.ajax({
        url: '/admin/sytemstatus',
        type: 'GET',
        success: function(res) {
            let data = JSON.parse(res);
            render(data);
        }
    });
}

function render(wind_turbines) {
    let html = '',
        first_connect = true,
        connect_count = 1;
    wind_turbines.forEach((wind_turbine, idx) => {
        if ((idx) % 6 == 0) html += '<div class="row boxes">';
        html += '<div class="box ' + (wind_turbine['active'] ? 'turbine-active' : 'turbine-inactive') + '">';
        html += '<h3>' + wind_turbine['Name'] + '</h3> ';
        html += '<img src="' + '/adminasset/images/' + (wind_turbine['Type'] == 'PDL' ? (wind_turbine['active'] ? 'pld_green.png' : 'pld_img_new.png') : (wind_turbine['active'] ? 'fan_green.png' : 'fan_brown.png')) + '">';

        if (wind_turbine['computers'].length) {
            html += '<ul>';
            wind_turbine['computers'].forEach(computer => {
                html += '<li style="color:#008bcb">' + computer['c_name'] + '</li>';
                if (computer['script'].length) {
                    computer['script'].forEach(sc => {
                        html += '<li style="' + (sc['status'] ? 'color:green' : 'color:gray') + '">' + sc['sc_name'] + '</li>';
                    });
                }
            });
            html += '</ul>';
            if (!first_connect) {
                // html += '<div class="connect" style="width:' + (connect_count * 170) + 'px !important;"></div>';
            }
            first_connect = false;
            connect_count = 0;

        } else {
            html += '<ul style="border:0px"></ul>';
        }
        html += '</div>';
        connect_count++;
        if ((idx) % 6 == 5) html += '</div>';
    });
    for (var i=0; i < (6 - wind_turbines.length %6 ); i++) { 
        html +='<div class="box"></div>';
      }
    if (wind_turbines.length % 6 != 5) html += '</div>';

    $('.System_status_section1').html(html);
}