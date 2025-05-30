import 'flowbite';
import ApexCharts from "apexcharts";

let dashboardDescription = [];
let dashboardData = {
  'Laporan Masuk Pengiriman': {
    'color': "#1A56DB",
    'amount': 0,
  },
  'Laporan Masuk Retur': {
    'color': "#7E3BF2",
    'amount': 0,
  },
  'Laporan Keluar': {
    'color': "#10B981",
    'amount': 0,
  },
  'Laporan Retur': {
    'color': "#F59E0B",
    'amount': 0,
  },
};

let chart = null; // 🔧 inisialisasi chart di global scope

const options = {
  xaxis: {
    show: true,
    categories: ['01 Feb', '02 Feb', '03 Feb', '04 Feb', '05 Feb', '06 Feb', '07 Feb'],
    labels: {
      show: true,
      style: {
        fontFamily: "Inter, sans-serif",
        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
      }
    },
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false,
    },
  },
  yaxis: {
    show: true,
    labels: {
      show: true,
      style: {
        fontFamily: "Inter, sans-serif",
        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
      },
      formatter: function (value) {
        return value;
      }
    }
  },
  series: [
    {
      name: "Developer Edition",
      data: [150, 141, 145, 152, 135, 125],
      color: "#1A56DB",
    },
    {
      name: "Designer Edition",
      data: [43, 13, 65, 12, 42, 73],
      color: "#7E3BF2",
    },
  ],
  chart: {
    sparkline: {
      enabled: false
    },
    height: "100%",
    width: "100%",
    type: "area",
    fontFamily: "Inter, sans-serif",
    dropShadow: {
      enabled: false,
    },
    toolbar: {
      show: true,
    },
  },
  tooltip: {
    enabled: true,
    x: {
      show: false,
    },
  },
  fill: {
    type: "gradient",
    gradient: {
      opacityFrom: 0.55,
      opacityTo: 0,
      shade: "#1C64F2",
      gradientToColors: ["#1C64F2"],
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    width: 6,
  },
  legend: {
    show: true
  },
  grid: {
    show: true,
  },
};

const takeTotalKey = (laporanArray) => {
  const totals = laporanArray.map((item) => item.total);
  return totals;
};

const graph = async (filter) => {
  const csrfToken = document.querySelector('select[name="csrf-token"]').getAttribute('content');

  const response = await fetch('/dashboard-graph', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken
    },
    credentials: 'include',
    body: JSON.stringify({
      filter_durasi: filter,
    }),
  });

  let graphData = await response.json();
  graphData = JSON.parse(graphData);
  graphData = graphData.data;

  dashboardDescription = graphData.description;

  dashboardData['Laporan Masuk Pengiriman'].amount = takeTotalKey(graphData.laporan_masuk_pengiriman);
  dashboardData['Laporan Masuk Retur'].amount = takeTotalKey(graphData.laporan_masuk_retur);
  dashboardData['Laporan Keluar'].amount = takeTotalKey(graphData.laporan_keluar);
  dashboardData['Laporan Retur'].amount = takeTotalKey(graphData.laporan_retur);

  const legends = Object.entries(dashboardData).map(([key, value]) => {
    return {
      name: key,
      data: value.amount,
      color: value.color,
    };
  });

  // 🔁 Update chart x-axis categories
  if (chart) {
    chart.updateOptions({
      xaxis: {
        categories: dashboardDescription
      },
      series: legends,
    });
  }
};

if (document.getElementById("labels-chart") && typeof ApexCharts !== 'undefined') {
  chart = new ApexCharts(document.getElementById("labels-chart"), options);
  chart.render();
}

const dropdown = document.getElementById('filterDurasi');

if (dropdown) {
  dropdown.addEventListener('change', () => {
    const selectedValue = dropdown.value;
    graph(selectedValue);
  });
}

graph('Hari ini');