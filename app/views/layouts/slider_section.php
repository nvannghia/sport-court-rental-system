<section class="slider_section ">
    <div class="container ">
        <div class="row">
            <div class="col-lg-7 col-md-8 mx-auto">
                <div class="detail-box">
                    <img src="../../public/images/soccer.gif" alt="gif" style="width: 25%;">

                    <h1>
                        HỆ THỐNG HỖ TRỢ TÌM KIẾM SÂN BÃI NHANH
                    </h1>
                    <p>
                        Dữ liệu được hệ thống SPORT COURT RENTAL cập nhật thường xuyên giúp cho người dùng tìm được sân một cách nhanh nhất
                    </p>
                </div>
            </div>
        </div>
        <div class="find_container ">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <form action="<?php $_SERVER['PHP_SELF'];?>">
                            <div class="form-row ">
                                <div class="form-group col-lg-3">
                                    <select name="sportType" class="form-control wide" id="inputDoctorName">
                                        <option value="">Thể loại sân</option>
                                        <?php foreach ($sportTypes as $sportType) : ?>
                                            <option value="<?= $sportType['ID']; ?>"> <?= $sportType['TypeName']; ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-3">
                                    <input type="text" class="form-control" name="inputSportFieldName" id="inputSportFieldName" placeholder="Nhập tên sân">
                                </div>

                                <div class="form-group col-lg-3">
                                    <input type="text" class="form-control" name="inputZoneName" id="inputZoneName" placeholder="Nhập khu vực">
                                </div>

                                <div class="form-group col-lg-3">
                                    <div class="btn-box">
                                        <button onclick="localStorage.setItem('scrollTo', 'view-sport-field');" type="submit" class="btn ">Tìm sân</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>