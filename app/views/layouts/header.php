<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>
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
    <link rel="stylesheet" type="text/css" href="/sport-court-rental-system/public/css/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">

    <!-- font awesome style -->
    <link href="/sport-court-rental-system/public/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- nice select -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />

    <!-- Custom styles for this template -->
    <link href="/sport-court-rental-system/public/css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="/sport-court-rental-system/public/css/responsive.css" rel="stylesheet" />
    <!-- custom sweet alert css -->
    <link href="/sport-court-rental-system/public/css/custom-sweet-alert.css" rel="stylesheet" />
    <!-- header css -->
    <link href="/sport-court-rental-system/public/css/header.css" rel="stylesheet" />
    <!-- sweet alert animate -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- swiperjs.com -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- swiperjs.com -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- jQery -->
    <script src="/sport-court-rental-system/public/js/jquery-3.4.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        .swiper {
            width: 100%;
            height: 470px;
        }

        /* //... for overflow */
        .ellipsis {
            max-width: 150px;
            /* Điều chỉnh độ rộng của phần tử theo ý muốn */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 5px;
            /* Thêm khoảng cách bên trong */
        }

        .ellipsis_social_link {
            max-width: 250px;
            /* Điều chỉnh độ rộng của phần tử theo ý muốn */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 5px;
            /* Thêm khoảng cách bên trong */
        }

        .ellipsis_user_comment {
            max-width: 500px;
            max-height: 4em;
            line-height: 1.5em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            padding: 5px;
        }


        /* //sweet alert custom  */
        .custom-success-title {
            color: #A5DC86
        }


        .custom-error-title {
            color: #FF5252
        }

        .overflow-hidden {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        /* // image hover effect */
        .image-container {
            position: relative;
            display: inline-block;
            overflow: hidden;
        }

        .image-container img {
            transition: transform 0.3s ease-in-out;
        }

        .image-container:hover img {
            transform: scale(1.5);
        }

        /* // sport type hover effect */
        .sporttype-hover:hover p {
            color: #e3192a !important;
        }

        .sporttype-hover:hover~p {
            color: #e3192a !important;
        }



        /* //button effect */
        .btnDetail:hover {
            width: 60% !important;
            transform: scale(1);
            transition: transform 0.5s ease-in-out;
        }

        .custom-button {
            color: #123366;
        }

        .custom-button:hover {
            color: white;
        }

        /* //shadow effect */
        .shadow-hover:hover {
            padding: 0;
            box-shadow: 12px 6px rgba(25, 69, 138);
            transition: box-shadow 0.5s ease-in-out;
        }

        /* //like hover */
        .like-hover:hover {
            transform: scale(1.5);
            transition: transform 0.1s ease-in-out;
        }

        body.swal2-shown>[aria-hidden='true'] {
            transition: 0.1s filter;
            filter: blur(10px);
        }

        .breadcrumb-item.active {
            color: #3b5998;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding: 10px 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #f0f4f8;
            transition: all 0.3s ease;
        }

        .breadcrumb-item.active:hover {
            background-color: #e1e9f3;
            color: #2d4373;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
    </style>

</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        <?php isset($hiddenHeaderSection) && $hiddenHeaderSection == true ? null : require_once 'header_section.php'; ?>
        <!-- end header section -->

        <!-- slider section -->
        <?php isset($hiddenSliderSection) && $hiddenSliderSection == true ? null : require_once 'slider_section.php'; ?>
        <!-- end slider section -->

        <!-- category section -->
        <?php isset($hiddenCategory) && $hiddenCategory == true ? null : require_once 'category_section.php'; ?>
        <!-- end category section -->