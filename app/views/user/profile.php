<?php
$hiddenSliderSection = true;
$hiddenCategory = true;
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
    $businessName      = $_SESSION['userInfo']['field_owner']['BusinessName'];
    $businessStatus    = $_SESSION['userInfo']['field_owner']['Status'];
    $businessAddress   = $_SESSION['userInfo']['field_owner']['BusinessAddress'];
    $businessPhone     = $_SESSION['userInfo']['field_owner']['PhoneNumber'];
    $businessCreatedAt = $_SESSION['userInfo']['field_owner']['created_at'];
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
                <div class="card mb-4 mb-lg-0" style="padding-bottom: 35px">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush rounded-3 d-flex jusity-content-center">
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <div class="d-flex flex-row align-items-center wrapper-link w-75">
                                    <i class="fas fa-globe fa-lg text-warning mr-3" style="width: 20px"></i>
                                    <a
                                        href="<?= !empty($userWWWLink) ? $userWWWLink : '#' ?>"
                                        class="mb-0 display-link">
                                        <?= !empty($userWWWLink) ? $userWWWLink : 'NULL' ?>
                                    </a>
                                </div>
                                <div>
                                    <button onclick="changeProfileLink(this)" class="rounded btn-info" title="Cập nhật"><i class=" fa-regular fa-pen-to-square"></i></button>
                                    <button class="rounded btn-success d-none btn-save" onclick="saveProfileLink(this, 'www')" title="Lưu"><i class="fa-regular fa-square-check fa-lg"></i></button>
                                    <button class="rounded btn-danger d-none" title="Hủy"><i class=" fa-solid fa-ban"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <div class="d-flex flex-row align-items-center wrapper-link w-75">
                                    <i class="fab mr-3 fa-twitter fa-lg" style="color: #55acee; width: 20px"></i>
                                    <a
                                        href="<?= !empty($userTwitterLink) ? $userTwitterLink : '#' ?>"
                                        class="mb-0 display-link">
                                        <?= !empty($userTwitterLink) ? $userTwitterLink : 'NULL' ?>
                                    </a>

                                </div>
                                <div>
                                    <button onclick="changeProfileLink(this)" class="rounded btn-info" title="Cập nhật"><i class=" fa-regular fa-pen-to-square"></i></button>
                                    <button class="rounded btn-success d-none btn-save" onclick="saveProfileLink(this, 'twitter')" title="Lưu"><i class="fa-regular fa-square-check fa-lg"></i></button>
                                    <button class="rounded btn-danger d-none" title="Hủy"><i class=" fa-solid fa-ban"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <div class="d-flex flex-row align-items-center wrapper-link w-75">
                                    <i class="fab mr-3 fa-instagram fa-lg" style="color: #ac2bac; width: 20px"></i>
                                    <a
                                        href="<?= !empty($userInstagramLink) ? $userInstagramLink : '#' ?>"
                                        class="mb-0 display-link">
                                        <?= !empty($userInstagramLink) ? $userInstagramLink : 'NULL' ?>
                                    </a>
                                </div>
                                <div>
                                    <button onclick="changeProfileLink(this)" class="rounded btn-info" title="Cập nhật"><i class=" fa-regular fa-pen-to-square"></i></button>
                                    <button class="rounded btn-success d-none btn-save" onclick="saveProfileLink(this, 'instagram')" title="Lưu"><i class="fa-regular fa-square-check fa-lg"></i></button>
                                    <button class="rounded btn-danger d-none" title="Hủy"><i class=" fa-solid fa-ban"></i></button>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <div class="d-flex flex-row align-items-center wrapper-link w-75">
                                    <i class="fab mr-3 fa-facebook-f fa-lg" style="color: #3b5998; width: 20px"></i>
                                    <a
                                        href="<?= !empty($userFacebookLink) ? $userFacebookLink : '#' ?>"
                                        class="mb-0 display-link"
                                    >
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
                                <p class="mb-0 text-danger"> <?= !empty($userPhoneNumber) ? $userPhoneNumber : 'Chưa cập nhật'; ?> </p>
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
                                <div class="card-body " style="padding-bottom: 29px;font-family: 'Times New Roman', Times, serif;">
                                    <p class="mb-4 p-2 font-weight-bold border border-left border-primary rounded-right" style="border-left-width: 5px !important">
                                        <?php echo mb_strtoupper($businessName); ?>
                                    </p>
                                    <div class="mb-1 d-flex align-items-center">
                                        <i class="fa-regular fa-circle-dot text-success mr-2"></i>
                                        <span class="mr-2">TRẠNG THÁI:</span>
                                        <span class="font-weight-bold <?php echo $businessStatus ? 'text-success' : 'text-danger'; ?>">
                                            <?php echo $businessStatus ? "ĐANG HOẠT ĐỘNG" : "TẠM NGƯNG"; ?>
                                        </span>
                                    </div>
                                    <hr>
                                    <div class="mt-4 mb-1 d-flex align-items-center flex-wrap">
                                        <i class="fa-solid fa-map-pin text-success mr-2 fa-lg"></i>
                                        <span class="mr-2"> ĐỊA CHỈ: </span>
                                        <span> <?php echo $businessAddress; ?> </span>
                                    </div>
                                    <hr>
                                    <p class="mt-4 mb-1 d-flex align-items-center">
                                        <i class="fa-solid fa-mobile-screen-button text-success mr-2"></i>
                                        <span class="mr-2">SĐT:</span>
                                        <span><?php echo $businessPhone; ?></span>
                                    </p>
                                    <hr>
                                    <p class="mt-4 mb-1">
                                        <i class="fa-solid fa-clock text-success mr-1"></i>
                                        <span class="mr-2">NGÀY ĐK TRÊN HỆ THỐNG:</span>
                                        <span>
                                            <?php
                                            $iso8601String = $businessCreatedAt;
                                            $timestamp = strtotime($iso8601String);
                                            $formattedDate = date("d/m/Y ", $timestamp);
                                            echo $formattedDate;
                                            ?>
                                        </span>
                                    </p>
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
                                        <button id="addSportFieldBtn" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1 mb-1">
                                            Thêm Sân
                                        </button>
                                    </div>

                                    <hr class="mt-0">
                                    <div id="container-sportField">
                                        <?php foreach ($sportFields as $spf) : ?>
                                            <div id="sportField-<?php echo $spf['ID']; ?>">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="ellipsis mb-1 ">
                                                        Sân
                                                        <span id="display-typename-sportfield-<?php echo $spf['ID']; ?>">
                                                            <?php echo $spf['sport_type']['TypeName'] . " " .  $spf['FieldName']; ?>
                                                        </span>
                                                    </p>
                                                    <div>
                                                        <a href="../sportfield/detail/<?php echo $spf['ID']; ?>" class="btn btn-default border border-info shadow-sm mb-2" title="Chi Tiết Sân">
                                                            <i class="fa-sm fa-solid fa-eye text-info" style="min-width: 20px;"></i>
                                                        </a>
                                                        <a onclick="fillDataToEditForm(<?php echo $spf['ID']; ?>)" class="btn btn-default border border-warning shadow-sm mb-2" title="Cập Nhật Sân">
                                                            <i class="fa-sm fa-regular fa-pen-to-square text-warning" style="min-width: 20px;"></i>
                                                        </a>
                                                        <a onclick="destroySportField(<?php echo  $spf['ID']; ?>)" class="btn btn-default border-danger border shadow-sm mb-2" title="Xóa Sân">
                                                            <i class="fa-sm fa-solid fa-trash-can text-danger" style="min-width: 20px;"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <!-- //paginate -->
                                    <div class="d-flex justify-content-center" style="max-height: 50px">
                                        <nav>
                                            <ul class="pagination">
                                                <li class="page-item <?php echo $currentPage - 1 < 1 ? "d-none" : ''; ?>">
                                                    <a
                                                        class="page-link"
                                                        data-page=<?= $currentPage - 1 ?>>
                                                        Trước
                                                    </a>
                                                </li>
                                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                    <li class="page-item">
                                                        <a
                                                            class="page-link"
                                                            data-page=<?= $i ?>>
                                                            <?= $i ?>
                                                        </a>
                                                    </li>
                                                <?php endfor; ?>
                                                <li class="page-item <?php echo $currentPage + 1 > $totalPages ? "d-none" : ''; ?>">
                                                    <a
                                                        class="page-link"
                                                        data-page=<?= $currentPage + 1 ?>>
                                                        Sau
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>

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
    document.addEventListener('DOMContentLoaded', () => {
        // Lấy URL hiện tại
        const currentUrl = new URL(window.location.href);

        // Lấy tất cả các thẻ <a> với class "page-link"
        const pageLinks = document.querySelectorAll('.page-link');

        // Cập nhật giá trị href cho từng thẻ <a>
        pageLinks.forEach(link => {
            const page = link.getAttribute('data-page'); // Lấy số trang từ thuộc tính data-page
            const newUrl = new URL(currentUrl); // Tạo một đối tượng URL mới để sửa đổi

            // Xóa tham số page nếu có
            newUrl.searchParams.delete('page');

            // Thêm tham số page mới
            newUrl.searchParams.set('page', page);

            // Cập nhật thuộc tính href của thẻ <a>
            link.href = newUrl.toString();
        });
    })
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>