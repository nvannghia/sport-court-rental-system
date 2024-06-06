<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Sport Court Rental System</title>

    <!-- bs 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="../../public/css/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">

    <!-- font awesome style -->
    <link href="../../public/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- nice select -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />

    <!-- Custom styles for this template -->
    <link href="../../public/css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="../../public/css/responsive.css" rel="stylesheet" />
    <!-- custom sweet alert css -->
    <link href="../../public/css/custom-sweet-alert.css" rel="stylesheet" />
    <!-- header css -->
    <link href="../../public/css/header.css" rel="stylesheet" />
</head>

<body>

    <div class="hero_area">
        <!-- header section strats -->
        <header class="header_section">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="navbar-brand" href="index.html">
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
                                <a class="nav-link" href="index.html">Trang chủ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.html"> Về chúng tôi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="job.html">Công việc</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="freelancer.html">Tự do làm việc</a>
                            </li>
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
                                        <button style="background-color: #E41A2B" class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-user text-white" style="min-width: 15%;"></i>
                                            <span class="text-white">
                                                <?php echo $_SESSION['userInfo']['FullName']; ?>
                                            </span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <div class="dropdown-item" href="#" onclick="getProfile()">
                                                <i class="fa-solid fa-id-card" style="min-width: 20%;"></i>
                                                <span>Hồ sơ</span>
                                            </div>
                                            <div class="dropdown-item" href="#">
                                                <i class="fa-regular fa-building" style="min-width: 20%;"></i>
                                                <span> Bạn là chủ sân?</span>
                                            </div>
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
        <!-- end header section -->

        <!-- slider section -->
        <section class="slider_section ">
            <div class="container ">
                <div class="row">
                    <div class="col-lg-7 col-md-8 mx-auto">
                        <div class="detail-box">
                            <img src="../../public/images/soccer.gif" alt="gif" style="width: 25%;">

                            <h1>
                                HỆ THỐNG HỖ TRỢ TÌM KIẾM SÂN BÃI NHANH
                            </h1>
                            <p>
                                Dữ liệu được hệ thống SPORT COURT RENTAL cập nhật thường xuyên giúp cho người dùng tìm được sân một cách nhanh nhất
                            </p>
                        </div>
                    </div>
                </div>
                <div class="find_container ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <form>
                                    <div class="form-row ">

                                        <div class="form-group col-lg-3">
                                            <select name="" class="form-control wide" id="inputDoctorName">
                                                <option value="Normal distribution ">Thể loại sân</option>
                                                <option value="Normal distribution ">Sân bóng đá </option>
                                                <option value="Normal distribution ">Sân tennis</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <input type="text" class="form-control" id="inputPatientName" placeholder="Nhập tên sân hoặc địa chỉ">
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <input type="text" class="form-control" id="inputPatientName" placeholder="Nhập khu vực">
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <div class="btn-box">
                                                <button type="submit" class="btn ">Tìm sân</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- <ul class="job_check_list">
              <li class=" ">
                <input id="checkbox_qu_01" type="checkbox" class="styled-checkbox">
                <label for="checkbox_qu_01">
                  Freelancer
                </label>
              </li>
              <li class=" ">
                <input id="checkbox_qu_02" type="checkbox" class="styled-checkbox">
                <label for="checkbox_qu_02">
                  Part Time
                </label>
              </li>
              <li class=" ">
                <input id="checkbox_qu_03" type="checkbox" class="styled-checkbox">
                <label for="checkbox_qu_03">
                  Full Time
                </label>
              </li>
            </ul> -->
                    </div>
                </div>
            </div>
        </section>
        <!-- end slider section -->

        <!-- category section -->
        <section class="category_section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-xl-2 px-0">
                        <a href="#" class="box">
                            <div class="img-box">
                                <img src="../../public/images/c1.png" alt="">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    Bóng đá
                                </h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-2 px-0">
                        <a href="#" class="box">
                            <div class="img-box">
                                <img src="../../public/images/c2.png" alt="">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    Tennis
                                </h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-2 px-0">
                        <a href="#" class="box">
                            <div class="img-box">
                                <img src="../../public/images/c3.png" alt="">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    Bóng chuyền
                                </h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-2 px-0">
                        <a href="#" class="box">
                            <div class="img-box">
                                <img src="../../public/images/c4.png" alt="">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    Golf
                                </h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-2 px-0">
                        <a href="#" class="box">
                            <div class="img-box">
                                <img src="../../public/images/c5.png" alt="">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    Cầu lông
                                </h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-2 px-0">
                        <a href="#" class="box">
                            <div class="img-box">
                                <img src="../../public/images/c6.png" alt="">
                            </div>
                            <div class="detail-box">
                                <h5>
                                    Bóng bàn
                                </h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- end category section -->