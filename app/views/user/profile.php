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
                        <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                        <h5 class="my-3"> <?php echo $_SESSION['userInfo']['FullName']; ?> </h5>
                        <p class="text-muted mb-1">Cầu thủ bóng đá</p>
                        <p class="text-muted mb-4">Thần tượng: Ronaldo, Messi</p>
                        <div class="d-flex justify-content-center mb-2">
                            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary">Follow</button>
                            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1">Message</button>
                        </div>
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
                                        <span class="text-primary font-italic me-1">Doanh Nghiệp: </span> <?php echo $_SESSION['userInfo']['BusinessName']; ?>
                                    </p>
                                    <p class="mb-1 ">Trạng thái:
                                        <span class="<?php echo $_SESSION['userInfo']['Status'] === 'ACTIVE' ? 'text-success' : 'text-danger'; ?>">
                                            <?php echo $_SESSION['userInfo']['Status']; ?> </span>
                                    </p>

                                    <p class="mt-4 mb-1 ">Địa Chỉ Doanh Nghiệp: <?php echo $_SESSION['userInfo']['BusinessAddress']; ?></p>

                                    <p class="mt-4 mb-1">SĐT: <?php echo $_SESSION['userInfo']['PhoneNumber']; ?></p>

                                    <p class="mt-4 mb-1">Ngày Đăng Ký Trên Hệ Thống:
                                        <?php
                                        // Chuỗi thời gian ISO 8601
                                        $iso8601String = $_SESSION['userInfo']['created_at'];

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
                                                <div class="d-flex justify-content-between align-items-center" >
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

<script>
    const destroySportField = (sportFieldID) => {

        Swal.fire({
            title: "Bạn Đã Chắc Chắn?",
            text: "Dữ Liệu Về Sân Sẽ Bị Xóa!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Xóa!",
            cancelButtonText: "Hủy"
        }).then(async (result) => {
            if (result.isConfirmed) {

                const destroySportFieldUrl = `${sportFieldUrl}/destroy/${sportFieldID}`;

                const response = await fetch(`${destroySportFieldUrl}`, {
                    method: 'POST',
                });

                const data = await response.json();

                if (data.statusCode === 204) {

                    Swal.fire({
                        title: "Xóa Thành Công!",
                        text: "Đã Xóa Sân.",
                        icon: "success"
                    });

                    //remove element sport fiele deleted
                    sportFieldElement = document.getElementById(`sportField-${sportFieldID}`);
                    sportFieldElement.remove();

                } else if (data.statusCode === 400) {
                    Swal.fire({
                        title: "Thất Bại!",
                        text: "Vui Lòng Kiểm Tra Lại Các Thông Tin, Hoặc Thử Lại Sau!",
                        icon: "error",
                        customClass: {
                            popup: 'my-custom-popup',
                            title: 'custom-error-title'
                        },
                    });
                } else {
                    Swal.fire({
                        title: "Thất Bại!",
                        text: "Lỗi Phía Server, Vui Lòng Liên Hệ QTV!",
                        icon: "error",
                        customClass: {
                            popup: 'my-custom-popup',
                            title: 'custom-error-title'
                        },
                    });
                }
            }
        });
    }
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>