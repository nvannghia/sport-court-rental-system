const addSportFiledBtn = document.getElementById("addSportFieldBtn");
const formAddContainer = document.getElementById('formAddContainer');
const formEditContainer = document.getElementById('formEditContainer');
const infoView = document.getElementById('infoView');
addSportFiledBtn.addEventListener("click", () => {

    //hide edit form and display add form
    const formEditContainer = document.getElementById('formEditContainer');
    if (formEditContainer.classList.contains("d-block"))
        formEditContainer.classList.remove('d-block');

    formAddContainer.classList.add('d-block');

    //scroll to view add
    formAddContainer.scrollIntoView({
        behavior: 'smooth'
    });
});


const hiddenFormAdd = () => {
    //reset the form
    const formAdd = document.getElementById('addSportFieldForm');
    formAdd.reset();

    formAddContainer.classList.toggle("d-block");

    window.scroll({
        top: 140,
        left: 0,
        behavior: "smooth",
    });
}

const hiddenFormEdit = () => {
    //reset the form
    const formEdit= document.getElementById('editSportFieldForm');
    formEdit.reset();

    formEditContainer.classList.toggle("d-block");

    window.scroll({
        top: 140,
        left: 0,
        behavior: "smooth",
    });
}

