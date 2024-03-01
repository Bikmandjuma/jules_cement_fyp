<div class="card-body">
                    <h2>Stored Raw Materials Analytics</h2>
                    <p>Mean: <span id="storedMean"></span></p>
                    <p>Median: <span id="storedMedian"></span></p>
                    <p>Standard Deviation: <span id="storedStdDeviation"></span></p>

                    <h2>Consumed Raw Materials Analytics</h2>
                    <p>Mean: <span id="consumedMean"></span></p>
                    <p>Median: <span id="consumedMedian"></span></p>
                    <p>Standard Deviation: <span id="consumedStdDeviation"></span></p>

                    <script>
                        // Fetch data from fetch_mean_value_deviation.php using AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', 'deviation.php', true);
                        xhr.onload = function() {
                            if (xhr.status >= 200 && xhr.status < 300) {
                                // Parse JSON response
                                var data = JSON.parse(xhr.responseText);

                                // Check if data is not empty
                                if (Object.keys(data).length === 0 && data.constructor === Object) {
                                    console.log('No data received from the server');
                                    return;
                                }

                                // Extract mean, median, and standard deviation for stored and consumed quantities
                                var storedMean = data.stored.mean;
                                var storedMedian = data.stored.median;
                                var storedStdDeviation = data.stored.std_deviation;

                                var consumedMean = data.consumed.mean;
                                var consumedMedian = data.consumed.median;
                                var consumedStdDeviation = data.consumed.std_deviation;

                                // Display the analytics data
                                document.getElementById('storedMean').innerText = storedMean;
                                document.getElementById('storedMedian').innerText = storedMedian;
                                document.getElementById('storedStdDeviation').innerText = storedStdDeviation;

                                document.getElementById('consumedMean').innerText = consumedMean;
                                document.getElementById('consumedMedian').innerText = consumedMedian;
                                document.getElementById('consumedStdDeviation').innerText = consumedStdDeviation;
                            } else {
                                console.error('Request failed with status ' + xhr.status);
                            }
                        };

                        // Handle errors
                        xhr.onerror = function() {
                            console.error('Request failed');
                        };

                        // Send the request
                        xhr.send();
                    </script>

                  </div>
                  <!---->