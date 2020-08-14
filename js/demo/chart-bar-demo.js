// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}
// Bar Chart Example

function get_data(){
  $.get("db/bar_chart.php",function (data){
    var month_name=["January","Feburary","March","April","May","June","July","August","September","Octber","Novemeber","December"]
    var month=[];
    var temp=0,max=0,maxpercentage=0;
    var profit_last=[]
    var profit_this=[]
    var percentage_month=[];
    var percentage_year=[];
    for (var i in data) {
      if(i==parseInt((data.length/2))){
        temp=(data[i]['sum']);
      }
      else if (i<(data.length/2)){
        month.push(month_name[data[i]['ym']%100-1]);
        profit_last.push(data[i]['sum']);
      }
      else
        profit_this.push(data[i]['sum']);
    }
    for (var i in profit_this) {
      if (i>0){
        percentage_month.push(((profit_this[i]-profit_this[i-1])/profit_this[i-1])*100);
      }
      else
        percentage_month.push(((profit_this[i]-temp)/temp)*100);
      percentage_year.push(((profit_this[i]-profit_last[i])/profit_last[i])*100);
    }
    if(Math.max(...profit_this)>Math.max(...profit_last)) max=Math.max(...profit_this);
    else max=Math.max(...profit_last);
    if(Math.max.apply(null, percentage_month.map(Math.abs))>Math.max.apply(null, percentage_year.map(Math.abs))) 
      maxpercentage=Math.max.apply(null, percentage_month.map(Math.abs));
    else maxpercentage=Math.max.apply(null, percentage_year.map(Math.abs));

    var ctx = document.getElementById("myBarChart");
    var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: month,
        datasets: [
          {
            label: "Compared Last Month",
            type: 'line',
            fill:'false',
            yAxisID: "y-axis-percentage",
            backgroundColor: "#f6c23e",
            borderColor: "#f6c23e",
            data:percentage_month//[10,20,-10,0,-20]
          },
          {
            label: "Compared Last Year",
            type: 'line',
            fill:'false',
            yAxisID: "y-axis-percentage",
            backgroundColor: "#e74a3b",
            borderColor: "#e74a3b",

            data:percentage_year//[15,25,-40,0,-30]
          },
          {
            label: "Last Year",
            backgroundColor: "#4e73df",
            hoverBackgroundColor: "#2e59d9",
            borderColor: "#4e73df",
            data: profit_last,
          },
          {
            label: "This Year",
            backgroundColor: "#1cc88a",
            hoverBackgroundColor: "#14D892",
            borderColor: "#1cc88a",
            data: profit_this,
          }
        ],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'month'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 6
            },
            maxBarThickness: 25,
          }],
          yAxes: [{
            id: "y-axis-profit",
            ticks: {
              suggestedMin: 0,
              suggestedMax: max,
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function(value, index, values) {
                return '$' + number_format(value);
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          },{
            id: "y-axis-percentage",
            position:"right",
            ticks: {
              min: (-1)*((maxpercentage+10)-(maxpercentage%10)),
              max: (maxpercentage+10)-(maxpercentage%10),
              maxTicksLimit: 5,
              padding: 10,
              // Include a percentage sign in the ticks
              callback: function(value, index, values) {
                return  number_format(value)+'%' ;
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: false
        },
        tooltips: {
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              if ((datasetLabel == 'Compared Last Year') || (datasetLabel == 'Compared Last Month'))
                return datasetLabel + ': ' + number_format(tooltipItem.yLabel)+' %';
              else
                return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
            }
          }
        },
      }
    });
    //console.log(sales_temp);
  });
}

get_data();


