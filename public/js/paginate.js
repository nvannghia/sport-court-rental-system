
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
        render: (item, index) => {
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
                                                    <input type="radio" id="radio-${item.ID}-${current}" name="radio-card-${item.ID}" ${index === 0 ? 'checked' : ''}>
                                                    <article class="card d-flex flex-column" style="width: 350px">
                                                        <img class="card-img w-100" src="${review.ImageReview}">
                                                        <div class="card-data w-100">
                                                        <span class="card-num">${current}/${total}</span>
                                                        <a class="card-name" href="/sport-court-rental-system/public/sportfield/detail/${item.ID}">Sân ${item.FieldName}</a>
                                                        <hr class="m-0">
                                                        <div class="card-comment mb-1">
                                                            <div class="card-comment-title">
                                                            <i class="fa-regular fa-message mr-2"></i>
                                                            <div>Bình luận nổi bật:</div>
                                                            </div>
                                                            <div>
                                                            <div class="card-comment-user">
                                                                <img src="${review.user.Avatar}" alt="" class="rounded-circle mr-2 border border-secondary" style="border-width: 2px !important; object-fit: cover" width="50px" height="50px" >
                                                                <div>
                                                                <div style="text-decoration: underline">${review.user.FullName}</div>
                                                                <span class="text-yellow-400">⭐⭐⭐⭐⭐</span>
                                                                </div>
                                                            </div>
                                                            <div class="card-comment-content ellipsis_user_comment">Đã Bình Luận: ${review.Content}</div>
                                                            </div>
                                                        </div>
                                                        <hr class="m-0 mb-2">
                                                        <footer class="" style="">
                                                            <label for="radio-${item.ID}-${prevIndex}" aria-label="Previous">&#10094;</label>
                                                            <label for="radio-${item.ID}-${nextIndex}" aria-label="Next">&#10095;</label>
                                                        </footer>
                                                        </div>
                                                    </article>
                                                    `;
                                        }).join('')
                                        : 
                                            `
                                            <input type="radio" id="radio-${item.ID}-1" name="radio-card-${item.ID}" checked>
                                            <article class="card d-flex flex-column" style="width: 350px">
                                            <img class="card-img w-100" src="${item.Image}">
                                            <div class="card-data w-100">
                                                <span class="card-num">1/1</span>
                                                <a class="card-name" href="/sport-court-rental-system/public/sportfield/detail/${item.ID}">Sân ${item.FieldName}</a>
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

            if (index % 3 === 2) {
                html += '</div>';
            }
            return html;
        }
    }
};

function getPrevNext(index, total) {
    const current = index + 1;
    return {
        prev: current === 1 ? total : current - 1,
        next: current === total ? 1 : current + 1
    };
}

const loadPage = (page = 1) => {
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

const renderItems = (items, TYPE_CONFIG_PAGINATION) => {
    const html = items.map((item, index) => configPagination[TYPE_CONFIG_PAGINATION].render(item, index)).join('');
    if (html) {
        document.querySelector(configPagination[TYPE_CONFIG_PAGINATION].container).innerHTML = html;
        return;
    }

    document.querySelector(configPagination[TYPE_CONFIG_PAGINATION].container).innerHTML = '<small id="display-no-field" class="text-danger">KHÔNG CÓ DỮ LIỆU</small>';
}

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

// Bắt sự kiện click phân trang
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

// Load trang đầu tiên khi mở web
$(document).ready(function () {
    if (!API_URL_PAGINATION || !TYPE_CONFIG_PAGINATION) {
        alert("URL OR TYPE NOT FOUND !");
        return;
    }

    loadPage(1);
});

