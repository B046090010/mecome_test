// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example

function get_data(){
  $.get("db/pie_chart.php",function (data){
    var category=[]
    var profit=[]
    var others=0
    for (var i in data) {
      if (i<4){
        category.push(data[i]['c']);
        //document.getElementById("category-"+i).innerHTML='<i class="fas fa-circle text-primary"></i>'+category[0];
        profit.push(data[i]['sum']);
      }
      else{
        others+=parseInt(data[i]['sum']);
      }  
        
    }
    category.push("其餘");
    profit.push(others);
    document.getElementById("category-1").innerHTML='<i class="fas fa-circle text-primary"></i>'+category[0];
    document.getElementById("category-2").innerHTML='<i class="fas fa-circle text-success"></i>'+category[1];
    document.getElementById("category-3").innerHTML='<i class="fas fa-circle text-info"></i>'+category[2];
    document.getElementById("category-4").innerHTML='<i class="fas fa-circle text-warning"></i>'+category[3];
    document.getElementById("category-6").innerHTML='<i class="fas fa-circle text-secondary"></i>'+category[4];
    //new
    // Chart.defaults.global.tooltips.custom = function (tooltip) {
    //   // Tooltip Element
    //   var tooltipEl = document.getElementById('chartjs-tooltip');
    //   // Hide if no tooltip
    //   if (tooltip.opacity === 0) {
    //       tooltipEl.style.color = "#464950";
    //       $("#chartjs-tooltip div p").text("100%");

    //       tooltipEl.style.opacity = 0;
    //       return;
    //   }
    //   tooltipEl.classList.remove('above', 'below', 'no-transform');
    //   if (tooltip.yAlign) {
    //       tooltipEl.classList.add(tooltip.yAlign);
    //   } else {
    //       tooltipEl.classList.add('no-transform');
    //   }
    //   function getBody(bodyItem) {
    //       return bodyItem.lines;
    //   }
    //   // Set Text
    //   if (tooltip.body) {
    //       var bodyLines = tooltip.body.map(getBody);
    //       var innerHtml = '<p>';
    //       bodyLines.forEach(function (body, i) {
    //           var dataNumber = body[i].split(":");
    //           var dataValNum = parseInt(dataNumber[1].trim());
    //           var dataToPercent = (dataValNum / (others+profit) * 100).toFixed(2) + '%';
    //           innerHtml += dataToPercent;
    //           console.log(dataToPercent);
    //       });

    //       innerHtml += '</p>';

    //       var tableRoot = tooltipEl.querySelector('div');
    //       tableRoot.innerHTML = innerHtml;
    //   }
    //   tooltipEl.style.opacity = 1;
    //   tooltipEl.style.color = "#FFF";
    // };
    //new
    
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: category,//["Direct", "Referral", "Social"],
        datasets: [{
          data: profit,//[55, 30, 15],
          backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#858796'],
          hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        //new
        // tooltips:{
        //   enabled: false
        // },
        //
        cutoutPercentage: 80,
      },
    });
  });
}
get_data();
