<?php
require_once __DIR__ . '/../layouts/header.php';
?>
<link rel="stylesheet" type="text/css" href="/sport-court-rental-system/public/css/table.css" />
<link rel="stylesheet" type="text/css" href="/sport-court-rental-system/public/css/card.css" />
<link rel="stylesheet" type="text/css" href="/sport-court-rental-system/public/css/menu-bar.css" />
<style>
    .d-flex-custom {
        display: flex;
        width: 100%;
    }

    #view-sport-field {
        flex: 1;
        transition: all 0.3s ease;
    }
</style>


<section>
    <div class="d-flex-custom ">
        <!-- SRART Menu bar  -->
        <aside class="vertical-sidebar"> <input type="checkbox" role="switch" id="checkbox-input" class="checkbox-input" checked />
            <nav class="nav_container">
                <header>
                    <div class="sidebar__toggle-container"> <label tabindex="0" for="checkbox-input" id="label-for-checkbox-input" class="nav__toggle"> <span class="toggle--icons" aria-hidden="true"> <svg width="24" height="24" viewBox="0 0 24 24" class="toggle-svg-icon toggle--open">
                                    <path d="M3 5a1 1 0 1 0 0 2h18a1 1 0 1 0 0-2zM2 12a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1M2 18a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1"> </path>
                                </svg> <svg width="24" height="24" viewBox="0 0 24 24" class="toggle-svg-icon toggle--close">
                                    <path d="M18.707 6.707a1 1 0 0 0-1.414-1.414L12 10.586 6.707 5.293a1 1 0 0 0-1.414 1.414L10.586 12l-5.293 5.293a1 1 0 1 0 1.414 1.414L12 13.414l5.293 5.293a1 1 0 0 0 1.414-1.414L13.414 12z"> </path>
                                </svg> </span> </label> </div>
                    <figure> <img class="codepen-logo" src="https://blog.codepen.io/wp-content/uploads/2023/09/logo-black.png" alt="" />
                        <!-- <figcaption>
                            <p class="user-id">Codepen</p>
                            <p class="user-role">Coder</p>
                        </figcaption> -->
                    </figure>
                </header>
                <section class="sidebar__wrapper">
                    <ul class="sidebar__list list--primary">
                        <li class="sidebar__item item--heading">
                            <h2 class="sidebar__item--heading">THỂ LOẠI SÂN</h2>
                        </li>
                        <li class="sidebar__item">
                            <a class="sidebar__link sport_type_category" data-sport-type-id="1" href="#" data-tooltip="Inbox">
                                <img src="/sport-court-rental-system/public/images/category/basketball.png" alt="basketball.png" class="ml-1" width="25px">
                                <span class="text">Bóng Rổ</span>
                            </a>
                        </li>
                        <li class="sidebar__item">
                            <a class="sidebar__link sport_type_category" data-sport-type-id="2" href="#" data-tooltip="Inbox">
                                <img src="/sport-court-rental-system/public/images/category/volleyball.png" alt="basketball.png" class="ml-1" width="25px">
                                <span class="text">Bóng Chuyền</span>
                            </a>
                        </li>
                        <li class="sidebar__item">
                            <a class="sidebar__link sport_type_category" data-sport-type-id="3" href="#" data-tooltip="Inbox">
                                <img src="/sport-court-rental-system/public/images/category/tennis.png" alt="basketball.png" class="ml-1" width="25px">
                                <span class="text">Tennis</span>
                            </a>
                        </li>
                        <li class="sidebar__item">
                            <a class="sidebar__link sport_type_category" data-sport-type-id="4" href="#" data-tooltip="Inbox">
                                <img src="/sport-court-rental-system/public/images/category/badminton.png" alt="basketball.png" class="ml-1" width="25px">
                                <span class="text">Cầu Lông</span>
                            </a>
                        </li>
                        <li class="sidebar__item">
                            <a class="sidebar__link sport_type_category" data-sport-type-id="5" href="#" data-tooltip="Inbox">
                                <img src="/sport-court-rental-system/public/images/category/football.png" alt="basketball.png" class="ml-1" width="25px">
                                <span class="text">Bóng Đá</span>
                            </a>
                        </li>
                        <li class="sidebar__item">
                            <a class="sidebar__link sport_type_category" data-sport-type-id="6" href="#" data-tooltip="Inbox">
                                <img src="/sport-court-rental-system/public/images/category/golf.png" alt="basketball.png" class="ml-1" width="25px">
                                <span class="text">Golf</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="sidebar__list list--secondary">
                        <li class="sidebar__item item--heading">
                            <h2 class="sidebar__item--heading">Chung</h2>
                        </li>
                        <li class="sidebar__item"> 
                            <a class="sidebar__link d-flex align-items-center ml-2" href="/sport-court-rental-system/public/user/getProfile" data-tooltip="Profile"> 
                                <i class="fa-solid fa-id-card text-white mr-2"></i>
                                <span class="text">Hồ Sơ</span> 
                            </a> 
                        </li>
                        <li class="sidebar__item">
                            <?php 
                                $isLogged       = !empty($_SESSION['userInfo']);
                                $authAction     = $isLogged ? 'handleLogout()' : 'handleLogin()';
                                $textAuthAction = $isLogged ? 'Đăng Xuất' : 'Đăng Nhập';
                                $iconAuthAction = $isLogged ? 'fa-arrow-right-from-bracket' : 'fa-arrow-right-to-bracket';
                            ?> 
                            <a class="sidebar__link d-flex align-items-center ml-2" onclick="<?=$authAction?>" href="#"> 
                                <i class="fa-solid <?=$iconAuthAction?> mr-2 text-white"></i>
                                </span> <span class="text"><?=$textAuthAction?></span> 
                            </a> 
                        </li>
                    </ul>
                </section>
            </nav>
        </aside>
        <!-- END Menu bar -->
        <!-- //sport field -->
        <div id="view-sport-field">
            <div class="mb-1">
                <h2
                    class="font-weight-bold mt-4"
                    style="
                        color:#fff; 
                        text-align:center; 
                    ">
                    DANH SÁCH SÂN BÃI
                </h2>
            </div>
            <hr class="border border-white">

            <div class="container" id="homepage-container">
            </div>

            <!-- PAGINATION -->
            <nav class="d-flex justify-content-center mt-3">
                <ul id="pagination" class="pagination">
                </ul>
            </nav>


        </div>
    </div>
</section>


<!-- paginate -->
<script>
    var API_URL_PAGINATION = "/sport-court-rental-system/public/home/getPaginatedSportFieldsForHomepage?sportTypeId=1";
    const TYPE_CONFIG_PAGINATION = "homepage_template";

    $(document).ready(function() {
        $(".sport_type_category").click(function() {
            let sportTypeId = $(this).attr('data-sport-type-id');
            if (!sportTypeId || !$.isNumeric(sportTypeId)) {
                alert("false sport type ID value");
                return;
            }
            // Xóa sportTypeId hiện tại (nếu có)
            API_URL_PAGINATION = "/sport-court-rental-system/public/home/getPaginatedSportFieldsForHomepage";
            API_URL_PAGINATION += `?sportTypeId=${sportTypeId}`;

            changeColorSportTypeClicked(sportTypeId);
            loadPage(1);
            scrollToViewSportField();
        });

        const changeColorSportTypeClicked = (sportTypeId) => {
            $('[data-sport-type-id].cate_section').css({
                backgroundColor: '#e41a2b'
            });
            $('[data-sport-type-id].sidebar__link').blur();
            $(`[data-sport-type-id="${sportTypeId}"].cate_section`).css({
                backgroundColor: '#b51623'
            });
            $(`[data-sport-type-id="${sportTypeId}"].sidebar__link`).focus();
        }

        const scrollToViewSportField = () => {
            $('html, body').animate({
                scrollTop: $('#view-sport-field').offset().top
            }, 500);
        }


        // header search form
        $('#formSearch').submit(function(event) {
            event.preventDefault();
            let sportTypeId = $('#formSearch select[name="sportType"]').val();
            let fieldName = $('#formSearch input[name="inputSportFieldName"]').val();
            let area = $('#formSearch input[name="inputAreaName"]').val();

            let isValid = true;
            if (!sportTypeId || !$.isNumeric(sportTypeId)) {
                isValid = false;
                $('#formSearch select[name="sportType"]').siblings().css('border', "2px solid red");
            }

            if (!fieldName) {
                isValid = false;
                $('#formSearch input[name="inputSportFieldName"]').css('border', "2px solid red");
            }

            if (!area) {
                isValid = false;
                $('#formSearch input[name="inputAreaName"]').css('border', "2px solid red");
            }

            if (isValid) {
                API_URL_PAGINATION = `/sport-court-rental-system/public/home/getPaginatedSportFieldsForHomepage?sportTypeId=${sportTypeId}&fieldName=${fieldName}&area=${area}`;
                loadPage(1);
                changeColorSportTypeClicked(sportTypeId);
                scrollToViewSportField();
            }

        });
    });
</script>
<script src="/sport-court-rental-system/public/js/paginate.js"></script>
<script src="/sport-court-rental-system/public/js/home.js"></script>
<?php
require_once __DIR__ . '/../layouts/footer.php';
?>