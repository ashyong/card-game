<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Distribution</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        :root {
            --color-border-default: #d0d7de;
            --color-canvas-default: #ffffff;
            --color-canvas-subtle: #f6f8fa;
            --color-btn-bg: #f6f8fa;
            --color-btn-border: #1b1f2426;
            --color-btn-hover-bg: #f3f4f6;
            --color-btn-active-bg: #ebecf0;
            --color-header-bg: #24292f;
            --color-header-text: #ffffff;
            --color-danger-fg: #cf222e;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
            line-height: 1.5;
            color: #24292f;
            background-color: var(--color-canvas-default);
            margin: 0;
            padding: 0;
        }

        /* Header styling */
        .header {
            background-color: var(--color-header-bg);
            color: var(--color-header-text);
            padding: 16px;
            display: flex;
            align-items: center;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
            font-weight: 600;
        }

        /* Container styling */
        .container {
            max-width: 1012px;
            margin: 0 auto;
            padding: 24px;
        }

        /* Box styling */
        .box {
            background-color: var(--color-canvas-default);
            border: 1px solid var(--color-border-default);
            border-radius: 6px;
            margin-bottom: 16px;
        }

        .box-header {
            background-color: var(--color-canvas-subtle);
            border-bottom: 1px solid var(--color-border-default);
            padding: 16px;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }

        .box-title {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }

        .box-body {
            padding: 16px;
        }

        /* Form styling */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            max-width: 200px;
            padding: 5px 12px;
            font-size: 14px;
            line-height: 20px;
            border: 1px solid var(--color-border-default);
            border-radius: 6px;
            appearance: none;
        }

        /* Button styling */
        .btn {
            color: #24292f;
            background-color: var(--color-btn-bg);
            border: 1px solid var(--color-btn-border);
            border-radius: 6px;
            padding: 5px 16px;
            font-size: 14px;
            font-weight: 500;
            line-height: 20px;
            cursor: pointer;
            display: inline-block;
            transition: .2s;
        }

        .btn:hover {
            background-color: var(--color-btn-hover-bg);
        }

        .btn:active {
            background-color: var(--color-btn-active-bg);
        }

        /* Error message styling */
        .flash {
            padding: 16px;
            border-radius: 6px;
            margin-bottom: 16px;
            border: 1px solid var(--color-border-default);
        }

        .flash-error {
            color: var(--color-danger-fg);
            background-color: #ffebe9;
            border-color: rgba(255, 129, 130, 0.4);
        }

        /* Results styling */
        .distribution-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .distribution-item {
            padding: 8px 0;
            border-bottom: 1px solid var(--color-border-default);
            font-family: ui-monospace, SFMono-Regular, SF Mono, Menlo, Consolas, Liberation Mono, monospace;
            font-size: 12px;
        }

        .distribution-item:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Card Distribution System</h1>
    </div>

    <div class="container">
        <div class="box">
            <div class="box-header">
                <h2 class="box-title">Distribute Cards</h2>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label for="num_people" class="form-label">Number of People</label>
                    <input type="number" id="num_people" class="form-control" min="1" required>
                </div>
                <button onclick="distributeCards()" class="btn">Distribute Cards</button>
            </div>
        </div>

        <div id="error" style="display: none;" class="flash flash-error"></div>

        <div id="results" class="box" style="display: none;">
            <div class="box-header">
                <h2 class="box-title">Distribution Results</h2>
            </div>
            <div class="box-body">
                <ul id="distribution" class="distribution-list"></ul>
            </div>
        </div>
    </div>

    <script>
        function distributeCards() {
            const numPeople = document.getElementById('num_people').value;
            const errorDiv = document.getElementById('error');
            const resultsDiv = document.getElementById('results');
            const distributionList = document.getElementById('distribution');

            // Reset display
            errorDiv.style.display = 'none';
            resultsDiv.style.display = 'none';
            distributionList.innerHTML = '';

            // Input validation
            if (!numPeople || numPeople < 1) {
                errorDiv.textContent = 'Input value does not exist or value is invalid';
                errorDiv.style.display = 'block';
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
                            const li = document.createElement('li');
                            li.className = 'distribution-item';
                            li.textContent = `Person ${index + 1}: ${cards.join(', ')}`;
                            distributionList.appendChild(li);
                        });
                        resultsDiv.style.display = 'block';
                    }
                },
                error: function() {
                    errorDiv.textContent = 'Irregularity occurred';
                    errorDiv.style.display = 'block';
                }
            });
        }
    </script>
</body>

</html>
