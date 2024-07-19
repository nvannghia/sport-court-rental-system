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

// display image preview 
const imagePreview = document.getElementById("imagePreview");
const inputFileImage = document.getElementById("fieldImage");

inputFileImage.addEventListener("change", function () {
    imagePreview.src = URL.createObjectURL(inputFileImage.files[0]);
    if (imagePreview.classList.contains('d-none'))
        imagePreview.classList.remove('d-none');
    imagePreview.classList.add('d-block');
});

const hiddenFormAdd = () => {
    //reset the form
    const formAdd = document.getElementById('addSportFieldForm');
    formAdd.reset();

    formAddContainer.classList.toggle("d-block");

    //clear image preview
    if (imagePreview.classList.contains('d-block')) {
        imagePreview.classList.remove('d-block');
        imagePreview.classList.add('d-none');
    }

    window.scroll({
        top: 140,
        left: 0,
        behavior: "smooth",
    });
}

const hiddenFormEdit = () => {
    //reset the form
    const formEdit = document.getElementById('editSportFieldForm');
    formEdit.reset();

    formEditContainer.classList.toggle("d-block");

    window.scroll({
        top: 140,
        left: 0,
        behavior: "smooth",
    });
}

// add sport field
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addSportFieldForm');
    const fieldName = document.getElementById('fieldName');
    const pricePerHour = document.getElementById('pricePerHour');
    const status = document.getElementById('status');
    const numberOfField = document.getElementById('numberOfField');
    const sportTypeID = document.getElementById('sportTypeID');
    const address = document.getElementById('address');
    const description = document.getElementById('description');
    const wrapTinyMCE = document.getElementById('wrap-tinyMCE');
    const wrapSportTypeID = document.getElementById('wrap-sportTypeID');
    const btnSubmitFormAdd = document.querySelector('form#addSportFieldForm #btnAddForm');


    // Định dạng đầu vào tiền
    pricePerHour.addEventListener("input", function (e) {
        let value = e.target.value;
        value = value.replace(/[^0-9]/g, "");
        if (value !== "") {
            value = Number(value).toLocaleString('vi-VN');
        }
        e.target.value = value;
    });

    // Thêm event listener cho sự kiện submit một lần
    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        //image file
        var fieldImage = document.getElementById('fieldImage');
        var fileImage = fieldImage.files[0] ? fieldImage.files[0] : null;

        // Validate các trường
        let isValid = true;
        if (!fieldName.value.trim()) {
            fieldName.classList.add('is-invalid');
            isValid = false;
        } else {
            fieldName.classList.remove('is-invalid');
        }

        if (!pricePerHour.value.trim()) {
            pricePerHour.classList.add('is-invalid');
            isValid = false;
        } else {
            pricePerHour.classList.remove('is-invalid');
        }

        if (!status.value.trim()) {
            status.classList.add('is-invalid');
            isValid = false;
        } else {
            status.classList.remove('is-invalid');
        }

        if (!numberOfField.value.trim()) {
            numberOfField.classList.add('is-invalid');
            isValid = false;
        } else {
            numberOfField.classList.remove('is-invalid');
        }

        if (sportTypeID.value == "-1") {
            sportTypeID.classList.add('is-invalid');
            isValid = false;
        } else {
            sportTypeID.classList.remove('is-invalid');
        }

        if (!address.value.trim()) {
            address.classList.add('is-invalid');
            isValid = false;
        } else {
            address.classList.remove('is-invalid');
        }

        var editorContent = tinyMCE.get('add').getContent();
        if (editorContent == '') {
            wrapTinyMCE.style.border = "1px solid red";
            isValid = false;
        } else {
            wrapTinyMCE.classList.remove('is-invalid');
        }

        // Nếu form hợp lệ
        if (isValid) {
            btnSubmitFormAdd.setAttribute("disabled", "disabled");

            const formData = new FormData();
            formData.append('action', 'addSportField');
            formData.append('sportTypeID', sportTypeID.value);
            formData.append('fieldName', fieldName.value);
            formData.append('pricePerHour', pricePerHour.value);
            formData.append('numberOfField', numberOfField.value);
            formData.append('address', address.value);
            formData.append('description', editorContent);
            formData.append('fieldImage', fileImage);

            const addSportFieldUrl = '../sportfield/storeSportField';
            const response = await fetch(addSportFieldUrl, {
                method: 'POST',
                body: formData,
            });

            //disabled button submit 
            const data = await response.json();


            if (data.statusCode === 201) {

                await Swal.fire({
                    title: "Thành Công!",
                    text: "Thêm Sân Thành Công!",
                    icon: "success",
                    customClass: {
                        popup: 'my-custom-popup',
                    },
                });


                const containerSportField = document.getElementById("container-sportField");
                containerSportField.insertAdjacentHTML('afterbegin', `
                 <div id="sportField-${data.sportField.ID}">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-1" id="display-typename-sportfield-${data.sportField.ID}"> Sân ${data.sportField.TypeName} ${data.sportField.FieldName} </p>
                        <div>
                            <a href="../sportfield/detail/${data.sportField.ID}" class="btn btn-default border border-info shadow-sm mb-2" title="Chi Tiết Sân">
                                <i class="fa-solid fa-eye text-info" style="min-width: 20px;"></i>
                            </a>
                            <a onclick="fillDataToEditForm(${data.sportField.ID})" class="btn btn-default border border-warning shadow-sm mb-2" title="Cập Nhật Sân">
                                <i class="fa-regular fa-pen-to-square text-warning" style="min-width: 20px;"></i>
                            </a>
                            <a onclick="destroySportField(${data.sportField.ID})" class="btn btn-default border-danger border shadow-sm mb-2" title="Xóa Sân">
                                <i class="fa-solid fa-trash-can text-danger" style="min-width: 20px;"></i>
                            </a>
                        </div>
                    </div>
                    <hr>
                </div>
            `);

                //enabled button
                btnSubmitFormAdd.removeAttribute('disabled');

                // Reset form
                form.reset();
                //hidden image preview
                if (imagePreview.classList.contains('d-block')) {
                    imagePreview.classList.remove('d-block');
                    imagePreview.classList.add('d-none');
                }
                tinyMCE.get('default').setContent('');

            } else if (data.statusCode === 400) {
                Swal.fire({
                    icon: "error",
                    title: "Lỗi !",
                    text: "Vui lòng nhập đầy đủ các thông tin!",
                });
                btnSubmitFormAdd.removeAttribute('disabled');

            } else if (data.statusCode === 409) {
                Swal.fire({
                    icon: "error",
                    title: "Lỗi !",
                    text: `Tên sân \`${data.sportField.FieldName}\` đã tồn tại!`,
                });
                btnSubmitFormAdd.removeAttribute('disabled');

            } else {
                Swal.fire({
                    icon: "error",
                    title: "Lỗi !",
                    text: "Lỗi phía máy chủ, vui lòng liên hệ QTV!",
                });
                btnSubmitFormAdd.removeAttribute('disabled');

            }
        }
    });
});






//Edit sport field
const sportFieldUrl = '../sportfield';


//script for get sport field by id
const getFieldSportByID = async (sportFieldID) => {

    const editSportFieldUrl = `${sportFieldUrl}/edit/${sportFieldID}`;

    const response = await fetch(`${editSportFieldUrl}`);

    const data = await response.json();

    switch (data.statusCode) {
        case 200:
            return data;
            break;
        case 404:
            await Swal.fire({
                icon: "error",
                title: "Lỗi !",
                text: `Không tìm thấy sân được yêu cầu!`,
            });
            break;
        case 400:
            await Swal.fire({
                icon: "error",
                title: "Lỗi !",
                text: `Thiếu thông tin cần thiết để sửa sân!`,
            });
            break;
        default:
            await Swal.fire({
                icon: "error",
                title: "Lỗi !",
                text: "Lỗi phía máy chủ, vui lòng liên hệ QTV!",
            });
            break;
    }
    return false;
}

const fillDataToEditForm = async (sportFieldID) => {
    //hide add form and display edit form
    const formAddContainer = document.getElementById('formAddContainer');
    if (formAddContainer.classList.contains("d-block"))
        formAddContainer.classList.remove('d-block');

    const formEditContainer = document.getElementById('formEditContainer');
    formEditContainer.classList.add('d-block');

    //scroll to view edit form
    formEditContainer.scrollIntoView({
        behavior: 'smooth'
    });

    const data = await getFieldSportByID(sportFieldID);

    if (data.sportField) {
        const {
            ID,
            SportTypeID,
            FieldName,
            Status,
            PricePerHour,
            NumberOfFields,
            Address,
            Description,
            Image
        } = data.sportField;


        const form = document.getElementById('editSportFieldForm');
        const sportFieldID = document.querySelector('form#editSportFieldForm #sportFieldID');
        const sportTypeID = document.querySelector('form#editSportFieldForm #sportTypeID');
        const fieldName = document.querySelector('form#editSportFieldForm #fieldName');
        const pricePerHour = document.querySelector('form#editSportFieldForm #pricePerHour');
        const numberOfField = document.querySelector('form#editSportFieldForm #numberOfField');
        const address = document.querySelector('form#editSportFieldForm #address');
        const description = document.querySelector('form#editSportFieldForm #description');
        const wrapTinyMCE = document.querySelector('form#editSportFieldForm #wrap-tinyMCE');
        const imagePreview = document.querySelector('form#editSportFieldForm #imagePreview');

        //setting value for hidden input, ID of sport field need edit
        sportFieldID.value = ID;

        //sport type setting value
        const wrapSportTypeID = document.querySelector('form#editSportFieldForm #wrap-sportTypeID');

        const selectElement = document.querySelector('form#editSportFieldForm #sportTypeID');
        if (selectElement == null) {

            const selectElement = document.createElement('select');
            selectElement.id = 'sportTypeID';
            selectElement.classList.add('custom-select');

            // Tạo các tùy chọn và thêm vào thẻ <select>
            data.sportTypes.forEach(spt => {
                const option = document.createElement('option');
                option.style.fontFamily = 'Poppins';
                option.style.fontSize = '16px';
                option.value = spt.ID;
                option.value == SportTypeID ? option.selected = true : option.selected = false;
                option.textContent = spt.TypeName;
                selectElement.appendChild(option);
                // Thêm thẻ <select> vào trong wrapSportTypeID
                wrapSportTypeID.appendChild(selectElement);
            })
        } else {
            selectElement.value = SportTypeID;
        }

        //status setting value
        const radiosStatus = form.elements['status'];
        radiosStatus.forEach(radio => {
            if (radio.defaultValue === Status) {
                radio.checked = true;
            } else {
                radio.checked = false;
            }
        });

        fieldName.value = FieldName;
        pricePerHour.value = PricePerHour;
        numberOfField.value = NumberOfFields;
        address.value = Address;
        imagePreview.src = Image;
        tinyMCE.get('edit').setContent(Description);

    }
}


//EDIT

const imagePreviewEdit = document.querySelector("form#editSportFieldForm #imagePreview");
const inputFileImageEdit = document.querySelector("form#editSportFieldForm #fieldImage");

inputFileImageEdit.addEventListener("change", function () {
    imagePreviewEdit.src = URL.createObjectURL(inputFileImageEdit.files[0]);
    if (imagePreviewEdit.classList.contains('d-none'))
        imagePreviewEdit.classList.remove('d-none');
    imagePreviewEdit.classList.add('d-block');
});

//Update sport field action
const form = document.getElementById('editSportFieldForm');
const pricePerHour = document.querySelector('form#editSportFieldForm #pricePerHour');

// Định dạng đầu vào tiền
pricePerHour.addEventListener("input", function (e) {
    let value = e.target.value;
    value = value.replace(/[^0-9]/g, "");
    if (value !== "") {
        value = Number(value).toLocaleString('vi-VN');
    }
    e.target.value = value;
});

// Thêm event listener cho sự kiện submit một lần
form.addEventListener('submit', async function (event) {

    event.preventDefault();

    const sportFieldID = document.querySelector('form#editSportFieldForm #sportFieldID');
    const fieldName = document.querySelector('form#editSportFieldForm #fieldName');
    const status = document.querySelector('form#editSportFieldForm input[type=radio][name="status"]:checked');
    const numberOfField = document.querySelector('form#editSportFieldForm #numberOfField');
    const address = document.querySelector('form#editSportFieldForm #address');
    const description = document.querySelector('form#editSportFieldForm #description');
    const wrapStatus = document.querySelector('form#editSportFieldForm #wrap-status');
    const wrapTinyMCE = document.querySelector('form#editSportFieldForm #wrap-tinyMCE');
    const wrapSportTypeID = document.querySelector('form#editSportFieldForm #wrap-sportTypeID');
    const sportTypeID = document.querySelector('form#editSportFieldForm #sportTypeID');
    const fileImage = document.querySelector('form#editSportFieldForm #fieldImage');
    const imagePreview = document.querySelector('form#editSportFieldForm #imagePreview');
    const btnSubmitFormEdit = document.querySelector('form#editSportFieldForm #btnEditForm');

    // Validate các trường
    let isValid = true;

    if (!sportFieldID.value.trim()) {
        sportFieldID.classList.add('is-invalid');
        isValid = false;
    } else {
        sportFieldID.classList.remove('is-invalid');
    }


    if (!fieldName.value.trim()) {
        fieldName.classList.add('is-invalid');
        isValid = false;
    } else {
        fieldName.classList.remove('is-invalid');
    }

    if (!pricePerHour.value.trim()) {
        pricePerHour.classList.add('is-invalid');
        isValid = false;
    } else {
        pricePerHour.classList.remove('is-invalid');
    }

    if (!status.value) {
        wrapStatus.classList.add('is-invalid');
        isValid = false;
    } else {
        wrapStatus.classList.remove('is-invalid');
    }

    if (!numberOfField.value.trim()) {
        numberOfField.classList.add('is-invalid');
        isValid = false;
    } else {
        numberOfField.classList.remove('is-invalid');
    }

    if (sportTypeID.value === null) {
        sportTypeID.classList.add('is-invalid');
        isValid = false;
    } else {
        sportTypeID.classList.remove('is-invalid');
    }

    if (!address.value.trim()) {
        address.classList.add('is-invalid');
        isValid = false;
    } else {
        address.classList.remove('is-invalid');
    }

    var editorContent = tinyMCE.get('edit').getContent();
    if (editorContent == '') {
        wrapTinyMCE.style.border = "1px solid red";
        isValid = false;
    } else {
        wrapTinyMCE.classList.remove('is-invalid');
    }


    // Nếu form hợp lệ
    if (isValid) {

        //disabled button submit to edit
        btnSubmitFormEdit.setAttribute('disabled', 'disabled');

        const formData = new FormData();
        formData.append('action', 'updateSportField');
        formData.append('sportFieldID', sportFieldID.value);
        formData.append('sportTypeID', sportTypeID.value);
        formData.append('fieldName', fieldName.value);
        formData.append('pricePerHour', pricePerHour.value);
        formData.append('status', status.value);
        formData.append('numberOfField', numberOfField.value);
        formData.append('address', address.value);
        formData.append('description', editorContent);

        if (fileImage.files[0]) // have upload image file
            formData.append('fieldImage', fileImage.files[0]);
        else
            formData.append('oldImage', imagePreview.src);

        const updateSportFieldUrl = `${sportFieldUrl}/update/${sportFieldID.value}`;
        const response = await fetch(updateSportFieldUrl, {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();

        if (data.statusCode === 200) {
            await Swal.fire({
                title: "Thành Công!",
                text: "Cập Nhật Sân Thành Công!",
                icon: "success",
                customClass: {
                    popup: 'my-custom-popup',
                    title: 'custom-success-title'
                },
            });

            //enabled button submit to edit
            btnSubmitFormEdit.removeAttribute('disabled');
            
            //hide form and reset form edit
            form.reset();
            const formEditContainer = document.getElementById('formEditContainer');
            formEditContainer.classList.remove('d-block');

            //update sport field name
            const displayTypeNameAndFieldName = document.getElementById(`display-typename-sportfield-${sportFieldID.value}`);
            displayTypeNameAndFieldName.innerText = `${data?.sportFieldUpdated?.TypeName} ${data?.sportFieldUpdated?.FieldName} `;

            const viewMangeField = document.getElementById('viewManageField');
            viewMangeField.scrollIntoView(true);

        } else {
            await Swal.fire({
                title: "Thất Bại!",
                text: "Vui Lòng Kiểm Tra Lại Các Thông Tin, Hoặc Thử Lại Sau!",
                icon: "error",
                customClass: {
                    popup: 'my-custom-popup',
                    title: 'custom-error-title'
                },
            });

            btnSubmitFormEdit.removeAttribute('disabled');
        }

    }
});





//delete sport field
const destroySportField = (sportFieldID) => {

    Swal.fire({
        title: "Bạn Đã Chắc Chắn?",
        text: "Dữ Liệu Về Sân Sẽ Bị Xóa!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Xóa!",
        cancelButtonText: "Hủy"
    }).then(async (result) => {

        if (result.isConfirmed) {

            const destroySportFieldUrl = `${sportFieldUrl}/destroy/${sportFieldID}`;

            const response = await fetch(`${destroySportFieldUrl}`, {
                method: 'POST',
            });

            const data = await response.json();

            if (data.statusCode === 204) {

                Swal.fire({
                    title: "Xóa Thành Công!",
                    text: "Đã Xóa Sân.",
                    icon: "success"
                });

                //remove element sport fiele deleted
                sportFieldElement = document.getElementById(`sportField-${sportFieldID}`);
                sportFieldElement.remove();

            } else if (data.statusCode === 400) {
                Swal.fire({
                    title: "Thất Bại!",
                    text: "Vui Lòng Kiểm Tra Lại Các Thông Tin, Hoặc Thử Lại Sau!",
                    icon: "error",
                    customClass: {
                        popup: 'my-custom-popup',
                        title: 'custom-error-title'
                    },
                });
            } else {
                Swal.fire({
                    title: "Thất Bại!",
                    text: "Lỗi Phía Server, Vui Lòng Liên Hệ QTV!",
                    icon: "error",
                    customClass: {
                        popup: 'my-custom-popup',
                        title: 'custom-error-title'
                    },
                });
            }
        }
    });
}

