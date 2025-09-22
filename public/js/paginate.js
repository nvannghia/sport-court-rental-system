
const configPagination = {
    sport_field_template: {
        container: '#list-sport-field',
        render: (item) => `
            <div id="sportField-<?php echo $spf['ID']; ?>">
                <div class="d-flex justify-content-between align-items-center position-relative">
                    <div class="mb-1 d-flex justify-content-between align-items-center">
                        <div class="d-flex rounded" style="background-color: #e41a2b;">
                            <img
                                width  = "34px"
                                height = "32px"
                                alt    = "sport_type_image"
                                src    = "${SPORT_FIELD_INFO[item.SportTypeID][0]}"
                                title  = "${SPORT_FIELD_INFO[item.SportTypeID][1]}"
                            />
                        </div>
                        <span id="display-typename-sportfield-${item.ID}" class="ellipsis">
                            ${item.FieldName}
                        </span>
                    </div>
                    <div class="d-flex w-100 justify-content-end position-absolute">
                        <a href="../sportfield/detail/${item.ID}" class="btn btn-default border border-info shadow-sm mb-2 mr-2" style="padding: 3px 6px;" title="Chi Tiết Sân">
                            <i class="fa-sm fa-solid fa-eye text-info" style="min-width: 20px;"></i>
                        </a>
                        <a onclick="fillDataToEditForm(${item.ID})" class="btn btn-default border border-warning shadow-sm mb-2 mr-2" style="padding: 3px 6px;" title="Cập Nhật Sân">
                            <i class="fa-sm fa-regular fa-pen-to-square text-warning" style="min-width: 20px;"></i>
                        </a>
                        <a onclick="destroySportField(${item.ID})" class="btn btn-default border-danger border shadow-sm mb-2" style="padding: 3px 6px;" title="Xóa Sân">
                            <i class="fa-sm fa-solid fa-trash-can text-danger" style="min-width: 20px;"></i>
                        </a>
                    </div>
                </div>
                <hr>
            </div>
        `
    },
    homepage_template: {
        container: '#homepage-container',
        scroll_to_view: '#view-sport-field',
        render: (item, index, array) => {
            let total = item.field_reviews.length;
            let html = '';
            if (index % 3 == 0) {
                html += '<div class="row mt-4 d-flex justify-content-between">';
            }
            html += `
            <div class="col">
                <div class="cards" style="height: 460px">
                ${item.field_reviews.length > 0
                    ? item.field_reviews
                        .map((review, index) => {
                            const current = index + 1;
                            const prevIndex = current === 1 ? total : current - 1;
                            const nextIndex = current === total ? 1 : current + 1;

                            return `
                            <input 
                                type="radio" 
                                id="radio-${item.ID}-${current}" 
                                name="radio-card-${item.ID}" 
                                ${index === 0 ? 'checked' : ''}
                            >
                            <article class="card d-flex flex-column" style="width: 350px">
                                <img class="card-img w-100" src="${review.ImageReview}">
                                <div class="card-data w-100">
                                <span class="card-num">${current}/${total}</span>
                                <a class="card-name" href="/sport-court-rental-system/public/sportfield/detail/${item.ID}">
                                    Sân ${item.FieldName}
                                </a>
                                <hr class="m-0">
                                <div class="card-comment mb-1">
                                    <div class="card-comment-title">
                                    <i class="fa-regular fa-message mr-2"></i>
                                    <div>Bình luận nổi bật:</div>
                                    </div>
                                    <div>
                                    <div class="card-comment-user">
                                        <img 
                                        src="${review.user.Avatar}" 
                                        alt="" 
                                        class="rounded-circle mr-2 border border-secondary" 
                                        style="border-width: 2px !important; object-fit: cover" 
                                        width="50px" 
                                        height="50px"
                                        >
                                        <div>
                                        <div style="text-decoration: underline">
                                            ${review.user.FullName}
                                        </div>
                                        <span class="text-yellow-400">⭐⭐⭐⭐⭐</span>
                                        </div>
                                    </div>
                                    <div class="card-comment-content ellipsis_user_comment">
                                        Đã Bình Luận: ${review.Content}
                                    </div>
                                    </div>
                                </div>
                                <hr class="m-0 mb-2">
                                <footer>
                                    <label for="radio-${item.ID}-${prevIndex}" aria-label="Previous">&#10094;</label>
                                    <label for="radio-${item.ID}-${nextIndex}" aria-label="Next">&#10095;</label>
                                </footer>
                                </div>
                            </article>
                        `;
                        }).join('')
                    :
                    `
                            <input 
                                type="radio" 
                                id="radio-${item.ID}-1" 
                                name="radio-card-${item.ID}" 
                                checked
                            >
                            <article class="card d-flex flex-column" style="width: 350px">
                                <img class="card-img w-100" src="${item.Image}">
                                <div class="card-data w-100">
                                <span class="card-num">1/1</span>
                                <a class="card-name" href="/sport-court-rental-system/public/sportfield/detail/${item.ID}">
                                    Sân ${item.FieldName}
                                </a>
                                <hr class="m-0">
                                <div class="card-comment">
                                    <div class="card-comment-title">
                                    <i class="fa-regular fa-message mr-2"></i>
                                    <div>Chưa có bình luận nào</div>
                                    </div>
                                </div>
                                </div>
                            </article>
                        `
                }
                </div>
            </div>
            `;


            if (index % 3 === 2 || index == array.length - 1) {
                // for correct layout
                if (array.length % 3 == 2)
                    html += '<div class="col"></div>';

                html += '</div>'
            }
            return html;
        }
    },
    review_template: {
        container: '#review-container',
        scroll_to_view: '#view-reviews',
        user_id: localStorage.getItem('user_id'),
        render: function (item) {
            return `
            <div class="mt-3 d-flex" id="review-id-${item.fieldreview_id}">
                <div class="user_avatar_cmt mr-2">
                    <img class="rounded-circle" src="${item.author_avatar}" width="70px" height="70px" alt="">
                </div>
                <div class="cmt_block_content container rounded mr-2" style="background-color:#f0f0f0">
                    <div class=" mt-2 d-flex justify-content-between">
                        <div>
                            <div class="font-weight-bold">
                                ${item.author_name}
                            </div>
                            <div>
                                ${item.Rating} <i class="fa-solid fa-star text-warning"></i>
                            </div>
                        </div>
                        ${item.author_id == this.user_id
                ?
                `
                            <div>
                            <button onclick="deleteReview(${item.fieldreview_id})" style="border-color: #dc3545" class="bg-outline-danger mr-1 rounded" title="Xóa đánh giá">
                                <svg class="text-danger" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                </svg>
                            </button>
                            <button onclick="editReview(${item.fieldreview_id})" style="border-color: #007bff" class="bg-primary rounded" title="Sửa đánh giá">
                                <svg class="text-white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                </svg>
                            </button>
                            </div>
                            `
                :
                ''
            }
                    </div>
                    <div class="mt-2">${item.review_content}</div>
                    ${item.ImageReview ? `<img class="mt-3" src="${item.ImageReview}" width="200px" alt="">` : ''}
                    <div class="mt-3 mb-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center" style="${(this.user_id == null || item.author_id == this.user_id) ? 'display: none !important' : ''}">
                            ${item.user_liked_review_ids != null && item.user_liked_review_ids.includes(this.user_id)
                ?
                `
                                <button data-author-id='${item.author_id}' id="btn-like-review-id-${item.fieldreview_id}" onclick="likeReview(event, ${item.fieldreview_id})" class="border-white rounded mr-2 btn_like"> 
                                    <i class="fa-solid fa-thumbs-up text-white" id="icon-like-review-id-${item.fieldreview_id}"></i> 
                                    LIKE
                                </button>
                                `
                :
                `                        
                                <button data-author-id='${item.author_id}' id="btn-like-review-id-${item.fieldreview_id}" class="mr-2 border-white rounded" onclick="likeReview(event, ${item.fieldreview_id})">
                                    <i class="fa-regular fa-thumbs-up" id="icon-like-review-id-${item.fieldreview_id}"></i>
                                    LIKE
                                </button>
                                `
            }
                            <div class="text-info" id="number-like-id-${item.fieldreview_id}">${item.number_liked}</div>
                        </div>
                        <i style="font-size: 14px; flex:1; text-align: right">${item.date_cmt}</i>
                    </div>
                </div>
            </div>
        `
        }
    }
};


// function get next previous 
function getPrevNext(index, total) {
    const current = index + 1;
    return {
        prev: current === 1 ? total : current - 1,
        next: current === total ? 1 : current + 1
    };
}

// load for the firt time load to page
var isFirstPageLoad = false; // the variable is use for not scroll to view for the first time load to page
const loadPage = (page = 1) => {
    //scroll to specific view
    if (configPagination[TYPE_CONFIG_PAGINATION].hasOwnProperty('scroll_to_view') && isFirstPageLoad) {
        $('html, body').animate({
            scrollTop: $(configPagination[TYPE_CONFIG_PAGINATION].scroll_to_view).offset().top
        }, 500);
    }

    isFirstPageLoad = true;

    // format the url
    const fullUrl = appendPageParam(API_URL_PAGINATION, page);
    $.ajax({
        url: `${fullUrl}`,
        method: 'GET',
        dataType: 'json',
        beforeSend: function () {
            $(`${configPagination[TYPE_CONFIG_PAGINATION].container}`).html('<p>Loading...</p>');
        },
        success: function (res) {
            renderItems(res.items, TYPE_CONFIG_PAGINATION);
            renderPagination(res.pagination);
        },
        error: function () {
            $(`${configPagination[TYPE_CONFIG_PAGINATION].container}`).html('<p>Không thể tải dữ liệu.</p>');
        }
    });
}

// render layout of page
const renderItems = (items, TYPE_CONFIG_PAGINATION) => {
    const html = items.map((item, index, array) => configPagination[TYPE_CONFIG_PAGINATION].render(item, index, array)).join('');
    if (html) {
        document.querySelector(configPagination[TYPE_CONFIG_PAGINATION].container).innerHTML = html;
        return;
    }

    document.querySelector(configPagination[TYPE_CONFIG_PAGINATION].container).innerHTML = '<small id="display-no-field" class="text-danger">KHÔNG CÓ DỮ LIỆU</small>';
}

//render pagination
const renderPagination = (pagination) => {
    let html = '';
    for (let i = 1; i <= pagination.totalPages; i++) {
        html += `
            <li class="page-item ${pagination.current == i ? 'active' : ''}">
                <a 
                    href="#" 
                    data-page="${i}"
                    class="pagination-link page-link" 
                >
                    ${i}
                </a> 
            </li>
        `;
    }
    if (pagination.totalPages > 0) {
        // PREVIOUS PAGE
        if (pagination.current > 1)
            html = `
                <li class="page-item">
                    <a data-page="${pagination.current - 1}" class="pagination-link page-link" href="#">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                ${html}
            `;
        // NEXT PAGE
        if (pagination.current < pagination.totalPages)
            html += `
            <li class="page-item">
                <a data-page="${pagination.current + 1}" class="pagination-link page-link" href="#">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            `;
    }
    $('#pagination').html(html);
}

// set load page event
$(document).on('click', '.pagination-link', function (e) {
    e.preventDefault();
    const page = $(this).data('page');
    loadPage(page);
});

// Funtion process if more than two query string 
function appendPageParam(url, page) {
    const separator = url.includes('?') ? '&' : '?';
    return `${url}${separator}page=${page}`;
}

// Load first page when open the page
$(document).ready(function () {
    if (!API_URL_PAGINATION || !TYPE_CONFIG_PAGINATION) {
        alert("URL OR TYPE NOT FOUND !");
        return;
    }

    loadPage(1);
});

