<style>
    .navbar {       height: 5%;
                    margin-top: 1%;
                    padding: 20px 0;
                    display: flex;
                    justify-content: space-between; /* Ensure space between the brand and the rest */
                }
                .container {
                    display: flex;
                    align-items: center;
                    width: 50%; /* Ensure the container spans the full width */
                }

                .container img {
                    width: 10%;
                }

                .navbar a {
                    color: #365AC2;
                    text-decoration: none;
                    margin: 0 15px;
                    font-size: large;
                    font-weight: 900;
                }

                .aiken {
                    max-width: 50%;
                }

                .aiken i {
                    color: #365AC2;
                    font-size: 30px;
                    padding-top: 20px;
                }

</style>
<header class="navbar">
    <div class="container">
        <img src="img/logo_sarastya.png">
    </div>
    <div class="aiken">
        <a href="{{ route('dashboard') }}">
            <i class="fas fa-home"></i>
        </a>
        <a href="{{ route('profil') }}">
        <i class="fas fa-user"></i>
    </a>
</div>
</header>
