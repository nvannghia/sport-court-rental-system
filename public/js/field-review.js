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

            const formData = new FormData();
            formData.append('action', 'addFieldReview');
            formData.append('sportFieldID', sportFieldID);
            formData.append('ratingStar', ratingStar);
            formData.append('content', ratingContent);
            formData.append('imageReview', ratingImage);

            const addFieldReivewUrl = `../../fieldreview/addFieldReivew`;

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
                 Swal.fire({
                    title: 'Thành công!',
                    text: 'Đánh giá của bạn đã được tải lên!',
                    icon: 'success'
                });
            }
        }
    });
});