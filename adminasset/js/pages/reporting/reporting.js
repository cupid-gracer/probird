// Global Variables
var wt_canvases = [];
var wt_canvase_length = 0;



$('.pdf-download').click(function () {
	// toastr.info('coming soon!')
})
// summary status 
$(document).ready(function () {
	var size = 140,
		scaleLength = 0,
		lineWidth = 16,
		lineCap = 'butt',
		animate = 2000;

	$(function () {
		$('#circle-progress-stop-duration').easyPieChart({
			size: size,
			scaleLength: scaleLength,
			lineWidth: lineWidth,
			lineCap: lineCap,
			animate: animate,
			barColor: "#00A1FF",
			trackColor: '#FFC400',

		});
		$('#circle-progress-stop-duration').parent().parent().show()

		$('#circle-progress-production-loss').easyPieChart({
			size: size,
			scaleLength: scaleLength,
			lineWidth: lineWidth,
			lineCap: lineCap,
			animate: animate,
			barColor: "#00A1FF",
			trackColor: '#FF6600',

		});
		$('#circle-progress-production-loss').parent().parent().show()

		$('#circle-progress-sound-duration').easyPieChart({
			size: size,
			scaleLength: scaleLength,
			lineWidth: lineWidth,
			lineCap: lineCap,
			animate: animate,
			barColor: "#00A1FF",
			trackColor: 'white',

		});
		$('#circle-progress-sound-duration').parent().parent().show()

		$('#circle-progress-data-availability').easyPieChart({
			size: size,
			scaleLength: scaleLength,
			lineWidth: lineWidth,
			lineCap: lineCap,
			animate: animate,
			barColor: "#94CEFD",
			trackColor: '#727272',

		});
		$('#circle-progress-data-availability').parent().parent().show()

		$('#circle-progress-com-availability').easyPieChart({
			size: size,
			scaleLength: scaleLength,
			lineWidth: lineWidth,
			lineCap: lineCap,
			animate: animate,
			barColor: "#94CEFD",
			trackColor: '#FFF',

		});
		$('#circle-progress-com-availability').parent().parent().show()
	});
});

$(function () {
	var trace1 = {
		x: sound_number_x,
		y: sound_number_y,
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
		x: sound_number_x,
		y: stop_number_y,
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
			text: '<b>Sound & Stop per wind turbine</b>',
			font: {
				family: "'Noto Sans HK', sans-serif",
				size: 20
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

$(function () {

	var trace1 = {
		x: detect_cam_x,
		y: detect_cam_y,
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
			text: '<b>Detection per camera</b>',
			font: {
				family: "'Noto Sans HK', sans-serif",
				weight: 'bold',
				size: 20
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

// Calculation wind power amount
function cal_power_amount(wind_speed, type)
{
    if( wind_speed > 0){
        increment = type == 'S' ? 3600: type == 'M'? 60 : 1;
        production = 3346.35 / (1+Math.exp(5.60355-0.68957 * wind_speed))
        production = production / increment
    }else
        production = 0;
    return production
}

//   WT graph
function wt_graph(data, chart_type) {
    // $('#wt-pannel-download').hide();
    wt_canvase_length = data.length;
    $('#second-pdf').html("");
    wt_canvases = [];
    for (let i = 0; i < data.length; i++) {
        let graph_item = '<div id="wt-' + data[i]['wt_id'] + '" class="wt-graph"></div>';
        $('#second-pdf').append(graph_item);
    }

	for (var i = 0; i < data.length; i++) {
        let wt_id = data[i]['wt_id'];
        let wt_data = data[i]['data'];
		var x = [],
			status_y = [],
			sound_y = [],
			stops_y = [],
			prod_y = [],
			wind_speed_y = [],
			rpm_y = [],
			max = 14,
			min = 0;
		for (var j = 0; j < wt_data.length; j++) {
            let _d = wt_data[j];
            if(chart_type == "minute"){
                x.push(_d['Time_Stamp']);
                status_y.push(0);
                sound_y.push(0);
                stops_y.push(_d['Stop_number']);
                prod_y.push(_d['Prod']*1000);
                wind_speed_y.push(_d['Wind_Speed']);
                rpm_y.push(_d['RPM']);
            }
            else{
                x.push(_d['date']);
                status_y.push(0);
                sound_y.push(_d['sound_number']);
                stops_y.push(_d['stop_number']);
                prod_y.push((_d['expect_power_amount'] - _d['loss_power_amount'])*1000);
                wind_speed_y.push(_d['avg_wind_speed']);
                rpm_y.push(_d['avg_rpm']);
            }
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
			type: 'bar'
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
            name: 'yaxis2 data',
            yaxis: 'y2',
			marker: {
				color: '#FFBF00',
				line: {
					width: 1
				}
			},
			name: 'Prod',
			type: 'scatter'
		};

		var __data = [status, sound, stops, wind_speed, rpm, prod];

		var layout = {
			barmode: 'stack',
			title: {
				text: '<b>WT ' + wt_id + '</b>',
				font: {
					family: "'Noto Sans HK', sans-serif",
					size: 20,
					weight: 'bold'
				},
				xref: 'paper',
				x: 0.01,
			},
            xaxis: {domain: [0.1, 0.95]},
            yaxis2: {
              overlaying: 'y',
              side: 'right',
              position: 0.97
            },
		};
		var config = {
			responsive: true
		}
		Plotly.newPlot('wt-' + wt_id, __data, layout, config).then(
            function(gd){
                 Plotly.toImage(gd,{height:450,width:1000})
                 .then(function(blob){
                    wt_canvases.push({id: wt_id, img: blob});
                });
            });
	}
    
};

//   Cam graph
$(document).ready(function () {
	$(function () {
		for (let i = 0; i < 36; i++) {
			let graph_item = '<div id="cam-' + i + '" class="wt-graph"></div>';
			$('.cam-graph-panel1').append(graph_item);
		}
	})

	$(function () {
		var cams = ['Cam 22', 'Cam 23', 'Cam 24', 'Cam 32', 'Cam 33', 'Cam 34', 'Cam 35', 'Cam 36', 'Cam 42', 'Cam 43', 'Cam 44', 'Cam 45', 'Cam 46', 'Cam 48', 'Cam 52', 'Cam 53', 'Cam 54', 'Cam 62', 'Cam 63', 'Cam 64', 'Cam 65', 'Cam 66', 'Cam 72', 'Cam 73', 'Cam 74', 'Cam 75', 'Cam 76', 'Cam 77', 'Cam 78', 'Cam 82', 'Cam 84', 'Cam 92', 'Cam 94', 'Cam 102', 'Cam 103', 'Ca 104'];

		for (var i = 0; i < 36; i++) {
			var x = [],
				danger_y = [],
				stops_y = [],
				visi_y = [],
				max = 14,
				min = 0;
			for (var j = 0; j < 36; j++) {
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
});

// generate PDF
function firstSectionGeneratePDF(html_id, title, progress) {
	const element = document.getElementById(html_id);

	var opt = {
		margin: [100, 6],
		filename: title + '.pdf',
		image: {
			type: 'jpeg',
			quality: 0.98
		},
		html2canvas: {
			scale: 1,
			letterRendering: true
		},
		jsPDF: {
			unit: 'mm',
			format: 'a4',
			orientation: 'p'
		}
	};
	html2canvas(document.querySelector("#first_progress_section")).then(first_progress_section => {
		html2canvas(document.querySelector("#second_progress_section")).then(second_progress_section => {
			html2canvas(document.querySelector("#third_section")).then(third_section => {
				html2canvas(document.querySelector("#detection_graph")).then(detection_graph => {
					html2canvas(document.querySelector("#sound_stop_graph")).then(sound_stop_graph => {
						html2pdf().from("<div></div>").set(opt).toPdf().get('pdf').then(function (pdf) {   
							var logo_sol = new Image;
							var logo_probird = new Image;
							var logo_valeco = new Image;
							logo_sol.src = "/adminasset/images/logo_simple.png";
							logo_probird.src = "/adminasset/images/logo_probird2.png";
							logo_valeco.src = "/adminasset/images/logo_valeco.png";
							var totalPages = pdf.internal.getNumberOfPages();
							console.log('PDf', pdf);
							for (i = 1; i <= totalPages; i++) {
								console.log('here', i);
								pdf.setPage(i);
								pdf.addImage(logo_sol, "PNG", 10, 8, 52, 38);
								pdf.addImage(logo_probird, "PNG", 65, 2, 90, 23);
								pdf.addImage(logo_valeco, "PNG", 140, 26, 65, 15);

								pdf.rect(6, 53, 198, 38);
								pdf.setFont('Helvetica', 'bold');
								pdf.setFontSize(14);
                                pdf.setTextColor('#595959')
								pdf.text('Wind Farm: Capespigne', 13, 60)
								pdf.setFont('Helvetica', 'normal');
								pdf.setFontSize(11);
                                pdf.setTextColor('#000')
								pdf.text('System: ProBird', 13, 68)
								pdf.text('Installation date: 12/10/2021', 13, 76)
								pdf.text('Version: 4', 13, 83)

								pdf.rect(6, 95, 198, 195);
								pdf.setFontSize(14);
								pdf.setFont('Helvetica', 'bold');
                                pdf.setTextColor('#595959')
								pdf.text('Automated report - Global Data', 13, 102)
                                pdf.setTextColor('#000')
								pdf.setFontSize(11);
								pdf.setFont('Helvetica', 'normal');
								pdf.text('Period: ' + first_pdf_period, 13, 110)
                                pdf.setDrawColor('#B0B0B0')

								var width = 0, height = 0;
								var rate = first_progress_section.width / first_progress_section.height;
								width = rate * 30;
								var _w = width;

                                rate = second_progress_section.width / second_progress_section.height;
								width = rate * 30;
                                var _hh=0;
                                if((_w + width) <= 185){
                                    pdf.addImage(first_progress_section, 'JPEG', 13, 118, _w, 30);
                                    pdf.rect(13, 115, _w, 36);
                                    
                                    pdf.addImage(second_progress_section, 'JPEG', 13 + _w, 118, width, 30);
                                    pdf.rect(13 + _w, 115, width, 36);
                                    height = 115 + 36;
                                    _hh = 30;
                                }
                                else{
                                    rate = first_progress_section.height / first_progress_section.width;
                                    _h = rate * 102;
                                    pdf.addImage(first_progress_section, 'JPEG', 13, 118, 102, _h);
                                    pdf.rect(13, 115, 102, _h+6);

                                    rate = second_progress_section.width / second_progress_section.height;
                                    width = rate * _h;
                                    pdf.addImage(second_progress_section, 'JPEG', 13 + 102, 118, width, _h);
                                    pdf.rect(13 + 102, 115, width, _h + 6);
                                    height = 115 +  _h + 6;
                                    _hh = _h;
                                }

								rate = third_section.width / third_section.height;
								width = rate * _hh;
								pdf.addImage(third_section, 'JPEG', 13, height + 5, width, _hh);
								pdf.rect(13, height + 3, width, _hh+3);
								height = height + _hh+3;

                                var h2 =  (285 - height)/2;
								rate = detection_graph.width / detection_graph.height;
								pdf.addImage(detection_graph, 'JPEG', 8, height + 5, 50 * rate + 30, h2);
								height = height + h2 + 2;

								rate = sound_stop_graph.width / sound_stop_graph.height;
								pdf.addImage(sound_stop_graph, 'JPEG', 8, height, 50 * rate + 30, h2);
								clearProgress("", 'first_section_loading', progress)

							}
						}).save();

					});
				});
			});
		});
	});
}

function secondSectionGeneratePDF(title, progress, period)
{

	var opt = {
		margin: [100, 6],
		filename: title + '.pdf',
		image: {
			type: 'jpeg',
			quality: 0.98
		},
		html2canvas: {
			scale: 1,
			letterRendering: true
		},
		jsPDF: {
			unit: 'mm',
			format: 'a4',
			orientation: 'p'
		}
	};


    html2pdf().from('<div></div>').set(opt).toPdf().get('pdf').then(function (pdf) {   
        let pageNumbers = Math.ceil(wt_canvases.length/2)
        var logo_sol = new Image;
        var logo_probird = new Image;
        var logo_valeco = new Image;
        logo_sol.src = "/adminasset/images/logo_simple.png";
        logo_probird.src = "/adminasset/images/logo_probird2.png";
        logo_valeco.src = "/adminasset/images/logo_valeco.png";
        let wt_count = 0;
        wt_canvases.sort(function(a, b){return a.id - b.id});
        for (i = 1; i <= pageNumbers; i++) {
            pdf.addImage(logo_sol, "PNG", 10, 8, 52, 38);
            pdf.addImage(logo_probird, "PNG", 65, 2, 90, 23);
            pdf.addImage(logo_valeco, "PNG", 140, 26, 65, 15);

            pdf.rect(6, 53, 198, 38);
            pdf.setFont('Helvetica', 'bold');
            pdf.setFontSize(14);
            pdf.setTextColor('#595959')
            pdf.text('Wind Farm: Capespigne', 13, 60)
            pdf.setFont('Helvetica', 'normal');
            pdf.setFontSize(11);
            pdf.setTextColor('#000')
            pdf.text('System: ProBird', 13, 68)
            pdf.text('Installation date: 12/10/2021', 13, 76)
            pdf.text('Version: 4', 13, 83)

            pdf.rect(6, 95, 198, 195);
            pdf.setFontSize(14);
            pdf.setFont('Helvetica', 'bold');
            pdf.setTextColor('#595959')
            pdf.text('Wind Turbine Graph', 13, 102)
            pdf.setTextColor('#000')
            pdf.setFontSize(11);
            pdf.setFont('Helvetica', 'normal');
            pdf.text('Period: ' + period, 13, 110)
            pdf.text(i + " of " + pageNumbers, 100, 294)

            var rate = 1000/450;
            if(wt_count < wt_canvases.length) pdf.addImage(wt_canvases[wt_count++].img, 'PNG', 13, 115, rate * 80, 80);
            if(wt_count < wt_canvases.length) pdf.addImage(wt_canvases[wt_count++].img, 'PNG', 13, 205, rate * 80, 80);
            if(i < pageNumbers) pdf.addPage('a4', 'p');
        }
        clearProgress("", 'wt_graph_loading', progress)
    }).save();

}

$(document).ready(function () {
	$("#global-pannel-download").click(function () {
		var progress = rotateProgress('generating...', 2, 'first_section_loading', 99);
		var title = $('#first-title').text().trim();
        setTimeout(function(){
            firstSectionGeneratePDF('first_progress_section', title, progress);
        }, 800);
	})

    $("#wt-pannel-download").click(function () {
		var progress2 = rotateProgress('generating...', 2, 'wt_graph_loading', 99);
        var period = $('#wt_start_time').val() + " - " + $('#wt_end_time').val();
        var title2 = 'WT_Graph_' + period;
        setTimeout(function(){
            secondSectionGeneratePDF(title2, progress2, period);
        }, 800);

	})
    

});

// Loading progress bar
function rotateProgress(title, time, id = "", value = 99) {
	if (id != "") id = "#" + id
	if (id != "") $(id).css({
		display: "flex"
	})
	let percent = 0
	time = time * 10;
    var progress = setInterval(() => {
		percent += 1;
		setProgress(percent, title, id)
		if (percent >= value) clearInterval(progress);

	}, time);
	return progress;
}

function setProgress(percent, title = "", id = "") {
	$(id + ' .progress-title').text(title)
	$(id + ' .mask.full,' + id + ' .circle .fill').css({
		transform: 'rotate(' + 1.8 * percent + 'deg)'
	})
	$(id + ' .percent-value').text(percent);
	if (percent >= 100 && id != "") {
		setTimeout(() => {
			$(id).css({
				display: "none"
			})
			$(id + ' .percent-value').text(0);
		}, 1000)
	}
}

function clearProgress(title, dom_id = "", interval_id) {
	clearInterval(interval_id)
	setProgress(100, "", '#' + dom_id)
}

//   draw wt graph
function draw_wt_graph(start_time, end_time, chart_type) {
	var progress = rotateProgress('loading data...',300, 'wt_graph_loading');
	$.ajax({
		type: 'POST',
		url: '/admin/reporting/wt_graph',
		dataType: 'json',
		data: {
			start: start_time,
			end: end_time,
            chart_type:chart_type
		},
		success: function (response) {
			console.log("response", response);
            setProgress(100, 'loading data...', 'wt_graph_loading');
            clearProgress('loading data...', 'wt_graph_loading', progress);
            if(response.length == 0){
                toastr.info('No data. Please select other date range!');
                return;
            }
            wt_graph(response, chart_type);
		},
        error:function(){
            clearProgress('loading data...', 'wt_graph_loading', progress);
            toastr.error('Error occurs during processing data!');
        }
	});
}


$('#wt_chart_type input[name=chart_type_wt]').click(function(){
    let type = $(this).val();
    let day_range = 2;
    let date_format = 'YYYY-MM-DD HH:mm:ss';
    if(type == 'day') {
        day_range = 365;
        date_format = 'YYYY-MM-DD';
    }
    $('#wt_start_time').val("");
    $('#wt_end_time').val("");
    var input = $('#wt_kt_daterangepicker').find('.form-control');
    input.val("");

    $('#wt_kt_daterangepicker').daterangepicker({
        buttonClasses: ' btn',
        applyClass: 'btn-primary',
        cancelClass: 'btn-light-primary',
        timePicker:true,
        timePicker24Hour:true,
        timePickerSeconds:true,
        maxDate: new Date(),
        maxSpan:{"days": day_range},
        minYear:2021,
    }, function(start, end, label) {
        var input = $('#wt_kt_daterangepicker').find('.form-control');
        let start_time = start.format(date_format);
        let end_time = end.format(date_format);
        input.val( start.format(date_format) + ' ~ ' + end.format(date_format));
        $('#wt_start_time').val(start_time);
        $('#wt_end_time').val(end_time);
    });
});

$('#btn_wt_chart_view').click(function(){
    let start_time = $('#wt_start_time').val();
    let end_time = $('#wt_end_time').val();
    if(start_time == "" || end_time == ""){
        toastr.warning('Please select date range');
        return;
    }
    let chart_type = $('#wt_chart_type input:checked').val();
    console.log(chart_type)
    draw_wt_graph(start_time, end_time, chart_type);
});


function init(){
    let today = new Date();
    let month_ago = new Date();
    month_ago.setMonth(month_ago.getMonth() - 1);
    today = today.getFullYear() + "-" + ('0' + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2);
    month_ago = month_ago.getFullYear() + "-" + ('0' + (month_ago.getMonth() + 1)).slice(-2) + "-" + ('0' + month_ago.getDate()).slice(-2);
    $('#wt_start_time').val(month_ago);
    $('#wt_end_time').val(today);
    var input = $('#wt_kt_daterangepicker').find('.form-control');
    input.val( month_ago + ' ~ ' + today);
    // draw_wt_graph(month_ago, today, 'day');
    draw_wt_graph('2021-10-10', today, 'day');
}

$(document).ready(function(){
    init();
});