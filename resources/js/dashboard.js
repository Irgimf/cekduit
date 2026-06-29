import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", () => {
    const trendEl = document.getElementById("trendChart");

    if (trendEl) {
        const chartLabels = JSON.parse(trendEl.dataset.labels);
        const chartIncome = JSON.parse(trendEl.dataset.income);
        const chartExpense = JSON.parse(trendEl.dataset.expense);

        new Chart(trendEl, {
            type: "bar",
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: "Pemasukan",
                        data: chartIncome,
                        backgroundColor: "#16a34a",
                    },
                    {
                        label: "Pengeluaran",
                        data: chartExpense,
                        backgroundColor: "#dc2626",
                    },
                ],
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } },
            },
        });
    }

    const categoryEl = document.getElementById("categoryChart");

    if (categoryEl) {
        const categoryLabels = JSON.parse(categoryEl.dataset.labels);
        const categoryData = JSON.parse(categoryEl.dataset.data);

        new Chart(categoryEl, {
            type: "doughnut",
            data: {
                labels: categoryLabels,
                datasets: [
                    {
                        data: categoryData,
                        backgroundColor: [
                            "#dc2626",
                            "#ea580c",
                            "#ca8a04",
                            "#65a30d",
                            "#0891b2",
                            "#7c3aed",
                            "#db2777",
                        ],
                    },
                ],
            },
            options: {
                responsive: true,
            },
        });
    }
});
