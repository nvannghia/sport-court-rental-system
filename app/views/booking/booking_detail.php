<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đặt Lịch</title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="border border-info m-3">
        <div style="text-align: center;" class="h5 mt-4 mb-4">Đặt Sân - Sân Số <?= $fieldNumber ?> (Sân <?= $sportField['FieldSize'] ?>)</div>
        <hr class="ml-5 mr-5 border-secondary">

        <!-- //user and booking information -->
        <div class="container d-flex justify-content-around">
            <!-- //user information -->
            <div class="w-50">
                <div class="d-flex ">
                    <i class="fa-solid fa-circle-info h4 mr-2 text-info"></i>
                    <span class="font-weight-bold">THÔNG TIN KHÁCH HÀNG</span>
                </div>
                <hr class="border-secondary">

                <div class="form-floating mb-3">
                    <input value="<?php echo isset($_SESSION['userInfo']['FullName'])
                                        ? $_SESSION['userInfo']['FullName']
                                        : '';
                                    ?>" type="text" class="form-control" id="customer-name" placeholder="">
                    <label for="customer-name">Tên <b class="text-danger">*</b></label>
                </div>
                <div class="form-floating mb-3">
                    <input value="<?php echo isset($_SESSION['userInfo']['PhoneNumber'])
                                        ? str_replace("+84", "0", $_SESSION['userInfo']['PhoneNumber'])
                                        : '';
                                    ?>" type="text" class="form-control" id="customer-phone" placeholder="">
                    <label for="customer-phone">SĐT <b class="text-danger">*</b></label>
                </div>
                <div class="form-floating">
                    <input value="<?php echo isset($_SESSION['userInfo']['Email'])
                                        ? $_SESSION['userInfo']['Email']
                                        : '';
                                    ?>" type="email" class="form-control" id="customer-email" placeholder="">
                    <label for="customer-email">Email <b class="text-danger">*</b></label>
                </div>

            </div>
            <!-- // booking information -->
            <div class="w-50 ml-5">
                <div class="d-flex flex-column">
                    <!-- //field sport information -->
                    <div class="d-flex ">
                        <i class="fa-solid fa-info h4 mr-2 text-info"></i>
                        <span class="font-weight-bold">THÔNG TIN ĐẶT SÂN</span>
                    </div>
                    <hr class="border-secondary">

                    <div>
                        <!-- //hidden field  -->
                        <input id="sport-field-id" type="hidden" value="<?= $sportField["ID"] ?>">
                        <input id="booking-date" type="hidden" value="<?= $bookingDate ?>">
                        <input id="field-number" type="hidden" value="<?= $fieldNumber ?>">
                        <input id="start-time" type="hidden" value="<?= $startTime ?>">

                        <div class="d-flex align-items-center mb-3" style="width:100% ;font-size: 18px;">
                            <input id="price-per-hour" type="hidden" value="<?php echo $startTime < 17 ? $sportField["PriceDay"] : $sportField["PriceEvening"] ?>">
                            <span style="min-width: 150px;">Loại giờ: </span>
                            <span>
                                <?php echo $startTime < 17 ? "Giờ thường" : "Giờ vàng" ?>
                                -
                                <?php echo $startTime < 17 ? $sportField["PriceDay"] : $sportField["PriceEvening"] ?>đ/1h
                            </span>
                        </div>
                        <div class="d-flex align-items-center mb-3" style="width:100% ;font-size: 18px;">
                            <span style="min-width: 150px;">Thời Gian: </span>
                            <span class="d-flex">
                                <div class="mr-3"><?= $startTime ?>:00</div>
                                -
                                <select name="end-time" id="end-time" class="ml-3">
                                    <option value="null" selected disabled>?</option>
                                    <option value="1"><?= $startTime  + 1 ?>:00 </option>
                                    <option value="1.5"><?= $startTime  + 1 ?>:30 </option>
                                    <option value="2"><?= $startTime  + 2 ?>:00 </option>
                                </select>
                            </span>
                        </div>
                        <div class="d-flex align-items-center mb-3" style="width:100% ;font-size: 18px;">
                            <span style="min-width: 150px;" class="d-flex">
                                Giá
                                (<div id="hours">?</div>h)
                                :
                            </span>
                            <span class="d-flex">
                                <div class="mr-1" id="total-money">?</div> đ
                            </span>
                        </div>
                        <div class="d-flex align-items-center mb-3" style="width:100% ;font-size: 18px;">
                            <span style="min-width: 150px;">Ngày Đặt: </span>
                            <span class="mr-2"> <?= $bookingDate ?> </span> <span> (Năm-Tháng-Ngày)</span>
                        </div>
                        <div class="d-flex align-items-start" style="width:100% ;font-size: 18px;">
                            <span style="min-width: 150px;">Địa Chỉ Sân: </span>
                            <span>
                                <?= $sportField["Address"] ?>
                            </span>
                        </div>
                    </div>
                    <hr class="border-secondary">
                    <!-- //reminder -->
                    <div>
                        <i class="fa-regular fa-bell h4 mr-2 text-info"></i>
                        <span class="font-weight-bold">NHẮC TÔI</span>
                        <div class="d-flex align-items-center mt-2">
                            <input type="checkbox" style=" width: 20px; height: 20px;">
                            <span class="ml-2" style="font-size:20px">Tôi muốn nhận được e-mail nhắc nhở</span>
                        </div>
                    </div>
                    <hr class="border-secondary">
                </div>

                <!-- //mesage validate -->
                <div id="wrap-message" class="text-danger d-none font-weight-bold">
                    <div class="d-flex">
                        <p>* Lỗi:</p>
                        <p id="message" class="ml-2">this is message</p>
                    </div>

                </div>
            </div>

        </div>

        <div class="container rounded mb-5 d-flex justify-content-end" style="background-color: #E9E9E9;text-align: right ;padding:12px">
            <button id="btn-booking" style=" font-size: 20px;" class="btn btn-info">Đặt Sân</button>

            <!-- <form class="" 
                method="POST" 
                target="_blank" 
                enctype="application/x-www-form-urlencoded" 
                action="/sport-court-rental-system/app/utils/MomoPaymentService.php"
            >
                <button name="momo" style="font-size: 20px; background-color: #D82D8B ;" class="btn text-white ml-2">Đặt Sân - Thanh Toán MoMo</button>
            </form> -->

            <a id="btn-cancel" href="/sport-court-rental-system/public/booking/fieldSchedule/<?= $sportField['ID'] ?>" style="width: 100px; font-size: 20px;" class="btn btn-outline-danger ml-2 text-danger">Hủy</a>
        </div>
    </div>
</body>
</html>
<!-- // booking.js -->
<script src="/sport-court-rental-system/public/js/booking.js"></script>
