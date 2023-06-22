const app = {

    // Méthode se déclenchant au démarage de la page
    // Appelle les méthode init des autres objets
    init: function() {

        //Démarage des objets actifs au démarage de la page
        like.init();

    }
}

// Ecouteur sur le chargement du DOM pour lancer l'objet init
document.addEventListener('DOMContentLoaded', app.init);