<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Batangas Province Shcolarship Grants</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            font-family: 'Poppins', sans-serif;
            color: #fff;
        }

        .container {
            padding-top: 30px;
        }

        h1 {
            text-align: center;
            font-weight: 600;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 50px;
        }

        .district-card {
            border-radius: 15px;
            background-color: #fff;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .district-card:hover {
            transform: translateY(-10px);
        }

        .district-card h3 {
            font-weight: 600;
            color: #343a40;
        }

        .district-card ul {
            list-style: none;
            padding-left: 0;
        }

        .district-card ul li {
            padding: 8px 0;
            font-weight: 500;
        }

        .district-card a {
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .district-card a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .district-button {
            background-color: #2575fc;
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 25px;
            transition: background-color 0.3s ease;
        }

        .district-button:hover {
            background-color: #6a11cb;
            cursor: pointer;
        }

        .collapse p {
            font-size: 16px;
            color: #555;
        }

        /* Card Container Layout */
        .district-card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        /* Mobile Responsiveness */
        @media (max-width: 767px) {
            .district-card-container {
                grid-template-columns: 1fr;
            }
        }

    </style>
</head>

<body>

<div class="container">
    <a href="javascript:void(0);" onclick="window.history.back();">
        <h1>Batangas Province Shcolarship Grants</h1>
    </a>

    <div class="district-card-container">
        <!-- District 1 -->
        <div class="district-card">
            <h3>Scheme 1</h3>
            <ul>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
            </ul>
            <button class="btn district-button" data-bs-toggle="collapse" data-bs-target="#scheme1Details">More Info</button>
            <div class="collapse" id="scheme1Details">
                <p class="mt-3">Scheme 1 information goes here</p>
            </div>
        </div>

        <!-- District 2 -->
        <div class="district-card">
            <h3>Scheme 2</h3>
            <ul>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
            </ul>
            <button class="btn district-button" data-bs-toggle="collapse" data-bs-target="#scheme2Details">More Info</button>
            <div class="collapse" id="scheme2Details">
                <p class="mt-3">Scheme 2 information goes here</p>
            </div>
        </div>

        <!-- District 3 -->
        <div class="district-card">
            <h3>Scheme 3</h3>
            <ul>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
            </ul>
            <button class="btn district-button" data-bs-toggle="collapse" data-bs-target="#scheme3Details">More Info</button>
            <div class="collapse" id="scheme3Details">
                <p class="mt-3">Scheme 3 information goes here</p>
            </div>
        </div>

        <!-- District 4 -->
        <div class="district-card">
            <h3>Scheme 4</h3>
            <ul>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
            </ul>
            <button class="btn district-button" data-bs-toggle="collapse" data-bs-target="#scheme4Details">More Info</button>
            <div class="collapse" id="scheme4Details">
                <p class="mt-3">Scheme 4 information goes here</p>
            </div>
        </div>

        <!-- District 5 -->
        <div class="district-card">
            <h3>Scheme 5</h3>
            <ul>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
            </ul>
            <button class="btn district-button" data-bs-toggle="collapse" data-bs-target="#scheme5Details">More Info</button>
            <div class="collapse" id="scheme5Details">
                <p class="mt-3">Scheme 5 information goes here</p>
            </div>
        </div>

        <!-- District 6 -->
        <div class="district-card">
            <h3>Scheme 6</h3>
            <ul>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
                <li><a href="#">Info here</a></li>
            </ul>
            <button class="btn district-button" data-bs-toggle="collapse" data-bs-target="#scheme6Details">More Info</button>
            <div class="collapse" id="scheme6Details">
                <p class="mt-3">Scheme 6 information goes here</p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Popper.js and Bootstrap Bundle) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
