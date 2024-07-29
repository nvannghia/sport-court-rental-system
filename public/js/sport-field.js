const sportFieldUrl = '/sport-court-rental-system/public/sportfield';
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

//format tiền
function formatCurrency(e) {
    let value = e.target.value;
    value = value.replace(/[^0-9]/g, "");
    if (value !== "") {
        value = Number(value).toLocaleString('vi-VN');
    }
    e.target.value = value;
}

// Nếu khách hàng chọn thể loại sân là Bóng Đá, cho chọn sân 5,7,11 
const wrapFieldSizeAdd = document.getElementById('wrapFieldSize');
const wrapFieldSizeEdit = document.querySelector('#editSportFieldForm #wrapFieldSize');
const fieldSize = document.getElementById('fieldSize');
const displayFieldSize = (e, action) => {
    let wrapFieldSize = null;
    if (action === 'add') {
        wrapFieldSize = wrapFieldSizeAdd;
    } else {
        wrapFieldSize = wrapFieldSizeEdit;
    }
    let sportTypeID = e.value;
    if (sportTypeID == 108) {
        if (wrapFieldSize.classList.contains('d-none')) {
            wrapFieldSize.classList.remove('d-none');
            wrapFieldSize.classList.add('d-block');
        }
    } else {
        if (wrapFieldSize.classList.contains('d-block')) {
            wrapFieldSize.classList.remove('d-block');
            wrapFieldSize.classList.add('d-none');
        }
    }
}

//===================== add sport field
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addSportFieldForm');
    const fieldName = document.getElementById('fieldName');
    const priceDay = document.getElementById('priceDay');
    const priceEvening = document.getElementById('priceEvening');
    const openingTime = document.getElementById('openingTime');
    const closingTime = document.getElementById('closingTime');
    const status = document.getElementById('status');
    const numberOfField = document.getElementById('numberOfField');
    const sportTypeID = document.getElementById('sportTypeID'); // sportTypeID là select box, sportTypeID.value là value của option
    const address = document.getElementById('address');
    const description = document.getElementById('description');
    const wrapTinyMCE = document.getElementById('wrap-tinyMCE');
    const wrapSportTypeID = document.getElementById('wrap-sportTypeID');
    const btnSubmitFormAdd = document.querySelector('form#addSportFieldForm #btnAddForm');
    const fieldSize = document.getElementById('fieldSize'); // fieldSize là select box, fieldSize.value là value của option

    //Định dạng đầu vào cho giá tiền trước và sau 17:00
    priceDay.addEventListener("input", formatCurrency);
    priceEvening.addEventListener("input", formatCurrency);

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

        if (!priceDay.value.trim()) {
            priceDay.classList.add('is-invalid');
            isValid = false;
        } else {
            priceDay.classList.remove('is-invalid');
        }

        if (!priceEvening.value.trim()) {
            priceEvening.classList.add('is-invalid');
            isValid = false;
        } else {
            priceEvening.classList.remove('is-invalid');
        }

        if (openingTime.value === '' || openingTime.value.trim < 0) {
            openingTime.classList.add('is-invalid');
            isValid = false;
        } else {
            openingTime.classList.remove('is-invalid');
        }

        if (closingTime.value === '' || closingTime.value.trim < 0) {
            closingTime.classList.add('is-invalid');
            isValid = false;
        } else {
            closingTime.classList.remove('is-invalid');
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
            if (sportTypeID.value == 108) {
                formData.append('fieldSize', fieldSize.value)
            }
            formData.append('fieldName', fieldName.value);
            formData.append('priceDay', priceDay.value);
            formData.append('priceEvening', priceEvening.value);
            formData.append('openingTime', openingTime.value);
            formData.append('closingTime', closingTime.value);
            formData.append('numberOfField', numberOfField.value);
            formData.append('address', address.value);
            formData.append('description', editorContent);
            formData.append('fieldImage', fileImage);

            const addSportFieldUrl = `${sportFieldUrl}/storeSportField`;
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
                        <p class="ellipsis mb-1" id="display-typename-sportfield-${data.sportField.ID}"> Sân ${data.sportField.TypeName} ${data.sportField.FieldName} </p>
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






//==================Edit sport field
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
            NumberOfFields,
            Address,
            Description,
            Image,
            OpeningTime,
            ClosingTime,
            PriceDay,
            PriceEvening,
            FieldSize
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
        const openingTime = document.querySelector('form#editSportFieldForm #openingTime');
        const closingTime = document.querySelector('form#editSportFieldForm #closingTime');
        const priceDay = document.querySelector('form#editSportFieldForm #priceDay');
        const priceEvening = document.querySelector('form#editSportFieldForm #priceEvening');
        const fieldSize = document.querySelector('form#editSportFieldForm #fieldSize');

        // Cập nhật giá trị của thẻ <select>
        fieldSize.value = FieldSize;
        sportTypeID.value = SportTypeID;
        // Khởi tạo Nice Select
        $(fieldSize).niceSelect();
        $(sportTypeID).niceSelect();

        // Khởi tạo lại Nice Select sau khi cập nhật giá trị
        $(fieldSize).niceSelect('update');
        $(sportTypeID).niceSelect('update');

        //setting value for hidden input, ID of sport field need edit
        sportFieldID.value = ID;

        //Nếu đang edit sân bóng thì hiển thị kích cỡ sân(5,7,11)
        const wrapFieldSize = document.querySelector('form#editSportFieldForm #wrapFieldSize');
        if (SportTypeID == 108) {
            if (wrapFieldSize.classList.contains('d-none')) {
                wrapFieldSize.classList.remove('d-none');
                wrapFieldSize.classList.add('d-block');
            }
        } else {
            if (wrapFieldSize.classList.contains('d-block')) {
                wrapFieldSize.classList.remove('d-block');
                wrapFieldSize.classList.add('d-none');
            }
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
        numberOfField.value = NumberOfFields;
        address.value = Address;
        imagePreview.src = Image;
        tinyMCE.get('edit').setContent(Description);
        openingTime.value = OpeningTime;
        closingTime.value = ClosingTime;
        priceDay.value = PriceDay;
        priceEvening.value = PriceEvening;
        fieldSize.value = FieldSize;
    }
}


//================= EDIT
const imagePreviewEdit = document.querySelector("form#editSportFieldForm #imagePreview");
const inputFileImageEdit = document.querySelector("form#editSportFieldForm #fieldImage");

inputFileImageEdit.addEventListener("change", function () {
    imagePreviewEdit.src = URL.createObjectURL(inputFileImageEdit.files[0]);
    if (imagePreviewEdit.classList.contains('d-none'))
        imagePreviewEdit.classList.remove('d-none');
    imagePreviewEdit.classList.add('d-block');
});

//Update sport field action
const form = document.getElementById('editSportFieldForm'); //edit form

// Định dạng đầu vào giá tiền trước và sau 17:00
const priceDay = document.querySelector('form#editSportFieldForm #priceDay');
const priceEvening = document.querySelector('form#editSportFieldForm #priceEvening');
priceDay.addEventListener("input", formatCurrency);
priceEvening.addEventListener("input", formatCurrency);


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
    const openingTime = document.querySelector('form#editSportFieldForm #openingTime');
    const closingTime = document.querySelector('form#editSportFieldForm #closingTime');
    const priceDay = document.querySelector('form#editSportFieldForm #priceDay');
    const priceEvening = document.querySelector('form#editSportFieldForm #priceEvening');

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

    if (!priceDay.value.trim()) {
        priceDay.classList.add('is-invalid');
        isValid = false;
    } else {
        priceDay.classList.remove('is-invalid');
    }

    if (!priceEvening.value.trim()) {
        priceEvening.classList.add('is-invalid');
        isValid = false;
    } else {
        priceEvening.classList.remove('is-invalid');
    }

    if (openingTime.value === '' || openingTime.value.trim < 0) {
        openingTime.classList.add('is-invalid');
        isValid = false;
    } else {
        openingTime.classList.remove('is-invalid');
    }

    if (closingTime.value === '' || closingTime.value.trim < 0) {
        closingTime.classList.add('is-invalid');
        isValid = false;
    } else {
        closingTime.classList.remove('is-invalid');
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
        if (sportTypeID.value == 108) {
            formData.append('fieldSize', fieldSize.value)
        }
        formData.append('fieldName', fieldName.value);
        formData.append('priceDay', priceDay.value);
        formData.append('priceEvening', priceEvening.value);
        formData.append('openingTime', openingTime.value);
        formData.append('closingTime', closingTime.value);
        formData.append('status', status.value);
        formData.append('numberOfField', numberOfField.value);
        formData.append('address', address.value);
        formData.append('description', editorContent);

        // // Lặp qua tất cả các cặp key-value và in ra
        for (const [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        // return;

        if (fileImage.files[0]) // have photos uploaded
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

