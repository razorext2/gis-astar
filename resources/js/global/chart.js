import ApexCharts from "apexcharts";

const globalOptions = {
    chart: {
        height: "100%",
        width: "100%",
        type: "area",
        fontFamily: "Inter, sans-serif",
        dropShadow: {
            enabled: false,
        },
        toolbar: {
            show: false,
        },
        animations: {
            enabled: true,
        },
    },
    tooltip: {
        enabled: false,
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        width: 2,
    },
    grid: {
        show: false,
    },
    xaxis: {
        labels: {
            show: false,
        },
    },
    yaxis: {
        show: false,
    },
};

const bigChart = document.getElementById("tooltip-chart");

function renderChart(element, options) {
    const chart = new ApexCharts(element, options);
    chart.render();
}

// Use IntersectionObserver to delay rendering until the element is in view
const observer = new IntersectionObserver(
    (entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const element = entry.target;
                let options;

                if (element === bigChart) {
                    const lateCounts = JSON.parse(bigChart.dataset.lateCounts);
                    const ontimeCounts = JSON.parse(
                        bigChart.dataset.ontimeCounts
                    );
                    const outtimeCounts = JSON.parse(
                        bigChart.dataset.outtimeCounts
                    );
                    const fastCounts = JSON.parse(bigChart.dataset.fastCounts);
                    const dates = JSON.parse(bigChart.dataset.dates);

                    options = {
                        ...globalOptions,
                        series: [
                            {
                                name: "Masuk Tepat Waktu",
                                data: ontimeCounts,
                                color: "#22c55e",
                            },
                            {
                                name: "Terlambat",
                                data: lateCounts,
                                color: "#f43f5e",
                            },
                            {
                                name: "Keluar Tepat Waktu",
                                data: outtimeCounts,
                                color: "#06b6d4",
                            },
                            {
                                name: "Kecepatan Pulang",
                                data: fastCounts,
                                color: "#ec4899",
                            },
                        ],
                        xaxis: {
                            categories: dates,
                            labels: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            axisTicks: {
                                show: false,
                            },
                        },
                        tooltip: {
                            enabled: true,
                        },
                    };
                    renderChart(bigChart, options);
                }
                observer.unobserve(element); // Stop observing once the chart is rendered
            }
        });
    },
    { threshold: 0.1 }
);

// Attach observer to each chart element
if (bigChart) observer.observe(bigChart);