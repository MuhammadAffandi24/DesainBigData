// PIE CHART
const kategoriChart = new Chart(document.getElementById("kategoriChart"), {
    type: "doughnut",
    data: {
        labels: ["Makanan", "Tagihan", "Lainnya"],
        datasets: [
            {
                data: [50, 30, 20],
                backgroundColor: ["#4a3324", "#8d7762", "#d1c3b1"],
                borderWidth: 0,
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: "right", labels: { color: "#291C0E" } },
        },
    },
});

// CASHFLOW CHART
const cashflowChart = new Chart(document.getElementById("cashflowChart"), {
    type: "line",
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun"],
        datasets: [
            {
                label: "Cashflow",
                data: [20, 18, 22, 30, 35, 28],
                borderColor: "#291C0E",
                backgroundColor: "rgba(41,28,14,0.1)",
                fill: true,
                tension: 0.35,
                pointRadius: 4,
                pointBackgroundColor: "#291C0E",
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                ticks: { color: "#291C0E" },
                grid: { color: "rgba(0,0,0,0.05)" },
            },
            y: {
                ticks: { color: "#291C0E" },
                grid: { color: "rgba(0,0,0,0.05)" },
            },
        },
        animation: {
            duration: 1000,
            easing: "easeInOutQuart",
        },
        plugins: { legend: { display: false } },
    },
});
