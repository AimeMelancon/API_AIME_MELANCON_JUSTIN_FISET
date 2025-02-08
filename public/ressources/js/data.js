// données des activités
const activities = [
    {
        id: 1,
        name: "Yoga",
        description:
            "Retrouver votre équilibre intérieur avec nos séances de yoga apaisantes",
        image: "ressources/images/activities/yoga.jpg",
        level: "Débutant",
        coach: "Amélie",
        schedule_day: "Lundi",
        schedule_time: "10h - 11h",
        location: "Intérieur",
    },
    {
        id: 2,
        name: "Calisthenic",
        description:
            "Renforcez votre corps avec des exercices au poids du corps puissants et dynamiques.",
        image: "ressources/images/activities/calisthenic.jpg",
        level: "Tous niveaux",
        coach: "Lucas",
        schedule_day: "Mardi",
        schedule_time: "18h - 19h",
        location: "Extérieur",
    },
    {
        id: 3,
        name: "Natation",
        description:
            "Plongez dans la santé et la vitalité grâce à nos cours de natation adaptés à tous les niveaux.",
        image: "ressources/images/activities/natation.jpg",
        level: "Intermédiaire",
        coach: "Nina",
        schedule_day: "Mercredi",
        schedule_time: "14h - 15h",
        location: "Intérieur",
    },
    {
        id: 4,
        name: "Danse",
        description:
            "Perfectionner ou découvrez vos talent et améliorer votre mobilité avec nos cours amusant pours tous",
        image: "ressources/images/activities/danse.jpg",
        level: "Tous niveaux",
        coach: "Paul",
        schedule_day: "Jeudi",
        schedule_time: "16h - 17h",
        location: "Extérieur",
    },
    {
        id: 5,
        name: "Karaté",
        description:
            "Développez votre discipline et vos compétences en arts martiaux.",
        image: "ressources/images/activities/karate.jpg",
        level: "Tous niveaux",
        coach: "Sensei Hiro",
        schedule_day: "Mardi",
        schedule_time: "18h - 19h30",
        location: "Intérieur",
    },
    {
        id: 6,
        name: "Course à pied",
        description:
            "Améliorez votre endurance et découvrez le plaisir de courir en plein air.",
        image: "ressources/images/activities/running.jpg",
        level: "Tous niveaux",
        coach: "Sensei Hiro",
        schedule_day: "Dimanche",
        schedule_time: "8h - 9h",
        location: "Extérieur",
    },
];

function init() {
    let idSale = new URL(window.location.href);
    let params = new URLSearchParams(idSale.search);

    if (params.has("id")) {
        let _id = params.get("id");

        let index = getActivityIndex(_id);
        if (0 <= index && index < activities.length) {
            populateForm(activities[index]);
        } else {
            console.log("id non trouvée");
        }
    }

    initButtons();

    displayPopularActivities();
    populateFilters();

    resetActivityFilters();
    bindFilterEvents();
}

addEventListener("DOMContentLoaded", () => {
    init();
});

// affiche les activités populaires pour la page d'accueil
function displayPopularActivities() {
    fetch("/api/activities/random/", { method: "GET" })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Erreur HTTP: " + response.statusText);
            }
            return response.json();
        })
        .then((data) => {
            if (!data.error) {
                const container = document.getElementById("popular-activities");

                if (container != null) {
                    data.forEach((activity) => {
                        container.append(createPopularActivity(activity));
                    });
                }
            } else {
                throw new Error("Erreur reçue du serveur: " + data.error);
            }
        })
        .catch((error) => {
            console.error(error.message);
        });
}

function createPopularActivity(activity) {
    const container = document.createElement("div");
    const img = document.createElement("img");
    const descriptionContainer = document.createElement("div");
    const description = document.createElement("p");

    container.className = "img-content";

    img.src = activity.image;
    img.alt = activity.name;
    img.className = "img-bg";

    descriptionContainer.className = "img-overlay";

    description.innerText = activity.description;

    container.append(img, descriptionContainer);
    descriptionContainer.append(description);

    return container;
}

// gestion des filtres pour la page des activités
function populateFilters() {
    const form = document.getElementById("form-filtres");

    createFilter("/api/levels/", "name", form, "Niveau : ", "level");
    createFilter("/api/locations/", "name", form, "Lieu : ", "location");
    createFilter("/api/coaches/","name",form,"Entraineur : ","coach");
}

function createFilter(apiSrc, column, container, label, id) {
    if (!container) return; // Si le conteneur n'existe pas, on ne crée pas de filtre

    const labelObject = document.createElement("label");
    labelObject.innerText = label;
    const select = document.createElement("select");
    select.id = id;

    fetch(apiSrc, { method: "GET" })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Erreur HTTP: " + response.statusText);
            }
            return response.json();
        })
        .then((data) => {
            if (!data.error) {
                data.unshift({ [column]: "Tous" }); // Ajout manuel de l'option Tous pour chaque filtre
                for (let i = 0; i < data.length; i++) {
                    const optionObject = document.createElement("option");
                    optionObject.value = data[i][column];
                    optionObject.innerText = data[i][column];
                    select.appendChild(optionObject);
                }
            } else {
                throw new Error("Erreur reçue du serveur: " + data.error);
            }
        })
        .catch((error) => {
            console.error(error.message);
        });

    container.insertBefore(select, container.firstChild);
    container.insertBefore(labelObject, select);
}

// Retourne toutes les options possibles pour un attribut donné selon les données des activités
function getOptions(attribute) {
    let options = ["Tous"];

    activities.forEach((activity) => {
        const option = activity[attribute];
        if (!options.includes(option)) {
            options.push(option);
        }
    });

    return options;
}

// Gestion des événements pour les filtres
function bindFilterEvents() {
    const appliquer = document.getElementById("appliquer-filtres");
    if (appliquer) {
        appliquer.addEventListener("click", () => {
            displayFilteredActivities({
                coach: document.getElementById("coach").value,
                location: document.getElementById("location").value,
                level: document.getElementById("level").value,
            });
        });
    }

    const reset = document.getElementById("reset-filtres");
    if (reset) {
        reset.addEventListener("click", () => {
            resetActivityFilters();
        });
    }
}

// Réinitialise les filtres pour la page des activités
function resetActivityFilters() {
    displayFilteredActivities({
        coach: "Tous",
        location: "Tous",
        level: "Tous",
    });
}

// affiche toutes les activités filtrées pour la page des activités
function displayFilteredActivities(filters) {
    const container = document.getElementById("conteneur-activites");
    if (!container) {
        console.error("Conteneur d'activités non trouvé");
        return;
    }

    container.innerHTML = ""; // Reset du code html, on enlève les activités déjà affichées

    const apiurl = "/api/activities/filter?";
    const paramsObj = new URLSearchParams();
    for (const key in filters) {
        if (filters[key] !== "Tous") {
          paramsObj.append(key, filters[key]);
        }
    }
    const params = paramsObj.toString();
    const uri = params ? apiurl + params : apiurl;

    fetch(uri, { method: "GET" })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Erreur HTTP: " + response.statusText);
            }
            return response.json();
        })
        .then((data) => {
            if (!data.error) {
                data.forEach((activity) => {
                    createActivity(activity, container);
                });
            } else {
                throw new Error("Erreur reçue du serveur: " + data.error);
            }
        })
        .catch((error) => {
            console.error(error.message);
        });
}

// Crée un élément HTML pour une activité donnée
function createActivity(activity, container) {
    const article = document.createElement("article");
    article.className = "table";

    console.log(activity);
    const col1 = document.createElement("div");
    col1.className = "col";
    const img = document.createElement("img");
    img.className = "img";
    img.src = activity.image;
    img.alt = activity.name;
    col1.append(img);

    const col2 = document.createElement("div");
    col2.className = "col";

    const titleContainer = document.createElement("div");
    titleContainer.className = "title";
    const title = document.createElement("p");
    title.innerText = activity.name;
    titleContainer.appendChild(title);

    const contenu = document.createElement("div");
    contenu.className = "contenu";
    const description = document.createElement("p");
    description.innerText = activity.description;
    const horaire = document.createElement("p");
    horaire.innerText = "Horaire : " + activity.schedule_day;
    const niveau = document.createElement("p");
    niveau.innerText = "Niveau : " + activity.level_id;
    const coach = document.createElement("p");
    coach.innerText = "Entraineur : " + activity.coach_name;
    const location = document.createElement("div");
    location.className = "location";
    const locationTxt = document.createElement("p");
    location.innerText = "Lieu : " + activity.location;
    const locationImg = document.createElement("img");
    locationImg.src = activity.location_logo;
    locationImg.alt = activity.location_name;
    locationImg.className = "location-img";
    location.append(locationTxt, locationImg);
    contenu.append(description, horaire, niveau, coach, location);

    col2.append(titleContainer, contenu);
    article.append(col1, col2);
    container.append(article);

    article.addEventListener("click", () => {
        window.location.href = "/formulaireActivite?id=" + activity.id;
    });
}

function initButtons() {
    const logo = document.getElementById("navbar-logo");
    if (logo) {
        logo.addEventListener("click", () => {
            window.location.href = "/index";
        });
    }

    const home = document.getElementById("welcome");
    if (home) {
        home.addEventListener("click", () => {
            window.location.href = "/index";
        });
    }

    const listOfActivity = document.getElementById("listOfActivity");
    if (listOfActivity) {
        listOfActivity.addEventListener("click", () => {
            window.location.href = "/listeActivite";
        });
    }

    const addActivity = document.getElementById("ajouter-activite");
    if (addActivity) {
        addActivity.addEventListener("click", () => {
            window.location.href = "/formulaireActivite";
        });
    }

    const allActivity = document.getElementById("allActivities");
    if (allActivity) {
        allActivity.addEventListener("click", () => {
            window.location.href = "/listeActivite";
        });
    }

    // Gestion des boutons de réseaux sociaux dans le footer
    const fbIcon = document.getElementById("facebook-icon");
    if (fbIcon) {
        fbIcon.addEventListener("click", () => {
            window.open("https://www.facebook.com", "_blank");
        });
    }
    const instagramIcon = document.getElementById("instagram-icon");
    if (instagramIcon) {
        instagramIcon.addEventListener("click", () => {
            window.open("https://www.instagram.com", "_blank");
        });
    }
    const xIcon = document.getElementById("x-icon");
    if (xIcon) {
        xIcon.addEventListener("click", () => {
            window.open("https://x.com", "_blank");
        });
    }

    const enregistrerForm = document.getElementById("enregistrer");
    if (enregistrerForm) {
        enregistrerForm.addEventListener("click", () => {
            window.location.href = "/listeActivite";
        });
    }
}

// Remplir le formulaire avec les données de l'activité
function populateForm(activity) {
    document.getElementById("nom-activite").value = activity.name;
    document.getElementById("description").value = activity.description;
    document.getElementById("img-url").value = activity.image;
    document.getElementById("coach").value = activity.coach;
    document.getElementById("horaire").value =
        activity.schedule_day + " " + activity.schedule_time;
    document.getElementById("niv").value = activity.level;
    document.getElementById("location").value = activity.location;
    document.getElementById("form-title").innerText =
        "Modifier l'activité : " + activity.name;
}

// Retourne l'index d'une activité dans l'ensemble de données selon son id
function getActivityIndex(id) {
    for (let i = 0; i < activities.length; i++) {
        if (activities[i].id == id) {
            return i;
        }
    }

    return -1;
}
