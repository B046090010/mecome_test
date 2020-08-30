

anychart.onDocumentReady(function () {
	// set chart theme
    anychart.theme('lightBlue');
    var stage = acgraph.create('container');

    // The data that have been used for this sample can be taken from the CDN
    // https://cdn.anychart.com/svg-data/seat-map/sport-mall.svg
    // https://cdn.anychart.com/text-data/sport_mall_text.js
    // $('#container').append(
    //     '<div class="seat-map-title">' +
    //     '<h1>Sport Mall</h1>' +
    //     '<p>Source <a href="https://cdn.anychart.com/svg-data/' +
    //     'seat-map/sport-mall.svg"' +
    //     'target="_blank">SVG Image</a></p></div>'
    // );

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
                { equal: 'A1', color: 'rgb(127, 210, 235)' },
                { equal: 'A2', color: 'rgb(111, 193, 117)' },
                { equal: 'A3', color: 'rgb(242, 203, 117)' },
                { equal: 'A4', color: 'rgb(188, 139, 191)' }
                ])
            );

            // sets stroke/fill series
            series.stroke(returnColor);
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
                this.value +
                ' - ' +
                state +
                '<br><span style="font-size: 10px;">' +
                openTime.workingTime +
                '</span>'
                );
            });
            // Create chart tooltip own text
            series.tooltip().format(function () {
                var textCompany = aboutCompany(); 

                switch (this.regionProperties.id) {
                case 'a1':
                    return textCompany.nike;
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
        // attr in svg.file
        var itemClass = attrs.class;
        console.log(itemClass);
        switch (itemClass) {
        case 'a1':
            return 'rgb(127, 210, 235)';
        case 'a2':
            return 'rgb(111, 193, 117)';
        case 'a3':
            return 'rgb(242, 203, 117)';
        case 'a4':
            return 'rgb(188, 139, 191)';
        case 'nike-logo':
        case 'adidas-logo':
        case 'puma-logo':
        case 'reebok-logo':
            return '#606061';
        default:
            return this.sourceColor;
        // it returns the original color for
        // those elements that are not fill/stroke over
        }
    }
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
                