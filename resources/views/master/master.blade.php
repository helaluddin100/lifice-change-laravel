<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- fave-icon  -->
    <link rel="shortcut icon" href="assets/images/icon/fave-icon.png" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700;900&amp;display=swap"
        rel="stylesheet">

    @include('layouts.backend.style')

</head>

<body>
    <div class="body-bg">
        {{-- @include('sweetalert::alert') --}}
        @include('layouts.backend.sidebar')
        @include('layouts.backend.nav')
        @yield('content')
        @include('layouts.backend.js')
    </div>
    @yield('js')

    @section('js')
        <script>
            let darkMode = JSON.parse(localStorage.getItem("darkMode"))
            // min-calender
            $("#min-calender").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                inline: true,
            });
        </script>


        <script>
            //totalEarnBar
            const ctx_bids = document
                .getElementById("totalEarnBar")
                .getContext("2d");
            const bitsMonth = ["Jan", "Feb", "Mar", "Afril", "May", "Jan"];
            const bitsData = [10, 20, 15, 50, 40, 25];
            let totalEarnBar = new Chart(ctx_bids, {
                type: "bar",
                data: {
                    labels: bitsMonth,
                    datasets: [{
                        label: "Visitor",
                        data: bitsData,
                        backgroundColor: [
                            "rgba(237, 242, 247, 1)",
                            "rgba(237, 242, 247, 1)",
                            "rgba(237, 242, 247, 1)",
                            "rgba(34, 197, 94, 1)",
                            "rgba(237, 242, 247, 1)",
                            "rgba(237, 242, 247, 1)",
                        ],
                        borderColor: "#22C55E",
                        pointRadius: 0,
                        pointBackgroundColor: "#fff",
                        pointBorderColor: "#22C55E",
                        fill: true,
                        fillColor: "#fff",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 3,
                    }, ],
                },
                options: {
                    layout: {
                        padding: {
                            bottom: -20,
                        },
                    },
                    maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                display: false,
                            },
                        },
                        y: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                display: false,
                            },
                        },
                    },

                    plugins: {
                        legend: {
                            position: "top",
                            display: false,
                        },
                        title: {
                            display: false,
                            text: "Visitor: 2k",
                        },
                        tooltip: {
                            enabled: false,
                        },
                    },
                },
            });

            //totalSpend
            let totalSpend = document
                .getElementById("totalSpendingBar")
                .getContext("2d");
            const SpendingCharbitsMonth = ["Jan", "Feb", "Mar", "Afril", "May", "Jan"];
            const SpendingCharbitsData = [10, 20, 15, 50, 40, 25];
            const totalSpendingChartBar = new Chart(totalSpend, {
                type: "bar",
                data: {
                    labels: SpendingCharbitsMonth,
                    datasets: [{
                        label: "Visitor",
                        data: SpendingCharbitsData,
                        backgroundColor: [
                            "rgba(237, 242, 247, 1)",
                            "rgba(237, 242, 247, 1)",
                            "rgba(237, 242, 247, 1)",
                            "rgba(34, 197, 94, 1)",
                            "rgba(237, 242, 247, 1)",
                            "rgba(237, 242, 247, 1)",
                        ],
                        borderColor: "#22C55E",
                        pointRadius: 0,
                        pointBackgroundColor: "#fff",
                        pointBorderColor: "#22C55E",
                        fill: true,
                        fillColor: "#fff",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 3,
                    }, ],
                },
                options: {
                    layout: {
                        padding: {
                            bottom: -20,
                        },
                    },
                    maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                display: false,
                            },
                        },
                        y: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                display: false,
                            },
                        },
                    },

                    plugins: {
                        legend: {
                            position: "top",
                            display: false,
                        },
                        title: {
                            display: false,
                            text: "Visitor: 2k",
                        },
                        tooltip: {
                            enabled: false,
                        },
                    },
                },
            });


            // totalGoalBar
            let totalGoalBarSelect = document.getElementById("totalGoalBar").getContext("2d");
            const totalGoalBarbitsMonth = ["Jan", "Feb", "Mar", "Afril", "May", "Jan"];
            const totalGoalBarbitsData = [10, 20, 15, 50, 40, 25];
            const totalGoalBar = new Chart(totalGoalBarSelect, {
                type: "bar",
                data: {
                    labels: totalGoalBarbitsMonth,
                    datasets: [{
                        label: "Visitor",
                        data: totalGoalBarbitsData,
                        backgroundColor: [
                            "rgba(237, 242, 247, 1)",
                            "rgba(237, 242, 247, 1)",
                            "rgba(237, 242, 247, 1)",
                            "rgba(34, 197, 94, 1)",
                            "rgba(237, 242, 247, 1)",
                            "rgba(237, 242, 247, 1)",
                        ],
                        borderColor: "#22C55E",
                        pointRadius: 0,
                        pointBackgroundColor: "#fff",
                        pointBorderColor: "#22C55E",
                        fill: true,
                        fillColor: "#fff",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 3,
                    }, ],
                },
                options: {
                    layout: {
                        padding: {
                            bottom: -20,
                        },
                    },
                    maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                display: false,
                            },
                        },
                        y: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                display: false,
                            },
                        },
                    },

                    plugins: {
                        legend: {
                            position: "top",
                            display: false,
                        },
                        title: {
                            display: false,
                            text: "Visitor: 2k",
                        },
                        tooltip: {
                            enabled: false,
                        },
                    },
                },
            });

            //monthSpendingBar
            let monthSpendingBarSelect = document
                .getElementById("monthSpendingBar")
                .getContext("2d");
            const monthSpendingBarbitsMonth = ["Jan", "Feb", "Mar", "Afril", "May", "Jan"];
            const monthSpendingBarbitsData = [10, 20, 15, 50, 40, 25];
            const monthSpendingBar = new Chart(monthSpendingBarSelect, {
                type: "bar",
                data: {
                    labels: monthSpendingBarbitsMonth,
                    datasets: [{
                        label: "Visitor",
                        data: monthSpendingBarbitsData,
                        backgroundColor: [
                            "rgba(237, 242, 247, 1)",
                            "rgba(237, 242, 247, 1)",
                            "rgba(237, 242, 247, 1)",
                            "rgba(34, 197, 94, 1)",
                            "rgba(237, 242, 247, 1)",
                            "rgba(237, 242, 247, 1)",
                        ],
                        borderColor: "#22C55E",
                        pointRadius: 0,
                        pointBackgroundColor: "#fff",
                        pointBorderColor: "#22C55E",
                        fill: true,
                        fillColor: "#fff",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 3,
                    }, ],
                },
                options: {
                    layout: {
                        padding: {
                            bottom: -20,
                        },
                    },
                    maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                display: false,
                            },
                        },
                        y: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                display: false,
                            },
                        },
                    },

                    plugins: {
                        legend: {
                            position: "top",
                            display: false,
                        },
                        title: {
                            display: false,
                            text: "Visitor: 2k",
                        },
                        tooltip: {
                            enabled: false,
                        },
                    },
                },
            });

            //revenueFlowBar
            let revenueFlowElement = document
                .getElementById("revenueFlowBar")
                .getContext("2d");
            let revenueFlowBarmonth = [
                "Jan",
                "Feb",
                "Mar",
                "April",
                "May",
                "Jun",
                "July",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ];
            let revenueDark = [{
                    label: "Dataset 1",
                    data: [65, 75, 65, 55, 75, 55, 45, 65, 75, 65, 85, 75],
                    backgroundColor: [
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(255, 120, 75, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                    ],
                    borderRadius: 3,
                },
                {
                    label: "Dataset 2",
                    data: [70, 80, 70, 65, 65, 65, 60, 70, 80, 70, 80, 65],
                    backgroundColor: [
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(74, 222, 128, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                    ],
                    borderRadius: 3,
                },
            ];
            let revenueLight = [{
                    label: "Dataset 1",
                    data: [65, 75, 65, 55, 75, 55, 45, 65, 75, 65, 85, 75],
                    backgroundColor: [
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(255, 120, 75, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                    ],
                    borderRadius: 3,
                },
                {
                    label: "Dataset 2",
                    data: [70, 80, 70, 65, 65, 65, 60, 70, 80, 70, 80, 65],
                    backgroundColor: [
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(74, 222, 128, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                    ],
                    borderRadius: 3,
                },
            ];
            let revenueFlow = new Chart(revenueFlowElement, {
                type: "bar",
                data: {
                    labels: revenueFlowBarmonth,
                    datasets: revenueLight,
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: "rgb(243 ,246, 255 ,1)",
                                borderDash: [5, 5],
                                borderDashOffset: 2,
                            },
                            gridLines: {
                                zeroLineColor: "transparent",
                            },
                            ticks: {
                                callback(value) {
                                    return `${value}% `;
                                },
                            },
                        },
                        x: {
                            grid: {
                                color: "rgb(243 ,246, 255 ,1)",
                                borderDash: [5, 5],
                                borderDashOffset: 2,
                            },
                            gridLines: {
                                zeroLineColor: "transparent",
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    // x: {
                    //   stacked: true,
                    // },
                    // y: {
                    //   stacked: true,
                    // },
                },
            });


            function pieChart() {
                let pieChart = document.getElementById("pie_chart").getContext("2d");

                const data = {
                    labels: [10, 20, 30],
                    datasets: [{
                        label: "My First Dataset",
                        data: [15, 20, 35, 40],
                        backgroundColor: ["#1A202C", "#61C660", "#F8CC4B", "#EDF2F7"],
                        borderColor: ["#ffffff", "#ffffff", "#ffffff", "#1A202C"],
                        hoverOffset: 18,
                        borderWidth: 0,
                    }, ],
                };
                const customDatalabels = {
                    id: "customDatalabels",
                    afterDatasetsDraw(chart, args, pluginOptions) {
                        const {
                            ctx,
                            data,
                            chartArea: {
                                top,
                                bottom,
                                left,
                                right,
                                width,
                                height
                            },
                        } = chart;
                        ctx.save();
                        data.datasets[0].data.forEach((datapoint, index) => {
                            const {
                                x,
                                y
                            } = chart
                                .getDatasetMeta(0)
                                .data[index].tooltipPosition();
                            ctx.font = "bold 12px sans-serif";
                            ctx.fillStyle = data.datasets[0].borderColor[index];
                            ctx.textAlign = "center";
                            ctx.textBaseline = "middle";
                            ctx.fillText(`${datapoint}%`, x, y);
                        });
                    },
                };
                const config = {
                    type: "doughnut",
                    data,
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 10,
                                top: 10,
                                bottom: 10,
                            },
                        },
                        plugins: {
                            legend: {
                                display: false,
                            },
                        },
                    },
                    plugins: [customDatalabels],
                };

                let pieChartConfiig = new Chart(pieChart, config);
            }
            pieChart();

            //dark chart
            function updateChart() {
                if (darkMode) {
                    totalEarnBar.data.datasets[0].backgroundColor = [
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(34, 197, 94, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                    ];
                    totalSpendingChartBar.data.datasets[0].backgroundColor = [
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(34, 197, 94, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                    ];
                    totalGoalBar.data.datasets[0].backgroundColor = [
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(34, 197, 94, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                    ];
                    monthSpendingBar.data.datasets[0].backgroundColor = [
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(34, 197, 94, 1)",
                        "rgba(42, 49, 60, 1)",
                        "rgba(42, 49, 60, 1)",
                    ];
                    revenueFlow.data.datasets = revenueDark;
                    revenueFlow.options.scales.y.ticks.color = 'white';
                    revenueFlow.options.scales.x.ticks.color = 'white';
                    revenueFlow.options.scales.x.grid.color = '#222429';
                    revenueFlow.options.scales.y.grid.color = '#222429';
                    totalEarnBar.update();
                    totalSpendingChartBar.update();

                    totalGoalBar.update();
                    monthSpendingBar.update();
                    revenueFlow.update();
                } else {
                    totalEarnBar.data.datasets[0].backgroundColor = [
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(34, 197, 94, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                    ];
                    totalSpendingChartBar.data.datasets[0].backgroundColor = [
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(34, 197, 94, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                    ];
                    totalGoalBar.data.datasets[0].backgroundColor = [
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(34, 197, 94, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                    ];
                    monthSpendingBar.data.datasets[0].backgroundColor = [
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(34, 197, 94, 1)",
                        "rgba(237, 242, 247, 1)",
                        "rgba(237, 242, 247, 1)",
                    ];
                    revenueFlow.data.datasets = revenueLight;
                    revenueFlow.options.scales.y.ticks.color = 'black';
                    revenueFlow.options.scales.x.ticks.color = 'black';
                    revenueFlow.options.scales.x.grid.color = 'rgb(243 ,246, 255 ,1)';
                    revenueFlow.options.scales.y.grid.color = 'rgb(243 ,246, 255 ,1)';
                    totalEarnBar.update();
                    totalSpendingChartBar.update();

                    totalGoalBar.update();
                    monthSpendingBar.update();
                    revenueFlow.update();
                }
            }


            //initial load
            if (darkMode) {
                totalEarnBar.data.datasets[0].backgroundColor = [
                    "rgba(42, 49, 60, 1)",
                    "rgba(42, 49, 60, 1)",
                    "rgba(42, 49, 60, 1)",
                    "rgba(34, 197, 94, 1)",
                    "rgba(42, 49, 60, 1)",
                    "rgba(42, 49, 60, 1)",
                ];
                totalSpendingChartBar.data.datasets[0].backgroundColor = [
                    "rgba(42, 49, 60, 1)",
                    "rgba(42, 49, 60, 1)",
                    "rgba(42, 49, 60, 1)",
                    "rgba(34, 197, 94, 1)",
                    "rgba(42, 49, 60, 1)",
                    "rgba(42, 49, 60, 1)",
                ];
                totalGoalBar.data.datasets[0].backgroundColor = [
                    "rgba(42, 49, 60, 1)",
                    "rgba(42, 49, 60, 1)",
                    "rgba(42, 49, 60, 1)",
                    "rgba(34, 197, 94, 1)",
                    "rgba(42, 49, 60, 1)",
                    "rgba(42, 49, 60, 1)",
                ];
                monthSpendingBar.data.datasets[0].backgroundColor = [
                    "rgba(42, 49, 60, 1)",
                    "rgba(42, 49, 60, 1)",
                    "rgba(42, 49, 60, 1)",
                    "rgba(34, 197, 94, 1)",
                    "rgba(42, 49, 60, 1)",
                    "rgba(42, 49, 60, 1)",
                ];
                revenueFlow.data.datasets = revenueDark;
                revenueFlow.options.scales.y.ticks.color = 'white';
                revenueFlow.options.scales.x.ticks.color = 'white';
                revenueFlow.options.scales.x.grid.color = '#222429';
                revenueFlow.options.scales.y.grid.color = '#222429';
            } else {
                totalEarnBar.data.datasets[0].backgroundColor = [
                    "rgba(237, 242, 247, 1)",
                    "rgba(237, 242, 247, 1)",
                    "rgba(237, 242, 247, 1)",
                    "rgba(34, 197, 94, 1)",
                    "rgba(237, 242, 247, 1)",
                    "rgba(237, 242, 247, 1)",
                ];
                totalSpendingChartBar.data.datasets[0].backgroundColor = [
                    "rgba(237, 242, 247, 1)",
                    "rgba(237, 242, 247, 1)",
                    "rgba(237, 242, 247, 1)",
                    "rgba(34, 197, 94, 1)",
                    "rgba(237, 242, 247, 1)",
                    "rgba(237, 242, 247, 1)",
                ];
                totalGoalBar.data.datasets[0].backgroundColor = [
                    "rgba(237, 242, 247, 1)",
                    "rgba(237, 242, 247, 1)",
                    "rgba(237, 242, 247, 1)",
                    "rgba(34, 197, 94, 1)",
                    "rgba(237, 242, 247, 1)",
                    "rgba(237, 242, 247, 1)",
                ];
                monthSpendingBar.data.datasets[0].backgroundColor = [
                    "rgba(237, 242, 247, 1)",
                    "rgba(237, 242, 247, 1)",
                    "rgba(237, 242, 247, 1)",
                    "rgba(34, 197, 94, 1)",
                    "rgba(237, 242, 247, 1)",
                    "rgba(237, 242, 247, 1)",
                ];
                revenueFlow.data.datasets = revenueLight;
                revenueFlow.options.scales.y.ticks.color = 'black';
                revenueFlow.options.scales.x.ticks.color = 'black';
                revenueFlow.options.scales.x.grid.color = 'rgb(243 ,246, 255 ,1)';
                revenueFlow.options.scales.y.grid.color = 'rgb(243 ,246, 255 ,1)';
            }
            totalEarnBar.update();
            totalSpendingChartBar.update();

            totalGoalBar.update();
            monthSpendingBar.update();
            revenueFlow.update();


            //Theme controll 

            if (darkMode) {
                document.getElementById("dark-icon").style.setProperty("display", "block")
                document.getElementById("light-icon").style.setProperty("display", "none")
                document.getElementsByClassName("logo")[0].style.setProperty("display", "none")
                document.getElementsByClassName("logo-dark")[0].style.setProperty("display", "block")
                modeSetup(darkMode)
            } else {
                document.getElementById("dark-icon").style.setProperty("display", "none")
                document.getElementById("light-icon").style.setProperty("display", "block")
                document.getElementsByClassName("logo")[0].style.setProperty("display", "block")
                document.getElementsByClassName("logo-dark")[0].style.setProperty("display", "none")
                modeSetup(darkMode)
            }

            document.getElementById("theme-controll").addEventListener("click", event => {
                darkMode = !darkMode
                localStorage.setItem("darkMode", darkMode)
                updateChart()
                const main = document.querySelector("html")
                modeSetup(darkMode)
            })
        </script>
    @endsection
</body>

</html>
