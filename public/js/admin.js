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
    for (let button of closeButtons) {
        button.addEventListener('click', () => {
            for (let elem of document.getElementsByClassName("ModalDelSection")) {
                elem.style.display = "none"; 
            }
            for (let elem of document.getElementsByClassName("ModalEditSection")) {
                elem.style.display = "none"; 
            }
        });
    }


});

function openModalDelSection(sectionId) {
    document.querySelector(`.ModalDelSection[data-section-id="${sectionId}"]`).style.display = "block";
}

function openModalEditSection(sectionId) {
    document.querySelector(`.ModalEditSection[data-section-id="${sectionId}"]`).style.display = "block";
}
