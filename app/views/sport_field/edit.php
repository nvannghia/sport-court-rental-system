<div id="formEditContainer" class="d-none mt-3 border border-primary" style="background-color: rgba(255, 255, 255, 0.1); padding: 10px; border-radius:4px">
    <form id="editSportFieldForm" class=" mt-3" method="POST" enctype="multipart/form-data">
        <div class="form-group d-flex flex-wrap justify-content-between">
            <label for="fieldName" class="text-white">Tên Sân</label>

            <button class="btn btn-outline-primary ms-1 mb-1 text-white" type="button" onclick="hiddenFormEdit()">
                <i class="fa-regular fa-eye-slash"></i>
                <span>Ẩn Form</span>
            </button>

            <input type="text" class="form-control" id="fieldName" name="fieldName">
        </div>
        <hr class="border border-secondary">
        <div class="form-group">
            <label for="fieldImage" class="text-white">Hình đại diện sân</label>
            <br>
            <img 
                class="mb-3 border rounded" 
                style="width: 200px; height: 200px; object-fit: cover;" 
                id="imagePreview" src="" 
                alt="file choose"
            >
            <input type="file" class="form-control" id="fieldImage" name="fieldImage">
        </div>
        <hr class="border border-secondary">
        <div class="form-group" style="margin-top: -6px;">
            <div class="d-flex justify-content-between flex-wrap">
                <div style="max-width: 150px;" id="wrap-sportTypeID">
                    <label class="text-white" style="min-width: 200px;">Sân</label>
                    <select class="wide" id="sportTypeID" name="sportTypeID" onchange="displayFieldSize(this, 'edit')">
                        <?php foreach ($sportTypes as $spt) : ?>
                            <option value="<?php echo $spt['ID']; ?>"><?php echo $spt['TypeName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="max-width: 150px;" class="d-none" id="wrapFieldSize">
                    <label for="fieldSize" class="text-white">Cỡ Sân(5/7/11)</label>
                    <select class="wide fieldsize-wrapper" name="fieldSize" id="fieldSize">
                        <option value>Vui lòng chọn</option>
                        <option value="5">5</option>
                        <option value="7">7</option>
                        <option value="11">11</option>
                    </select>
                </div>

                <div style="width: 150px;">
                    <label for="numberOfField" class="text-white">Số Lượng Sân</label>
                    <input type="number" min="1" max="10" class="form-control" id="numberOfField" name="numberOfField">
                </div>

                <div style="max-width: 150px;">
                    <label for="status" class="text-white">Trạng Thái</label>
                    <br>
                    <select class="wide status-wrapper" name="status" id="status">
                        <option value>Vui lòng chọn</option>
                        <option value="1" >Hoạt động</option>
                        <option value="0" >Tạm ngưng</option>
                    </select>
                </div>
            </div>
        </div>
        <hr class="border border-secondary">
        <div class="form-group" style="margin-top: -6px;">
            <div class="d-flex justify-content-between flex-wrap">

                <div style="max-width: 150px;">
                    <label for="openingTime" class="text-white" style="min-width: 200px;">Giờ Mở Cửa</label>
                    <input class="form-control" type="number" step="2" min="0" max="24"  id="openingTime" name="openingTime">
                </div>

                <div style="max-width: 150px;">
                    <label for="closingTime" class="text-white" style="min-width: 200px;">Giờ Đóng Cửa</label>
                    <input class="form-control" type="number" step="2" min="0" max="24"   id="closingTime" name="closingTime">
                </div>

                <div style="max-width: 150px;">
                    <label for="numberOfField" class="text-white">Giá Trước 17:00</label>
                    <input type="text" class="form-control" id="priceDay" name="priceDay">
                </div>

                <div style="max-width: 150px;">
                    <label for="status" class="text-white">Giá Sau 17:00</label>
                    <input type="text" class="form-control" id="priceEvening" name="priceEvening">
                </div>
            </div>
        </div>
        <hr class="border border-secondary">
        <div class="form-group">
            <label for="address" class="form-label text-white">Địa chỉ</label>
            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
        </div>
        <hr class="border border-secondary">
        <div class="form-group">
            <label for="description" class="form-label text-white">Mô Tả</label>
            <div id="wrap-tinyMCE">
                <textarea class="form-control" id="edit" name="description" name="description"></textarea>
            </div>
        </div>
        <hr class="border border-secondary">
        <input type="hidden" id="sportFieldID">

        <button id="btnEditForm" type="submit" class="btn btn-outline-primary border border-warning text-warning ms-1 mb-1 text-white">
            <i class="fa-regular fa-pen-to-square text-warning"></i>
            <span>Sửa</span>
        </button>

    </form>
</div>