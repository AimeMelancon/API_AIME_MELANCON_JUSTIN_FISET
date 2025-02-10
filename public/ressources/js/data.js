function init() {
    if (window.location.pathname.includes("formulaireActivite")) {
        initForm();
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

async function initForm() {
    await populateFormOptions(); // On commence pas créer les options à l'aide de l'API, on attend avant de remplir le formulaire!

    // Au besoin, on remplit le formulaire avec les données de l'activité
    let idSale = new URL(window.location.href);
    let params = new URLSearchParams(idSale.search);
    if (params.has("id")) {
        populateForm(params.get("id"));
    }
}

async function populateFormOptions() {
    const coach = document.getElementById("coach");
    const location = document.getElementById("location");
    const level = document.getElementById("niv");

    await Promise.all([
        createOptionFromAPI("/api/coaches/", "name", "id", coach),
        createOptionFromAPI("/api/locations/", "name", "id", location),
        createOptionFromAPI("/api/levels/", "name", "name", level),
    ]);
}

async function createOptionFromAPI(apiSrc, textColumn, valueColumn, select) {
    await fetch(apiSrc, { method: "GET" })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Erreur HTTP: " + response.statusText);
            }
            return response.json();
        })
        .then((data) => {
            if (!data.error) {
                data.forEach((optionData) => {
                    const option = document.createElement("option");
                    option.value = optionData[valueColumn];
                    option.innerText = optionData[textColumn];
                    select.append(option);
                });
            } else {
                throw new Error("Erreur reçue du serveur: " + data.error);
            }
        })
        .catch((error) => {
            console.error(error.message);
        });
}

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
    createFilter("/api/coaches/", "name", form, "Entraineur : ", "coach");
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
        console.log("Conteneur d'activités non trouvé");
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
    location.innerText = "Lieu : " + activity.location_name;
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
function populateForm(id) {
    if (!Number.isInteger(Number(id))) return; // Si l'id n'est pas un nombre, on fait rien

    fetch("/api/activities/" + id, { method: "GET" })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Erreur HTTP: " + response.statusText);
            }
            return response.json();
        })
        .then((data) => {
            if (!data.error) {
                const activity = data[0];
                document.getElementById("nom-activite").value = activity.name;
                document.getElementById("description").value =
                    activity.description;
                document.getElementById("img-url").value = activity.image;
                document.getElementById("coach").value = activity.coach_id;
                document.getElementById("schedule_day").value =
                    activity.schedule_day;
                document.getElementById("schedule_time").value =
                    activity.schedule_time;
                document.getElementById("niv").value = activity.level_id;
                document.getElementById("location").value =
                    activity.location_id;
                document.getElementById("form-title").innerText =
                    "Modifier l'activité : " + activity.name;
            } else {
                throw new Error("Erreur reçue du serveur: " + data.error);
            }
        })
        .catch((error) => {
            console.error(error.message);
        });
}


function updateActivity(id){
    if(!Number.isInteger(Number(id))) return;

    const url = "/api/activities/"+id;

    //Prépare les  données à envoyer à l'api
    const data={
        
        id:            id,
        name:          activity.name,
        description:   activity.description,
        level_id:      activity.level_id,
        coach_id:      activity.coach_id,
        schedule_day:  activity.schedule_day,
        schedule_time: activity.schedule_time,
        location_id:   activity.location_id,

    };
    //Prépare le fichier JSON et la  méthode pour l'envoie
    const fetchOptions = {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    };
    //Envoie la requête à l'api.
    fetch(url,fetchOptions)
    .then(response => {
        if (!response.ok) {
          throw new Error('Le serveur a renvoyé une erreur');
        }
        return response.json(); 
      })
      .then(updatedPost => {
        console.log('Post mis à jour:', updatedPost);
      })
      .catch(error => {
        console.error("Il y a eu une erreur lors de l'exécution du fetch");
      });


}
