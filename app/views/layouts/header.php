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