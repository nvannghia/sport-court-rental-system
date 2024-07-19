<?php
require_once __DIR__ . '/../layouts/header.php';
?>


<?php if (isset($sportFields)) : ?>

    <section class="container">
        <div class="d-flex">
            <!-- //sport type -->
            <div class="mr-4 shadow p-3 bg-body rounded-bottom" style="min-width: 250px;max-height: 400px;background-color: #F9F9F9;">
                <h5 class="font-weight-bold" style="color: #19458A;">Thể loại sân</h5>
                <hr>
                <?php foreach ($sportTypes as $sportType) :
                    $color = '#19458A';
                    if ($_GET['sportType'] == $sportType['ID'])
                        $color = '#F9BC18';
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
                <div class="mt-3 mb-3">
                    <h2 class="font-weight-bold shadow p-3 bg-body rounded" style="color:#19458A; text-align:center">Danh sách sân bãi</h2>
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
                    if ($key % 3 == 2) :
                        echo '</div>';
                    endif;
                endforeach;
                ?>

            </div>
        </div>


    </section>
<?php endif; ?>

<script>
    const handleFilterBySportType = (evt, sportType) => {
        evt.preventDefault;

        // Create a new URLSearchParams object
        const urlParams = new URLSearchParams();
        // Add the new parameter
        urlParams.set('sportType', sportType);

        const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
        window.location.href = newUrl;

        // Save the typeName in localStorage to scroll to it after reload
        localStorage.setItem('scrollTo', 'view-sport-field');
    }

    // Scroll to the element after the page reloads
    window.addEventListener('load', () => {
        const scrollTo = localStorage.getItem('scrollTo');
        if (scrollTo) {
            const element = document.getElementById(scrollTo);
            if (element) {
                element.scrollIntoView({
                    behavior: 'smooth'
                });
            }
            // Remove the item from localStorage
            localStorage.removeItem('scrollTo');
        }
    });
</script>

<?php
require_once __DIR__ . '/../layouts/footer.php';
?>