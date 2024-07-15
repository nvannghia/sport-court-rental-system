<div class="mt-3 bg-white border shadow" style="border-radius: 0 4px 4px 0;">
                <div >
                    <div >
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
                                                    <i style = "        
                                                        background: linear-gradient(to right, #FFC107 <?= $oddPercent ?>0%, #B0ACAC 20%);
                                                        -webkit-background-clip: text;
                                                        -webkit-text-fill-color: transparent;
                                                        display: inline-block;
                                                        font-size: 25px;
                                                        " 
                                                        class="text-warning fa-solid fa-star"
                                                    >
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
                        <div class="border-bottom text-center">
                            <button id="type-rating" data-sportfield-id="<?= $sportField['ID']; ?>" class="mt-2 mb-2 btn btn-primary">Nhập đánh giá</button>
                        </div>

                        <!-- reviews -->
                        <div>
                            <!-- //each review -->
                             <?php
                             $reviews = $sportField['field_reviews'];
                             if (count($reviews) > 0):
                            ?>
                            <?php foreach($reviews as $review): ?>
                                    <div class="ml-3 mt-3">
                                        <!-- //number of star -->
                                        <div class="">
                                            <?php
                                            $rating = $review['Rating'];
                                            $notRating = 5 - $rating;
                                            ?>
                                            <?php for($i = 1 ; $i <= $rating; $i++): ?>
                                                <i class="text-warning fa-solid fa-star"></i>
                                            <?php endfor; ?>

                                            <?php for($j = 1 ; $j <= $notRating; $j++): ?>
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
                                             <?php if ($review['ImageReview']): ?>
                                                <img src="<?= $review['ImageReview'] ?>" style="max-height: 150px;" alt="field image review">
                                            <?php endif; ?>
                                        </div>
                                        <!-- //number of like -->
                                        <div class="mt-2">
                                            <i class="fa-regular fa-thumbs-up"></i>
                                            <span class="mt-2 ml-2">5</span>
                                        </div>
                                        <hr>
                                    </div>
                            <?php endforeach; ?>
                            <?php else: ?>
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