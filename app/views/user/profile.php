<?php
$hiddenSliderSection = true;
$hiddenCategory = true;
require_once __DIR__ . '/../layouts/header.php';
?>
<section style="background-color: #1E286A;">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active h5 font-weight-bold" style="color:#3b5998" aria-current="page">Thông tin khách hàng</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row" id="infoView">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">

                        <?php
                        if (!empty($_SESSION['userInfo']['Avatar'])) {

                            $avatarUrl = $_SESSION['userInfo']['Avatar'];
                            echo '<img id="userAvatar" src="' . $avatarUrl . '" class="shadow bg-body rounded-circle img-fluid" style="width: 200px; height: 200px; object-fit:cover;" alt="User Avatar Loading ...">';
                        } else {

                            echo '<img id="userAvatar" src="../../public/images/user.jpg" alt="User Avatar Loading ..." class="shadow bg-body rounded-circle img-fluid" style="width: 200px; height:200px; object-fit:cover;">';
                        }
                        ?>

                        <div class="d-flex justify-content-center mb-2">
                            <button type="button" onclick="uploadUserAvatar()" id="uploadBtn" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1 mt-2"> Cập Nhật </button>
                            <input type="file" id="fileInput" name="avatarFile" style="display: none;" accept="image/*">
                        </div>
                        <h5 class="my-3"> <?php echo $_SESSION['userInfo']['FullName']; ?> </h5>
                        <p class="text-muted mb-1">Cầu thủ bóng đá</p>
                        <p class="text-muted mb-4">Thần tượng: Ronaldo, Messi</p>
                    </div>
                </div>
                <div class="card mb-4 mb-lg-0">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush rounded-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <i class="fas fa-globe fa-lg text-warning"></i>
                                <p class="mb-0">https://mdbootstrap.com</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <i class="fab fa-github fa-lg text-body"></i>
                                <p class="mb-0">mdbootstrap</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                                <p class="mb-0">@mdbootstrap</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                                <p class="mb-0">mdbootstrap</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                                <p class="mb-0">mdbootstrap</p>
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
                                <p class="text-muted mb-0"> <?php echo $_SESSION['userInfo']['Role']; ?></p>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Họ & Tên</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"> <?php echo $_SESSION['userInfo']['FullName']; ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"> <?php echo $_SESSION['userInfo']['Email']; ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">SĐT</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">(<?php echo substr($_SESSION['userInfo']['PhoneNumber'], 0, 3); ?> ) <?php echo substr($_SESSION['userInfo']['PhoneNumber'], 3) ?> </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Địa chỉ</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"> <?php echo $_SESSION['userInfo']['Address']; ?> </p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($_SESSION['userInfo']['Role'] === 'OWNER') : ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                                <div class="card-body">
                                    <p class="mb-4 h4 shadow p-2">
                                        <span class="text-primary font-italic me-1">Doanh Nghiệp: </span> <?php echo $_SESSION['userInfo']['field_owner']['BusinessName']; ?>
                                    </p>
                                    <p class="mb-1 ">Trạng thái:
                                        <span class="<?php echo $_SESSION['userInfo']['field_owner']['Status'] === 'ACTIVE' ? 'text-success' : 'text-danger'; ?>">
                                            <?php echo $_SESSION['userInfo']['field_owner']['Status']; ?> </span>
                                    </p>

                                    <p class="mt-4 mb-1 ">Địa Chỉ Doanh Nghiệp: <?php echo $_SESSION['userInfo']['field_owner']['BusinessAddress']; ?></p>

                                    <p class="mt-4 mb-1">SĐT: <?php echo $_SESSION['userInfo']['field_owner']['PhoneNumber']; ?></p>

                                    <p class="mt-4 mb-1">Ngày Đăng Ký Trên Hệ Thống:
                                        <?php
                                        // Chuỗi thời gian ISO 8601
                                        $iso8601String = $_SESSION['userInfo']['field_owner']['created_at'];

                                        // Chuyển đổi chuỗi thời gian thành timestamp
                                        $timestamp = strtotime($iso8601String);

                                        // Định dạng ngày giờ
                                        $formattedDate = date("H:i:s  m-d-Y ", $timestamp);

                                        echo $formattedDate;

                                        ?>
                                    </p>
                                </div>
                                <button id="addSportFieldBtn" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1 mb-1">
                                    Thêm Sân
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6" id="viewManageField">
                            <div class="card mb-4 mb-md-0">
                                <div class="card-body">
                                    <p class="mb-4"><span class="font-weight-bold h5 text-center shadow p-2">Quản Lý Sân </p>
                                    <div id="container-sportField">
                                        <?php foreach ($sportFields as $spf) : ?>
                                            <div id="sportField-<?php echo $spf['ID']; ?>">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class=" ellipsis mb-1 ">
                                                        Sân
                                                        <span id="display-typename-sportfield-<?php echo $spf['ID']; ?>">
                                                            <?php echo $spf['sport_type']['TypeName'] . " " .  $spf['FieldName']; ?>
                                                        </span>
                                                    </p>
                                                    <div>
                                                        <a href="../sportfield/detail/<?php echo $spf['ID']; ?>" class="btn btn-default border border-info shadow-sm mb-2" title="Chi Tiết Sân">
                                                            <i class="fa-solid fa-eye text-info" style="min-width: 20px;"></i>
                                                        </a>
                                                        <a onclick="fillDataToEditForm(<?php echo $spf['ID']; ?>)" class="btn btn-default border border-warning shadow-sm mb-2" title="Cập Nhật Sân">
                                                            <i class="fa-regular fa-pen-to-square text-warning" style="min-width: 20px;"></i>
                                                        </a>
                                                        <a onclick="destroySportField(<?php echo  $spf['ID']; ?>)" class="btn btn-default border-danger border shadow-sm mb-2" title="Xóa Sân">
                                                            <i class="fa-solid fa-trash-can text-danger" style="min-width: 20px;"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        <?php endforeach; ?>
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

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>