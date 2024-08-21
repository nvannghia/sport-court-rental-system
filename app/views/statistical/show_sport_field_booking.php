<?php
$hiddenSliderSection = true;
$hiddenCategory = true;

require_once __DIR__ . '/../layouts/header.php';
?>
<section class="bg-white">
    <div class="container shadow-lg rounded-bottom">
        <table class="table">
            <p style="text-align:center; padding:12px; color: #E41A2B" class="h3 shadow-lg rounded-bottom font-weight-bold">
                CHI TIẾT THỐNG KÊ MỖI SÂN
            </p>
            <hr>
            <p style="text-align:center; font-size:20px" class="text-warning">
                *Lưu ý: Doanh nghiệp cần xác nhận thanh toán của các hóa đơn đã được
                thanh toán trực tiếp(in-person) tại sân!
            </p>
            <hr>
            <?php if (count($bookings) > 0): ?>
                <div class="d-flex justify-content-end  align-items-center mb-3 mr-4">
                    <div style="color: #E41A2B; margin-bottom: 0" class="h3">
                        [<i class="fa-solid fa-download"></i>]
                    </div>
                    <button
                        data-bookings='<?= htmlspecialchars(json_encode($bookings), ENT_QUOTES, 'UTF-8') ?>'
                        data-total-revenue='<?= htmlspecialchars($totalRevenue, ENT_QUOTES, 'UTF-8') ?>'
                        data-business-info='<?= htmlspecialchars(json_encode($businessInfo), ENT_QUOTES, 'UTF-8') ?>'
                        onclick="generatePDFStatistics(this)"
                        class="btn btn-link ml-2" style="background-color: #E41A2B; color:aliceblue">
                        Xuất Thống Kê(.pdf) Sân
                    </button>
                </div>
                <hr>
                <div class="d-flex justify-content-around mt-1 mb-1">
                    <div class="h4">[<i class="fa-solid fa-filter"></i>]</div>
                    <span>||</span>
                    <div class="form-check h5">
                        <input type="radio" class="form-check-input" id="detail-sp-bookings-all" name="filter-detail-sp-payment-status" value="all" checked>
                        <label class="form-check-label" for="detail-sp-bookings-all">Tất Cả</label>
                    </div>
                    <span>|</span>
                    <div class="form-check h5">
                        <input type="radio" class="form-check-input" id="detail-sp-bookings-paid" name="filter-detail-sp-payment-status" value="paid">
                        <label class="form-check-label" for="detail-sp-bookings-paid">Đã Thanh Toán</label>
                    </div>
                    <span>|</span>
                    <div class="form-check h5">
                        <input type="radio" class="form-check-input" id="detail-sp-bookings-unpaid" name="filter-detail-sp-payment-status" value="unpaid">
                        <label class="form-check-label" for="detail-sp-bookings-unpaid">Chưa Thanh Toán</label>
                    </div>
                </div>
                <thead>
                    <tr style="color: #202A6A">
                        <th scope="col">[<i class="fa-solid fa-arrow-down-1-9"></i>] STT</th>
                        <th scope="col">[<i class="fa-solid fa-calendar-day"></i>] NGÀY ĐẶT</th>
                        <th scope="col">[<i class="fa-solid fa-calendar-days"></i>] NGÀY THUÊ</th>
                        <th scope="col">[<i class="fa-solid fa-clock"></i>] GIỜ THUÊ</th>
                        <th scope="col">[<i class="fa-solid fa-signature"></i>] TÊN SÂN</th>
                        <th scope="col">[<i class="fa-solid fa-credit-card"></i>] TRẠNG THÁI</th>
                        <th scope="col">[<i class="fa-solid fa-file-invoice"></i>] HÓA ĐƠN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $BookingIndex => $booking) : ?>
                        <tr>
                            <th scope="row"> <?= $BookingIndex + 1 ?> </th>
                            <td> <?= $booking['created_at'] ?> </td>
                            <td> <?= $booking['BookingDate'] ?> </td>
                            <td> <?= $booking['RentalHours'] ?> </td>
                            <td> <?= $booking['sport_field']['FieldName'] ?> </td>
                            <td id="td-booking-id-<?= $booking['ID'] ?>">
                                <?php
                                echo $booking['PaymentStatus'] == 'UNPAID'
                                    ? '
                                    <div style="width:228px; height:40px " class="rounded">
                                        <a onclick="approvePayment(event, ' . $booking["ID"] . ', ' . $booking["TotalAmount"] . ')" class="btn btn-info text-white d-flex align-items-center h-100" >
                                            <i class="fa-solid fa-money-check-dollar mr-2" style="font-size: 20px;"></i></i>
                                            <span>Xác nhận thanh toán</span>
                                        </a>
                                    </div>
                                        
                                    '
                                    : '
                                    <div style="width:228px; height:40px " class="d-flex align-items-center text-success border border-success rounded">
                                        <i class="fa-solid fa-square-check ml-2 mr-2" style="min-width:30px; font-size:25px"></i> 
                                        <span>Đã Thanh Toán</span>
                                    </div>
                                    '; ?>
                            </td>
                            <td>
                                <button onclick="showInvoice(<?= $booking['ID'] ?>)" class="btn btn-outline-info">
                                    Xem hóa đơn
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            <?php else: ?>
                <tr>
                    <div class="h4 p-4 rounded text-light" style="background-color: #030D47;text-align: center;">Sân này chưa có bookings nào!</div>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</section>
<!-- //js pdf package -->
<script src="https://unpkg.com/jspdf-invoice-template@1.4.4/dist/index.js"></script>
<script src="/sport-court-rental-system/public/js/statistics.js"></script>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>