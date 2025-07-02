const sportFieldUrl = '/sport-court-rental-system/public/sportfield';
const addSportFiledBtn = document.getElementById("addSportFieldBtn");
const formAddContainer = document.getElementById('formAddContainer');
const formEditContainer = document.getElementById('formEditContainer');
const infoView = document.getElementById('infoView');

// SPORT TYPE FOOTBALL 
const FOOTBALL_ID = 5;

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
    if (sportTypeID == FOOTBALL_ID) {
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

// ARRAY FOR IMAGE AND TITLE SPORT FIELD 
const SPORT_FIELD_INFO = [
    [],
    [
        '/sport-court-rental-system/public/images/category/basketball.png',
        'Bóng Rổ'
    ],
    [
        '/sport-court-rental-system/public/images/category/volleyball.png',
        'Bóng Chuyền'
    ],
    [
        '/sport-court-rental-system/public/images/category/tennis.png',
        'Tennis'
    ],
    [
        '/sport-court-rental-system/public/images/category/badminton.png',
        'Cầu Lông'
    ],
    [
        '/sport-court-rental-system/public/images/category/football.png',
        'Bóng đá'
    ],
    [
        '/sport-court-rental-system/public/images/category/golf.png',
        'Golf'
    ]
];

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
    const sportTypeID = document.getElementById('sportTypeID');
    const address = document.getElementById('address');
    const wrapTinyMCE = document.getElementById('wrap-tinyMCE');
    const btnSubmitFormAdd = document.querySelector('form#addSportFieldForm #btnAddForm');
    const fieldSize = document.getElementById('fieldSize');

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

        if (!fileImage) {
            fieldImage.classList.add('is-invalid');
            isValid = false;
        } else {
            fieldImage.classList.remove('is-invalid');
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

        if (!status.value) {
            $('div.status-wrapper').css("border", "1px solid red");
            isValid = false;
        } else {
            $('div.status-wrapper').css("border", "none");
        }

        if (!sportTypeID.value) {
            $('div.sporttype-wrapper').css("border", "1px solid red");
            isValid = false;
        } else {
            $('div.sporttype-wrapper').css("border", "none");
        }

        if (sportTypeID.value == FOOTBALL_ID) {
            if (!fieldSize.value) {
                $('div.fieldsize-wrapper').css("border", "1px solid red");
                isValid = false;
            } else {
                $('div.fieldsize-wrapper').css("border", "none");
            }
        }


        // VALID FORM 
        if (isValid) {
            btnSubmitFormAdd.setAttribute("disabled", "disabled");

            const formData = new FormData();
            formData.append('action', 'addSportField');
            formData.append('sportTypeID', sportTypeID.value);
            if (sportTypeID.value == FOOTBALL_ID) {
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
            formData.append('status', status.value);

            Swal.fire({
                html: '<img src="/sport-court-rental-system/public/images/soccer.gif" width="100%" height="100%"/>',
                background: 'rgba(255, 255, 255, 0)',
                showConfirmButton: false,
                allowOutsideClick: false
            })
            const addSportFieldUrl = `${sportFieldUrl}/storeSportField`;
            const response = await fetch(addSportFieldUrl, {
                method: 'POST',
                body: formData,
            });

            //disabled button submit 
            const data = await response.json();

            if (data.statusCode === 201) {
                // DELETE MESSAGE NO SPORT FIELD ALERT
                if ($('#display-no-field'))
                    $('#display-no-field').remove();
                await Swal.fire({
                    html: `
                        <div>
                            <i class="fa-solid fa-check-double h1 rounded-circle border border-success mb-3" style="padding: 10px 13px"></i>
                            <div class="font-weight-bold h5">THÊM THÀNH CÔNG</div>
                            <div>Sân của bạn đã được thêm vào hệ thống. Chi tiết xem thêm tại mục QUẢN LÝ SÂN.</div>
                        </div>
                    `,
                    customClass: {
                        popup: 'success-alert',
                        confirmButton: 'btn btn-outline-success'
                    },
                    confirmButtonText: "Đóng",
                });

                // reload component for display new item sport field
                loadPage(1);

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
                    html: `
                        <div>
                            <i class="fa-solid fa-triangle-exclamation h1 rounded-circle border border-danger" style="padding: 10px"></i>
                            <div class="font-weight-bold h5">XẢY RA LỖI</div>
                            <div>Vui lòng kiểm tra thông tin nhập chính xác và đầy đủ các trường thông tin!</div>
                        </div>
                    `,
                    customClass: {
                        popup: 'error-alert',
                        confirmButton: 'btn btn-outline-danger'
                    },
                    confirmButtonText: "Đóng"
                });
                btnSubmitFormAdd.removeAttribute('disabled');

            } else if (data.statusCode === 409) {
                Swal.fire({
                    html: `
                        <div>
                        <i class="fa-solid fa-triangle-exclamation h1 rounded-circle border border-danger" style="padding: 10px"></i>
                        <div class="font-weight-bold h5">XẢY RA LỖI</div>
                        <div>Tên sân \`${data.sportField.FieldName}\` đã tồn tại!</div>
                        </div>
                    `,
                    confirmButtonText: "Đóng",
                    customClass: {
                        popup: 'error-alert',
                        confirmButton: 'btn btn-outline-danger',
                    }
                });
                btnSubmitFormAdd.removeAttribute('disabled');

            } else {
                Swal.fire({
                    html: `
                        <div>
                            <i class="fa-solid fa-triangle-exclamation h1 rounded-circle border border-danger" style="padding: 10px"></i>
                            <div class="font-weight-bold h5">XẢY RA LỖI</div>
                            <div>Lỗi phía máy chủ, vui lòng liên hệ QTV!</div>
                        </div>
                    `,
                    customClass: {
                        popup: 'error-alert',
                        confirmButton: 'btn btn-outline-danger'
                    },
                    confirmButtonText: "Đóng"
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
        const sportFieldID = form.querySelector('form#editSportFieldForm #sportFieldID');
        const sportTypeID = form.querySelector('form#editSportFieldForm #sportTypeID');
        const fieldName = form.querySelector('form#editSportFieldForm #fieldName');
        const numberOfField = form.querySelector('form#editSportFieldForm #numberOfField');
        const address = form.querySelector('form#editSportFieldForm #address');
        const imagePreview = form.querySelector('form#editSportFieldForm #imagePreview');
        const openingTime = form.querySelector('form#editSportFieldForm #openingTime');
        const closingTime = form.querySelector('form#editSportFieldForm #closingTime');
        const priceDay = form.querySelector('form#editSportFieldForm #priceDay');
        const priceEvening = form.querySelector('form#editSportFieldForm #priceEvening');
        const fieldSize = form.querySelector('form#editSportFieldForm #fieldSize');
        const status = form.querySelector('form#editSportFieldForm #status');

        // Cập nhật giá trị của thẻ <select>
        fieldSize.value = FieldSize;
        sportTypeID.value = SportTypeID;
        status.value = Status;
        // Khởi tạo Nice Select
        $(fieldSize).niceSelect();
        $(sportTypeID).niceSelect();
        $(status).niceSelect();

        // Khởi tạo lại Nice Select sau khi cập nhật giá trị
        $(fieldSize).niceSelect('update');
        $(sportTypeID).niceSelect('update');
        $(status).niceSelect('update');

        //setting value for hidden input, ID of sport field need edit
        sportFieldID.value = ID;

        if (SportTypeID == FOOTBALL_ID) {
            $('form#editSportFieldForm #wrapFieldSize').removeClass('d-none');
        } else {
            $('form#editSportFieldForm #wrapFieldSize').addClass('d-none');
        }

        fieldName.value = FieldName;
        numberOfField.value = NumberOfFields;
        address.value = Address;
        imagePreview.src = Image;
        tinyMCE.get('edit').setContent(Description);
        openingTime.value = OpeningTime;
        closingTime.value = ClosingTime;
        priceDay.value = PriceDay;
        priceEvening.value = PriceEvening;
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
    const status = document.querySelector('form#editSportFieldForm #status');
    const numberOfField = document.querySelector('form#editSportFieldForm #numberOfField');
    const address = document.querySelector('form#editSportFieldForm #address');
    const wrapTinyMCE = document.querySelector('form#editSportFieldForm #wrap-tinyMCE');
    const sportTypeID = document.querySelector('form#editSportFieldForm #sportTypeID');
    const fileImage = document.querySelector('form#editSportFieldForm #fieldImage');
    const imagePreview = document.querySelector('form#editSportFieldForm #imagePreview');
    const btnSubmitFormEdit = document.querySelector('form#editSportFieldForm #btnEditForm');
    const openingTime = document.querySelector('form#editSportFieldForm #openingTime');
    const closingTime = document.querySelector('form#editSportFieldForm #closingTime');
    const priceDay = document.querySelector('form#editSportFieldForm #priceDay');
    const priceEvening = document.querySelector('form#editSportFieldForm #priceEvening');
    const fieldSize = document.querySelector('form#editSportFieldForm #fieldSize');

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
        $('div.status-wrapper').css('border', '1px solid red');
        isValid = false;
    } else {
        $('div.status-wrapper').css('border', 'none');
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

    if (sportTypeID.value == FOOTBALL_ID) {
        if (!fieldSize.value) {
            $('div.fieldsize-wrapper').css("border", "1px solid red");
            isValid = false;
        } else {
            $('div.fieldsize-wrapper').css("border", "none");
        }
    }

    if (!status.value) {
        $('div.status-wrapper').css("border", "1px solid red");
        isValid = false;
    } else {
        $('div.status-wrapper').css("border", "none");
    }

    // Nếu form hợp lệ
    if (isValid) {
        //disabled button submit to edit
        btnSubmitFormEdit.setAttribute('disabled', 'disabled');

        const formData = new FormData();
        formData.append('action', 'updateSportField');
        formData.append('sportFieldID', sportFieldID.value);
        formData.append('sportTypeID', sportTypeID.value);
        if (sportTypeID.value == FOOTBALL_ID) {
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
        formData.append('status', status.value);

        if (fileImage.files[0]) // have photos uploaded
            formData.append('fieldImage', fileImage.files[0]);
        else
            formData.append('oldImage', imagePreview.src);


        Swal.fire({
            html: '<img src="/sport-court-rental-system/public/images/soccer.gif" width="100%" height="100%"/>',
            background: 'rgba(255, 255, 255, 0)',
            showConfirmButton: false,
            allowOutsideClick: false
        });
        const updateSportFieldUrl = `${sportFieldUrl}/update/${sportFieldID.value}`;
        const response = await fetch(updateSportFieldUrl, {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();

        if (data.statusCode === 200) {
            Swal.fire({
                html: `
                    <div>
                        <i class="fa-solid fa-check-double h1 rounded-circle border border-success mb-3" style="padding: 10px 13px"></i>
                        <div class="font-weight-bold h5">CẬP NHẬT SÂN THÀNH CÔNG</div>
                    </div>
                `,
                customClass: {
                    popup: 'success-alert',
                    confirmButton: 'btn btn-outline-success'
                },
                confirmButtonText: "Đóng",
            });

            //enabled button submit to edit
            btnSubmitFormEdit.removeAttribute('disabled');

            //hide form and reset form edit
            form.reset();
            const formEditContainer = document.getElementById('formEditContainer');
            formEditContainer.classList.remove('d-block');

            //update sport field name
            const displayTypeNameAndFieldName = document.getElementById(`display-typename-sportfield-${sportFieldID.value}`);
            displayTypeNameAndFieldName.innerText = `${data?.sportFieldUpdated?.FieldName} `;

            const viewMangeField = document.getElementById('viewManageField');
            viewMangeField.scrollIntoView(true);
        } else {
            Swal.fire({
                html: `
                    <div>
                        <i class="fa-solid fa-triangle-exclamation h1 rounded-circle border border-danger" style="padding: 10px"></i>
                        <div class="font-weight-bold h5">XẢY RA LỖI</div>
                        <div>Vui Lòng Kiểm Tra Lại Các Thông Tin, Hoặc Thử Lại Sau!</div>
                    </div>
                `,
                customClass: {
                    popup: 'error-alert',
                    confirmButton: 'btn btn-outline-danger'
                },
                confirmButtonText: "Đóng"
            });
            btnSubmitFormEdit.removeAttribute('disabled');
        }

    }
});



//delete sport field
const destroySportField = (sportFieldID) => {
    Swal.fire({
        html: `
            <div>
                <i class="fa-solid fa-exclamation h1 rounded-circle border border-warning mb-3" style="padding: 10px 27px"></i>
                <div class="font-weight-bold h5">XÁC NHẬN XÓA</div>
                <div>Xóa sân sẽ mất toàn bộ dữ liệu. Bạn chắc chắn muốn xóa?</div>
            </div>
         `,
        showCancelButton: true,
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy",
        customClass: {
            popup: 'warn-alert',
            confirmButton: 'btn btn-outline-danger',
            cancelButton: 'btn btn-outline-secondary'
        }
    }).then(async (result) => {

        if (result.isConfirmed) {

            const destroySportFieldUrl = `${sportFieldUrl}/destroy/${sportFieldID}`;

            const response = await fetch(`${destroySportFieldUrl}`, {
                method: 'POST',
            });

            const data = await response.json();

            if (data.statusCode === 204) {
                Swal.fire({
                    html: `
                        <div>
                            <i class="fa-solid fa-check-double h1 rounded-circle border border-success mb-3" style="padding: 10px 13px"></i>
                            <div class="font-weight-bold h5">XÓA SÂN THÀNH CÔNG</div>
                            <div>Sân của bạn đã được xóa khỏi hệ thống. Chi tiết xem thêm tại mục QUẢN LÝ SÂN.</div>
                        </div>
                    `,
                    customClass: {
                        popup: 'success-alert',
                        confirmButton: 'btn btn-outline-success'
                    },
                    confirmButtonText: "Đóng",
                });

                //remove element sport fiele deleted
                let pageActive = $('.active');
                if (pageActive) {
                    let dataPage = pageActive.data('page');
                    loadPage(dataPage);
                }
            } else if (data.statusCode === 400) {
                Swal.fire({
                    html: `
                        <div>
                            <i class="fa-solid fa-triangle-exclamation h1 rounded-circle border border-danger" style="padding: 10px"></i>
                            <div class="font-weight-bold h5">XẢY RA LỖI</div>
                            <div>Vui Lòng Kiểm Tra Lại Các Thông Tin, Hoặc Thử Lại Sau!</div>
                        </div>
                    `,
                    confirmButtonText: "Đóng",
                    customClass: {
                        popup: 'error-alert',
                        confirmButton: 'btn btn-outline-danger',
                    }
                });
            } else {
                Swal.fire({
                    html: `
                        <div>
                            <i class="fa-solid fa-triangle-exclamation h1 rounded-circle border border-danger" style="padding: 10px"></i>
                            <div class="font-weight-bold h5">XẢY RA LỖI</div>
                            <div>Lỗi Phía Server, Vui Lòng Liên Hệ QTV!</div>
                        </div>
                    `,
                    confirmButtonText: "Đóng",
                    customClass: {
                        popup: 'error-alert',
                        confirmButton: 'btn btn-outline-danger',
                    }
                });
            }
        }
    });
}

