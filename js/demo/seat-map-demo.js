var perctenage={
    "a1":50,
    "a2":30,
    "a3":10,
    "a4":10
};
// var Librarydata;

// function callback(response) {
//     Librarydata = response;
// }

// $.ajax({
//     url:"db/pie_chart.php",
//     type : "GET",
//     dataType : "json",
//     async: false,
//     success : callback
// })

anychart.onDocumentReady(function () {
	// set chart theme
    anychart.theme('lightBlue');
    var stage = document.getElementById("seatmap");
    // console.log(Librarydata);
    // set svg file
    $.ajax({
        type: 'GET',
        url: './svg/temp.svg',//https://cdn.anychart.com/svg-data/seat-map/sport-mall.svg
        // The data that have been used for this sample can be taken from the CDN
        // load SVG image using jQuery ajax
        success: function (svgData) {
            // data for creating a SeatMap
            var chart = anychart.seatMap([
                { id: 'a1', value: 'A1' },
                { id: 'a2', value: 'A2' },
                { id: 'a3', value: 'A3' },
                { id: 'a4', value: 'A4' }
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
                { equal: '50~100', color: 'rgb(127, 210, 235)' },
                { equal: '30~49', color: 'rgb(111, 193, 117)' },
                { equal: '10~29', color: 'rgb(242, 203, 117)' },
                { equal: '0~9', color: 'rgb(188, 139, 191)' }
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
                var openTime = {};

                switch (this.regionProperties.id) {
                case 'a1':
                    openTime = {
                    workingTime: '9AM-8PM',
                    workingTime24Format: '9-20'
                    };
                    break;
                case 'a2':
                    openTime = {
                    workingTime: '12AM-9PM',
                    workingTime24Format: '12-21'
                    };
                    break;
                case 'a3':
                    openTime = {
                    workingTime: '10AM-9PM',
                    workingTime24Format: '10-21'
                    };
                    break;
                case 'a4':
                    openTime = {
                    workingTime: '8AM-4PM',
                    workingTime24Format: '8-16'
                    };
                    break;
                default:
                }

                var state = isOpen(openTime.workingTime24Format);

                return (
                '<h1 style="color: black;">'+
                this.value +
                ' - ' +
                state +
                '</h1>'+
                '<br><span style="font-size: 10px;color: black;">' +
                openTime.workingTime +
                '</span>'
                );
            });
            // Create chart tooltip own text
            series.tooltip().format(function () {
                var textCompany = LayerSales(); 
                switch (this.regionProperties.id) {
                case 'a1':
                    return textCompany.a1;
                case 'a2':
                    return textCompany.adidas;
                case 'a3':
                    return textCompany.puma;
                case 'a4':
                    return textCompany.reebok;
                default:
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
        case 'a1':
        case 'a2':
        case 'a3':
        case 'a4':
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
function  LayerSales(){
    return {
        a1: 'Layer 1 : \n 中藥：（30,000 元，27個）；酒精：（27,000 元，14個）\n Layer 2：\n 藥水：（21,000 元，43 個）',
        puma: 'To be the fastest sports brand in the world',
        adidas: 'We strive to be the best sports company in the world, \n with brands built on a passion \n for sports and a sporting lifestyle!',
        reebok: 'Retail location for the brand\'s own athletic shoes, \n apparel, backpacks and other accessories.'
    }
}
                