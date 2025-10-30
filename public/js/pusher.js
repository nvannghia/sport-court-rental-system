document.addEventListener('DOMContentLoaded', (event) => {
    // Enable log để debug
    Pusher.logToConsole = true;

    var pusher = new Pusher('104a8ee9340cb349a757', {
        cluster: 'ap1'
    });

    const notify_controller_url = "/sport-court-rental-system/public/notification/";

    // load new notification when have new notification
    const getNewNotification = async (user_receiver_id) => {
        // get 10 latest notification
        const get_latest_notify = `${notify_controller_url}/getLatestNotificationsByUser?user_receiver_id=${user_receiver_id}`;
        let   response          = await fetch(`${get_latest_notify}`);
              response          = await response.json();

        let unread_notification_count = response.unreadNotificationCount;
        let user_notifications = response.data;
        user_notifications = user_notifications.map((notify) => `
            <div>
                <div class="notify-item" style="background-color: ${notify.status == 0 ? '#e7f3ff' : ''}">
                    <div>
                        👍 <b> ${notify.user_trigger_name} </b> ${notify.content}
                    </div>

                ${notify.status == 0
                ?
                `
                    <div class="d-flex align-items-center parent_read_one_noti justify-content-end">
                        <input data-noti-id="${notify.ID}" type="checkbox" id="" name="" class="read_notification">
                        <label for="read" class="m-0 ml-1">Đã đọc</label>
                    </div>
                `
                : ''
            }
                </div>
            </div>
        `).join('');
        // append notify to list
        $('#notify_wrapper').empty().prepend(user_notifications);
        // bell config
        $('.mark_all_wrapper').removeClass("d-none");
        notify_number.classList.remove('d-none');
        notify_number.innerText = unread_notification_count;
        bell.classList.add("bell-shake");
    }

    // Gửi notifications bằng AJAX
    const userId = localStorage.getItem('user_id');
    const channel = pusher.subscribe(`new-noti-userId-${userId}`);
    const save_notify_url = `${notify_controller_url}/firstOrNewNotification`;

    channel.bind('new-noti', async function (data) {
        // // xử lý lưu notifications
        let formData = new FormData();
        formData.append('user_receiver_id', data.userReceiverId);
        formData.append('user_trigger_id', data.userTriggerId);
        formData.append('content', data.message);
        formData.append('action', data.action);

        const response = await fetch(`${save_notify_url}`, {
            method: 'POST',
            body: formData
        });
        const rsData = await response.json();
        if (rsData.statusCode !== 201)
            return;

        // xử lý hiện thông báo
        getNewNotification(data.userReceiverId);
    });

})

const notifications = async (message, user_receiver_id, action) => {
    let user_trigger_id = localStorage.getItem("user_id");
    if (!user_trigger_id || !message || !user_receiver_id || !action) {
        alert("Invalid Parameter for notification!");
        return;
    }

    const rs = await fetch('/sport-court-rental-system/app/utils/pusher.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `message=${encodeURIComponent(message)}&user_receiver_id=${user_receiver_id}&user_trigger_id=${user_trigger_id}&action=${encodeURIComponent(action)}`
    });
    rs = await rs.json();

    if (rs.statusCode !== 200) {
        alert("Failed notification!");
        return;
    }

    // bell, notify_number at file header_section.php

}
