<style>
    .btn_like {
        color: #fff;
        background-color: rgb(75, 153, 237);
    }
</style>
<div class="mt-3 bg-white border shadow" style="border-radius: 0 4px 4px 0;">
    <div>
        <div>
            <div>
                <!-- //total ratings -->
                <div class="ml-2">
                    <div class="h3">
                        <span class="font-weight-bold"><?= $averagePoint; ?></span>
                        <sub style="font-size: 30px; color: #9E9E9E">/ 5</sub>
                    </div>
                    <div class="star mt-3 d-flex flex-column">
                        <span>

                            <?php
                            $remainingStars = 5 - ceil($averagePoint);

                            $oddPercent = $averagePoint * 10 % 10;

                            for ($i = 1; $i <= $averagePoint; $i++) :
                            ?>
                                <i style="font-size: 25px;" class="text-warning fa-solid fa-star">
                                </i>
                                <?php
                                if ($oddPercent != 0) : //if $averageStars isn't a integer number
                                    if ($i + 1 > $averagePoint) :
                                ?>
                                        <i style="        
                                                        background: linear-gradient(to right, #FFC107 <?= $oddPercent ?>0%, #B0ACAC 20%);
                                                        -webkit-background-clip: text;
                                                        -webkit-text-fill-color: transparent;
                                                        display: inline-block;
                                                        font-size: 25px;
                                                        " class="text-warning fa-solid fa-star">
                                        </i>
                            <?php
                                    endif;
                                endif;
                            endfor;
                            ?>

                            <?php for ($i = 1; $i <= $remainingStars; $i++) : ?>
                                <i class="fa-solid fa-star" style="font-size: 25px; color: #B0ACAC"></i>
                            <?php endfor; ?>
                        </span>
                        <span class="mt-2"><?= $totalReviews; ?> đánh giá</span>
                    </div>
                </div>
                <hr>
                <!-- // ratings star percent -->
                <div>
                    <div class="d-flex">
                        <div class="d-flex justify-content-around align-items-start" style="min-width: 45%; max-height: 20px; font-size: 20px;">
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class="text-warning fa-solid fa-star"></i>
                        </div>
                        <div class="w-100 ml-2 mr-2">
                            <div style="background-color: #b0acac ;max-height: 20px;">
                                <div style="width: <?= $percents[4]; ?>%; max-height: 20px;" class="bg-warning">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mt-2">
                        <div class="d-flex justify-content-around align-items-start" style="min-width: 45%; max-height: 20px; font-size: 20px;">
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class="fa-solid fa-star" style="color: #b0acac"></i>
                        </div>
                        <div class="w-100 ml-2 mr-2">
                            <div style="background-color: #b0acac ;max-height: 20px;">
                                <div style="width: <?= $percents[3]; ?>%; max-height: 20px;" class="bg-warning">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mt-2">
                        <div class="d-flex justify-content-around align-items-start" style="min-width: 45%; max-height: 20px; font-size: 20px;">
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class=" fa-solid fa-star" style="color: #b0acac"></i>
                            <i class=" fa-solid fa-star" style="color: #b0acac"></i>
                        </div>
                        <div class="w-100 ml-2 mr-2">
                            <div style="background-color: #b0acac ;max-height: 20px;">
                                <div style="width: <?= $percents[2]; ?>%; max-height: 20px;" class="bg-warning">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mt-2">
                        <div class="d-flex justify-content-around align-items-start" style="min-width: 45%; max-height: 20px; font-size: 20px;">
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class=" fa-solid fa-star" style="color: #b0acac"></i>
                            <i class=" fa-solid fa-star" style="color: #b0acac"></i>
                            <i class=" fa-solid fa-star" style="color: #b0acac"></i>
                        </div>
                        <div class="w-100 ml-2 mr-2">
                            <div style="background-color: #b0acac ;max-height: 20px;">
                                <div style="width: <?= $percents[1]; ?>%; max-height: 20px;" class="bg-warning">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mt-2 mb-2">
                        <div class="d-flex justify-content-around align-items-start" style="min-width: 45%; max-height: 20px; font-size: 20px;">
                            <i class="text-warning fa-solid fa-star"></i>
                            <i class=" fa-solid fa-star" style="color: #b0acac"></i>
                            <i class=" fa-solid fa-star" style="color: #b0acac"></i>
                            <i class=" fa-solid fa-star" style="color: #b0acac"></i>
                            <i class=" fa-solid fa-star" style="color: #b0acac"></i>
                        </div>
                        <div class="w-100 ml-2 mr-2">
                            <div style="background-color: #b0acac ;max-height: 20px;">
                                <div style="width: <?= $percents[0]; ?>%; max-height: 20px;" class="bg-warning">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <hr> -->


                <!-- // filter ratings -->
                <div class="d-flex justify-content-between border-top border-bottom">
                    <div class="p-3">
                        Các đánh giá
                    </div>
                    <div class="d-flex align-items-center border-left p-3">
                        <i class="fa-solid fa-sort mr-2"></i>
                        <select onchange="sortReviews(this)">
                            <option disabled selected value>Sắp xếp theo</option>
                            <option value="">Mới nhất</option>
                            <option value="asc">Thấp đến cao</option>
                            <option value="desc">Cao đến thấp</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- //type a rating -->
            <?php if (isset($_SESSION['userInfo'])): ?>
                <div class="border-bottom  d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-feather-pointed mr-2" style="font-size: 26px; color: #E41A2B;"></i>
                    <button id="type-rating" data-sportfield-id="<?= $sportFieldId; ?>" style="background-color: #E41A2B;" class="mt-2 mb-2 btn text-white">Nhập đánh giá</button>
                </div>
            <?php else: ?>
                <div class="border-bottom  d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-feather-pointed mr-2" style="font-size: 26px; color: #E41A2B;"></i>
                    <button onclick="handleLogin()" style="background-color: #E41A2B;" class="mt-2 mb-2 btn text-white">Đăng nhập để đánh giá</button>
                </div>
            <?php endif; ?>

            <!-- reviews -->
            <div id="view-reviews">

                <div class="container" id="review-container">
                </div>

                <!-- PAGINATION -->
                <nav class="d-flex justify-content-center mt-3">
                    <ul id="pagination" class="pagination">
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script>
    var API_URL_PAGINATION = "/sport-court-rental-system/public/fieldreview/getReviewPagination?sportFieldId=<?= $sportFieldId ?>";
    const TYPE_CONFIG_PAGINATION = "review_template";

    //sort review by created_at, rating-desc, rating-acs
    const sortReviews = (evt) => {
        let orderBy = evt.value;
        // change the url call pagination and pass param to url
        API_URL_PAGINATION = `/sport-court-rental-system/public/fieldreview/getReviewPagination?sportFieldId=<?= $sportFieldId ?>&orderBy=${orderBy}`;
        loadPage(1);
    }
</script>
<script src="/sport-court-rental-system/public/js/paginate.js"></script>