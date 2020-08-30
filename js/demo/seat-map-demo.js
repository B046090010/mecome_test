

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
        url: './svg/sport-mall.svg',//https://cdn.anychart.com/svg-data/seat-map/sport-mall.svg
        // The data that have been used for this sample can be taken from the CDN
        // load SVG image using jQuery ajax
        success: function (svgData) {
            // data for creating a SeatMap
            var chart = anychart.seatMap([
                { id: 'nike', value: 'Nike' },
                { id: 'adidas', value: 'Adidas' },
                { id: 'puma', value: 'Puma' },
                { id: 'reebok', value: 'Reebok' }
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
                { equal: 'Nike', color: 'rgb(127, 210, 235)' },
                { equal: 'Adidas', color: 'rgb(111, 193, 117)' },
                { equal: 'Puma', color: 'rgb(242, 203, 117)' },
                { equal: 'Reebok', color: 'rgb(188, 139, 191)' }
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
                case 'nike':
                    openTime = {
                    workingTime: '9AM-8PM',
                    workingTime24Format: '9-20'
                    };
                    break;
                case 'adidas':
                    openTime = {
                    workingTime: '12AM-9PM',
                    workingTime24Format: '12-21'
                    };
                    break;
                case 'puma':
                    openTime = {
                    workingTime: '10AM-9PM',
                    workingTime24Format: '10-21'
                    };
                    break;
                case 'reebok':
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
                case 'nike':
                    return textCompany.nike;
                case 'adidas':
                    return textCompany.adidas;
                case 'puma':
                    return textCompany.puma;
                case 'reebok':
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
        switch (itemClass) {
        case 'nike':
            return 'rgb(127, 210, 235)';
        case 'adidas':
            return 'rgb(111, 193, 117)';
        case 'puma':
            return 'rgb(242, 203, 117)';
        case 'reebok':
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
        case 'nike':
        case 'adidas':
        case 'puma':
        case 'reebok':
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
                