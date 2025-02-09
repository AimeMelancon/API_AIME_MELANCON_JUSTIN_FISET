<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Édition | Centre Sportif</title>
    <link rel="stylesheet" href="/public/ressources/css/normalize.css">
    <link rel="stylesheet" href="/public/ressources/css/main.css">
    <link rel="stylesheet" href="/public/ressources/css/formulaire.css">

    <script type="module" src="/public/ressources/js/data.js" defer></script>
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
        <section>
            <form id="form-activite">
                <h2 id="form-title">Ajouter une activité</h2>
                <label for="nom-activite">Nom de l'activité :</label> <br>
                <input type="text" value id="nom-activite" required> <br>
                <label for="description">Description :</label> <br>
                <textarea id="description" required></textarea> <br>
                <label for="img-url">Image (URL) :</label> <br>
                <input  type="text" id="img-url" required> <br>
                <label for="niv">Niveau :</label> <br>
                <select id="niv" required>
                    <option value selected disabled>---Veuillez choisir un
                        niveau---</option>
                </select> <br>
                <label for="coach">Coach :</label> <br>
                <select id="coach" required>
                    <option value selected disabled>---Veuillez sélectionner
                        un coach---</option>
                </select> <br>
                <label for="schedule_day">Horaire :</label> <br>
                <input type="text" id="schedule_day" required> <br>
                <label for="schedule_time">Horaire :</label> <br>
                <input type="text" id="schedule_time" required> <br>
                <label for="location">Lieu :</label> <br>
                <select id="location" required>
                    <option value selected disabled>---Veuillez sélectionner
                        un lieu pour l'activité---</option>
                </select> <br>
                <br>
                <button id="enregistrer" class="buttons" type="button">Enregistrer</button>
            </form>
        </section>
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