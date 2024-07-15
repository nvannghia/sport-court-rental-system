<div id="formAddContainer" class="d-none mt-3" style="background-color:#5361B5; padding: 10px; border-radius:4px">
    <form id="addSportFieldForm" class=" mt-3" method="POST" enctype="multipart/form-data">
        <div class="form-group d-flex flex-wrap justify-content-between">
            <label for="fieldName" class="text-white">Tên Sân</label>

            <button class="btn btn-outline-primary ms-1 mb-1 text-white" type="button" onclick="hiddenFormAdd()">
                <i class="fa-regular fa-eye-slash"></i>
                <span>Ẩn Form</span>
            </button>

            <input type="text" class="form-control" id="fieldName" name="fieldName">
        </div>

        <div class="form-group">
            <label for="fieldImage" class="text-white">Hình đại diện sân</label>
            <img  class="d-none mb-3 border rounded" style="width: 200px; height: 200px; object-fit: cover;" id="imagePreview" src="test.png" alt="file choose">
            <input type="file" class="form-control" id="fieldImage" name="fieldImage">
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
                    <input type="number" class="form-control" id="numberOfField" name="numberOfField">
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
                <textarea class="form-control" id="add" name="description" name="description"></textarea>
            </div>
        </div>

        <button id="btnAddForm" type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1 mb-1 text-white">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm</span>
        </button>

    </form>
</div>
