<?php
$hiddenSliderSection = true;
$hiddenCategory = true;
require_once __DIR__ . '/../layouts/header.php';
?>
<section style="background-color: #1E286A;" >
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
                                    <p class="mb-4 h4">
                                        <span class="text-primary font-italic me-1 h5">Doanh Nghiệp: </span> <?php echo $_SESSION['userInfo']['BusinessName']; ?>
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
                        <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                                <div class="card-body">
                                    <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status
                                    </p>
                                    <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                                    <div class="progress rounded mb-2" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- add  sport field form -->
                <div id="formContainer" class="d-none" style="background-color:coral; padding: 10px; border-radius:4px">
                    <form id="addSportFieldForm" class=" mt-3" method="POST" action="../sportfield/storeSportField" enctype="multipart/form-data">
                        <div class="form-group d-flex flex-wrap justify-content-between">
                            <label for="sportFieldName" class="text-white">Tên Sân</label>
                            <button class="btn btn-outline-primary ms-1 mb-1 text-white" type="button" onclick="hiddenForm()" > Ẩn Form </button>
                            <input type="text" class="form-control" id="sportFieldName" name="sportFieldName">
                        </div>
                        <div class="form-group" style="margin-top: -6px;">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div>
                                    <label for="pricePerHour" class="text-white">Giá Mỗi Giờ</label>
                                    <input type="text" class="form-control" id="pricePerHour" name="pricePerHour">
                                </div>
                                <div>
                                    <label for="status" class="text-white">Trạng Thái</label>
                                    <input type="text" class="form-control" id="status" name="status">
                                </div>
                                <div>
                                    <label for="numberOfField" class="text-white">Số Lượng Sân</label>
                                    <input type="text" class="form-control" id="numberOfField" name="numberOfField">
                                </div>

                                <div class="d-flex justify-content-center w-100 mt-3">
                                    <div class="form-group">
                                        <label for="sportTypeID" class="text-white">Thể Loại Sân</label>
                                        <br>
                                        <select class="form-control" id="sportTypeID" name="sportTypeID">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: -50px;">
                            <label for="address" class="form-label text-white">Địa chỉ</label>
                            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label text-white">Mô Tả</label>
                            <textarea class="form-control" id="default" name="description" name="description"></textarea>
                        </div>
                        <button id="" type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1 mb-1 text-white">
                            Thêm
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<?php require_once __DIR__ . '/../layouts/footer.php'; ?>