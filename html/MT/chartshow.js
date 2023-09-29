
let currentChartType = 'scatter';
function get_data() {
  // Pobierz dane z serwera
  fetch('get_data_from_db.php')
    .then(response => response.json())
    .then(data => {
      if (currentChartType === 'scatter') {
        drawChart(data);
      } else if (currentChartType === 'line') {
        drawLineChart(data);
      }
    });
}

function drawChart(data) {
  // Wykres położenia robota
  let position = document.getElementById('position').getContext('2d');
  if (Chart.getChart("position")){
    Chart.getChart("position").destroy();
  }
  let positionChart = new Chart(position, {
    type: 'scatter',
    data: {
      datasets: [{
        label: 'Robot Position',
        data: [],
        backgroundColor: 'green',
        borderColor: 'red',
        pointRadius: 5
      }]
    },
    options: {
      scales: {
        x: {
          min: -3,
          max: 3
        },
        y: {
          min: -3,
          max: 3
        }
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              let index = context.dataIndex;
              let temperature = data.temperature[index];
              let humidity = data.humidity[index];
              return 'Temperature: ' + temperature + '°C'+'\n;Humidity: ' + humidity + '%'+ '\n;Position: ' + data.posx[index] + ', ' + data.posy[index]
            }
          }
        }
      }
    }
  });

  // Aktualizuj dane na wykresie położenia robota
  function updatePositionChart() {
    let positions = [];
    let maxTemperatureIndex = 0;
    let minTemperatureIndex = 0;
    let minHumidityIndex = 0;
    let maxHumidityIndex = 0;
    let maxTemperature = data.temperature[0];
    let minTemperature = data.temperature[0];
    let maxHumidity = data.humidity[0];
    let minHumidity = data.humidity[0];

    for (let i = 0; i < data.log_id.length; i++) {
      positions.push({x: data.posx[i], y: data.posy[i]});

      if (data.temperature[i] > maxTemperature) {
        maxTemperature = data.temperature[i];
        maxTemperatureIndex = i;
      }
      if (data.temperature[i] < minTemperature) {
        minTemperature = data.temperature[i];
        minTemperatureIndex = i;
      }
      if (data.humidity[i] > maxHumidity) {
        maxHumidity = data.humidity[i];
        maxHumidityIndex = i;
      } 
      if (data.humidity[i] < minHumidity) {
        minHumidity = data.humidity[i];
        minHumidityIndex = i;
      }



    }

    positionChart.data.datasets[0].data = positions;

    // Ustawienie innego koloru dla punktu z najwyższą temperaturą
    positionChart.data.datasets[0].pointBackgroundColor = positions.map((position, index) => {
      if (index === maxTemperatureIndex) {
        return 'red'; // Inny kolor dla najwyższej temperatury
      } 
      else if ( index === maxHumidityIndex) {
        return 'yellow';
      }
      else if ( index === minTemperatureIndex) {
        return 'blue';
      }
      else if ( index === minHumidityIndex) {
        return 'black';
      }
      else{
        return 'green'; // Kolor domyślny dla pozostałych punktów
      }
    });


    positionChart.update();
  }

  updatePositionChart();

  document.getElementById('toggle-chart-btn').addEventListener('click', function() {
    if (currentChartType === 'scatter') {
      currentChartType = 'line';
    } else if (currentChartType === 'line') {
      currentChartType = 'scatter';
    }
    get_data();
  });

}


