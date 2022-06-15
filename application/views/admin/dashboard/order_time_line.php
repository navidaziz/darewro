<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Highcharts Example</title>
</head>
<body>


<!--<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>-->





<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>

<div id="order_hours" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<div id="orders_record" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="monthly_ordes" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

</body>
<script type="text/javascript">



Highcharts.chart('monthly_ordes', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly Average Temperature'
    },
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    xAxis: {
        categories: [
		
		<?php foreach($months  as $month){ ?> '<?php echo date("F", strtotime("00-".$month->month."-01 00:00:00")); ?>',  <?php } ?>]
    },
    yAxis: {
        title: {
            text: 'Temperature (°C)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Total Order',
        data: [ <?php 
		$food_orders='';
		$general_orders='';
		$cancelled_orders='';
		foreach($months  as $month){ echo $month->total_orders.", "; 
		$food_orders=$food_orders." ".$month->food_orders.", ";
		$general_orders=$general_orders." ".$month->general_orders.", ";
		$cancelled_orders=$cancelled_orders." ".$month->cancelled_orders.", ";
		  } ?> ]
    },
	{
        name: 'Food Orders',
        data: [ <?php echo $food_orders; ?> ]
    }
	,
	{
        name: 'General Orders',
        data: [ <?php echo $general_orders; ?> ]
    }
	,
	{
        name: 'Cancelled Orders',
        data: [ <?php echo $cancelled_orders; ?> ]
    }
	]
});





var seriesOptions = [],
    seriesCounter = 0,
    names = ['order_cancelled', 'order_records'];

/**
 * Create the chart when all data is loaded
 * @returns {undefined}
 */
function createChart() {

    Highcharts.stockChart('orders_record', {

        rangeSelector: {
            selected: 4
        },

        yAxis: {
            labels: {
                formatter: function () {
                    return this.value;
                }
            },
            plotLines: [{
                value: 0,
                width: 2,
                color: 'silver'
            }]
        },

       /* plotOptions: {
            series: {
                compare: 'percent',
                showInNavigator: true
            }
        },*/

        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}<br/>',
            valueDecimals: 0,
            split: true
        },

        series: seriesOptions
    });
}

$.each(names, function (i, name) {

    $.getJSON('<?php echo site_url(ADMIN_DIR."dashboard/"); ?>/' + name.toLowerCase(),    function (data) {

        seriesOptions[i] = {
            name: name,
            data: data
        };

        // As we're loading the data asynchronously, we don't know what order it will arrive. So
        // we keep a counter and create the chart when all the data is loaded.
        seriesCounter += 1;

        if (seriesCounter === names.length) {
            createChart();
        }
    });
});






Highcharts.chart('order_hours', {
    chart: {
        type: 'areaspline'
    },
    title: {
        text: 'Average fruit consumption during one week'
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 150,
        y: 100,
        floating: true,
        borderWidth: 1,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    xAxis: {
        categories: [
		
		<?php foreach($order_hours as $order_hour){ ?>
		'<?php echo @date("h A", strtotime("00-00-00 ".$order_hour->hour.":00:00")); ?>', 
		<?php } ?>
           
		   
        ],
        /*plotBands: [{ // visualize the weekend
            from: 4.5,
            to: 6.5,
            color: 'rgba(68, 170, 213, .2)'
        }]*/
    },
    yAxis: {
        title: {
            text: 'Orders'
        }
    },
    tooltip: {
        shared: true,
        valueSuffix: ' Orders'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0.5
        }
    },
    series: [{
        name: 'Over All Orders',
        data: [
		<?php foreach($order_hours as $order_hour){ ?> <?php echo @$order_hour->total; ?>,<?php } ?>
		]
    },
	
	<?php 
	
	
	
	
	foreach($months  as $month){ ?>
	{
        name: '<?php echo date("F", strtotime("00-".$month->month."-01 00:00:00")); ?>',
        data: [
		<?php foreach($month->order_hours as $order_hour){ 
		
		?> <?php echo $order_hour['total']; ?>,<?php } ?>
		]
    },
	<?php } ?>
	]
});

		</script>
</html>
