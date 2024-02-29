<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Raw Materials Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="rawMaterialsChart" width="800" height="400"></canvas>
    
    <script>
        // Fetch data from fetch_data.php using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_data.php', true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Parse JSON response
                var data = JSON.parse(xhr.responseText);

                // Extract names and quantities
                var names = Object.keys(data);
                var quantities = Object.values(data).map(function(item) { return item.quantity; });
                var consumed = Object.values(data).map(function(item) { return item.consumed; });

                // Create chart data
                var ctx = document.getElementById('rawMaterialsChart').getContext('2d');
                var rawMaterialsChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: names,
                        datasets: [
                            {
                                label: 'Stored',
                                data: quantities,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Consumed',
                                data: consumed,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        };
        xhr.send();
    </script>
</body>
</html>
