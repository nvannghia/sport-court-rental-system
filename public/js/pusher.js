document.addEventListener('DOMContentLoaded', (event) => {
    // Enable log để debug
    Pusher.logToConsole = true;

    var pusher = new Pusher('104a8ee9340cb349a757', {
        cluster: 'ap1'
    });

    // Gửi notifications bằng AJAX
    const userId              = localStorage.getItem('user_id');
    const channel             = pusher.subscribe(`new-noti-userId-${userId}`);
    const saveNotificationUrl = '/sport-court-rental-system/public/notification/firstOrNewNotification';

    channel.bind('new-noti', async function (data) {
        // xử lý lưu notifications
        let formData = new FormData();
        formData.append('user_receiver_id', data.userReceiverId);
        formData.append('user_trigger_id', data.userTriggerId);
        formData.append('content', data.message);
        formData.append('action', data.action);

        const response = await fetch(`${saveNotificationUrl}`, {
            method: 'POST',
            body  : formData
        });
        
        const rsData = await response.json();

        if (rsData.statusCode !== 201 )
            return;

        // xử lý hiện thông báo
        

          // code lại chỗ này để lấy -> bell -> hiện số TB chưa đọc lên bell -> hiện noti trong bell
        await Swal.fire({
            position         : "top-end",
            icon             : "success",
            title            : data.message,
            showConfirmButton: false,
            timer            : 1500
        });
    });

})

const notifications = (message, user_receiver_id, action) => {
    let user_trigger_id = localStorage.getItem("user_id");
    if (!user_trigger_id || !message || !user_receiver_id || !action) {
        alert("Invalid Parameter for notification!");
        return;
    }
    fetch('/sport-court-rental-system/app/utils/pusher.php', {
        method : 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body   : `message=${encodeURIComponent(message)}&user_receiver_id=${user_receiver_id}&user_trigger_id=${user_trigger_id}&action=${encodeURIComponent(action)}`
    });
}
