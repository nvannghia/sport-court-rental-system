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