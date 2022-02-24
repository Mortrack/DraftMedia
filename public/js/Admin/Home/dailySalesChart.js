<!-- javascript init -->
// General configuration for the charts with Line gradientStroke
gradientChartOptionsConfiguration =  {
    maintainAspectRatio: false,
    legend: {
        display: false
    },

    tooltips: {
        backgroundColor: '#fff',
        titleFontColor: '#333',
        bodyFontColor: '#666',
        bodySpacing: 4,
        xPadding: 12,
        mode: "nearest",
        intersect: 0,
        position: "nearest"
    },
    responsive: true,
    scales:{
        yAxes: [{
            barPercentage: 1.6,
            gridLines: {
                drawBorder: true,
                color: 'rgba(32,151,238,0.1)',
                zeroLineColor: "transparent",
            },
            ticks: {
                suggestedMin:50,
                suggestedMax: 110,
                padding: 20,
                fontColor: "#9a9a9a"
            }
        }],

        xAxes: [{
            barPercentage: 0.9,
            gridLines: {
                drawBorder: true,
                color: 'rgba(32,151,238,0.1)',
                zeroLineColor: "transparent",
            },
            ticks: {
                padding: 20,
                fontColor: "#9a9a9a"
            }
        }]
    }
};

var ctx = document.getElementById("CountryChart").getContext("2d");

var gradientStroke = ctx.createLinearGradient(0,230,0,50);

gradientStroke.addColorStop(1, 'rgba(72,72,176,0.2)');
gradientStroke.addColorStop(0.2, 'rgba(72,72,176,0.0)');
gradientStroke.addColorStop(0, 'rgba(119,52,169,0)'); //purple colors

var data = {
    labels: ['LUN', 'MAR', 'MIE', 'JUE', 'VIE', 'SAB', 'DOM'],
    datasets: [{
        label: "Data",
        fill: true,
        backgroundColor: gradientStroke,
        borderColor: '#2097ee',
        borderWidth: 2,
        borderDash: [],
        borderDashOffset: 0.0,
        pointBackgroundColor: '#2097ee',
        pointBorderColor:'rgba(255,255,255,0)',
        pointHoverBackgroundColor: '#2097ee',
        pointBorderWidth: 20,
        pointHoverRadius: 4,
        pointHoverBorderWidth: 15,
        pointRadius: 4,
        data: [ 60,110,70,100, 75, 90, 80, 100, 70, 80, 120, 80],
    }]
};

var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: gradientChartOptionsConfiguration
});
