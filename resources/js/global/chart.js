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
const cardLate = document.getElementById("cardLate-chart");
const cardOntime = document.getElementById("cardOntime-chart");
const cardOuttime = document.getElementById("cardOuttime-chart");
const cardKecepatan = document.getElementById("cardKecepatan-chart");

function renderChart(element, options) {
    const chart = new ApexCharts(element, options);
    chart.render(); // Render langsung tanpa requestAnimationFrame
}

function createOptions(seriesData, colors, seriesName, categories) {
    return {
        ...globalOptions,
        series: [
            {
                name: seriesName,
                data: seriesData,
            },
        ],
        fill: {
            type: "solid",
            colors: [colors],
        },
        stroke: {
            width: 2,
            colors: ["#fff"],
        },
    };
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

                if (element === cardLate) {
                    const lateCounts = JSON.parse(cardLate.dataset.lateCounts);
                    options = createOptions(lateCounts, "#f05252", "Terlambat");
                    renderChart(cardLate, options);
                }

                if (element === cardOntime) {
                    const ontimeCounts = JSON.parse(
                        cardOntime.dataset.ontimeCounts
                    );
                    options = createOptions(
                        ontimeCounts,
                        "#0e9f6e",
                        "Tepat Waktu"
                    );
                    renderChart(cardOntime, options);
                }

                if (element === cardOuttime) {
                    const outtimeCounts = JSON.parse(
                        cardOuttime.dataset.outtimeCounts
                    );
                    options = createOptions(
                        outtimeCounts,
                        "#06b5d4",
                        "Keluar Tepat Waktu"
                    );
                    renderChart(cardOuttime, options);
                }

                if (element === cardKecepatan) {
                    const fastCounts = JSON.parse(cardKecepatan.dataset.fastCounts);
                    options = createOptions(
                        fastCounts,
                        "#f43f5d",
                        "Kecepatan Pulang"
                    );
                    renderChart(cardKecepatan, options);
                }

                observer.unobserve(element); // Stop observing once the chart is rendered
            }
        });
    },
    { threshold: 0.1 }
);

// Attach observer to each chart element
if (bigChart) observer.observe(bigChart);
if (cardLate) observer.observe(cardLate);
if (cardOntime) observer.observe(cardOntime);
if (cardOuttime) observer.observe(cardOuttime);
if (cardKecepatan) observer.observe(cardKecepatan);
