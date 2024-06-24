const addSportFiledBtn = document.getElementById("addSportFieldBtn");
const formContainer = document.getElementById('formContainer');
const infoView = document.getElementById('infoView');
addSportFiledBtn.addEventListener("click", () => {
    formContainer.classList.toggle("d-block");
    formContainer.scrollIntoView({
        behavior: 'smooth'
    });
});


const hiddenForm = () => {
    //reset the form
    const form = document.getElementById('addSportFieldForm');
    form.reset();

    formContainer.classList.toggle("d-block");
    window.scroll({
        top: 140,
        left: 0,
        behavior: "smooth",
    });
}

