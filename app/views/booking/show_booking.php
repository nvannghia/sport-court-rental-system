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
        <table class="table">
            <p style="text-align:center; padding:12px; color: #E41A2B" class="h3 shadow-lg rounded-bottom font-weight-bold">Sân Bạn Đã Đặt</p>
            <hr>
            <p style="text-align:center; font-size:20px" class="text-warning">
                *Lưu ý: Bạn có thể chọn thanh toán bằng MoMo hoặc trực tiếp tại sân,
                việc cập nhật trạng thái thanh toán sẽ do chủ sân xử lý!
            </p>
            <thead>
                <tr style="color: #202A6A">
                    <th scope="col">[<i class="fa-solid fa-arrow-down-1-9"></i>] STT</th>
                    <th scope="col">[<i class="fa-solid fa-calendar-day"></i>] Ngày Đặt</th>
                    <th scope="col">[<i class="fa-solid fa-calendar-days"></i>] Ngày Thuê</th>
                    <th scope="col">[<i class="fa-solid fa-clock"></i>] Giờ Thuê</th>
                    <th scope="col">[<i class="fa-solid fa-signature"></i>] Tên Sân</th>
                    <th scope="col">[<i class="fa-solid fa-credit-card"></i>] Trạng Thái</th>
                    <th scope="col">[<i class="fa-brands fa-elementor"></i>] Chi Tiết </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $BookingIndex => $booking) :?>
                    <tr>
                        <th scope="row"> <?= $BookingIndex + 1?> </th>
                        <td> <?= $booking['created_at'] ?> </td>
                        <td> <?= $booking['BookingDate'] ?> </td>
                        <td>
                            <?= $booking['StartTime'] ?>:00
                            -
                            <?php
                            switch ($booking['EndTime']):
                                case 1:
                                    echo  $booking['StartTime'] + 1 . ':00';
                                    break;
                                case 1.5:
                                    echo  $booking['StartTime'] + 1 . ':30';
                                    break;
                                case 2:
                                    echo  $booking['StartTime'] + 2 . ':00';
                                    break;
                                default:
                            endswitch;
                            ?>
                        </td>
                        <td> <?= $booking['sport_field']['FieldName'] ?> </td>
                        <td>
                            <?php 
                            echo $booking['PaymentStatus'] == 'UNPAID'
                            ? '<form class="" 
                                method="POST" 
                                target="_blank" 
                                enctype="application/x-www-form-urlencoded" 
                                action="
                                /sport-court-rental-system/app/utils/MomoPaymentService.php
                                ?totalAmount='.urlencode($booking['TotalAmount']).'&bookingID='.urlencode($booking['ID']).'
                                "
                                >
                                    <button name="momo" style="background-color: #D82D8B ;" class="btn text-white">Thanh Toán MoMo</button>
                                </form>'
                            : '
                                <div style="width:172px; height:40px " class="d-flex align-items-center text-success border border-success rounded">
                                    <i class="fa-solid fa-square-check ml-2 mr-2"></i> 
                                    <span>Đã Thanh Toán</span>
                                </div>
                                '; ?>
                        </td>
                        <td>
                            <button data-booking='<?= htmlspecialchars(json_encode($booking), ENT_QUOTES, 'UTF-8') ?>' name="detail-info-booking" class="btn btn-outline-info">TT Chi Tiết</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <script>
        const btnDetailInfoBookings = document.querySelectorAll('button[name=detail-info-booking]');

        btnDetailInfoBookings.forEach(btnDetailInfoBooking => {

            btnDetailInfoBooking.addEventListener('click', function(evt) {

                const bookingData = this.getAttribute('data-booking');
                const bookingObject = JSON.parse(bookingData);
                console.log(bookingObject);
                Swal.fire({
                    title: 'Thông Tin Chi Tiết',
                    imageAlt: "Custom image",
                    html: `
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-signature"></i>]
                    <b>Tên sân: </b> 
                    <span class="ml-3"> 
                    ${bookingObject.sport_field.FieldName} 
                    </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-map-location-dot"></i>]
                    <b>Địa chỉ sân: </b> 
                    <span class="ml-3"> ${bookingObject.sport_field.Address} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-list-ol"></i>]
                    <b style="width:100px">Sân số: </b> 
                    <span class="ml-3"> ${bookingObject.FieldNumber} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-calendar-days"></i>]
                    <b style="width:100px">Ngày thuê: </b> 
                    <span class="ml-3"> ${bookingObject.BookingDate} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-clock"></i>]
                    <b style="width:100px">Giờ thuê: </b> 
                    <span class="ml-3"> ${bookingObject.StartTime}:00 - ${parseInt(bookingObject.StartTime) + parseInt(bookingObject.EndTime)}:00 </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-money-check-dollar"></i>]
                    <b style="width:100px">Tiền sân: </b> 
                    <span class="ml-3"> ${bookingObject.TotalAmount}.000 đ </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-regular fa-credit-card"></i>]
                    <b style="width:100px">Trạng thái: </b> 
                    <span class="ml-3"> ${bookingObject.PaymentStatus == 'UNPAID' ? 'Chưa thanh toán' : 'Đã thanh toán'} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-regular fa-address-card"></i>]
                    <b style="width:100px">Tên khách hàng: </b> 
                    <span class="ml-3"> ${bookingObject.CustomerName} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-envelope"></i>]
                    <b style="width:100px">Email khách hàng: </b> 
                    <span class="ml-3"> ${bookingObject.CustomerEmail} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-mobile"></i>]
                    <b style="width:100px">SĐT: </b> 
                    <span class="ml-3"> ${bookingObject.CustomerPhone} </span>
                </div>
                <hr>
                `
                });
            });
        })
    </script>
</section>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>