<?php
$hiddenSliderSection = true;
$hiddenCategory      = true;
if (empty($_SESSION)) {
    echo "<h1 class='text-danger'>VUI LÒNG ĐĂNG NHẬP TRƯỚC!</h1>";
    die();
}

// USER INFORMATION
$userAvatar        = $_SESSION['userInfo']['Avatar'] ?? null;
$userFullName      = $_SESSION['userInfo']['FullName'];
$userQuote         = $_SESSION['userInfo']['quotes'] ?? null;
$userWWWLink       = $_SESSION['userInfo']['www'] ?? null;
$userTwitterLink   = $_SESSION['userInfo']['twitter'] ?? null;
$userInstagramLink = $_SESSION['userInfo']['instagram'] ?? null;
$userFacebookLink  = $_SESSION['userInfo']['fb'] ?? null;
$userRole          = $_SESSION['userInfo']['Role'];
$userEmail         = $_SESSION['userInfo']['Email'];
$userPhoneNumber   = $_SESSION['userInfo']['PhoneNumber'];
$userAddress       = $_SESSION['userInfo']['Address'];

if ($userRole === 'OWNER') {
    $businessName      = $_SESSION['userInfo']['field_owner']['BusinessName'] ?? null;
    $businessStatus    = $_SESSION['userInfo']['field_owner']['Status'] ?? null;
    $businessAddress   = $_SESSION['userInfo']['field_owner']['BusinessAddress'] ?? null;
    $businessPhone     = $_SESSION['userInfo']['field_owner']['PhoneNumber'] ?? null;
    $businessCreatedAt = $_SESSION['userInfo']['field_owner']['created_at'] ?? null;
}

require_once __DIR__ . '/../layouts/header.php';
?>
<link rel="stylesheet" type="text/css" href="/sport-court-rental-system/public/css/loading.css" />
<section>
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <ol class="breadcrumb mb-4 border-left border-info rounded-right" style="border-left-width: 20px !important;">
                    <li class="breadcrumb-item active" aria-current="page">THÔNG TIN NGƯỜI DÙNG</li>
                </ol>
            </div>
        </div>

        <div class="row" id="infoView">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center" style="height: 418px">

                        <?php
                        if (!empty($userAvatar)) {
                            echo '<img id="userAvatar" src="' . $userAvatar . '" class="shadow bg-body rounded-circle img-fluid" style="width: 200px; height: 200px; object-fit:cover;" alt="User Avatar Loading ...">';
                        } else {

                            echo '<img id="userAvatar" src="../../public/images/user.jpg" alt="User Avatar Loading ..." class="shadow bg-body rounded-circle img-fluid" style="width: 200px; height:200px; object-fit:cover;">';
                        }
                        ?>

                        <div class="d-flex justify-content-center mb-2">
                            <button type="button" onclick="uploadUserAvatar()" id="uploadBtn" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1 mt-2"> <i class="fa-solid fa-images fa-lg"></i> </button>
                            <input type="file" id="fileInput" name="avatarFile" style="display: none;" accept="image/*">
                        </div>
                        <h5 class="my-3 text-decoration"> <?php echo $userFullName; ?> </h5>
                        <hr class="mb-1">
                        <div>
                            <p class="text-muted mb-1">
                                <small class="font-italic text-"><?= !empty($userQuote) ? $userQuote : "Hãy viết đôi dòng về bản thân mình"; ?></small>
                                <button
                                    data-type="quote"
                                    data-prompt-text="NHẬP TIỂU SỬ CỦA BẠN(TỐI ĐA 80 KÝ TỰ):"
                                    data-link-name="quotes"
                                    title="Chỉnh sửa tiểu sử"
                                    class="ml-1 border rounded btn-outline-info btn-edit-user-profile"
                                    data-old-text="<?= !empty($userQuote) ? $userQuote : ""; ?>">
                                    <i class="fa-solid fa-pen-clip"></i>
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0" style="padding-bottom: 35px; height: 284px">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush rounded-3 d-flex jusity-content-center">
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3" style="height:65px">
                                <div class="d-flex flex-row align-items-center wrapper-link w-75">
                                    <i class="fas fa-globe fa-lg text-warning mr-3" style="width: 20px"></i>
                                    <a
                                        href="<?= !empty($userWWWLink) ? $userWWWLink : '#' ?>"
                                        class="mb-0 display-link ellipsis_social_link">
                                        <?= !empty($userWWWLink) ? $userWWWLink : 'NULL' ?>
                                    </a>
                                </div>
                                <div>
                                    <button onclick="changeProfileLink(this)" class="rounded btn-info" title="Cập nhật"><i class=" fa-regular fa-pen-to-square"></i></button>
                                    <button class="rounded btn-success d-none btn-save" onclick="saveProfileLink(this, 'www')" title="Lưu"><i class="fa-regular fa-square-check fa-lg"></i></button>
                                    <button class="rounded btn-danger d-none" title="Hủy"><i class=" fa-solid fa-ban"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3" style="height:65px">
                                <div class="d-flex flex-row align-items-center wrapper-link w-75">
                                    <i class="fab mr-3 fa-twitter fa-lg" style="color: #55acee; width: 20px"></i>
                                    <a
                                        href="<?= !empty($userTwitterLink) ? $userTwitterLink : '#' ?>"
                                        class="mb-0 display-link ellipsis_social_link">
                                        <?= !empty($userTwitterLink) ? $userTwitterLink : 'NULL' ?>
                                    </a>

                                </div>
                                <div>
                                    <button onclick="changeProfileLink(this)" class="rounded btn-info" title="Cập nhật"><i class=" fa-regular fa-pen-to-square"></i></button>
                                    <button class="rounded btn-success d-none btn-save" onclick="saveProfileLink(this, 'twitter')" title="Lưu"><i class="fa-regular fa-square-check fa-lg"></i></button>
                                    <button class="rounded btn-danger d-none" title="Hủy"><i class=" fa-solid fa-ban"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3" style="height:65px">
                                <div class="d-flex flex-row align-items-center wrapper-link w-75">
                                    <i class="fab mr-3 fa-instagram fa-lg" style="color: #ac2bac; width: 20px"></i>
                                    <a
                                        href="<?= !empty($userInstagramLink) ? $userInstagramLink : '#' ?>"
                                        class="mb-0 display-link ellipsis_social_link">
                                        <?= !empty($userInstagramLink) ? $userInstagramLink : 'NULL' ?>
                                    </a>
                                </div>
                                <div>
                                    <button onclick="changeProfileLink(this)" class="rounded btn-info" title="Cập nhật"><i class=" fa-regular fa-pen-to-square"></i></button>
                                    <button class="rounded btn-success d-none btn-save" onclick="saveProfileLink(this, 'instagram')" title="Lưu"><i class="fa-regular fa-square-check fa-lg"></i></button>
                                    <button class="rounded btn-danger d-none" title="Hủy"><i class=" fa-solid fa-ban"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3" style="height:65px">
                                <div class="d-flex flex-row align-items-center wrapper-link w-75">
                                    <i class="fab mr-3 fa-facebook-f fa-lg" style="color: #3b5998; width: 35px"></i>
                                    <a
                                        href="<?= !empty($userFacebookLink) ? $userFacebookLink : '#' ?>"
                                        class="mb-0 display-link ellipsis_social_link">
                                        <?= !empty($userFacebookLink) ? $userFacebookLink : 'NULL' ?>
                                    </a>
                                </div>
                                <div>
                                    <button onclick="changeProfileLink(this)" class="rounded btn-info" title="Cập nhật"><i class=" fa-regular fa-pen-to-square"></i></button>
                                    <button class="rounded btn-success d-none btn-save" onclick="saveProfileLink(this, 'fb')" title="Lưu"><i class="fa-regular fa-square-check fa-lg"></i></button>
                                    <button class="rounded btn-danger d-none" title="Hủy"><i class=" fa-solid fa-ban"></i></button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Vai trò</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"> <?php echo $userRole; ?></p>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Họ & Tên</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"> <?php echo $userFullName; ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"> <?php echo $userEmail; ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">SĐT</p>
                            </div>
                            <div class="col-sm-9 d-flex justify-content-between">
                                <p class="mb-0 text-info font-weight-bold"> <?= !empty($userPhoneNumber) ? $userPhoneNumber : 'Chưa cập nhật'; ?> </p>
                                <button
                                    data-type="phone"
                                    data-prompt-text="VUI LÒNG NHẬP SỐ ĐIỆN THOẠI:"
                                    data-link-name="PhoneNumber"
                                    title="Cập nhật số điện thoại"
                                    class="rounded btn-info btn-edit-user-profile"
                                    data-old-text="<?= !empty($userPhoneNumber) ? $userPhoneNumber : ''; ?>">
                                    <i class=" fa-regular fa-pen-to-square"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Địa chỉ</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"> <?php echo $userAddress; ?> </p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($userRole === 'OWNER') : ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4 mb-md-0" style="height: 405px">
                                <div class="card-body " style="padding-bottom: 29px;">
                                    <div class="mb-4 p-2 font-weight-bold border border-left border-primary rounded-right" style="border-left-width: 5px !important">
                                        <?php echo mb_strtoupper($businessName); ?>
                                    </div>
                                    <div class="mb-1 d-flex align-items-center">
                                        <i class="fa-regular fa-circle-dot text-success mr-2"></i>
                                        <div class="mr-2">Trạng thái:</div>
                                        <div class="font-weight-bold <?php echo $businessStatus ? 'text-success' : 'text-danger'; ?>">
                                            <?php echo $businessStatus ? "ĐANG HOẠT ĐỘNG" : "TẠM NGƯNG"; ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mt-4 mb-1 d-flex align-items-center flex-wrap">
                                        <i class="fa-solid fa-map-pin text-success mr-2 fa-lg"></i>
                                        <div class="mr-2"> Địa chỉ: </div>
                                        <div> <?php echo $businessAddress; ?> </div>
                                    </div>
                                    <hr>
                                    <div class="mt-4 mb-1 d-flex align-items-center flex-row">
                                        <i class="fa-solid fa-mobile-screen-button text-success mr-2"></i>
                                        <div class="mr-2">SĐT:</div>
                                        <div><?php echo $businessPhone; ?></div>
                                    </div>
                                    <hr>
                                    <div class="mt-4 mb-1  d-flex align-items-center flex-row">
                                        <i class="fa-solid fa-clock text-success mr-1"></i>
                                        <div class="mr-2">Ngày đăng ký trên HT:</div>
                                        <div>
                                            <?php
                                            $iso8601String = $businessCreatedAt;
                                            $timestamp = strtotime($iso8601String);
                                            $formattedDate = date("d/m/Y ", $timestamp);
                                            echo $formattedDate;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" id="viewManageField">
                            <div class="card mb-4 mb-md-0" style=" height: 405px">
                                <div class="card-body pb-0 ">
                                    <p class="mb-1 p-2 font-weight-bold border border-left border-warning rounded-right" style="border-left-width: 5px !important">
                                        QUẢN LÝ SÂN
                                    </p>
                                    <div class="text-right">
                                        <button id="addSportFieldBtn" type="button" class="btn btn-outline-primary ms-1 mb-1">
                                            Thêm Sân
                                        </button>
                                    </div>

                                    <hr class="mt-0">

                                    <!-- VIEW SPORT FIELD -->
                                    <div id="list-sport-field">
                                    </div>

                                    <!-- PAGINATION -->
                                    <nav class="position-absolute" style="left: 25%; top: 85%">
                                        <ul id="pagination" class="pagination">                                           
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- add  sport field form -->
                <?php
                require_once realpath(dirname(__FILE__) . '/../sport_field/add.php');
                ?>

                <!-- edit  sport field form -->
                <?php
                require_once realpath(dirname(__FILE__) . '/../sport_field/edit.php');
                ?>
            </div>
        </div>
    </div>
</section>

<script src="../../public/js/user.js"></script>

<script src="../../public/js/sport-field.js"></script>

<script>
    const API_URL_PAGINATION = "/sport-court-rental-system/public/sportfield/apiPagination";
    const TYPE_CONFIG_PAGINATION = "sport_field_template";
</script>
<script src="../../public/js/paginate.js"></script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>