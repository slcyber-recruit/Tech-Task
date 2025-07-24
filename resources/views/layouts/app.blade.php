<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #343a40; /* Dark gray for the header */
            color: white;
            padding: 1rem 0;
            text-align: center; /* Ensures content inside navbar is centered */
        }
        .navbar h1 {
            color: red;
            margin-bottom: 0.5rem;
            text-align: center !important; /* Add !important to override any Bootstrap styles */
            width: 100%; /* Ensure it takes full width */
        }
        .navbar p {
            color: #ccc;
            font-size: 0.9rem;
            text-align: center; /* Explicitly centered */
        }
        .container {
            padding-top: 2rem;
        }
        .table-responsive {
            margin-top: 1rem;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .search-bar {
            margin-bottom: 1.5rem;
        }

        /* Custom CSS to remove button styling and make them underlined text */
        /* This class will now apply to both Edit and Delete actions */
        .action-link {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            text-decoration: underline; /* This adds the underscore */
            color: blue; /* Default link color for both Edit and Delete */
            font-size: inherit; /* Inherit font size from parent */
            font-family: inherit; /* Inherit font family from parent */
        }
        .action-link:hover {
            color: darkblue; /* Change color on hover for both */
        }

        /* The .delete-link class is no longer needed if it's styled the same as .action-link */
        /* You can remove these specific styles if you want them to be identical. */
        /* If you wanted a slight variation (e.g., still slightly different hover), you could keep it */
    </style>
</head>
<body>
    <header class="navbar">
        <div class="container">
            <h1>Book Shop</h1>
            <p>Cupcake ipsum dolor sit amet croissant. I love topping candy canes sweet roll croissant caramels. Soufflé macaroon liquorice chocolate tart I love.</p>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>