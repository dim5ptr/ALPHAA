<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
        }
        .container {
            background: rgba(0, 0, 0, 0.7);
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
        }
        .loader {
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #3498db;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
            margin: auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Verification Status</h1>
        <div id="content">
            <div class="loader"></div>
            <p>Loading...</p>
        </div>
    </div>

    <script>
        async function fetchVerificationStatus() {
            const url = '{{ $url }}';
            try {
                const response = await fetch(url);
                const data = await response.json();
                displayStatus(data);
            } catch (error) {
                document.getElementById('content').innerHTML = `<p>Error fetching verification status</p>`;
            }
        }

        function displayStatus(data) {
            const contentDiv = document.getElementById('content');
            contentDiv.innerHTML = '';
            if (data.success) {
                contentDiv.innerHTML = `
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>Your email has been successfully verified.</p>
                        <hr>
                        <p class="mb-0">${data.message}</p>
                    </div>
                `;
            } else {
                contentDiv.innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Verification Failed</h4>
                        <p>There was an issue with verifying your email.</p>
                        <hr>
                        <p class="mb-0">${data.message}</p>
                    </div>
                `;
            }
        }

        fetchVerificationStatus();
    </script>
    <p>Kembali ke <a href="{{ route('login') }}">halaman login</a>.</p>
</body>
</html>
