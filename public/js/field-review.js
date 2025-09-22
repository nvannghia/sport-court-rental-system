const sport-court-rental-system/public/home/urlFieldReview = '/sport-court-rental-system/public/fieldreview';

//add review
document.addEventListener('DOMContentLoaded', (event) => {
    //Rating
    btnRating = document.getElementById('type-rating');
    btnRating.addEventListener('click', function (event) {

        const button = event.target;
        const sportFieldID = button.dataset.sportfieldId;
        if (sportFieldID === undefined) {
            Swal.fire({
                icon: "error",
                title: "Đã xảy ra lỗi...",
                text: "Vui lòng thử lại sau!",
            });
            return;
        }

        Swal.fire({
            input: "textarea",
            // inputLabel: "Nhập đánh giá của bạn",
            inputPlaceholder: "Nhập đánh giá ở đây...",
            html: `
            <div class="ml-2">
                <div id="contain-review-image-preview" style="display:none !important" class="mb-2 d-flex align-items-center">  
                    <label class="font-weight-bold mr-2"> Ảnh bạn đã chọn: </label>
                    <img style="width:300px" class="shadow  bg-white rounded" src="#" id="image-review-preview" alt="image review preview"/>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="rating-image"> Ảnh Sân </label>
                    <input type="file" class="form-control" id="rating-image">
                </div>
                <div class="input-group mb-2">
                    <select style="height:40px; width:45px" class="border rounded form-select" id="rating-star">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <label style="height:40px" class="bg-white input-group-text" for="rating-star">
                        <i class="text-warning fa-solid fa-star" style="font-size: large"></i>
                    </label>
                </div>
            </div>
        `,
            showCancelButton: true,
            confirmButtonText: "Gửi đánh giá",
            cancelButtonText: "Hủy",
            didOpen: () => {
                //show image file when user choose
                const imageReviewPreview = document.getElementById("image-review-preview");
                const inputFileImage = document.getElementById("rating-image");
                const containImageReviewPreview = document.getElementById("contain-review-image-preview");

                inputFileImage.addEventListener("change", function () {
                    imageReviewPreview.src = URL.createObjectURL(inputFileImage.files[0]);
                    if (containImageReviewPreview.style.display == "none")
                        containImageReviewPreview.style.removeProperty("display");
                });
                // Đặt ID cho phần tử textarea sau khi hộp thoại được mở
                const textarea = Swal.getInput();
                if (textarea) {
                    textarea.id = 'rating-content';
                }
            },
            preConfirm: () => {

                const ratingContent = document.getElementById('rating-content').value != '' ? document.getElementById('rating-content').value : null;
                const ratingStar = document.getElementById('rating-star').value ?? null;
                const ratingImage = document.getElementById('rating-image').files[0] ?? null;

                return new Promise((resolve, reject) => {
                    if (!ratingContent || !ratingStar) {
                        Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin.');
                        Swal.enableButtons();
                        reject();
                    } else {
                        resolve({
                            ratingContent,
                            ratingStar,
                            ratingImage
                        });
                    }
                });
            }
        }).then(async (result) => {

            if (result.isConfirmed) {
                const {
                    ratingContent,
                    ratingStar,
                    ratingImage
                } = result.value;

                if (!ratingContent || !ratingStar) {
                    Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin.');
                    return false;
                }

                // waiting - loading ...
                Swal.fire({
                    html: '<img src="/sport-court-rental-system/public/images/soccer.gif" width="100%" height="100%"/>',
                    background: 'rgba(255, 255, 255, 0)',
                    showConfirmButton: false,
                    allowOutsideClick: false
                })

                const formData = new FormData();
                formData.append('action', 'addFieldReview');
                formData.append('sportFieldID', sportFieldID);
                formData.append('ratingStar', ratingStar);
                formData.append('content', ratingContent);
                formData.append('imageReview', ratingImage);

                const addFieldReivewUrl = `${urlFieldReview}/addFieldReivew`;
                const response = await fetch(`${addFieldReivewUrl}`, {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (data.statusCode === 400) {
                    Swal.fire({
                        icon: "error",
                        title: "Đã xảy ra lỗi...",
                        text: data.message,
                    });
                } else if (data.statusCode === 500) {
                    Swal.fire({
                        icon: "error",
                        title: "Đã xảy ra lỗi...",
                        text: data.message,
                    });
                } else {
                    await Swal.fire({
                        title: 'Thành công!',
                        text: 'Đánh giá của bạn đã được tải lên!',
                        icon: 'success'
                    });

                    // reload-page
                    let pageActive = $('.active');
                    if (pageActive) {
                        let dataPage = pageActive.data('page');
                        loadPage(dataPage);
                    }
                }
            }
        });
    });
});

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



// like review
const likeReview = async (event, fieldReviewID) => {
    //  the like button
    const btnLike = document.getElementById(`btn-like-review-id-${fieldReviewID}`);
    btnLike.disabled = true;
    // number of like
    const numberLikeDisplay = document.getElementById(`number-like-id-${fieldReviewID}`);
    let numberLike = parseInt(numberLikeDisplay.innerText);

    // form data
    const formData = new FormData();
    formData.append('fieldReviewID', fieldReviewID);

    //change the icon
    const iconLike = document.getElementById(`icon-like-review-id-${fieldReviewID}`);

    if (iconLike.classList.contains('fa-solid')) { //liked
        iconLike.classList.remove('fa-solid');
        iconLike.classList.add('fa-regular');
        iconLike.classList.remove('text-white');
        // action descrease
        formData.append('action', 'descreaseReviewLike');
        // increase like on user interface
        numberLikeDisplay.innerText = --numberLike;
        // css for the button
        btnLike.classList.remove('btn_like');
    } else { //don't like yet
        iconLike.classList.add('fa-solid');
        formData.append('action', 'increaseReviewLike');
        numberLikeDisplay.innerText = ++numberLike;
        btnLike.classList.add('btn_like');

        // -- User recieve this notification
        const btn = document.getElementById(`btn-like-review-id-${fieldReviewID}`);
        const userIdRecieveNoti = btn.dataset.authorId;
        // -- Pusher notifications
        notifications("Đã thích bình luận của bạn", userIdRecieveNoti, "like");
    }

    const updateLikeReviewUrl = `${urlFieldReview}/updateLike`;

    const response = await fetch(`${updateLikeReviewUrl}`, {
        method: 'POST',
        body: formData
    });

    const data = await response.json();
    if (data.statusCode >= 400)
        Swal.fire({
            icon: "error",
            title: "Đã xảy ra lỗi...",
            text: data.message,
        });

    // enabled the like button
    btnLike.disabled = false;
}


//delete review
const deleteReview = async (fieldReviewID) => {
    Swal.fire({
        title: "Xóa đánh giá!",
        text: "Bạn đã chắc chắn muốn xóa đánh giá này?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Xóa",
        cancelButtonText: "Không",
    }).then(async (result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('action', 'deleteFieldReview');

            const deleteReviewUrl = `${urlFieldReview}/deleteFieldReview/${fieldReviewID}`;

            const response = await fetch(`${deleteReviewUrl}`, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.statusCode == 204) {
                Swal.fire({
                    title: 'Thành công!',
                    text: 'Đánh giá của bạn đã được xóa!',
                    icon: 'success'
                });

                //remove review at user interface
                let reviewDeleted = document.getElementById(`review-id-${fieldReviewID}`);
                reviewDeleted.remove();
                // reload page currrent
                let pageActive = $('.active');
                if (pageActive) {
                    let dataPage = pageActive.data('page');
                    loadPage(dataPage);
                }
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Đã xảy ra lỗi...",
                    text: 'Vui lòng thử lại sau!',
                });
            }
        }
    });
}



//============== edit review
const getFieldReviewByID = async (fieldReviewID) => {
    const getReviewUrl = `${urlFieldReview}/getFieldReviewByID/${fieldReviewID}`;

    const response = await fetch(`${getReviewUrl}`);

    const data = await response.json();

    if (data.statusCode === 200)
        return data.fieldReview;
    else {
        Swal.fire({
            icon: "error",
            title: "Đã xảy ra lỗi...",
            text: 'Vui lòng thử lại sau!',
        });
        return;
    }


}

const editReview = async (fieldReviewID) => {
    const fieldReview = await getFieldReviewByID(fieldReviewID);
    console.log(fieldReview);
    Swal.fire({
        input: "textarea",
        // inputLabel: "Nhập đánh giá của bạn",
        inputPlaceholder: "Nhập đánh giá ở đây...",
        html: `
        <div class="ml-2">
            <div id="contain-review-image-preview" style="${!fieldReview.ImageReview ? "display:none !important" : ""}" class="mb-2 d-flex align-items-center">  
                <label class="font-weight-bold mr-2"> Ảnh bạn đã chọn: </label>
                <img style="width:300px" class="shadow  bg-white rounded" src="${fieldReview.ImageReview}" id="image-review-preview" alt="image review preview"/>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="rating-image"> Ảnh Sân </label>
                <input type="file" class="form-control" id="rating-image">
            </div>
            <div class="input-group mb-2">
                <select style="height:40px; width:45px" class="border rounded form-select" id="rating-star">
                    <option value="1" ${fieldReview.Rating == 1 ? "selected" : ""}>1</option>
                    <option value="2" ${fieldReview.Rating == 2 ? "selected" : ""}>2</option>
                    <option value="3" ${fieldReview.Rating == 3 ? "selected" : ""}>3</option>
                    <option value="4" ${fieldReview.Rating == 4 ? "selected" : ""}>4</option>
                    <option value="5" ${fieldReview.Rating == 5 ? "selected" : ""}>5</option>
                </select>
                <label style="height:40px" class="bg-white input-group-text" for="rating-star">
                    <i class="text-warning fa-solid fa-star" style="font-size: large"></i>
                </label>
            </div>
        </div>
    `,
        showCancelButton: true,
        confirmButtonText: "Gửi đánh giá",
        cancelButtonText: "Hủy",
        didOpen: () => {
            //show image file when user choose
            const imageReviewPreview = document.getElementById("image-review-preview");
            const inputFileImage = document.getElementById("rating-image");
            const containImageReviewPreview = document.getElementById("contain-review-image-preview");

            inputFileImage.addEventListener("change", function () {
                imageReviewPreview.src = URL.createObjectURL(inputFileImage.files[0]);
                if (containImageReviewPreview.style.display == "none")
                    containImageReviewPreview.style.removeProperty("display");
            });
            // Đặt ID cho phần tử textarea sau khi hộp thoại được mở
            const textarea = Swal.getInput();
            if (textarea) {
                textarea.id = 'rating-content';
                textarea.value = fieldReview.Content;
            }
        },
        preConfirm: () => {

            const ratingContent = document.getElementById('rating-content').value != '' ? document.getElementById('rating-content').value : null;
            const ratingStar = document.getElementById('rating-star').value ?? null;
            const ratingImage = document.getElementById('rating-image').files[0] ?? null;

            return new Promise((resolve, reject) => {
                if (!ratingContent || !ratingStar) {
                    Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin.');
                    Swal.enableButtons();
                    reject();
                } else {
                    resolve({
                        ratingContent,
                        ratingStar,
                        ratingImage
                    });
                }
            });
        }
    }).then(async (result) => {
        if (result.isConfirmed) {
            const {
                ratingContent,
                ratingStar,
                ratingImage
            } = result.value;

            if (!ratingContent || !ratingStar) {
                Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin.');
                return false;
            }

            // waiting - loading ...
            Swal.fire({
                html: '<img src="/sport-court-rental-system/public/images/soccer.gif" width="100%" height="100%"/>',
                background: 'rgba(255, 255, 255, 0)',
                showConfirmButton: false,
                allowOutsideClick: false
            })

            const formData = new FormData();
            formData.append('action', 'updateFieldReview');
            formData.append('ratingStar', ratingStar);
            formData.append('content', ratingContent);
            formData.append('imageReview', ratingImage);

            const updateFieldReivewUrl = `${urlFieldReview}/updateFieldReview/${fieldReviewID}`;

            const response = await fetch(`${updateFieldReivewUrl}`, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.statusCode === 200) {
                await Swal.fire({
                    title: 'Thành công!',
                    text: 'Đánh giá của bạn đã được sửa và tải lên!',
                    icon: 'success'
                });
                //window reload and scroll to reviews view to see the new review
                localStorage.setItem('scrollTo', 'view-reviews');
                window.location.reload();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Đã xảy ra lỗi...",
                    text: data.message,
                });
            }
        }
    });
}




// pagination review
document.addEventListener('DOMContentLoaded', () => {
    // get current url
    const currentUrl = new URL(window.location.href);

    // get all <a> tags have class "page-link"
    const pageLinks = document.querySelectorAll('.page-link');

    // update href for each <a> tag
    pageLinks.forEach(link => {
        const page = link.getAttribute('data-page');
        const newUrl = new URL(currentUrl);

        // delete `page` param
        newUrl.searchParams.delete('page');

        // add new `page` param
        newUrl.searchParams.set('page', page);

        // update href attribute of <a> tag
        link.href = newUrl.toString();
    });
});

