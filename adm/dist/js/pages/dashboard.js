/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

/* global moment:false, Chart:false, Sparkline:false */

$(function () {
  'use strict'

  // Make the dashboard widgets sortable Using jquery UI
  $('.connectedSortable').sortable({
    placeholder: 'sort-highlight',
    connectWith: '.connectedSortable',
    handle: '.card-header, .nav-tabs',
    forcePlaceholderSize: true,
    zIndex: 999999
  })
  $('.connectedSortable .card-header').css('cursor', 'move')

  // jQuery UI sortable for the todo list
  $('.todo-list').sortable({
    placeholder: 'sort-highlight',
    handle: '.handle',
    forcePlaceholderSize: true,
    zIndex: 999999
  })

  // bootstrap WYSIHTML5 - text editor
  $('.textarea').summernote()

  $('.daterange').daterangepicker({
    ranges: {
      Today: [moment(), moment()],
      Yesterday: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(29, 'days'),
    endDate: moment()
  }, function (start, end) {
    // eslint-disable-next-line no-alert
    alert('You chose: ' + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
  })

  /* jQueryKnob */
  $('.knob').knob()

  // jvectormap data
  var visitorsData = {
    US: 398, // USA
    SA: 400, // Saudi Arabia
    CA: 1000, // Canada
    DE: 500, // Germany
    FR: 760, // France
    CN: 300, // China
    AU: 700, // Australia
    BR: 600, // Brazil
    IN: 800, // India
    GB: 320, // Great Britain
    RU: 3000 // Russia
  }
  // World map by jvectormap
  $('#world-map').vectorMap({
    map: 'usa_en',
    backgroundColor: 'transparent',
    regionStyle: {
      initial: {
        fill: 'rgba(255, 255, 255, 0.7)',
        'fill-opacity': 1,
        stroke: 'rgba(0,0,0,.2)',
        'stroke-width': 1,
        'stroke-opacity': 1
      }
    },
    series: {
      regions: [{
        values: visitorsData,
        scale: ['#ffffff', '#0154ad'],
        normalizeFunction: 'polynomial'
      }]
    },
    onRegionLabelShow: function (e, el, code) {
      if (typeof visitorsData[code] !== 'undefined') {
        el.html(el.html() + ': ' + visitorsData[code] + ' new visitors')
      }
    }
  })

  // Sparkline charts
  var sparkline1 = new Sparkline($('#sparkline-1')[0], { width: 80, height: 50, lineColor: '#92c1dc', endColor: '#ebf4f9' })
  var sparkline2 = new Sparkline($('#sparkline-2')[0], { width: 80, height: 50, lineColor: '#92c1dc', endColor: '#ebf4f9' })
  var sparkline3 = new Sparkline($('#sparkline-3')[0], { width: 80, height: 50, lineColor: '#92c1dc', endColor: '#ebf4f9' })

  sparkline1.draw([1000, 1200, 920, 927, 931, 1027, 819, 930, 1021])
  sparkline2.draw([515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921])
  sparkline3.draw([15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21])

  // The Calender
  $('#calendar').datetimepicker({
    format: 'L',
    locale: 'sk',
    inline: true
  })

  // SLIMSCROLL FOR CHAT WIDGET
  $('#chat-box').overlayScrollbars({
    height: '250px'
  })

  /* Chart.js Charts */
  // Sales chart
  // var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d');
  // $('#revenue-chart').get(0).getContext('2d');

  var salesChartData = {
    labels: ['Január', 'Február', 'Marec', 'Apríl', 'Máj', 'Jún', 'Júl'],
    datasets: [
      {
        label: 'Objednávky',
        backgroundColor: 'rgba(60,141,188,0.9)',
        borderColor: 'rgba(60,141,188,0.8)',
        pointRadius: false,
        pointColor: '#3b8bba',
        pointStrokeColor: 'rgba(60,141,188,1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data: [28, 48, 40, 19, 86, 27, 90]
      },
      {
        label: 'Predaný tovar',
        backgroundColor: 'rgba(210, 214, 222, 1)',
        borderColor: 'rgba(210, 214, 222, 1)',
        pointRadius: false,
        pointColor: 'rgba(210, 214, 222, 1)',
        pointStrokeColor: '#c1c7d1',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data: [65, 59, 80, 81, 56, 55, 40]
      }
    ]
  };

  var salesChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: false
        }
      }],
      yAxes: [{
        gridLines: {
          display: false
        }
      }]
    }
  };


  // var areaChartCanvas = $('#barChart').get(0).getContext('2d');
  //
  // var areaChartData = {
  //   labels: ['Január', 'Február', 'Marec', 'Apríl', 'Máj', 'Jún', 'Júl','August','September','November','December'],
  //   datasets: [
  //     {
  //       label: 'Objednávky',
  //       backgroundColor: 'rgba(253,126,20,1)',
  //       borderColor: 'rgba(60,141,188,0.8)',
  //       pointRadius: false,
  //       pointColor: '#ed711b',
  //       pointStrokeColor: 'rgba(253,126,20,1)',
  //       pointHighlightFill: '#fff',
  //       pointHighlightStroke: 'rgba(253,126,20,1)',
  //       data: [28, 48, 40, 19, 86, 27, 90]
  //     },
  //     {
  //       label: 'Predaný tovar',
  //       backgroundColor: 'rgba(210, 214, 222, 1)',
  //       borderColor: 'rgba(210, 214, 222, 1)',
  //       pointRadius: false,
  //       pointColor: 'rgba(210, 214, 222, 1)',
  //       pointStrokeColor: '#c1c7d1',
  //       pointHighlightFill: '#fff',
  //       pointHighlightStroke: 'rgba(220,220,220,1)',
  //       data: [65, 59, 80, 81, 56, 55, 40]
  //     },
  //     {
  //       label: 'Obrat',
  //       backgroundColor: 'rgba(251, 160, 84, 1)',
  //       borderColor: 'rgba(210, 214, 222, 1)',
  //       pointRadius: false,
  //       pointColor: 'rgba(210, 214, 222, 1)',
  //       pointStrokeColor: '#c1c7d1',
  //       pointHighlightFill: '#fff',
  //       pointHighlightStroke: 'rgba(220,220,220,1)',
  //       data: [420, 346, 430, 281, 356, 345, 420]
  //     }
  //   ]
  // };
  //
  // var areaChartOptions = {
  //   maintainAspectRatio : false,
  //   responsive : true,
  //   legend: {
  //     display: false
  //   },
  //   scales: {
  //     xAxes: [{
  //       gridLines : {
  //         display : false,
  //       }
  //     }],
  //     yAxes: [{
  //       gridLines : {
  //         display : false,
  //       }
  //     }]
  //   }
  // };
  //
  // // This will get the first returned node in the jQuery collection.
  // new Chart(areaChartCanvas, {
  //   type: 'line',
  //   data: areaChartData,
  //   options: areaChartOptions
  // });
  //-------------
  //- BAR CHART -
  //-------------
  var barChartCanvas = $('#barChart').get(0).getContext('2d');
  var barChartData = $.extend(true, {}, areaChartData);
  var temp0 = areaChartData.datasets[0];
  var temp1 = areaChartData.datasets[1];
  barChartData.datasets[0] = temp1;
  barChartData.datasets[1] = temp0;

  var barChartOptions = {
    responsive              : true,
    maintainAspectRatio     : false,
    datasetFill             : false
  };

  new Chart(barChartCanvas, {
    type: 'bar',
    data: barChartData,
    options: barChartOptions
  })


});
