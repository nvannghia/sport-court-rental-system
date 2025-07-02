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
            <div class="container swiper swiper-container rounded shadow-lg">
                <div class="swiper-wrapper">
                    <?php if (count($fieldReivewImagesUrl) > 0): ?>
                        <?php foreach ($fieldReivewImagesUrl as $imageReview): ?>
                            <div class="swiper-slide">
                                <img class="w-100" src="<?= $imageReview ?>" alt="images-review">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="swiper-slide">
                            <img  class="w-100" style="object-fit: cover;" src="/sport-court-rental-system/public/images/thumbail-football.jpg" alt="thum-football">
                        </div>
                        <div class="swiper-slide">
                            <img class="w-100" style="object-fit: cover;" src="/sport-court-rental-system/public/images/thumbail-basketball.jpg" alt="thumb-basketball">
                        </div>
                        <div class="swiper-slide">
                            <img  class="w-100" src="/sport-court-rental-system/public/images/thumbail-volleyball.jpg" alt="thumb-volleyball">
                        </div>
                    <?php endif; ?>
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

            <?php if (isset($_SESSION['userInfo'])): ?>
                <div class="mt-3 d-flex align-items-center justify-content-end">
                    <i class="fa-solid fa-calendar-week mr-2 h2" style="color: #E41A2B;"></i>
                    <a target="_blank" href="/sport-court-rental-system/public/booking/fieldSchedule/<?= $sportField["ID"] ?>" class="btn text-white font-weight-bold" style="background-color: #E41A2B;">ĐẶT SÂN NGAY</a>
                </div>
            <?php else: ?>
                <div class="mt-3 d-flex align-items-center justify-content-end">
                    <i class="fa-solid fa-calendar-week mr-2 h2" style="color: #E41A2B;"></i>
                    <a onclick="handleLogin()" class="btn text-white font-weight-bold" style="background-color: #E41A2B;">ĐĂNG NHẬP ĐỂ ĐẶT SÂN</a>
                </div>
            <?php endif; ?>

            <hr>
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

<!-- <script>
    function replaceImagesSrc() {
        const images = document.getElementsByTagName("img");
        [...images].forEach((img) => {
            img.style.width = '100%';
            img.style.height = '470px'
            img.src = img.src.replace("/public", "")
        });
    }

    replaceImagesSrc();
</script> -->

<!-- // field review js -->
<script src="../../../public/js/field-review.js"></script>