<?php
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

$hiddenSliderSection = true;
$hiddenCategory = true;

require_once __DIR__ . '/../layouts/header.php';
?>
<section class="bg-white">
    <div class="container shadow-lg rounded-bottom">
        <hr>
        <table class="table">
            <p style="text-align:center; padding:12px; color: #E41A2B" class="h3 shadow-lg rounded-bottom font-weight-bold">
                Tất Cả Sân Của Doanh Nghiệp
            </p>
            <hr>
            <p style="text-align:center; font-size:20px" class="text-warning">
                *Lưu ý: Doanh nghiệp cần xác nhận thanh toán của các hóa đơn đã được
                thanh toán trực tiếp(in-person) tại sân!
            </p>
            <hr>
            <div class="d-flex align-items-center flex-column mb-2">
                <div class="d-flex align-items-center">
                    <span class="font-weight-bold mr-2" style="min-width:170px">TỔNG DOANH THU:</span>
                    <input id="revenue" class="border-0" style="width:120px" type="password" value="<?= number_format($totalRevenue); ?> đ" readonly disabled>
                    <i onclick="toggleRevenueVisibility(this)" class="fa-solid fa-eye-slash h4"></i>
                </div>
                <div class="d-flex align-items-center">
                    <span class="font-weight-bold mr-2" style="min-width:170px">ĐÃ THANH TOÁN:</span>
                    <input id="paid-bookings" class="border-0" style="width:120px" type="password" value="<?= $bookingPaidCount ?> (bookings)" readonly disabled>
                    <i onclick="togglePaidBookingsVisibility(this)" class="fa-solid fa-eye-slash h4"></i>
                </div>
                <div class="d-flex align-items-center">
                    <span class="font-weight-bold mr-2" style="min-width:170px">CHƯA THANH TOÁN:</span>
                    <input id="unpaid-bookings" class="border-0" style="width:120px" type="password" value="<?= $bookingUnpaidCount ?> (bookings)" readonly disabled>
                    <i onclick="toggleUnpaidBookingsVisibility(this)" class="fa-solid fa-eye-slash h4"></i>
                </div>
            </div>
            <thead>
                <tr style="color: #202A6A">
                    <th scope="col">[<i class="fa-solid fa-arrow-down-1-9"></i>] STT</th>
                    <th scope="col">[<i class="fa-solid fa-list"></i>] LOẠI SÂN</th>
                    <th scope="col">[<i class="fa-solid fa-file-signature"></i>] TÊN SÂN</th>
                    <th scope="col">[<i class="fa-solid fa-money-bill-wave"></i>] GIÁ SÁNG(<17H) </th>
                    <th scope="col">[<i class="fa-solid fa-money-bill-1-wave"></i>] GIÁ TỐI(>17H)</th>
                    <th scope="col">[<i class="fa-solid fa-arrow-down-wide-short"></i>] SL SÂN</th>
                    <th scope="col">[<i class="fa-solid fa-chart-line"></i>] THỐNG KÊ </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sportFields as $sportFieldKey => $sportField): ?>
                    <tr>
                        <td scope="row"> <?= $sportFieldKey + 1 ?> </td>
                        <td> <?= $sportField['sport_type']['TypeName'] ?> </td>
                        <td> <?= $sportField['FieldName'] ?> </td>
                        <td> <?= $sportField['PriceDay'] ?> </td>
                        <td> <?= $sportField['PriceEvening'] ?> </td>
                        <td> <?= $sportField['NumberOfFields'] ?> </td>
                        <td>
                            <a href="/sport-court-rental-system/public/statistical/getBookingOfSportField/<?= $sportField["ID"] ?>" class="btn btn-outline-info"> XEM THỐNG KÊ </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<script src="/sport-court-rental-system/public/js/statistics.js"></script>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>