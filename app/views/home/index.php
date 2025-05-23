<?php
require_once __DIR__ . '/../layouts/header.php';
?>
<link rel="stylesheet" type="text/css" href="/sport-court-rental-system/public/css/table.css" />

<?php if (isset($sportFields)) : ?>

    <section class="">
        <div class="d-flex">
            <!-- //sport type -->
            <div class=" p-3 bg-body" style="min-width: 250px;max-height: 400px;background-color: white;">
                <h5 class="font-weight-bold" style="color: #19458A; margin-top: 14px">THỂ LOẠI</h5>
                <hr>
                <?php foreach ($sportTypes as $sportType) :
                    $color = '#19458A';
                    if ($_GET['sportType'] == $sportType['ID'])
                        $color = 'rgb(228, 26, 43)';
                ?>
                    <div class="d-flex border-bottom mb-3">
                        <a onclick="handleFilterBySportType(this, <?= $sportType['ID']; ?>)" class="sporttype-hover">
                            <p style="color: <?= $color; ?>">
                                <?= $sportType['TypeName']; ?>
                            </p>

                        </a>
                        <hr>
                        <p style="color: <?= $color; ?>">
                            <?= $sportType['sport_fields_count']; ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- //sport field -->
            <div class="w-100" id="view-sport-field">
                <div class="mb-3">
                    <h2 class="font-weight-bold p-3 bg-body bg-white" style="color:#19458A; text-align:center">DANH SÁCH SÂN BÃI</h2>
                    <hr>
                </div>
                <?php foreach ($sportFields as $key => $sportField) :
                    if ($key % 3 == 0) :
                        echo '<div class="row mb-3">';
                    endif;
                ?>
                    <div class="col-sm-12 col-md-6 col-lg-4 shadow-hover">
                        <div class="card shadow-sm bg-body">
                            <div class="image-container">
                                <?php if ($sportField['Image']) : ?>
                                    <img class="card-img-top " style=" height: 200px; object-fit: cover;" src="<?= $sportField['Image']; ?>" alt="Sport Field image">
                                <?php else : ?>
                                    <img class="card-img-top" style=" height: 200px; object-fit: cover;" src="../../public/images/sport-representation.jpg" alt="Sport Field image">
                                <?php endif; ?>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title overflow-hidden" style="color:#19458A">
                                    <b>
                                        Sân
                                        <?= $sportField['FieldName']; ?>
                                    </b>
                                </h5>
                                <p class="card-text text-secondary">
                                    <i class="fa-solid fa-mobile"></i>
                                    <span class="overflow-hidden">
                                        <?= str_replace('+84', '0', $sportField['owner']['PhoneNumber']); ?>
                                        -
                                        <?= $sportField['owner']['FullName']; ?>
                                    </span>
                                </p>
                                <p class="card-text text-secondary overflow-hidden">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>
                                        <?= $sportField['Address']; ?>
                                    </span>
                                </p>
                                <div class="text-center">
                                    <a href="/sport-court-rental-system/public/sportfield/detail/<?= $sportField['ID']; ?>" id="btnDetail" style="background-color: #123366;" class=" btnDetail w-50 text-white btn ">
                                        <b>Chi tiết</b>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php
                    if ($key % 3 == 2 || $key == count($sportFields) - 1) :
                        echo '</div>';
                    endif;
                endforeach;
                ?>

                <!-- //paginate -->
                <div class="d-flex justify-content-center">
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
    </section>
<?php endif; ?>

<!-- //home.js -->
<script src="/sport-court-rental-system/public/js/home.js"></script>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>