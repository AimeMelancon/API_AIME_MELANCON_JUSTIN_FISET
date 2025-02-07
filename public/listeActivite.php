<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Liste d'activité | Centre Sportif</title>
    <link rel="stylesheet" href="./ressources/css/normalize.css">
    <link rel="stylesheet" href="./ressources/css/main.css">
    <link rel="stylesheet" href="./ressources/css/listeActivite.css">

    <script type="module" src="./ressources/js/data.js" defer></script>
</head>

<body>
    <header>
        <section class="banner">
            <p><strong>Les étudiants peuvent maintenant profiter de 15% de
                    rabais &#127881;</strong></p>
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

        <section id="filtres">
            <h3 id="title">Filtrer les activités</h3>
            <form id="form-filtres">
                <button type="button" id="appliquer-filtres">Appliquer les filtres</button>
                <input type="reset" id="reset-filtres" value="Réinitialiser">
            </form>
        </section>
    </header>

    <main>
        <section id="conteneur-activites"></section>

        <p id="ajouter-activite" class="buttons">
            <img src="./ressources/images/icons/light/add.png">
            Ajouter une activité
        </p>
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