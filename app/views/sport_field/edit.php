<div id="formEditContainer" class="d-none mt-3" style="background-color:#29378f; padding: 10px; border-radius:4px">
    <form id="editSportFieldForm" class=" mt-3" method="POST" enctype="multipart/form-data">
        <div class="form-group d-flex flex-wrap justify-content-between">
            <label for="fieldName" class="text-white">Tên Sân</label>

            <button class="btn btn-outline-primary ms-1 mb-1 text-white" type="button" onclick="hiddenFormEdit()">
                <i class="fa-regular fa-eye-slash"></i>
                <span>Ẩn Form</span>
            </button>

            <input type="text" class="form-control" id="fieldName" name="fieldName">
        </div>

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
                            <label for="ACTIVE" class="text-success" style="padding:5px; min-width: 125px ;">ACTIVE</label><br>
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

        <button id="btnEditForm" type="submit" class="btn btn-outline-primary border border-warning text-warning ms-1 mb-1 text-white">
            <i class="fa-regular fa-pen-to-square text-warning"></i>
            <span>Sửa</span>
        </button>

    </form>
</div>