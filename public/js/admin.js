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
            document.getElementById("myModal").style.display = "none";
        });
    }


});

function openModal() {
    document.getElementById("myModal").style.display = "block";
}


