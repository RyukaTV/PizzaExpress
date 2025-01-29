document.addEventListener('DOMContentLoaded', () => {
    const toggleButtons = document.querySelectorAll('.toggle-section');

    toggleButtons.forEach(button => {
        button.addEventListener('click', () => {
            const subSection = document.querySelector(`.sub-section[data-section-id="${button.getAttribute('data-section-id')}"]`);

            if (subSection) {
                subSection.classList.toggle('hidden');
            }
        });
    });

    var closeButtons = document.getElementsByClassName("closeModal");
    var classes= ["ModalDelSection", "ModalEditSection", "ModalAjoutSection", "ModalAjoutProduit", "ModalEditProduit", "ModalDelProduit"];
    for (let button of closeButtons) {
        button.addEventListener('click', () => {
            classes.forEach(element => {
                for (let elem of document.getElementsByClassName(element)) {
                    elem.style.display = "none"; 
                }
            });
        });
    }
});

function openModalDelSection(sectionId) {
    document.querySelector(`.ModalDelSection[data-section-id="${sectionId}"]`).style.display = "block";
}

function openModalEditSection(sectionId) {
    document.querySelector(`.ModalEditSection[data-section-id="${sectionId}"]`).style.display = "block";
}

function openModalAjoutSection() {
    document.querySelector(`.ModalAjoutSection`).style.display = "block";
}

function openModalAddProduit() {
    document.querySelector(`.ModalAjoutProduit`).style.display = "block";
}

function openModalEditProduit(produitId) {
    document.querySelector(`.ModalEditProduit[data-produit-id="${produitId}"]`).style.display = "block";
}

function openModalDelProduit(produitId) {
    document.querySelector(`.ModalDelProduit[data-produit-id="${produitId}"]`).style.display = "block";
}
