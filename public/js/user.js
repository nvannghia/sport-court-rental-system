
//user upload avatar
const uploadUserAvatar = () => {
    const fileInput = document.getElementById('fileInput');

    fileInput.click();

    // / Lắng nghe sự kiện change để lấy file sau khi người dùng chọn
    fileInput.addEventListener('change', async function (event) {
        const file = event.target.files[0];

        let userAvatar = document.getElementById('userAvatar');
        userAvatar.src = '';
        // userAvatar.classList.add('spinner-border', 'text-primary', 'border-5');
        userAvatar.outerHTML = `
        <svg id="loading" role="img" aria-label="Mouth and eyes come from 9:00 and rotate clockwise into position, right eye blinks, then all parts rotate and merge into 3:00" class="smiley" viewBox="0 0 128 128" width="128px" height="128px">
            <defs>
                <clipPath id="smiley-eyes">
                    <circle class="smiley__eye1" cx="64" cy="64" r="8" transform="rotate(-40,64,64) translate(0,-56)" />
                    <circle class="smiley__eye2" cx="64" cy="64" r="8" transform="rotate(40,64,64) translate(0,-56)" />
                </clipPath>
                <linearGradient id="smiley-grad" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#000" />
                    <stop offset="100%" stop-color="#fff" />
                </linearGradient>
                <mask id="smiley-mask">
                    <rect x="0" y="0" width="128" height="128" fill="url(#smiley-grad)" />
                </mask>
            </defs>
            <g stroke-linecap="round" stroke-width="12" stroke-dasharray="175.93 351.86">
                <g>
                    <rect fill="hsl(193,90%,50%)" width="128" height="64" clip-path="url(#smiley-eyes)" />
                    <g fill="none" stroke="hsl(193,90%,50%)">
                        <circle class="smiley__mouth1" cx="64" cy="64" r="56" transform="rotate(180,64,64)" />
                        <circle class="smiley__mouth2" cx="64" cy="64" r="56" transform="rotate(0,64,64)" />
                    </g>
                </g>
                <g mask="url(#smiley-mask)">
                    <rect fill="hsl(223,90%,50%)" width="128" height="64" clip-path="url(#smiley-eyes)" />
                    <g fill="none" stroke="hsl(223,90%,50%)">
                        <circle class="smiley__mouth1" cx="64" cy="64" r="56" transform="rotate(180,64,64)" />
                        <circle class="smiley__mouth2" cx="64" cy="64" r="56" transform="rotate(0,64,64)" />
                    </g>
                </g>
            </g>
        </svg>`;

        const formData = new FormData();
        formData.append('file', file);

        if (file) {

            const response = await fetch('../user/uploadUserAvatar', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            if (data.statusCode === 200) {
                let loading = document.getElementById("loading");
                loading.outerHTML = `<img id="userAvatar" src="${data.url}" class="shadow bg-body rounded-circle img-fluid" style="width: 200px; height: 200px; object-fit:cover;" alt="User Avatar Loading ...">`
            } else {
                Swal.fire({
                    title: "Thất Bại!",
                    text: "Lỗi Phía Server, Vui Lòng Liên Hệ QTV!",
                    icon: "error",
                    customClass: {
                        popup: 'my-custom-popup',
                        title: 'custom-error-title'
                    },
                });
            }
        }
    }, {
        once: true
    }); // { once: true } để sự kiện chỉ lắng nghe một lần
}



//update profile link (www, fb, linkin, instagram)
// www      : 1
// twitter  : 2
// instagram: 3
// fb       : 4
const changeProfileLink = (buttonClicked) => {
    buttonClicked.classList.add('d-none');
    let container = buttonClicked.parentElement.previousElementSibling;
    let saveBtn = buttonClicked.nextElementSibling;
    let cancelBtn = saveBtn.nextElementSibling;
    let displayLink = container.getElementsByClassName("display-link")[0];
    let linkValue = displayLink.textContent;

    //REMOVE HIDDEN AND SET ONCLICK CANCEL EVENT
    cancelBtn.classList.remove("d-none");
    cancelBtn.onclick = () => cancelProfileLink(linkValue, cancelBtn, saveBtn, buttonClicked);
    saveBtn.classList.remove('d-none');

    // CREATE NEW ELEMENT FOR TYPE `LINK`
    const newInput = document.createElement('input');
    newInput.name = 'link_value';
    newInput.className = 'link_value w-100';
    newInput.placeholder = 'Nhập đường dẫn...';
    // REPLACE LINK WITH INPUT
    displayLink.replaceWith(newInput);
}

const cancelProfileLink = (oldLinkValue, cancelBtn, saveBtn, editBtn) => {
    editBtn.classList.remove('d-none');
    cancelBtn.classList.add('d-none');
    saveBtn.classList.add('d-none');
    let container = cancelBtn.parentElement.previousElementSibling;
    let displayLink = container.getElementsByClassName("link_value")[0];

    // CREATE NEW ELEMENT FOR TYPE `LINK`
    const oldLink = document.createElement('a');
    oldLink.name = 'display-link';
    oldLink.className = 'display-link';
    oldLink.textContent = oldLinkValue;
    oldLink.href = oldLinkValue === "NULL" ? "#" : oldLinkValue;

    // REPLACE LINK WITH INPUT
    displayLink.replaceWith(oldLink);
}


// SAVE BUTTON FUNCTION .... LOADING
const saveProfileLink = async (btnSaveClicked, linkName) => {
    const parentDiv         = btnSaveClicked.parentElement;
    const previousParentDiv = parentDiv.previousElementSibling;
    const btnCancel         = btnSaveClicked.nextElementSibling;
    const btnEdit           = btnSaveClicked.previousElementSibling;

    const inputLink = previousParentDiv.getElementsByClassName("link_value")[0];
    if (!inputLink) {
        alert("Vui lòng chọn nút sửa thông tin!")
        return;
    }

    const linkValue = inputLink.value;
    if (!linkValue) {
        inputLink.classList.add("border", "border-danger");
        return;
    }

    // CALL API UPDATE PROFILE LINK
    const data = await callSaveProfileLinkAPI(linkName, linkValue);
    if (data.statusCode === 200) {
        alert("Thay đổi dữ liệu thành công!");
        const newLink             = document.createElement('a');
              newLink.name        = 'display-link';
              newLink.className   = 'display-link';
              newLink.href        = linkValue;
              newLink.textContent = linkValue;
        inputLink.replaceWith(newLink);
        btnEdit.classList.remove('d-none');
        btnCancel.classList.add('d-none');
        btnSaveClicked.classList.add('d-none');
    }
    else {
        alert("Thay đổi dữ liệu thất bại!");
    }
}

const callSaveProfileLinkAPI = async (linkName, linkValue) => {
    const dataSend = new URLSearchParams();
    dataSend.append("linkName", linkName);
    dataSend.append("linkValue", linkValue);

    const rs = await fetch('/sport-court-rental-system/public/user/changeProfileLink', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: dataSend.toString()
    });

    const dataRecieved = await rs.json();
    return dataRecieved;
}


// change bio profile
$(document).ready(function() {
    // EDIT USER QUOTES AND PHONE NUMBER IN ONE FUNCTION 
    $('.btn-edit-user-profile').on('click', (event) => {
        let buttonEdit     = event.currentTarget;
        let displayText    = $(buttonEdit).prev();
        let dataType       = $(buttonEdit).data('type');
        let dataOldText    = $(buttonEdit).attr('data-old-text');
        let dataLinkName   = $(buttonEdit).data('link-name');
        let dataPromptText = $(buttonEdit).data('prompt-text');
        let dataTypeText   = prompt(dataPromptText, dataOldText);

        if (!dataTypeText) return;

        //VALIDATE DATA USER TYPE
        const validators = {
            quote: {
                validate: (value) => value.length > 0 && value.length <= 80,
                success: "CẬP NHẬT TIỂU SỬ THÀNH CÔNG!",
                error: "VUI LÒNG NHẬP TỐI ĐA 80 KÝ TỰ!"
            },
            phone: {
                validate: (value) => /^(0|\+84)[0-9]{9}$/.test(value),
                success: "CẬP NHẬT SỐ ĐIỆN THOẠI THÀNH CÔNG!",
                error: "SỐ ĐIỆN THOẠI KHÔNG HỢP LỆ!"
            }
        };

        if (!validators[dataType].validate(dataTypeText)) {
            alert(validators[dataType].error);
            return;
        }

        //CALL API UPDATE
        $.ajax({
            url: '/sport-court-rental-system/public/user/changeProfileLink',
            method: 'POST',
            data: {
                linkName : dataLinkName,
                linkValue: dataTypeText
            },
            success: function(response) {
                alert(validators[dataType].success);
                displayText.text(dataTypeText);
                // LỖI: CHƯA CẬP NHẬT ĐƯỢC GIÁ TRỊ MỚI CHO THUỘC TÍNH SAU KHI UPDATE THÀNH CÔNG
                $(buttonEdit).attr("data-old-text", dataTypeText); 
            },
            error: function(xhr, status, error) {
                alert("ĐÃ XẢY RA LỖI, VUI LÒNG THỬ LẠI SAU!");
            }
        });
        
    });
});