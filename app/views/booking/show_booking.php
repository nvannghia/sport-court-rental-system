<?php
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

$hiddenSliderSection = true;
$hiddenCategory = true;

require_once __DIR__ . '/../layouts/header.php';

?>
<section class="bg-white">
    <div class="container">
        <table class="table">
            <p style="text-align:center; padding:12px; color: #E41A2B" class="h3 shadow-lg rounded-bottom font-weight-bold">Sân Bạn Đã Đặt</p>
            <hr>
            <p style="text-align:center; font-size:20px" class="text-warning">
                *Lưu ý: Bạn có thể chọn thanh toán bằng MoMo hoặc trực tiếp tại sân,
                việc cập nhật trạng thái thanh toán sẽ do chủ sân xử lý!
            </p>
            <thead>
                <tr>
                    <th scope="col"><i class="fa-solid fa-key"></i> Mã</th>
                    <th scope="col"><i class="fa-solid fa-calendar-days"></i> Ngày Đặt</th>
                    <th scope="col"><i class="fa-solid fa-clock"></i> Giờ Đặt</th>
                    <th scope="col"><i class="fa-solid fa-signature"></i> Tên Sân</th>
                    <th scope="col"><i class="fa-solid fa-credit-card"></i> Trạng Thái</th>
                    <th scope="col"><i class="fa-brands fa-elementor"></i> Chi Tiết </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking) :
                    $date = new DateTime($booking['BookingDate']);
                    $formattedDate = $date->format('d/m/Y');
                ?>
                    <tr>
                        <th scope="row"> <?= $booking['ID'] ?> </th>
                        <td> <?= $formattedDate ?> </td>
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
                        <td> Chưa Thanh Toán </td>
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
                //format date
                const bookingDate = bookingObject.BookingDate;
                const dateObject = new Date(bookingDate.replace(' ', 'T')); // Thay thế khoảng trắng bằng 'T'
                const day = dateObject.getDate().toString().padStart(2, '0');
                const month = (dateObject.getMonth() + 1).toString().padStart(2, '0'); // Tháng bắt đầu từ 0
                const year = dateObject.getFullYear();
                const formattedDate = `${day}/${month}/${year}`;
                // format rental hours
                const startTime = parseInt(bookingObject.StartTime);
                const endTime = bookingObject.EndTime;

                let pricePerHour = parseFloat(bookingObject.sport_field.PriceDay);
                if (startTime >= 17)
                    pricePerHour = parseFloat(bookingObject.sport_field.PriceEvening);

                let totalRent = 1;
                let rentalHours = '';
                switch (endTime) {
                    case '1':
                        totalRent = pricePerHour;
                        rentalHours = `${startTime}:00 - ${startTime+1}:00`;
                        break;
                    case '1.5':
                        totalRent = pricePerHour * 1.5;
                        rentalHours = `${startTime}:00 - ${startTime+1}:30`
                        break;
                    case '2':
                        totalRent = pricePerHour * 2;
                        rentalHours = `${startTime}:00 - ${startTime+2}:00`
                        break;
                }
                //asign new date, new rental, new totalRent hours for bookingObject
                bookingObject.BookingDate = formattedDate;
                bookingObject.RentalHours = rentalHours;
                bookingObject.TotalRent = totalRent;
                Swal.fire({
                    title: 'Thông Tin Chi Tiết',
                    imageAlt: "Custom image",
                    html: `
                <hr>
                <div style="text-align:left">
                    <b >Tên sân: </b> <span class="ml-3"> ${bookingObject.sport_field.FieldName} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    <b >Địa chỉ sân: </b> <span class="ml-3"> ${bookingObject.sport_field.Address} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    <b style="width:100px">Sân số: </b> <span class="ml-3"> ${bookingObject.FieldNumber} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    <b style="width:100px">Ngày thuê: </b> <span class="ml-3"> ${bookingObject.BookingDate} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    <b style="width:100px">Giờ thuê: </b> <span class="ml-3"> ${bookingObject.RentalHours} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    <b style="width:100px">Tiền sân: </b> <span class="ml-3"> ${bookingObject.TotalRent}.000 đ </span>
                </div>
                <hr>
                <div style="text-align:left">
                    <b style="width:100px">Tên khách hàng: </b> <span class="ml-3"> ${bookingObject.CustomerName} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    <b style="width:100px">Email khách hàng: </b> <span class="ml-3"> ${bookingObject.CustomerEmail} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    <b style="width:100px">SĐT: </b> <span class="ml-3"> ${bookingObject.CustomerPhone} </span>
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