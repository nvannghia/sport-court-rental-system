<?php if (!empty($sportFields)): ?>
    <?php foreach ($sportFields as $spf) : ?>
        <div id="sportField-<?php echo $spf['ID']; ?>">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mb-1 d-flex justify-content-between align-items-center">
                    <div class="d-flex rounded" style="background-color: #e41a2b;">
                        <img
                            width  = "34px"
                            height = "32px"
                            alt    = "sport_type_image"
                            src    = "<?= $imagesMapping[$spf['sport_type']['ID']][0] ?>"
                            title  = "<?= $imagesMapping[$spf['sport_type']['ID']][1] ?>"
                        />
                    </div>
                    <span id="display-typename-sportfield-<?php echo $spf['ID']; ?>" class="ellipsis">
                        <?= $spf['FieldName']; ?>
                    </span>
                </div>
                <div>
                    <a href="../sportfield/detail/<?php echo $spf['ID']; ?>" class="btn btn-default border border-info shadow-sm mb-2" style="padding: 3px 6px;" title="Chi Tiết Sân">
                        <i class="fa-sm fa-solid fa-eye text-info" style="min-width: 20px;"></i>
                    </a>
                    <a onclick="fillDataToEditForm(<?php echo $spf['ID']; ?>)" class="btn btn-default border border-warning shadow-sm mb-2" style="padding: 3px 6px;" title="Cập Nhật Sân">
                        <i class="fa-sm fa-regular fa-pen-to-square text-warning" style="min-width: 20px;"></i>
                    </a>
                    <a onclick="destroySportField(<?php echo  $spf['ID']; ?>)" class="btn btn-default border-danger border shadow-sm mb-2" style="padding: 3px 6px;" title="Xóa Sân">
                        <i class="fa-sm fa-solid fa-trash-can text-danger" style="min-width: 20px;"></i>
                    </a>
                </div>
            </div>
            <hr>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <small id="display-no-field" class="text-danger">Hệ thống chưa ghi nhận sân nào thuộc doanh nghiệp của bạn!</small>
<?php endif; ?>