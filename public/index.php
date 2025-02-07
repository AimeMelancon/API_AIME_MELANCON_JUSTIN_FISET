<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Acceuil | Centre Sportif</title>
    <link rel="stylesheet" href="./ressources/css/normalize.css">
    <link rel="stylesheet" href="./ressources/css/main.css">
    <link rel="stylesheet" href="./ressources/css/index.css">

    <script type="module" src="./ressources/js/data.js" defer></script>
</head>

<body>
    <header>
        <section class="banner">
            <p><strong>Les étudiants peuvent maintenant profiter de 15% de rabais &#127881;</strong></p>
        </section>

        <nav class="navbar">
            <div id="navbar-content">
                <img id="navbar-logo" src="./ressources/images/fima-light.png" alt="logo">
                <div id="navbar-menu-container">
                    <input type="checkbox" id="menu-toggle">
                    <img id="navbar-menu" src="./ressources/images/icons/light/menu.png" alt="menu_icon">
                </div>
                <div id="menu-content">
                    <ul>
                        <li class="menu-item" id="welcome"><p class="menu-link">Acceuil</p></li>
                        <li class="menu-item" id="listOfActivity"><p class="menu-link">Nos activitées</p></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section id="video-section">
            <div id="video-overlay">
                <img id="logo" src="./ressources/images/fima-light.png" alt="logo">
                <h2 id="titre">Bienvenue au <em>Centre Sportif Fima</em></h2>
                <p>
                    Le <em>Centre Sportif Fima</em> vous offre une expérience
                    unique. Que ce soit par sa variété
                    d'activitées
                    ou par le professionalisme de ses coachs, le centre
                    saura vous aider à atteindre vos objectif
                    sportifs et à atteindre votre potentiel en tant
                    qu'amateur ou athlète professionnel.
                </p>
            </div>
            <div id="video-container">
                <video id="background-video" src="./ressources/video/video_background.mp4" autoplay loop muted>
                    Votre navigateur ne prend pas en charge la lecture des vidéos
                </video>
            </div>
        </section>

        <section id="main-section">
            <h3>Nos activités populaires</h3>
            <div class="image-grid" id="popular-activities"></div>
        </section>

        <p class="buttons" id="allActivities">Voir toutes les activités</p>
    </main>

    <footer>
        <section>
            <ul>
                <li>
                    <p><strong>Nous contacter</strong></p>
                    <p>Adresse : 4562 Rue du Saint-Léonard, Montréal, QC</p>
                    <p>Téléphone : (438) 708-6989</p>
                </li>
                <li>
                    <p><strong>Proposez un cours chez nous</strong></p>
                    <p>
                        Joingez notre équipe et contribuez à inspirer le
                        bien-être à travers vos compétences sportives.
                    </p>
                </li>
                <li>
                    <p><strong>Suivez-nous</strong></p>
                    <ul id="footer-social">
                        <li>
                            <img id="facebook-icon" src="./ressources/images/icons/facebook.png" alt="facebook">
                        </li>
                        <li>
                            <img id="instagram-icon" src="./ressources/images/icons/instagram.png" alt="instagram">
                        </li>
                        <li>
                            <img id="x-icon" src="./ressources/images/icons/x.png" alt="twitter">
                        </li>
                    </ul>
                </li>
            </ul>
        </section>
        <p>&copy; 2025 Centre Sportif Fima, tous droits réservés.</p>
    </footer>
</body>

</html>