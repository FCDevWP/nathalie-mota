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
    justify-content: space-between; 
    align-items: center; /* Centre verticalement les éléments */
    height: auto; 
    padding: 20px 0; 
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
    /* display: flex;
    justify-content: center; */
    text-align: center;
    /* margin-right: 15px; */
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

.left-side {
    display: flex;
    /* flex-direction: column; */
    justify-content: space-around;
    align-items: center;
    height: 100%; /* Assurez-vous que le parent a une hauteur définie */
}

.left-side p {
    margin: 0; /* Supprime la marge par défaut du paragraphe */
    padding: 0; /* Supprime le padding par défaut du paragraphe */
}


.right-side {
    display: flex;
    /* flex-direction: column; */
    align-items: flex-end; /* Aligne les éléments à droite */
    width: 100%; 
}

.image-container {
    display: flex;
    flex-direction: column;
    align-items: center; /* Centre les éléments horizontalement dans le container */

}

.small-photo {
    width: 100px;
    height: 100px;
    object-fit: cover; /* Cela garantit que l'image couvre bien le carré sans être déformée */
    margin-bottom: 10px;
}


.navigation-arrows {
    display: flex;
    justify-content: center; 
    gap: 20px;
    width: 100%; /* Utilise toute la largeur du container */
}

.prev-arrow,
.next-arrow {
    font-size: 20px; /* Taille des icônes de flèche */
    color: #000; /* Couleur des flèches */
    text-decoration: none;
}

.arrow-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    margin-top: 10px;
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
    margin-top: 50px;
    margin-bottom: 30px;
}

.section-3-container {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 100%;
}

.photo-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.photo-item {
    margin-bottom: 20px;
}

.section-3 .photo-item {
    position: relative;
    overflow: hidden;
}

.section-3 .photo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    opacity: 0;
    transition: opacity 0.3s;
    display: flex;
    justify-content: center;
    align-items: center;
}

.section-3 .photo-item:hover .photo-overlay {
    opacity: 1;
}

.section-3 .photo-eye,
.section-3 .photo-expand {
    color: white;
    font-size: 24px;
    cursor: pointer;
}

.section-3 .photo-eye {
    margin-right: 20px;
}

.section-3 .photo-expand {
    position: absolute;
    top: 10px;
    right: 10px;
}
