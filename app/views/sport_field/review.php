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
                        <select name="cars" id="cars">
                            <option>Sắp xếp theo</option>
                            <option value="volvo">Mới nhất</option>
                            <option value="saab">Thấp đến cao</option>
                            <option value="mercedes">Cao đến thấp</option>
                        </select>

                    </div>
                </div>
            </div>

            <!-- //type a rating -->
            <div class="border-bottom  d-flex justify-content-center align-items-center">
                <i class="fa-solid fa-feather-pointed mr-2" style="font-size: 26px; color: #E41A2B;"></i>
                <button id="type-rating" data-sportfield-id="<?= $sportField['ID']; ?>"  style="background-color: #E41A2B;" class=" mt-2 mb-2 btn text-white">Nhập đánh giá</button>
            </div>

            <!-- reviews -->
            <div id="view-reviews" >
                <!-- //each review -->
                <?php
                $reviews = $sportField['field_reviews'];

                if (count($reviews) > 0) :
                ?>
                    <?php foreach ($reviews as $review) :  ?>
                        <div class="ml-3 mt-3" id="review-id-<?= $review['ID'] ?>">
                            <!-- //number of star -->
                            <div class="">
                                <?php
                                $rating = $review['Rating'];
                                $notRating = 5 - $rating;
                                ?>
                                <?php for ($i = 1; $i <= $rating; $i++) : ?>
                                    <i class="text-warning fa-solid fa-star"></i>
                                <?php endfor; ?>

                                <?php for ($j = 1; $j <= $notRating; $j++) : ?>
                                    <i class="fa-solid fa-star" style="color: #b0acac"></i>
                                <?php endfor; ?>
                            </div>
                            <!-- // name of user review -->
                            <div class="mt-2" style="color: #878787">
                                <?= $review['user']['FullName']; ?>
                            </div>
                            <!-- // content of review -->
                            <div class="mt-2" style="font-size: small">
                                <!-- //content -->
                                <span>
                                    <?= $review['Content']; ?>
                                </span>

                                <!-- //image review -->
                                <?php if ($review['ImageReview']) : ?>
                                    <div class="mr-2">
                                        <img src="<?= $review['ImageReview'] ?>" style="max-height: 150px;" class="border rounded" alt=" field image review">
                                    </div>

                                <?php endif; ?>
                            </div>
                            <hr>

                            <!-- //number of like -->
                            <div class="mt-2 d-flex align-items-center justify-content-between">
                                <div>
                                    <button onclick="likeReview(<?= $review['ID'] ?>)" id="btn-like-review" class="btn btn-warning border rounded" style="min-width: 40px; min-height: 40px;" title="Hữu ích">
                                        <i id="icon-like-review-id-<?= $review['ID'] ?>" class="
                                        <?php
                                        if (isset($_SESSION['userInfo']))
                                            echo in_array($_SESSION['userInfo']['ID'], $review['users_liked_review']) ? 'text-primary' : 'text-white';
                                        ?> 
                                        fa-regular 
                                        fa-thumbs-up 
                                        like-hover
                                        ">
                                        </i>
                                    </button>
                                    <span class="mt-2 ml-2" id="number-like-id-<?= $review['ID'] ?>">
                                        <?= count($review['users_liked_review']) > 0 ? count($review['users_liked_review']) : 0; ?>
                                    </span>
                                </div>

                                <!-- //edit and delete review action -->
                                <?php if (isset($_SESSION['userInfo']) && $_SESSION['userInfo']['ID'] == $review['user']['ID']) : ?>
                                    <div class="mr-2">
                                        <button onclick="editReview(<?= $review['ID'] ?>)" name="btn-edit-review" class="btn btn-info" title="Sửa đánh giá">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <button onclick="deleteReview(<?= $review['ID'] ?>)" name="btn-delete-review" class="btn btn-danger" title="Xóa đánh giá">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>

                            </div>
                            <hr style="border: 1px solid #787474">
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div style="padding: 8px; text-align: center;">
                        <span style="text-align: center;font-size: 22px;">Chưa có đánh giá nào!</span>
                    </div>
                <?php endif; ?>


            </div>
        </div>
        <!-- <div>
                        sadass
                    </div> -->
    </div>
</div>