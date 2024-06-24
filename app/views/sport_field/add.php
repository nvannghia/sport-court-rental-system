<div id="formContainer" class="d-none mt-3" style="background-color:#5361B5; padding: 10px; border-radius:4px">
    <form id="addSportFieldForm" class=" mt-3" method="POST" enctype="multipart/form-data">
        <div class="form-group d-flex flex-wrap justify-content-between">
            <label for="fieldName" class="text-white">Tên Sân</label>

            <button class="btn btn-outline-primary ms-1 mb-1 text-white" type="button" onclick="hiddenForm()">
                <i class="fa-regular fa-eye-slash"></i>
                <span>Ẩn Form</span>
            </button>

            <input type="text" class="form-control" id="fieldName" name="fieldName">
        </div>
        <div class="form-group" style="margin-top: -6px;">
            <div class="d-flex justify-content-between flex-wrap">

                <div style="max-width: 150px;" id="wrap-sportTypeID">
                    <label for="sportTypeID" class="text-white" style="min-width: 200px;">Sân</label>
                    <select class="custom-select" id="sportTypeID" name="sportTypeID">
                        <?php foreach ($sportTypes as $spt) : ?>
                            <option value="<?php echo $spt['ID']; ?>"><?php echo $spt['TypeName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="max-width: 150px;">
                    <label for="status" class="text-white">Trạng Thái</label>
                    <input type="text" disabled value="ACTIVE" class="form-control text-success font-weight-bold" id="status" name="status">
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
                <textarea class="form-control" id="default" name="description" name="description"></textarea>
            </div>
        </div>

        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1 mb-1 text-white">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm</span>
        </button>

    </form>
</div>

<!-- //validate script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
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

            var editorContent = tinyMCE.get('default').getContent();
            if (editorContent == '') {
                wrapTinyMCE.style.border = "1px solid red";
                isValid = false;
            } else {
                wrapTinyMCE.classList.remove('is-invalid');
            }

            // Nếu form hợp lệ
            if (isValid) {
                const formData = new URLSearchParams();
                formData.append('action', 'addSportField');
                formData.append('sportTypeID', sportTypeID.value);
                formData.append('fieldName', fieldName.value);
                formData.append('pricePerHour', pricePerHour.value);
                formData.append('numberOfField', numberOfField.value);
                formData.append('address', address.value);
                formData.append('description', editorContent);

                const addSportFieldUrl = '../sportfield/storeSportField';
                const response = await fetch(addSportFieldUrl, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: formData.toString(),
                });

                const data = await response.json();

                if (data.statusCode === 201) {
                    console.log("200 here");

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
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-1 font-weight-bold">Sân ${data.sportField.TypeName} ${data.sportField.FieldName} </p>
                        <div>
                            <a href="" class="btn btn-default border shadow-sm mb-2" title="Chi Tiết Sân">
                                <i class="fa-solid fa-eye text-info" style="min-width: 20px;"></i>
                            </a>
                            <a href="" class="btn btn-default border shadow-sm mb-2" title="Xóa Sân">
                                <i class="fa-solid fa-trash-can text-danger" style="min-width: 20px;"></i>
                            </a>
                        </div>
                    </div>
                    <hr>
                `);

                    // Reset form
                    form.reset();
                    tinyMCE.get('default').setContent('');
                } else if (data.statusCode === 400) {
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi !",
                        text: "Vui lòng nhập đầy đủ các thông tin!",
                    });
                } else if (data.statusCode === 409) {
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi !",
                        text: `Tên sân \`${data.sportField.FieldName}\` đã tồn tại!`,
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi !",
                        text: "Lỗi phía máy chủ, vui lòng liên hệ QTV!",
                    });
                }
            }
        });
    });
</script>