// Filed Schedule
document.addEventListener("DOMContentLoaded", function() {
    const daysOfWeek = ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"];
    let today = new Date();
    const headerRow = document.getElementById("header-row");

    function updateTable(startDate) {
        // Clear existing header
        while (headerRow.children.length > 2) {
            headerRow.removeChild(headerRow.lastChild);
        }

        let dateArray = [];

        for (let i = 0; i < 7; i++) {
            let currentDate = new Date(startDate);
            currentDate.setDate(startDate.getDate() + i);
            let day = daysOfWeek[currentDate.getDay()];
            let date = currentDate.toLocaleDateString('vi-VN');
            let parts = date.split('/');
            let formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`; // yyyy-mm-dd
            dateArray.push(formattedDate);

            let th = document.createElement("th");
            th.innerHTML = `${day}<br>${date}`;
            headerRow.appendChild(th);
        }

        // Update data-date attributes for each cell and hide links if needed
        const rows = document.querySelectorAll("tbody tr");
        let previousTime; // Previous time of rows have the same start time
        rows.forEach((row, rowIndex) => {
            // Get start time of booking
            let startTime = row.querySelector("td#start-time");
            if (startTime) {
                if (startTime.hasAttribute("data-start-time")) {
                    startTime = startTime.getAttribute("data-start-time");
                }
                previousTime = startTime;
            } else {
                startTime = previousTime;
            }

            // Get field number of booking
            let fieldNumber = row.querySelector("td span#field-number");
            if (fieldNumber) {
                if (fieldNumber.hasAttribute("data-field-number")) {
                    fieldNumber = fieldNumber.getAttribute("data-field-number");
                }
            }

            row.querySelectorAll("td a").forEach((a, colIndex) => {
                if (colIndex < dateArray.length) {
                    let bookingDate = dateArray[colIndex];
                    let [year, month, day] = bookingDate.split('-').map(Number);
                    let bookingDateObj = new Date(year, month - 1, day);

                    let now = new Date();
                    let todayDateObj = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                    let currentHour = now.getHours();

                    if (bookingDateObj < todayDateObj || (bookingDateObj.getTime() === todayDateObj.getTime() && currentHour >= startTime)) {
                        a.style.display = 'none'; // Hide the link
                    } else {
                        a.style.display = 'inline'; // Ensure the link is visible
                        let originalHref = a.getAttribute("href")
                            .split('?')[0] // Remove from '?' found first to end
                            .split('/')
                            .slice(0, 6)
                            .join('/'); // If click tuần sau button, if will overload params
                        a.setAttribute("href", `${originalHref}?bookingDate=${bookingDate}&fieldNumber=${fieldNumber}&startTime=${startTime}`);
                    }
                }
            });
        });
    }

    document.getElementById("next-week").addEventListener("click", function() {
        today.setDate(today.getDate() + 7);
        updateTable(today);
    });

    document.getElementById("this-week").addEventListener("click", function() {
        let today = new Date();
        updateTable(today);
    });

    updateTable(today);
});


// Booking Detail
document.addEventListener("DOMContentLoaded", function() {
    let endTimeSelect = document.getElementById("end-time");
    let hours = document.getElementById("hours");
    let pricePerHour = document.getElementById("price-per-hour");
    let totalMoney = document.getElementById("total-money");
    let wrapMessage = document.getElementById("wrap-message");
    let message = document.getElementById("message");
    let customerName = document.getElementById("customer-name");
    let customerPhone = document.getElementById("customer-phone");
    let customerEmail = document.getElementById("customer-email");
    let sportFieldID = document.getElementById("sport-field-id");
    let bookingDate = document.getElementById("booking-date");
    let fieldNumber = document.getElementById("field-number");
    let startTime = document.getElementById("start-time");
    const hoursValid = [1, 1.5, 2];
    //btn booking 
    const btnBooking = document.getElementById("btn-booking");

    //onchange select
    endTimeSelect.addEventListener("change", () => {
        // remove error message 
        wrapMessage.classList.add("d-none")
        endTimeSelect.style.border = "none";
        //set value for element
        hours.innerText = endTimeSelect.value;
        totalMoney.innerText = pricePerHour.value * endTimeSelect.value + ".000";
    })


    // regex for check email
    function validateEmail(email) {
        // Biểu thức chính quy để kiểm tra định dạng email
        const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return re.test(String(email).toLowerCase());
    }

    //regex for check Vietnamese phone number
    function isVietnamesePhoneNumber(number) {
        return /(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/.test(number);
    }


    //handle booking function
    const handleBooking = async () => {
        //validate data
        if (endTimeSelect.value == "null" || hoursValid.includes(parseInt(endTimeSelect.value)) == false) {
            endTimeSelect.style.border = "1px solid red";
            //display message error
            if (wrapMessage.classList.contains("d-none")) {
                wrapMessage.classList.remove("d-none")
                message.innerText = "Vui lòng chọn số giờ muốn thuê!"
            }
            return;
        } else {
            //hide the message and remove border invalid
            wrapMessage.classList.add("d-none")
            endTimeSelect.style.border = "none";
        }

        if (customerName.value.trim() === "") {
            customerName.style.border = "1px solid red";
            //display message error
            if (wrapMessage.classList.contains("d-none")) {
                wrapMessage.classList.remove("d-none")
                message.innerText = "Vui lòng nhập tên của bạn!"
            }
            return;
        } else {
            //hide the message and remove border invalid
            wrapMessage.classList.add("d-none")
            customerName.style.border = "none";
        }

        if (customerPhone.value.trim() === "") {
            customerPhone.style.border = "1px solid red";
            //display message error
            if (wrapMessage.classList.contains("d-none")) {
                wrapMessage.classList.remove("d-none")
                message.innerText = "Vui lòng nhập SĐT của bạn!"
            }
            return;
        } else {
            //hide the message and remove border invalid
            wrapMessage.classList.add("d-none")
            customerPhone.style.border = "none";
        }

        if (!isVietnamesePhoneNumber(customerPhone.value.trim())) {
            customerPhone.style.border = "1px solid red";
            //display message error
            if (wrapMessage.classList.contains("d-none")) {
                wrapMessage.classList.remove("d-none")
                message.innerText = "SĐT không hợp lệ!"
            }
            return;
        } else {
            //hide the message and remove border invalid
            wrapMessage.classList.add("d-none")
            customerPhone.style.border = "none";
        }

        if (customerEmail.value.trim() === "") {
            customerEmail.style.border = "1px solid red";
            //display message error
            if (wrapMessage.classList.contains("d-none")) {
                wrapMessage.classList.remove("d-none")
                message.innerText = "Vui lòng nhập e-mail của bạn!"
            }
            return;
        } else {
            //hide the message and remove border invalid
            wrapMessage.classList.add("d-none")
            customerEmail.style.border = "none";
        }

        if (!validateEmail(customerEmail.value.trim())) {
            customerEmail.style.border = "1px solid red";
            if (wrapMessage.classList.contains("d-none")) {
                wrapMessage.classList.remove("d-none")
                message.innerText = "E-mail không hợp lệ!"
            }
            return;
        } else {
            //hide the message and remove border invalid
            wrapMessage.classList.add("d-none")
            customerEmail.style.border = "none";
        }


        // validate success without error
        let endTime = parseFloat(endTimeSelect.value);
        const formData = new FormData();
        formData.append('action', 'createBooking');
        formData.append('sportFieldID', sportFieldID.value);
        formData.append('fieldNumber', fieldNumber.value);
        formData.append('customerName', customerName.value);
        formData.append('customerPhone', customerPhone.value);
        formData.append('customerEmail', customerEmail.value);
        formData.append('startTime', startTime.value);
        formData.append('endTime', endTime);
        formData.append('bookingDate', bookingDate.value);

        // // Using for...of loop to iterate through the FormData entries
        // for (const [key, value] of formData.entries()) {
        //     console.log(`${key}: ${value}`);
        // }

        const response = await fetch('/sport-court-rental-system/public/booking/createBooking', {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();

        if (data.statusCode === 200) {
            Swal.fire({
                position: "center-center",
                icon: "success",
                title: "Đặt sân thành công",
                footer: `
                <div class="d-flex justify-content-between">
                    <a href="/sport-court-rental-system/public/booking/showBooking" class="btn btn-info w-50 mr-2">Thanh Toán</a> 
                    <a href="/sport-court-rental-system/public/booking/fieldSchedule/${sportFieldID.value}" class="btn btn-primary w-50 text-white"> Tiếp Tục Đặt </a>
                </div>
                `,
                showConfirmButton: false,
            });
        } else if (data.statusCode === 409) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Sân đã được đặt bởi khách hàng khác!",
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Đặt sân không thành công, vui lòng thử lại sau!",
            });
        }

        //disabled button
        btnBooking.setAttribute('disabled', true);
    }

    //set event submit btn
    btnBooking.addEventListener("click", handleBooking);
});


// Show Booking Detail
document.addEventListener('DOMContentLoaded', () => {
    const btnDetailInfoBookings = document.querySelectorAll('button[name=detail-info-booking]');

    btnDetailInfoBookings.forEach(btnDetailInfoBooking => {

        btnDetailInfoBooking.addEventListener('click', function(evt) {
            const bookingData = this.getAttribute('data-booking');
            const bookingObject = JSON.parse(bookingData);

            Swal.fire({
                title: 'Thông Tin Chi Tiết',
                imageAlt: "Custom image",
                html: `
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-signature"></i>]
                    <b>Tên sân: </b> 
                    <span class="ml-3"> 
                    ${bookingObject.sport_field.FieldName} 
                    </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-map-location-dot"></i>]
                    <b>Địa chỉ sân: </b> 
                    <span class="ml-3"> ${bookingObject.sport_field.Address} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-list-ol"></i>]
                    <b style="width:100px">Sân số: </b> 
                    <span class="ml-3"> ${bookingObject.FieldNumber} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-calendar-days"></i>]
                    <b style="width:100px">Ngày thuê: </b> 
                    <span class="ml-3"> ${bookingObject.BookingDate} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-clock"></i>]
                    <b style="width:100px">Giờ thuê: </b> 
                    <span class="ml-3"> ${bookingObject.StartTime}:00 - ${parseInt(bookingObject.StartTime) + parseInt(bookingObject.EndTime)}:00 </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-money-check-dollar"></i>]
                    <b style="width:100px">Tiền sân: </b> 
                    <span class="ml-3"> ${bookingObject.TotalAmount}.000 đ </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-regular fa-credit-card"></i>]
                    <b style="width:100px">Trạng thái: </b> 
                    <span class="ml-3"> ${bookingObject.PaymentStatus == 'UNPAID' ? 'Chưa thanh toán' : 'Đã thanh toán'} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-regular fa-address-card"></i>]
                    <b style="width:100px">Tên khách hàng: </b> 
                    <span class="ml-3"> ${bookingObject.CustomerName} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-envelope"></i>]
                    <b style="width:100px">Email khách hàng: </b> 
                    <span class="ml-3"> ${bookingObject.CustomerEmail} </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-mobile"></i>]
                    <b style="width:100px">SĐT: </b> 
                    <span class="ml-3"> ${bookingObject.CustomerPhone} </span>
                </div>
                <hr>
                `
            });
        });
    })
});