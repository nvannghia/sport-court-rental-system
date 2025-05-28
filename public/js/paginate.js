
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
    sportField: {
        container: '#sport-field-container',
        render: (item) => `
      <div class="sport-field-item">
        <span>${item.name}</span>
        <small>${item.type}</small>
      </div>`
    }
};


const loadPage = (page = 1) => {
    $.ajax({
        url: `${API_URL_PAGINATION}?page=${page}`,
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
    const html = items.map(configPagination[TYPE_CONFIG_PAGINATION].render).join('');
    if (html) {
        document.querySelector(configPagination[TYPE_CONFIG_PAGINATION].container).innerHTML = html;
        return;
    } 

    document.querySelector(configPagination[TYPE_CONFIG_PAGINATION].container).innerHTML = '<small id="display-no-field" class="text-danger">Hệ thống chưa ghi nhận sân nào thuộc doanh nghiệp của bạn!</small>';
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

// Load trang đầu tiên khi mở web
$(document).ready(function () {
    if (!API_URL_PAGINATION || !TYPE_CONFIG_PAGINATION) {
        alert("URL OR TYPE NOT FOUND !");
        return;
    }

    loadPage(1);
});

