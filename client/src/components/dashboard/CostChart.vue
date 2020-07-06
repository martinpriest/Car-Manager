<template>
  <div>
    <canvas id="planet-chart"></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js';
  export default {
    name: "CostChart",
    data () {
      // fetch data
        var requestOptions = {
            method: 'GET',
            redirect: 'follow',
            credentials: 'include'
        };

        var tempArr = [];
        fetch(`${process.env.VUE_APP_API_URL}/cost_history/aggregate`, requestOptions)
            .then(response => response.json())
            .then((data) => {
                for (const [key, value] of Object.entries(data)) {
                    console.log(`${key}: ${value}`);
                    tempArr.push(value.toFixed(2));
                }
            })
            .catch(error => console.log('error', error));
      
      return {

        planetChartData: {
            type: 'bar',
            data: {
                labels: ['Naprawy', 'Tankowanie', 'Czyszczenie', 'Akcesoria', 'Płatności', 'Inne', 'Kupno samochodu'],
                datasets: [
                    { // one line graph
                label: 'Type of cost',
                data: tempArr,
                backgroundColor: [
                'rgba(54,73,93,.5)', // Blue
                'rgba(54,173,93,.5)',
                'rgba(54,73,93,.5)',
                'rgba(54,173,93,.5)',
                'rgba(54,73,93,.5)',
                'rgba(54,173,93,.5)',
                'rgba(54,73,93,.5)'
                ],
                borderColor: [
                '#ededed',
                '#36495d',
                '#ededed',
                '#36495d',
                '#ededed',
                '#36495d',
                '#ededed'
                ],
                borderWidth: 3
            }
            ]
        },
        options: {
            responsive: true,
            lineTension: 1,
            scales: {
            yAxes: [{
                ticks: {
                beginAtZero: true,
                padding: 25,
                }
            }]
            }
        }
      }
        }
    },
    mounted() {
      const ctx = document.getElementById('planet-chart');
        const myChart = new Chart(ctx, {
            type: '',
            data: [],
            options: {},
        });
        console.log(myChart)

        // Create chart
        this.createChart('planet-chart', this.planetChartData);
    },
    methods: {
        createChart(chartId, chartData) {
            const ctx = document.getElementById(chartId);
            const myChart = new Chart(ctx, {
                type: chartData.type,
                data: chartData.data,
                options: chartData.options,
            });
            console.log(myChart)
        }
    }
  }
</script>

<style>
  .small {
    max-width: 600px;
    margin:  150px auto;
  }
</style>