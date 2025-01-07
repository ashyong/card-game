<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Distribution</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .error {
            color: red;
            margin: 10px 0;
        }

        .distribution {
            margin-top: 20px;
        }

        .person-cards {
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Card Distribution System</h1>

        <div>
            <label for="num_people">Number of People:</label>
            <input type="number" id="num_people" min="1" required>
            <button onclick="distributeCards()">Distribute Cards</button>
        </div>

        <div id="error" class="error"></div>
        <div id="distribution" class="distribution"></div>
    </div>

    <script>
        function distributeCards() {
            const numPeople = document.getElementById('num_people').value;
            const errorDiv = document.getElementById('error');
            const distributionDiv = document.getElementById('distribution');

            // Clear previous results
            errorDiv.textContent = '';
            distributionDiv.innerHTML = '';

            // Input validation
            if (!numPeople || numPeople < 1) {
                errorDiv.textContent = 'Input value does not exist or value is invalid';
                return;
            }

            // Make API request
            $.ajax({
                url: '/cards/distribute',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                data: {
                    num_people: numPeople
                },
                success: function(response) {
                    if (response.status === 'success') {
                        response.distribution.forEach((cards, index) => {
                            const personDiv = document.createElement('div');
                            personDiv.className = 'person-cards';
                            personDiv.textContent = cards.join(',');
                            distributionDiv.appendChild(personDiv);
                        });
                    }
                },
                error: function() {
                    errorDiv.textContent = 'Irregularity occurred';
                }
            });
        }
    </script>
</body>

</html>
