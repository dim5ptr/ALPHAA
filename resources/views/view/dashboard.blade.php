<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STI | Sarastya Technology Integrata</title>
    <link rel="icon" type="image/x-icon" href="img/logo_sarastya.jpg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Inline CSS for simplicity */
                body {
                    font-family: 'Arial', sans-serif;
                    margin-left: 5%;
                    margin-right: 5%;
                    height: 100vh;
                    background-color: #d5def7;
                }


                .navbar {
                    margin-top: 1%;
                    padding: 20px 0;
                    display: flex;
                    justify-content: space-between; /* Ensure space between the brand and the rest */
                }

                .container {
                    display: flex;
                    align-items: center;
                    width: 100%; /* Ensure the container spans the full width */
                }

                .navbar a {
                    color: #365AC2;
                    text-decoration: none;
                    margin: 0 15px;
                    font-size: large;
                    font-weight: 900;
                }

                i {
                    color: #365AC2;
                    font-size: x-large;
                }

                .search-bar {
                    display: flex; /* Use flexbox for the container */
                    align-items: center; /* Center items vertically */
                    flex: 1; /* Allow the search bar to take up remaining space */
                    max-width: 500px; /* Optional: limit the max width */
                    padding: 5px;
                    border: 2px solid #ffffff;
                    border-radius: 50px;
                    background-color: #ffffff;
                margin-right: 40%;
                margin-left: 5%;

                }

                .search-bar input {
                    flex: 1; /* Allow the input to take up all available space */
                    border: none;
                    background-color: #ffffff;
                    outline: none;
                    padding-left: 10px;
                }

                .search-bar i {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #fffafa;
                    background-color: #365AC2;
                    border-radius: 20px;
                    font-size: medium;
                    width: 30px;
                    height: 30px;
                    margin-left: 10px; /* Add some space between the input and the icon */
                }


                .banner {
                    display: flex;
                    background-color: #ffffff;
                    background-size: cover;
                    border-radius: 20px;
                    margin-top: 1.3%;
                    padding: 40px 0;
                    box-shadow: 0 4px 8px 4px rgba(0, 0, 0, 0.1); /* Add box shadow */
                }

                .wlc h2 {
                    margin-top: 8%;
                    font-size: 2.8rem;
                    font-weight: 800;
                    color: rgba(20, 19, 19, 0.923);
                    margin-bottom: 1%;
                }

                .wlc span {
                    color: #365AC2;
                    font-weight: bolder;
                }


                .wlc {
                    margin-left: 10%;
                    max-width: 40%;
                }

                .wlc p {
                    color: #666;
                    font-size: 1.5rem;
                    line-height: 1.5;
                }

                .pict{
                    max-width: 40%;
                    margin-left: 50px;
                }

                .pict img {
                    width: 60%;
                    margin-left: 20%;
                }

                section {
                    max-width: 100%;
                    margin: 0 auto;
                    padding: 20px;
                }

                .grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(5%, 4fr));
                    height: 100%;
                    gap: 20px;
                }

                .card {
                    background-color: #fff;
                    border-radius: 15px;
                    overflow: hidden;
                    transition: transform 0.3s, box-shadow 0.3s;
                    cursor: pointer;
                    position: relative;
                }

                .card-overlay {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    opacity: 0; /* Awalnya tidak terlihat */
                    transition: opacity 0.3s; /* Transisi opacity */
                }

                .card-text {
                    position: absolute;
                    top: 80%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    text-align: left;
                    border-radius: 15px;
                    border: 2px solid white;
                    width: 93%;
                    padding: 20px;
                    background-color: rgba(255, 255, 255, 0.849);
                    color: #020202;
                    opacity: 0;
                    transition: opacity 0.3s;
                }

                .card:hover .card-overlay {
                    opacity: 1;
                }

                .card:hover .card-text {
                    opacity: 1;
                }

                .card:hover {
                    transform: translateY(-10px);
                    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
                }


                .card-content {
                    align-items: center; /* Mengatur kartu dan ikon menjadi sejajar */
                }

                .card-icon {
                    width: 97%; /* Ukuran gambar */
                    height: 0.5%;
                    border: 5px solid white;
                    border-radius: 15px;
                }

                .card:hover {
                    transform: translateY(-10px); /* Efek naik saat dihover */
                    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2); /* Efek bayangan saat dihover */
                }

                .card p {
                    font-size: 1rem;
                    margin-bottom: 25%;
                    padding: 10px;
                }

                .card span {
                    font-weight: bold;
                }
    </style>
</head>
<body>
    @include('layouts.navigation')

    <section class="banner">
        <div class="wlc">
            <h2>Welcome To Our Page!</h2>
            <p><span>SARASTYA TECHNOLOGY INTEGRATA</span> Merupakan tempat di mana inovasi bertemu dengan teknologi. Kami menyediakan solusi perangkat lunak inovatif untuk membantu bisnis Anda berkembang.</p>
        </div>
        <div class="pict">
            <img src="img/C.jpg">
        </div>
    </section>

    <section>
        <div class="grid">
            <div class="card">
                <div class="card-content">
                    <img src="img/il.jpg" alt="Grafis ilustratif" class="card-icon">
                    <div class="card-text">
                        <p><span>Grafis ilustratif </span></br>gambarkan ide, menceritakan cerita, atau menjelaskan konsep.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <img src="img/anm.jpg" alt="Motion graphics" class="card-icon">
                    <div class="card-text">
                        <p><span>Motion graphics</span></br>melibatkan pembuatan gerakan dan ilusi dari gambar statis atau objek untuk menciptakan ilusi gerak.</p>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <img src="img/grp.jpg" alt="Komunikasi visual" class="card-icon">
                    <div class="card-text">
                        <p><span>Komunikasi visual </span></br>gunakan elemen-elemen seperti gambar, teks, dan warna untuk menciptakan komunikasi yang efektif.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <img src="img/vid.jpg" alt="Sinematografi digital" class="card-icon">
                    <div class="card-text">
                        <p><span>Sinematografi digital</span></br>konten visual bergerak yang bisa berupa animasi, video klip, atau kombinasi dari keduanya.</br></p>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>
</html>
