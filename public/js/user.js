//user upload avatar
const uploadUserAvatar = () => {
    const fileInput = document.getElementById('fileInput');

    fileInput.click();

    // / Lắng nghe sự kiện change để lấy file sau khi người dùng chọn
    fileInput.addEventListener('change', async function(event) {
        const file = event.target.files[0];

        let userAvatar = document.getElementById('userAvatar');
        userAvatar.src = '';
        userAvatar.classList.add('spinner-border', 'text-primary', 'border-5');

        const formData = new FormData();
        formData.append('file', file);

        if (file) {

            const response = await fetch('../user/uploadUserAvatar', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            if (data.statusCode === 200) {
                userAvatar.classList.remove('spinner-border', 'text-primary','border-5');
                userAvatar.src = data.url;
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