Chart.defaults.font.family = 'iranyekan';
Chart.defaults.color = "#292b2c";
// -- Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["13 دی", "12 دی", "11 دی", "10 دی", "9 دی", "8 دی", "7 دی", "6 دی", "5 دی", "4 دی", "3 دی", "2 دی", "1 دی"],
    datasets: [{
      label: "بازه",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 20,
      pointBorderWidth: 2,
      data: [10000, 30162, 26263, 18394, 18287, 28682, 31274, 33259, 25849, 24159, 32651, 31984, 38451],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 40000,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    plugins: {
      legend: {
        display: false,
      },

      tooltip: {
        rtl:true,
        textDirection: 'right'
      }
    }
  }
});
// -- Bar Chart Example
var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["شهریور", "مرداد", "تیر", "خرداد", "اردیبهشت", "فروردین"],
    datasets: [{
      label: "درآمد",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: [4215, 5312, 6251, 7841, 9821, 14984],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 15000,
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    plugins: {
      legend: {
        display: false,
      },

      tooltip: {
        rtl:true,
        textDirection: 'right'
      }
    }
  }
});
// -- Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["آبی", "قرمز", "زرد", "سبز"],
    datasets: [{
      data: [12.21, 15.58, 11.25, 8.32],
      backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
    }],
  },
  options: {
    plugins: {
      legend: {
        rtl: true,
        textDirection: 'rtl',
      },

      tooltip: {
        rtl:true,
        textDirection: 'right'
      }
    }
  }
});
