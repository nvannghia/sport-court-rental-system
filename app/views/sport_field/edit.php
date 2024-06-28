<div id="formEditContainer" class="d-none mt-3" style="background-color:#5361B5; padding: 10px; border-radius:4px">
    <form id="editSportFieldForm" class=" mt-3" method="POST" enctype="multipart/form-data">
        <div class="form-group d-flex flex-wrap justify-content-between">
            <label for="fieldName" class="text-white">Tên Sân</label>

            <button class="btn btn-outline-primary ms-1 mb-1 text-white" type="button" onclick="hiddenFormEdit()">
                <i class="fa-regular fa-eye-slash"></i>
                <span>Ẩn Form</span>
            </button>

            <input type="text" class="form-control" id="fieldName" name="fieldName">
        </div>
        <div class="form-group" style="margin-top: -6px;">
            <div class="d-flex justify-content-between flex-wrap">
                <div style="max-width: 150px;" id="wrap-sportTypeID">
                    <label class="text-white" style="min-width: 200px;">Sân</label>
                </div>

                <div style="max-width: 150px;">
                    <label for="status" class="text-white">Trạng Thái</label>
                    <br>
                    <div id="wrap-status">
                        <div class="bg-white border border-success rounded" style="max-height: 40px;">
                            <input type="radio" id="ACTIVE" name="status" value="ACTIVE">
                            <label for="ACTIVE" class="  text-success " style="padding:5px; min-width: 125px ;">ACTIVE</label><br>
                        </div>
                        <div class="bg-white border border-danger rounded mt-2" style="max-height: 40px;">
                            <input type="radio" id="INACTIVE" name="status" value="INACTIVE">
                            <label for="INACTIVE" class=" text-danger " style="padding:5px; min-width: 125px">INACTIVE</label><br>
                        </div>
                    </div>
                </div>

                <div style="max-width: 150px;">
                    <label for="pricePerHour" class="text-white">Giá Mỗi Giờ</label>
                    <input type="text" class="form-control" id="pricePerHour" name="pricePerHour">
                </div>

                <div style="max-width: 150px;">
                    <label for="numberOfField" class="text-white">Số Lượng Sân</label>
                    <input type="text" class="form-control" id="numberOfField" name="numberOfField">
                </div>

            </div>
        </div>

        <div class="form-group">
            <label for="address" class="form-label text-white">Địa chỉ</label>
            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="description" class="form-label text-white">Mô Tả</label>
            <div id="wrap-tinyMCE">
                <textarea class="form-control" id="edit" name="description" name="description"></textarea>
            </div>
        </div>

        <input type="hidden" id="sportFieldID">

        <button type="submit" class="btn btn-outline-primary border border-warning text-warning ms-1 mb-1 text-white">
            <i class="fa-regular fa-pen-to-square text-warning"></i>
            <span>Sửa</span>
        </button>

    </form>
</div>

<script>
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
            tinyMCE.get('edit').setContent(Description);

        }
    }
</script>

<!-- //validate script -->
<script>
    const form = document.getElementById('editSportFieldForm');
    const pricePerHour = document.querySelector('form#editSportFieldForm #pricePerHour');

    // Định dạng đầu vào tiền
    pricePerHour.addEventListener("input", function(e) {
        let value = e.target.value;
        value = value.replace(/[^0-9]/g, "");
        if (value !== "") {
            value = Number(value).toLocaleString('vi-VN');
        }
        e.target.value = value;
    });

    // Thêm event listener cho sự kiện submit một lần
    form.addEventListener('submit', async function(event) {

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

            const formData = new URLSearchParams();
            formData.append('action', 'updateSportField');
            formData.append('sportFieldID', sportFieldID.value);
            formData.append('sportTypeID', sportTypeID.value);
            formData.append('fieldName', fieldName.value);
            formData.append('pricePerHour', pricePerHour.value);
            formData.append('status', status.value);
            formData.append('numberOfField', numberOfField.value);
            formData.append('address', address.value);
            formData.append('description', editorContent);

            const updateSportFieldUrl = `${sportFieldUrl}/update/${sportFieldID.value}`;
            const response = await fetch(updateSportFieldUrl, {
                method: 'POST',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: formData.toString(),
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

                //hide form and reset form edit
                form.reset();
                const formEditContainer = document.getElementById('formEditContainer');
                formEditContainer.classList.remove('d-block');

                //update sport field name
                const displayTypeNameAndFieldName = document.getElementById(`display-typename-sportfield-${sportFieldID.value}`);
                displayTypeNameAndFieldName.innerText = `${data?.sportFieldUpdated?.TypeName} ${data?.sportFieldUpdated?.FieldName} `;

                const viewMangeField = document.getElementById('viewManageField');
                viewManageField.scrollIntoView(true);
                
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
            }

        }
    });
</script>