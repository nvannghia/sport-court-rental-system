<?php
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

$hiddenSliderSection = true;
$hiddenCategory = true;

require_once __DIR__ . '/../layouts/header.php';

?>
<section class="bg-white">
    <div class="container d-flex">
        <div class="left" style="min-width: 70%;">
            <!-- Slider main container -->
            <div class="container swiper swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="https://ieltsxuanphi.edu.vn/wp-content/uploads/2021/06/sports-New-Brunswick.jpg" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://media.istockphoto.com/id/949190756/photo/various-sport-equipments-on-grass.webp?b=1&s=170667a&w=0&k=20&c=0du9Ul5NHOHDjpolTa8GKvLVSdOCoRPN-JGI_chUOsI=" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://ieltsxuanphi.edu.vn/wp-content/uploads/2021/06/sports-New-Brunswick.jpg" alt="">
                    </div>
                </div>
                <!-- Nếu bạn muốn thêm nút điều hướng -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <!-- Nếu bạn muốn thêm chỉ số slide -->
                <div class="swiper-pagination"></div>
                <script>
                    var swiper = new Swiper('.swiper-container', {
                        slidesPerView: 1,
                        spaceBetween: 10,
                        loop: true,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true, // Cho phép nhấp vào phân trang
                        },
                        autoplay: {
                            delay: 2000, // Đặt thời gian chờ giữa các lần chuyển slide là 5 giây (5000ms)
                        },
                    });
                </script>
            </div>

            <div class="mt-5">
                <span class="rounded h4 shadow font-weight-bold" style="padding:20px">
                    <i class="fa-solid fa-audio-description"></i> -
                    Giới thiệu chung
                </span>
                <br>
                <br>
                <br>
                <div>
                    <?php echo $sportField['Description']; ?>
                </div>
            </div>

        </div>

        <div class="right ml-2" style="min-width: 30%; border-left:5px solid #19458A">
            <div class="card w-100 " style="width: 18rem;">
                <div class="card-header font-weight-bold">
                    THÔNG TIN CHỦ SÂN
                </div>
                <ul class="text-secondary list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="fa-regular fa-user" style="min-width: 20px;"></i>
                        <span>Anh/Chị <?php echo $ownerOfSportField['FullName']; ?> </span>
                    </li>
                    <li class="list-group-item" style="border-radius: 0 30px 30px 0;background-color: #E41A2B;">
                        <i class="fa-solid fa-phone-volume text-white" style="min-width: 20px;"></i>
                        <span class="text-white"><?php echo str_replace('+84', '0', $ownerOfSportField['PhoneNumber']); ?> </span>
                    </li>
                    <li class="list-group-item">
                        <i class="fa-solid fa-location-dot" style="min-width: 20px;"></i>
                        <span><?php echo $ownerOfSportField['Address']; ?> </span>
                    </li>
                </ul>
            </div>

            <!-- //reviews -->
            <?php require_once('review.php'); ?>
        </div>

    </div>

</section>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>

<script>
    function replaceImagesSrc() {
        const images = document.getElementsByTagName("img");
        [...images].forEach((img) => {
            img.style.width = '100%';
            img.style.height = '470px'
            img.src = img.src.replace("/public", "")
        });
    }

    replaceImagesSrc();
</script>

<!-- // field review js -->
<script src="../../../public/js/field-review.js"></script>