<header class="header_section">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href="/sport-court-rental-system/public/home/">
                <span>
                    Sport Court Rental System
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class=""> </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav  ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/sport-court-rental-system/public/home/">Trang chủ</a>
                    </li>

                    <?php if (isset($_SESSION['userInfo']) && $_SESSION['userInfo']['Role'] === 'CUSTOMER') : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/sport-court-rental-system/public/booking/showBooking">Sân đã đặt</a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['userInfo']) && $_SESSION['userInfo']['Role'] === 'OWNER') : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/sport-court-rental-system/public/statistical/fetchOwnerWithSportFields">THỐNG KÊ</a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['userInfo'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/sport-court-rental-system/public/user/getProfile">
                                Hồ Sơ
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['userInfo'])) : ?>
                        <?php if (isset($_SESSION['userInfo']) && $_SESSION['userInfo']['Role'] != 'SYSTEMADMIN') : ?>
                            <li class="nav-item">
                                <a class="nav-link" onclick="handleOwnerRegister(<?php echo $_SESSION['userInfo']['ID']; ?>)">
                                    Bạn Là Chủ Sân?
                                </a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" onclick="handleBusiness()">
                                    Các Doanh Nghiệp
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="handleSportType()">
                                    Thể Loại Sân
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (!isset($_SESSION['userInfo'])) : ?>
                        <li class="nav-item" onclick="handleLogin()">
                            <a class="nav-link" href="#">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>
                                    Đăng nhập
                                </span>
                            </a>
                        </li>
                        <li class="nav-item" onclick="handleRegister()">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-user-plus"></i>
                                <span>
                                    Đăng ký
                                </span>
                            </a>
                        </li>
                    <?php else : ?>
                        <li class="mr-4 mb-2 notify-container d-flex align-items-center">
                            <i id="notifyBell" class="fa-solid fa-bell text-white fa-2xl <?= $unreadNotificationCount > 0 ? 'bell-shake' : '' ?>" style="display: block;"></i>
                            <div class="notify-number border rounded-circle text-white <?= $unreadNotificationCount <= 0 ? 'd-none' : '' ?>" id="notify-number"><?= $unreadNotificationCount ?></div>

                            <div class="notify-arrow"></div>
                            <div class="notify-dropdown" id="notifyDropdown">
                                <div class="mt-2 mr-2" style="text-align: right">
                                    <input 
                                        id           = "markRead"
                                        name         = "markRead"
                                        type         = "checkbox"
                                        class        = "read_notification"
                                        data-action  = "mark_all_as_read"
                                        data-noti-id = "<?= json_encode($allNotiIds) ?>"
                                    >
                                    <label for="markRead">Đọc tất cả</label>
                                </div>
                                <hr class="m-0">
                                <?php foreach ($userNotifications as $noti): ?>
                                    <div>
                                        <div class="notify-item" style="background-color: <?= $noti['status'] == 0 ? '#e0e0e0' : ''?>">
                                            <div>
                                                👍 <b><?= $noti['user_trigger_name'] ?></b> <?= $noti['content'] ?>
                                            </div>

                                            <?php if ($noti['status'] == 0): ?>
                                                <div class="d-flex align-items-center parent_read_one_noti">
                                                    <input data-noti-id="<?= json_encode([$noti['ID']]) ?>" type="checkbox" id="" name="" class="read_notification">
                                                    <label for="read" class="m-0 ml-1">Đã đọc</label>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div class="text-center w-100 p-2" style="cursor: pointer;">
                                    Xem thông báo trước đó <i class="fa-solid fa-angle-down"></i>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item" style="margin-right: 25px;">
                            <div class="dropdown">
                                <button style="background-color: #E41A2B; min-width: 220px" class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-user text-white" style="min-width: 15%;"></i>
                                    <span class="text-white">
                                        <?php echo $_SESSION['userInfo']['FullName']; ?>
                                    </span>
                                </button>

                                <div class="dropdown-menu" style="min-width: 220px" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item w-100" href="/sport-court-rental-system/public/user/getProfile">
                                        <i class="fa-solid fa-id-card" style="min-width: 15%;"></i>
                                        <span>Hồ Sơ</span>
                                    </a>

                                    <?php if ($_SESSION['userInfo']['Role'] != 'SYSTEMADMIN') : ?>
                                        <div class="dropdown-item" href="#" onclick="handleOwnerRegister(<?php echo $_SESSION['userInfo']['ID']; ?>)">
                                            <i class="fa-regular fa-building" style="min-width: 15%;"></i>
                                            <span> Bạn Là Chủ Sân? </span>
                                        </div>
                                    <?php else : ?>
                                        <div class="dropdown-item" href="#" onclick="handleBusiness()">
                                            <i class="fa-regular fa-building" style="min-width: 15%;"></i>
                                            <span>Các Doanh Nghiệp</span>
                                        </div>
                                        <div class="dropdown-item" href="#" onclick="handleSportType()">
                                            <i class="fa-solid fa-list" style="min-width: 15%;"></i>
                                            <span>Thể Loại Sân</span>
                                        </div>
                                    <?php endif; ?>

                                    <hr>

                                    <div class="dropdown-item" href="#" onclick="handleLogout()">
                                        <i class="fa-solid fa-arrow-right-from-bracket" style="min-width: 20%;"></i>
                                        <span>
                                            Đăng Xuất
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</header>

<script>
    const bell          = document.getElementById("notifyBell");
    const notify_number = document.getElementById("notify-number");
    const dropdown      = document.getElementById("notifyDropdown");

    bell.addEventListener("click", function(e) {
        dropdown.classList.toggle("active");
        document.querySelector(".notify-arrow").classList.toggle("active");
        e.stopPropagation(); // tránh click lan ra ngoài
    });

    // Chặn click bên trong dropdown (checkbox, label, item) không làm ẩn dropdown
    dropdown.addEventListener("click", function(e) {
        e.stopPropagation();
    });

    // Ẩn dropdown khi click ra ngoài
    document.addEventListener("click", function() {
        dropdown.classList.remove("active");
        arrow.classList.remove("active");


    });

    // read notification
    $(".read_notification").on("change", async function() {
        if ($(this).is(":checked")) {
            let noti_id = $(this).data("noti-id");
            let action  = $(this).data("action")

            if (!noti_id) {
                alert("Action failed!");
                return;
            }
            let formData = new FormData();
            formData.append('noti_ids', noti_id);
            const response = await fetch('/sport-court-rental-system/public/notification/markNotificationAsRead', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            if (data.statusCode !== 200) {
                await Swal.fire({
                    icon: "error",
                    title: "Đã xảy ra lỗi...",
                    text: data.message,
                });
                return;
            }

            // ACTION - read all notification
            if (action && action == "mark_all_as_read") {
                notify_number.classList.add('d-none');
                $('.parent_read_one_noti').remove();
                $('.notify-item').css('background-color', '');
                $(this).parent().remove();
                return;
            }


            // ACTION - minus one noti each action 'read' on bell
            let old_number_noti = parseInt(notify_number.innerText);
            if ((old_number_noti - 1) <= 0) {
                notify_number.classList.add('d-none');
            }
            notify_number.innerText = old_number_noti - 1;

            // remove the background color style for notify_item unread noti
            $(this).parent().parent().css('background-color', '');
            // remove checkbox 'Đã đọc'
            $(this).parent().remove();
        }
    });
</script>
</script>