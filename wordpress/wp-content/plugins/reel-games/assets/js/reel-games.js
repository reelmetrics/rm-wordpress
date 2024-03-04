jQuery(document).ready(function($) {
    $('body').addClass('dx-viewport');

    // Color Palette
    const mainColor = '#b91c1a';
    const darkBlueColor = '#192f3d';
    const goldColor = '#d4af37';
    const lightBlueColor = '#00bfff';
    const lightGreyColor = '#d3d3d3';

    const chartHeight = 250;

    // Extract and transform the data for each metric
    const consolidatedData = reelGamesData.gameData.lifecyle_analysis_json.map(item => {
        return {
            monthYear: new Date(item.reporting_month_yyyymm).toLocaleString('default', { month: 'short', year: 'numeric' }),
            terminals: item.terminals,
            marketShare: item.marketshare,
            venues: item.venues
        };
    });

        // 2. TimeSeries Chart initialization Performance over Time
    if ($('#timeSeriesChart').length) {
            const timeSeriesData = reelGamesData.gameData.lifecyle_analysis_json.map(item => {
                return {
                    date: new Date(item.reporting_month_yyyymm),
                    gptwRpm: item.gptw_rpm,
                    floorAverage: 1, // Assuming floorAverage is a constant value of 1
                    theoWin: item.tw_rpm,
                    gamesPlayed: item.gp_rpm
                };
            });
        
            $("#timeSeriesChart").dxChart({
                dataSource: timeSeriesData,
                commonSeriesSettings: {
                    argumentField: 'date',
                    type: 'line'
                },
                series: [
                    { valueField: 'gptwRpm', name: 'GPTW RPM', color: mainColor },
                    { valueField: 'floorAverage', name: 'Floor Average', color: lightGreyColor, point: { visible: false }, hoverMode: 'none',  },
                    { valueField: 'theoWin', name: 'Theo Win', color: goldColor },
                    { valueField: 'gamesPlayed', name: 'Games Played', color: lightBlueColor }
                ],
                argumentAxis: {
                    valueMarginsEnabled: false,
                    discreteAxisDivisionMode: 'crossLabels',
                    grid: {
                        visible: true
                    }
                },
                valueAxis: [
                    {
                        name: 'gptwValueAxis',
                        position: 'left'
                    },
                    {
                        name: 'floorAverageValueAxis',
                        position: 'right'
                    }
                ],
                tooltip: {
                    enabled: true,
                    shared: true
                },
                legend: {
                    verticalAlignment: "top",
                    horizontalAlignment: "center"
                },
                title: "Time Series Analysis",
            });
    }
        
    // 3. Adoption Over Time Chart initialization
    if ($('#adoptionOverTimeChart').length) {
        const adoptionData = reelGamesData.gameData.lifecyle_analysis_json.map(item => {
            return {
                date: new Date(item.reporting_month_yyyymm),
                terminals: item.terminals,
                venues: item.venues,
                games: item.games
            };
        });

        $("#adoptionOverTimeChart").dxChart({
            dataSource: adoptionData,
            commonSeriesSettings: {
                argumentField: 'date',
                type: 'line'
            },
            series: [
                { valueField: 'terminals', name: 'Terminals', color: mainColor },
                { valueField: 'venues', name: 'Venues', color: goldColor },
                { valueField: 'games', name: 'Games', color: lightBlueColor }
            ],
            argumentAxis: {
                valueMarginsEnabled: false,
                discreteAxisDivisionMode: 'crossLabels',
                grid: {
                    visible: true
                }
            },
            tooltip: {
                enabled: true,
                shared: true
            },
            legend: {
                verticalAlignment: "top",
                horizontalAlignment: "center"
            },
            title: "Adoption Over Time",
        });
    }
    
    // 4. revenueInsightsChart Chart initialization
    if ($('#revenueInsightsChart').length) {
        const revenueData = reelGamesData.gameData.lifecyle_analysis_json.map(item => ({
            date: new Date(item.reporting_month_yyyymm),
            gp_rpm: item.gp_rpm,
            tw_rpm: item.tw_rpm,
            gptw_rpm: item.gptw_rpm
        }));

        $("#revenueInsightsChart").dxChart({
            dataSource: revenueData,
            commonSeriesSettings: {
                argumentField: 'date',
                type: 'line'
            },
            series: [
                { valueField: 'gp_rpm', name: 'GP RPM', color: mainColor },
                { valueField: 'tw_rpm', name: 'TW RPM', color: goldColor },
                { valueField: 'gptw_rpm', name: 'GPTW RPM', color: lightBlueColor }
            ],
            argumentAxis: {
                valueMarginsEnabled: false,
                discreteAxisDivisionMode: 'crossLabels',
                grid: {
                    visible: true
                }
            },
            tooltip: {
                enabled: true,
                shared: true
            },
            legend: {
                verticalAlignment: "top",
                horizontalAlignment: "center"
            },
            title: "Revenue Insights",
        });
    }

    // 5. marketShareParetoChart Chart initialization
    if ($('#marketShareParetoChart').length) {
            const data = reelGamesData.gameData.lifecyle_analysis_json.sort((a, b) => new Date(a.reporting_month_yyyymm) - new Date(b.reporting_month_yyyymm)); // Sort by date
            let cumulativeCount = 0;
            const totalCount = data.reduce((prevValue, item) => prevValue + item.marketshare, 0);
            const dataSource = data.map((item) => {
                cumulativeCount += item.marketshare;
                return {
                    monthYear: new Date(item.reporting_month_yyyymm).toLocaleString('default', { month: 'short', year: 'numeric' }),
                    marketshare: item.marketshare,
                    cumulativePercentage: Math.round((cumulativeCount * 100) / totalCount)
                };
            }
            );
        
            $('#marketShareParetoChart').dxChart({
                palette: 'Harmony Light',
                dataSource,
                title: 'Market Share',
                argumentAxis: {
                    type: 'continuous',
                    label: {
                        overlappingBehavior: 'rotate', // this will rotate the labels if they overlap
                        rotationAngle: 45 // angle of rotation
                    }
                },
                tooltip: {
                    enabled: true,
                    shared: true,
                },
                valueAxis: [{
                    name: 'marketshare',
                    position: 'left',
                }, {
                    name: 'percentage',
                    position: 'right',
                    showZero: true,
                    label: {
                        customizeText(info) {
                            return `${info.valueText}%`;
                        }
                    },
                    constantLines: [{
                        value: 80,
                        color: '#d4af37',
                        dashStyle: 'dash',
                        width: 2,
                        label: { visible: false }
                    }],
                    tickInterval: 20,
                    valueMarginsEnabled: false
                }],
                commonSeriesSettings: {
                    argumentField: 'monthYear'
                },
                series: [{
                    type: 'bar',
                    valueField: 'marketshare',
                    axis: 'marketshare',
                    name: 'Market Share',
                    color: '#b91c1a'
                }, {
                    type: 'spline',
                    valueField: 'cumulativePercentage',
                    axis: 'percentage',
                    name: 'Cumulative percentage',
                    color: '#D3D3D3',
                    point: { visible: false }, // Hide circular points
                    hoverMode: 'none', // Disable hover effect on the line
                }],
                legend: {
                    verticalAlignment: 'bottom',
                    horizontalAlignment: 'center'
                },
                size: {
                    height: chartHeight
                }
            });
    }

    // 6. Terminal Distribution & Status Chart initialization
    if ($('#terminalsParetoChart').length) {
        const data = reelGamesData.gameData.lifecyle_analysis_json.sort((a, b) => new Date(a.reporting_month_yyyymm) - new Date(b.reporting_month_yyyymm)); // Sort by date
        let cumulativeCount = 0;
        const totalCount = data.reduce((prevValue, item) => prevValue + item.terminals, 0);
        const dataSource = data.map((item) => {
            cumulativeCount += item.terminals;
            return {
                monthYear: new Date(item.reporting_month_yyyymm).toLocaleString('default', { month: 'short', year: 'numeric' }),
                terminals: item.terminals,
                cumulativePercentage: Math.round((cumulativeCount * 100) / totalCount)
            };
        });
    
        $('#terminalsParetoChart').dxChart({
            palette: 'Harmony Light',
            dataSource,
            title: 'Terminals',
            argumentAxis: {
                type: 'continuous',
                label: {
                    overlappingBehavior: 'rotate', // this will rotate the labels if they overlap
                    rotationAngle: 45 // angle of rotation
                }
            },
            tooltip: {
                enabled: true,
                shared: true,
            },
            valueAxis: [{
                name: 'terminals',
                position: 'left',
            }, {
                name: 'percentage',
                position: 'right',
                showZero: true,
                label: {
                    customizeText(info) {
                        return `${info.valueText}%`;
                    }
                },
                constantLines: [{
                    value: 80,
                    color: '#d4af37',
                    dashStyle: 'dash',
                    width: 2,
                    label: { visible: false }
                }],
                tickInterval: 20,
                valueMarginsEnabled: false
            }],
            commonSeriesSettings: {
                argumentField: 'monthYear'
            },
            series: [{
                type: 'bar',
                valueField: 'terminals',
                axis: 'terminals',
                name: 'Terminals',
                color: '#b91c1a'
            }, {
                type: 'spline',
                valueField: 'cumulativePercentage',
                axis: 'percentage',
                name: 'Cumulative percentage',
                color: '#D3D3D3',
                point: { visible: false }, // Hide circular points
                hoverMode: 'none', // Disable hover effect on the line
            }],
            legend: {
                verticalAlignment: 'bottom',
                horizontalAlignment: 'center'
            },
            size: {
                height: chartHeight
            }
        });
    }

    // 7. Venue Distribution & Analysis Chart initialization
    if ($('#venuesParetoChart').length) {
        const data = reelGamesData.gameData.lifecyle_analysis_json.sort((a, b) => new Date(a.reporting_month_yyyymm) - new Date(b.reporting_month_yyyymm)); // Sort by date
        let cumulativeCount = 0;
        const totalCount = data.reduce((prevValue, item) => prevValue + item.venues, 0);
        const dataSource = data.map((item) => {
            cumulativeCount += item.venues;
            return {
                monthYear: new Date(item.reporting_month_yyyymm).toLocaleString('default', { month: 'short', year: 'numeric' }),
                venues: item.venues,
                cumulativePercentage: Math.round((cumulativeCount * 100) / totalCount)
            };
        }
        );

        $('#venuesParetoChart').dxChart({
            palette: 'Harmony Light',
            dataSource,
            title: 'Venues',
            argumentAxis: {
                type: 'continuous',
                label: {
                    overlappingBehavior: 'rotate', // this will rotate the labels if they overlap
                    rotationAngle: 45 // angle of rotation
                }
            },
            tooltip: {
                enabled: true,
                shared: true,
            },
            valueAxis: [{
                name: 'venues',
                position: 'left',
            }, {
                name: 'percentage',
                position: 'right',
                showZero: true,
                label: {
                    customizeText(info) {
                        return `${info.valueText}%`;
                    }
                },
                constantLines: [{
                    value: 80,
                    color: '#d4af37',
                    dashStyle: 'dash',
                    width: 2,
                    label: { visible: false }
                }],
                tickInterval: 20,
                valueMarginsEnabled: false
            }],
            commonSeriesSettings: {
                argumentField: 'monthYear'
            },
            series: [{
                type: 'bar',
                valueField: 'venues',
                axis: 'venues',
                name: 'Venues',
                color: '#b91c1a'
            }, {
                type: 'spline',
                valueField: 'cumulativePercentage',
                axis: 'percentage',
                name: 'Cumulative percentage',
                color: '#D3D3D3',
                point: { visible: false }, // Hide circular points
                hoverMode: 'none', // Disable hover effect on the line
            }],
            legend: {
                verticalAlignment: 'bottom',
                horizontalAlignment: 'center'
            },
            size: {
                height: chartHeight
            }
        });
    }

    // DataGrid initialization
    if ($('#dataGridContainer').length) {
        $("#dataGridContainer").dxDataGrid({
            dataSource: reelGamesData.gameData.lifecyle_analysis_json,
            // other configuration options for the DataGrid
        });
    }

    // Monthly Performance Chart initialization
    if ($('#monthlyPerformanceChart').length) {
        const monthlyPerformanceData = reelGamesData.gameData.lifecyle_analysis_json.map(item => {
            return {
                month: new Date(item.reporting_month_yyyymm).toLocaleString('default', { month: 'short', year: 'numeric' }),
                rpm: item.gp_rpm
            };
        });

        $("#monthlyPerformanceChart").dxChart({
            dataSource: monthlyPerformanceData,
            title: "Monthly Analysis",
            series: {
                argumentField: 'month',
                valueField: 'rpm',
                name: 'Game Played RPM',
                type: 'bar',
                color: '#b91c1a', // Main color
            },
            legend: {
                position: "outside",
                horizontalAlignment: "center",
                verticalAlignment: "bottom"
            }
        });
    }

    // Quartile Analysis Chart initialization
    if ($('#quartileAnalysisChart').length) {
        const quartileData = reelGamesData.gameData.lifecyle_analysis_json.map(item => {
            return {
                month: new Date(item.reporting_month_yyyymm).toLocaleString('default', { month: 'short', year: 'numeric' }),
                q1: item.gp_q1,
                median: item.gp_median,
                q3: item.gp_q3
            };
        });

        $("#quartileAnalysisChart").dxChart({
            palette: ['#b91c1a', '#192f3d', '#d4af37'], // Main, Dark Blue, Gold
            dataSource: quartileData,
            commonSeriesSettings: {
                argumentField: 'month',
                type: 'rangeBar',
                minBarSize: 2,
            },
            series: [
                {
                    rangeValue1Field: 'q1',
                    rangeValue2Field: 'q3',
                    name: 'Games Played RPM Q1-Q3',
                }
            ],
            valueAxis: {
                title: {
                    text: 'RPM Value',
                },
            },
            tooltip: {
                enabled: true,
            },
            argumentAxis: {
                label: {
                    format: 'month',
                },
            },
            legend: {
                verticalAlignment: 'bottom',
                horizontalAlignment: 'center',
            },
            title: 'Quartile Analysis',
        });
    }

    // Terminals Bar Chart
    if ($('#terminalsBarChart').length) {
        $("#terminalsBarChart").dxChart({
            dataSource: consolidatedData,
            series: {
                argumentField: 'monthYear',
                valueField: 'terminals',
                name: 'Terminals',
                type: 'bar',
                color: mainColor, // Use the main color
            },
            legend: {
                position: "outside",
                horizontalAlignment: "center",
                verticalAlignment: "bottom"
            },
            title: "Terminals",
        });
    }

    // Venues Bar Chart
    if ($('#venuesBarChart').length) {
        $("#venuesBarChart").dxChart({
            dataSource: consolidatedData,
            series: {
                argumentField: 'monthYear',
                valueField: 'venues',
                name: 'Venues',
                type: 'bar',
                color: darkBlueColor, // Use the dark blue color
            },
            legend: {
                position: "outside",
                horizontalAlignment: "center",
                verticalAlignment: "bottom"
            },
            title: "Venues",
        });
    }

    // Market Share Bar Chart
    if ($('#marketShareBarChart').length) {
        $("#marketShareBarChart").dxChart({
            dataSource: consolidatedData,
            series: {
                argumentField: 'monthYear',
                valueField: 'marketShare',
                name: 'Market Share',
                type: 'bar',
                color: goldColor, // Use the gold color
            },
            legend: {
                position: "outside",
                horizontalAlignment: "center",
                verticalAlignment: "bottom"
            },
            title: "Market Share",
        });
    }
});

// Toggle the chevron icon on the Game Performance section
jQuery(document).ready(function($) {
    $('#collapseGamePerformance').on('show.bs.collapse', function () {
        // Set the icon to point up (expanded state)
        $('#chevron-button-gameperformance .chevron i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
    }).on('hide.bs.collapse', function () {
        // Set the icon to point down (collapsed state)
        $('#chevron-button-gameperformance .chevron i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
    });
});

