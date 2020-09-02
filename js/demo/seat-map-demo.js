var perctenage={};
var sales={};
function callback(response) {
    for(var i in response[0]){
        perctenage[response[0][i]['Location']]=(response[0][i]['Sales(%)']*100).toFixed(2);
        sales[response[0][i]['Location']]={1:[],2:[],3:[],4:[],5:[],6:[],7:[]}
    }
    for (var i in response[1]){
        temp=response[1][i]['Name']+"($"+response[1][i]['Sales']+")";
        sales[response[1][i]['Location']][response[1][i]['Layer']].push(temp);
    }
    delete temp;
}

$.ajax({
    url:"db/seat_map.php",
    type : "GET",
    data:{start:$("#datepicker").val(),end:$("#datepickere").val(),main:$("#smain").val(),middle:$("#smiddle").val(),detail:$("#sdetail").val(),store:$("#sstore").val()},
    dataType : "json",
    async: false,
    success : callback
})

anychart.onDocumentReady(function () {
	// set chart theme
    anychart.theme('lightBlue');
    var stage = document.getElementById("seatmap");
    var c_store=($("#sstore").val());
    if (c_store == "-" )
        c_store= '149';
    // set svg file
    $.ajax({
        type: 'GET',
        url: './svg/'+c_store+'.svg',//https://cdn.anychart.com/svg-data/seat-map/sport-mall.svg
        // The data that have been used for this sample can be taken from the CDN
        // load SVG image using jQuery ajax
        success: function (svgData) {
            // data for creating a SeatMap
            var chart = anychart.seatMap([
                { id: 'a', value: 'A' },
                { id: 'b', value: 'B' },
                { id: 'c', value: 'C' },
                { id: 'd', value: 'D' }
            ]);
            // set svg data
            chart.geoData(svgData);
            // load svg-file how it looked(colors stroke/fill)
            chart
                .unboundRegions('as-is')
                // set chart padding
                .padding([10]);

            // create chart legend
            var legend = chart.legend();
            legend
                .enabled(true)
                // items source mode categories
                .itemsSourceMode('categories')
                .position('right')
                .itemsLayout('vertical');

            var series = chart.getSeries(0);
            // set color scale.
            series.colorScale(
                anychart.scales.ordinalColor([
                { equal: '50~100%', color: 'rgb(127, 210, 235)' },
                { equal: '30~49%', color: 'rgb(111, 193, 117)' },
                { equal: '10~29%', color: 'rgb(242, 203, 117)' },
                { equal: '0~9%', color: 'rgb(188, 139, 191)' }
                ])
            );

            // sets stroke/fill series
            series.stroke('rgb(56, 52, 56)');
            series.fill(returnColor);

            // sets fill on hover series and select series
            series.hovered().fill(returnColorHoverAndSelect);
            series.selected().fill(returnColorHoverAndSelect);

            // Create chart tooltip own title
            series.tooltip().title().useHtml(true);
            series.tooltip().titleFormat(function () {
                return (
                    '<h1 style="color: black;">'+
                    this.value +'\t('+perctenage[this.regionProperties.id]+
                    ')%</h1>'
                );
            });
            // Create chart tooltip own text
            series.tooltip().format(function () {
                if (sales[this.regionProperties.id]!=null){
                    temp="";
                    for (var i in sales[this.regionProperties.id]){
                        if (sales[this.regionProperties.id][i].length>0){
                            temp+="Layer "+i+":\n"+sales[this.regionProperties.id][i].join("\n")+"\n";
                        }
                    }
                    return temp;
                }
            });

            // set container id for the chart
            chart.container(stage);
            // initiate chart drawing
            chart.draw();
        }
    });
});

function returnColor() {
    var attrs = this.attributes;
    

    if (attrs) {
        var itemClass = attrs.class;
        if (perctenage[itemClass]>=50)
            return 'rgb(127, 210, 235)';
        else if (perctenage[itemClass]>=30)
            return 'rgb(111, 193, 117)';
        else if (perctenage[itemClass]>=10)
            return 'rgb(242, 203, 117)';
        else if (perctenage[itemClass]>=0)
            return 'rgb(188, 139, 191)';
        else
            return this.sourceColor;
    }
    // if (attrs) {
    //     // attr in svg.file
    //     var itemClass = attrs.class;
    //     switch (itemClass) {
    //     case 'a1':
    //         return 'rgb(127, 210, 235)';
    //     case 'a2':
    //         return 'rgb(111, 193, 117)';
    //     case 'a3':
    //         return 'rgb(242, 203, 117)';
    //     case 'a4':
    //         return 'rgb(188, 139, 191)';
    //     case 'nike-logo':
    //     case 'adidas-logo':
    //     case 'puma-logo':
    //     case 'reebok-logo':
    //         return '#606061';
    //     default:
    //         return this.sourceColor;
    //     // it returns the original color for
    //     // those elements that are not fill/stroke over
    //     }
    // }
}

function returnColorHoverAndSelect() {
    var attrs = this.attributes;
    if (attrs) {
        // attr in svg.file
        var itemClass = attrs.class;
        switch (itemClass) {
        case 'a':
        case 'b':
        case 'c':
        case 'd':
            return anychart.color.lighten(this.sourceColor, 0.25);
        case 'nike-logo':
        case 'adidas-logo':
        case 'puma-logo':
        case 'reebok-logo':
            return anychart.color.darken(this.sourceColor, 0.5);
        default:
            return this.sourceColor;
        // it returns the original color for
        // those elements that are not fill/stroke over
        }
    }
}

    // function return state open or close.
function isOpen(date) {
    var d = new Date(); // for now
    var min = 60;
    var currentTime = d.getHours() * min + d.getMinutes();
    // if it is not Sunday
    if (d.getDay() !== 0) {
        if (
        currentTime >= date.split('-')[0] * min &&
        currentTime <= date.split('-')[1] * min
        ) {
            return 'open';
        }
        return 'close';
    }
    return 'close';
}        