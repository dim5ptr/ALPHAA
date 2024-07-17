<style>
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
</style>
<header class="navbar">
    <div class="container">
        <a href="#" class="brand">HelpU</a>
        <div class="search-bar">
        <input type="text" placeholder="What are you looking for?">
        <i class="fas fa-search"></i></div>
        <a href="#">
            <i class="fas fa-home"></i>
        </a>
        <a href="{{ route('profil') }}">
        <i class="fas fa-user"></i>
    </a> </div>
</header>
