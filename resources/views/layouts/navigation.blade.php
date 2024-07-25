<style>
    /* General Navbar Styles */
.navbar {
    height: auto;
    margin-top: 1%;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    background: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    align-items: center;
}

.navbar .container {
    display: flex;
    align-items: center;
    flex: 1;
}

.navbar .container img {
    width: 100px; /* Adjust width as needed */
}

.navbar a {
    color: #365AC2;
    text-decoration: none;
    margin: 0 10px;
    font-size: 18px; /* Adjust font size as needed */
    font-weight: 900;
}

.navbar .aiken {
    display: flex;
    align-items: center;
}

/* Icon Styles */
.navbar .aiken i {
    color: #365AC2;
    font-size: 24px; /* Adjust font size as needed */
}

/* Responsive Styles */
@media (max-width: 1024px) {
    .navbar {
        flex-direction: column;
        align-items: flex-start;
    }

    .navbar .container,
    .navbar .aiken {
        width: 100%;
        justify-content: center;
        text-align: center;
    }

    .navbar .container img {
        width: 80px; /* Adjust width for smaller screens */
    }

    .navbar a {
        margin: 5px 10px;
        font-size: 16px; /* Adjust font size for smaller screens */
    }

    .navbar .aiken i {
        font-size: 20px; /* Adjust font size for smaller screens */
    }
}

@media (max-width: 768px) {
    .navbar {
        padding: 10px;
    }

    .navbar .container img {
        width: 60px; /* Further adjust width for mobile screens */
    }

    .navbar a {
        font-size: 14px; /* Adjust font size for mobile screens */
    }

    .navbar .aiken i {
        font-size: 18px; /* Adjust font size for mobile screens */
    }
}

@media (max-width: 480px) {
    .navbar {
        padding: 5px;
    }

    .navbar .container img {
        width: 50px; /* Further adjust width for extra-small screens */
    }

    .navbar a {
        font-size: 12px; /* Adjust font size for extra-small screens */
    }

    .navbar .aiken i {
        font-size: 16px; /* Adjust font size for extra-small screens */
    }
}


</style>
<header class="navbar">
    <div class="container">
        <img src="img/logo_sarastya.png" alt="Logo">
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
