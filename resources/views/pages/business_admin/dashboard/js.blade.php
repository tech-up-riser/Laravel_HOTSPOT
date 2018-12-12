<script src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    $(function() {
        /* ChartJS
         * -------
         * Data and config for chartjs
         */
        'use strict';

        var man = "{{ isset($man) ? $man : 0 }}";
        var women = "{{ isset($women) ? $women : 0 }}";
        var regionData = document.getElementById('region_chart_id').value;
        regionData = JSON.parse(regionData);

        var ageData = document.getElementById('age_chart_id').value;
        ageData = JSON.parse(ageData);

        var userData = document.getElementById('userlist_chart_id').value;
        userData = JSON.parse(userData);

        //Get New vs Returning User Data
        var month_data = document.getElementById('vs_month_data').value;
        month_data = JSON.parse(month_data);
        var new_user_data = document.getElementById('vs_new_user_data').value;
        new_user_data = JSON.parse(new_user_data);
        var old_user_data = document.getElementById('vs_old_user_data').value;
        old_user_data = JSON.parse(old_user_data);
        var max_value = Math.max.apply(Math, new_user_data.concat(old_user_data)) + 1;

        if ($("#pieChart").length) {
            var ctx = document.getElementById('pieChart').getContext("2d");
            var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 181);
            gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
            gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
            var gradientLegendBlue = 'linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))';

            var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 50);
            gradientStrokeRed.addColorStop(0, 'rgba(255, 191, 150, 1)');
            gradientStrokeRed.addColorStop(1, 'rgba(254, 112, 150, 1)');
            var gradientLegendRed = 'linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))';

            var trafficChartData = {
                datasets: [{
                    data: [man, women],
                    backgroundColor: [
                        gradientStrokeBlue,
                        gradientStrokeRed
                    ],
                    hoverBackgroundColor: [
                        gradientStrokeBlue,
                        gradientStrokeRed
                    ],
                    borderColor: [
                        gradientStrokeBlue,
                        gradientStrokeRed
                    ],
                    legendColor: [
                        gradientLegendBlue,
                        gradientLegendRed
                    ]
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: [
                    'Male Users',
                    'Female Users',
                ]
            };
            var trafficChartOptions = {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                legend: false,
                legendCallback: function(chart) {
                    var text = [];
                    text.push('<ul>');
                    for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) {
                        text.push('<li><span class="legend-dots" style="background:' +
                            trafficChartData.datasets[0].legendColor[i] +
                            '"></span>');
                        if (trafficChartData.labels[i]) {
                            text.push(trafficChartData.labels[i]);
                        }
                        text.push('<span class="float-right">'+trafficChartData.datasets[0].data[i]+""+'</span>')
                        text.push('</li>');
                    }
                    text.push('</ul>');
                    return text.join('');
                }
            };
            var trafficChartCanvas = $("#pieChart").get(0).getContext("2d");
            var trafficChart = new Chart(trafficChartCanvas, {
                type: 'doughnut',
                data: trafficChartData,
                options: trafficChartOptions
            });
            $("#gender-chart-legend").html(trafficChart.generateLegend());
        }

        // Age Bar chart
        var data = {
            labels: [" - 17", "18 - 24", "25 - 34", "35 - 44", "45 - 54", "55+"],
            datasets: [{
                label: 'Users',
                data: ageData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        };

        var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legend: {
                display: false
            },
            elements: {
                point: {
                    radius: 0
                }
            }

        };
        if ($("#barChart").length) {
            var barChartCanvas = $("#barChart").get(0).getContext("2d");

            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: data,
                options: options
            });
        }
        // Age chart end

        // Time of Login Chart
        var login_title = document.getElementById('login_title').value;
        login_title = JSON.parse(login_title);
        var login_value = document.getElementById('login_value').value;
        login_value = JSON.parse(login_value);

        var areaData = {
            labels: login_title,
            datasets: [{
                label: 'Login Numbers',
                data: login_value,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1,
                fill: true, // 3: no fill
            }]
        };

        var areaOptions = {
            plugins: {
                filler: {
                    propagate: true
                }
            },
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                        beginAtZero: true,  // minimum value will be 0.
                        stepSize: 1
                    }
                }]
            }
        }

        if ($("#loginChart").length) {
            var areaChartCanvas = $("#loginChart").get(0).getContext("2d");
            var areaChart = new Chart(areaChartCanvas, {
                type: 'line',
                data: areaData,
                options: areaOptions
            });
        }
        // Time of Login Chart End

        // Regional Chart
        google.charts.load('current', {
            'packages': ['geochart'],
            // Note: you will need to get a mapsApiKey for your project.
            // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
            'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
        });
        google.charts.setOnLoadCallback(drawRegionsMap);

        function drawRegionsMap() {
            var data = google.visualization.arrayToDataTable(regionData);

            var options = {
                colorAxis: {
                    colors: ['#76C1FA', '#63CF72', '#F36368', '#FABA66']
                }
            };
            var chart = new google.visualization.GeoChart(document.getElementById('regions-chart'));

            chart.draw(data, options);
        }
        // Region Charts Ends

        //New vs Returnning User Chart
        if ($("#new-returning-chart").length) {
            Chart.defaults.global.legend.labels.usePointStyle = true;
            var ctx = document.getElementById('new-returning-chart').getContext("2d");

            var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 181);
            gradientStrokeViolet.addColorStop(0, 'rgba(218, 140, 255, 1)');
            gradientStrokeViolet.addColorStop(1, 'rgba(154, 85, 255, 1)');
            var gradientLegendViolet = 'linear-gradient(to right, rgba(218, 140, 255, 1), rgba(154, 85, 255, 1))';

            var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 360);
            gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
            gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
            var gradientLegendBlue = 'linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))';

            var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStrokeRed.addColorStop(0, 'rgba(255, 191, 150, 1)');
            gradientStrokeRed.addColorStop(1, 'rgba(254, 112, 150, 1)');
            var gradientLegendRed = 'linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))';

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: month_data,
                    datasets: [
                        {
                            label: "New User",
                            borderColor: gradientStrokeRed,
                            backgroundColor: gradientStrokeRed,
                            hoverBackgroundColor: gradientStrokeRed,
                            legendColor: gradientLegendRed,
                            pointRadius: 0,
                            fill: false,
                            borderWidth: 1,
                            fill: 'origin',
                            data: new_user_data
                        },
                        {
                            label: "Returning User",
                            borderColor: gradientStrokeBlue,
                            backgroundColor: gradientStrokeBlue,
                            hoverBackgroundColor: gradientStrokeBlue,
                            legendColor: gradientLegendBlue,
                            pointRadius: 0,
                            fill: false,
                            borderWidth: 1,
                            fill: 'origin',
                            data: old_user_data
                        }
                    ]
                },
                options: {
                    responsive: true,
                    legend: false,
                    legendCallback: function(chart) {
                        var text = [];
                        text.push('<ul>');
                        for (var i = 0; i < chart.data.datasets.length; i++) {
                            text.push('<li><span class="legend-dots" style="background:' +
                                chart.data.datasets[i].legendColor +
                                '"></span>');
                            if (chart.data.datasets[i].label) {
                                text.push(chart.data.datasets[i].label);
                            }
                            text.push('</li>');
                        }
                        text.push('</ul>');
                        return text.join('');
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                display: false,
                                min: 0,
                                stepSize: Math.floor(max_value/2),
                                max: max_value
                            },
                            gridLines: {
                                drawBorder: false,
                                color: 'rgba(235,237,242,1)',
                                zeroLineColor: 'rgba(235,237,242,1)'
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display:false,
                                drawBorder: false,
                                color: 'rgba(0,0,0,1)',
                                zeroLineColor: 'rgba(235,237,242,1)'
                            },
                            ticks: {
                                padding: 20,
                                fontColor: "#9c9fa6",
                                autoSkip: true,
                            },
                            categoryPercentage: 0.5,
                            barPercentage: 0.5
                        }]
                    }
                },
                elements: {
                    point: {
                        radius: 0
                    }
                }
            })
            $("#new-returning-chart-legend").html(myChart.generateLegend());
        }

        //New vs Returning user end

        //List Of Users chart (Facebook, Twitter, Instagram, Linkedin, Normal)

        if ($("#list-users-chart").length) {
            var ctx = document.getElementById('pieChart').getContext("2d");
            var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 181);
            gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
            gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
            var gradientLegendBlue = 'linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))';

            var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 50);
            gradientStrokeRed.addColorStop(0, 'rgba(255, 191, 150, 1)');
            gradientStrokeRed.addColorStop(1, 'rgba(254, 112, 150, 1)');
            var gradientLegendRed = 'linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))';

            var gradientStrokeGreen = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStrokeGreen.addColorStop(0, 'rgba(6, 185, 157, 1)');
            gradientStrokeGreen.addColorStop(1, 'rgba(132, 217, 210, 1)');
            var gradientLegendGreen = 'linear-gradient(to right, rgba(6, 185, 157, 1), rgba(132, 217, 210, 1))';

            var gradientStrokePurple = ctx.createLinearGradient(0, 0, 0, 150);
            gradientStrokePurple.addColorStop(0, 'rgba(218, 140, 255, 1)');
            gradientStrokePurple.addColorStop(1, 'rgba(154, 85, 255, 1)');
            var gradientLegendPurple = 'linear-gradient(to right, rgba(218, 140, 255, 1), rgba(154, 85, 255, 1))';

            var gradientStrokeYellow = ctx.createLinearGradient(0, 0, 0, 150);
            gradientStrokeYellow.addColorStop(0, 'rgba(246, 227, 132, 1)');
            gradientStrokeYellow.addColorStop(1, 'rgba(255, 213, 0, 1)');
            var gradientLegendYellow = 'linear-gradient(to right, rgba(246, 227, 132, 1), rgba(255, 213, 0, 1))';

            var trafficChartData = {
                datasets: [{
                    data: userData,
                    backgroundColor: [
                        gradientStrokeBlue,
                        gradientStrokeRed,
                        gradientStrokeGreen,
                        gradientStrokePurple,
                        gradientStrokeYellow
                    ],
                    hoverBackgroundColor: [
                        gradientStrokeBlue,
                        gradientStrokeRed,
                        gradientStrokeGreen,
                        gradientStrokePurple,
                        gradientStrokeYellow
                    ],
                    borderColor: [
                        gradientStrokeBlue,
                        gradientStrokeRed,
                        gradientStrokeGreen,
                        gradientStrokePurple,
                        gradientStrokeYellow
                    ],
                    legendColor: [
                        gradientLegendBlue,
                        gradientLegendRed,
                        gradientLegendGreen,
                        gradientLegendPurple,
                        gradientLegendYellow
                    ]
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: [
                    'Facebook',
                    'Twitter',
                    'Instagram',
                    'Linkedin',
                    'Normal',
                ]
            };
            var trafficChartOptions = {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                legend: false,
                legendCallback: function(chart) {
                    var text = [];
                    text.push('<ul>');
                    for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) {
                        text.push('<li><span class="legend-dots" style="background:' +
                            trafficChartData.datasets[0].legendColor[i] +
                            '"></span>');
                        if (trafficChartData.labels[i]) {
                            text.push(trafficChartData.labels[i]);
                        }
                        text.push('<span class="float-right">'+trafficChartData.datasets[0].data[i]+""+'</span>')
                        text.push('</li>');
                    }
                    text.push('</ul>');
                    return text.join('');
                }
            };
            var trafficChartCanvas = $("#list-users-chart").get(0).getContext("2d");
            var trafficChart = new Chart(trafficChartCanvas, {
                type: 'doughnut',
                data: trafficChartData,
                options: trafficChartOptions
            });
            $("#list-users-chart-legend").html(trafficChart.generateLegend());
        }

    });
</script>