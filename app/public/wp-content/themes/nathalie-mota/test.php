p {
    font-size: 14px;
}

hr {
    width: 100%;
    margin: auto;
    height: 1px;
    padding-right: 15px;
}

/* Section 1 */
.section-1 {
    display: flex;
    align-items: end;
    text-transform: uppercase;
    font-weight: 400;
}

.section-1 .content {
    flex: 1;
}

.section-1 h1 {
    font-size: 50px;
}


.photo-content {
    display: flex;
    flex-direction: column;
    margin: 50px;
}

.photo-title-new {
    color: black;
    font-family: 'Space Mono';
}


.photo-meta {
    padding-bottom: 10px;
}


p, h1 {
    padding-bottom: 20px;
}


.left-column {
    margin-left: 15px;
}

.left-column,
.right-column,
.related-photo {
    width: 50%;
}

.photo-img {
    max-width: 100%;
    height: auto;
}

.small-photo {
    width: 50%;
    height: auto;
}



/* Section 2 */
.section-2 {
    display: flex;
    justify-content: space-between; /* Espace les éléments de gauche et de droite */
    align-items: flex-start; /* Aligne les éléments en haut */
    height: auto; /* Ajustez la hauteur selon vos besoins */
    padding: 20px 0; /* Ajoutez du padding vertical si nécessaire */
}


.section-2 p {
    padding-bottom: 0px;
    align-content: center;
    margin-left: 15px;
}


.btn-contact {
    background-color: #D8D8D8;
    border-radius: 2px;
    font-family: 'Space Mono';
    color: black;
    text-decoration: none;
    width: 272px;
    height: 50px;
    font-size: 14px;
    align-content: center;
    text-align: center;
    margin-right: 15px;
}


.section-2 .field-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
}

.section-2 .instructions {
    max-width: 600px;
}

.section-2 .instructions .wrap {
    border: 1px solid #ccc;
    -webkit-box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.07);
    -moz-box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.07);
    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.07);
    padding: 20px 25px;
}

#line {
    margin-left: 15px;
}

.right-side {
    display: flex;
    flex-direction: column;
    align-items: flex-end; /* Aligne les éléments à droite */
    width: 100%; /* Assurez-vous que le conteneur occupe toute la largeur */
}

.small-photo {
    width: 15%;
    height: auto;
    margin-bottom: 10px;
}

.navigation-arrows {
    display: flex;
    justify-content: flex-end; /* Aligne les flèches à droite */
    gap: 20px;
    width: 30%; /* Fait correspondre la largeur avec celle de l'image */
}

.prev-arrow,
.next-arrow {
    font-size: 24px; /* Taille des icônes de flèche */
    color: #000; /* Couleur des flèches */
    text-decoration: none;
    margin-bottom: 20px;
}

/* Section 3 */
.entry-content .section-3 .wrap {
    max-width: 800px;
    padding: 40px;
}

.section-3 {
    display: flex;
    text-transform: uppercase;
    font-family: 'Space Mono';
    text-decoration: none;
    margin-left: 15px;
}

.section-3 p {
    font-size: 18px;
    margin-top: 100px;
}

