tinymce.init({
    selector: 'textarea#add, textarea#edit',
    height: 300,
    plugins: [
        'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
        'searchreplace', 'wordcount', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media', 
        'table', 'emoticons', 'template', 'codesample'
    ],
    toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify |' + 
    'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
    'forecolor backcolor emoticons',
    menu: {
        favs: {title: 'menu', items: 'code visualaid | searchreplace | emoticons'}
    },
    menubar: 'favs file edit view insert format tools table',
    content_style: 'body{font-family:Helvetica,Arial,sans-serif; font-size:16px}',
    images_upload_url: '../../app/utils/upload.php', // Điều chỉnh đường dẫn đến endpoint xử lý upload.php
    automatic_uploads: true,
    file_picker_types: 'image',
    file_picker_callback: function(callback, value, meta) {
        if (meta.filetype === 'image') {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                const file = this.files[0];
                const formData = new FormData();
                formData.append('file', file);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '../../app/utils/upload.php', true); // Điều chỉnh đường dẫn endpoint xử lý upload
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        try {
                            const json = JSON.parse(xhr.responseText);
                            if (json.location) {
                                callback('../../app/utils/'+json.location, { alt: file.name });
                            } else {
                                alert('Failed to upload image: Invalid response from server');
                            }
                        } catch (e) {
                            alert('Failed to upload image: Error parsing response');
                        }
                    } else {
                        alert('Failed to upload image: Server Error ' + xhr.status);
                    }
                };
                xhr.onerror = function() {
                    alert('Failed to upload image: Network Error');
                };
                xhr.send(formData);
            };
            input.click();
        }
    }
});
