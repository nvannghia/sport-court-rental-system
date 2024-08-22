
// Visibility Revenue, paid bookings, unpaid bookings
const toggleRevenueVisibility = (iElement) => {
    const revenueElement = document.getElementById("revenue");
    // console.log(revenueElement.type = "text");
    if (revenueElement.type == "password") {
        revenueElement.type = "text";
        iElement.classList.remove("fa-eye-slash");
        iElement.classList.add("fa-eye");
    } else {
        revenueElement.type = "password";
        iElement.classList.remove("fa-eye");
        iElement.classList.add("fa-eye-slash");
    }
}

const togglePaidBookingsVisibility = (iElement) => {
    const paidBookingsElement = document.getElementById("paid-bookings");
    // console.log(revenueElement.type = "text");
    if (paidBookingsElement.type == "password") {
        paidBookingsElement.type = "text";
        iElement.classList.remove("fa-eye-slash");
        iElement.classList.add("fa-eye");
    } else {
        paidBookingsElement.type = "password";
        iElement.classList.remove("fa-eye");
        iElement.classList.add("fa-eye-slash");
    }
}

const toggleUnpaidBookingsVisibility = (iElement) => {
    const unpaidBookingsElement = document.getElementById("unpaid-bookings");
    // console.log(revenueElement.type = "text");
    if (unpaidBookingsElement.type == "password") {
        unpaidBookingsElement.type = "text";
        iElement.classList.remove("fa-eye-slash");
        iElement.classList.add("fa-eye");
    } else {
        unpaidBookingsElement.type = "password";
        iElement.classList.remove("fa-eye");
        iElement.classList.add("fa-eye-slash");
    }
}


// approve payment, show invoice 
const invoiceUrl = '/sport-court-rental-system/public/invoice';

const approvePayment = async (evt, bookingID, totalAmount) => {
    evt.preventDefault();
    const formData = new FormData();
    formData.append('bookingID', bookingID);
    formData.append('amount', `${totalAmount}000`);
    formData.append('paymentOption', 'in-person');

    const approvePaymentUrl = `${invoiceUrl}/payInvoice`;
    const response = await fetch(approvePaymentUrl, {
        method: "POST",
        body: formData
    });

    const data = await response.json();

    if (data.status === 'success') {
        const paymentStatusElement = document.getElementById(`td-booking-id-${bookingID}`)
        paymentStatusElement.innerHTML = `
                <div style="width:228px; height:40px " class="d-flex align-items-center text-success border border-success rounded">
                    <i class="fa-solid fa-square-check ml-2 mr-2" style="min-width:30px; font-size:25px"></i> 
                    <span>Đã Thanh Toán</span>
                </div>
            `;
        Swal.fire({
            title: "Phê Duyệt Thành Công!",
            text: "Xác nhận thanh toán thành công!",
            icon: "success"
        });
    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Đã có lỗi xảy ra!",
            footer: '<div class="text-info">Vui lòng thử lại sau!</div>'
        });
    }
}

const showInvoice = async (bookingID) => {

    const getInvoiceUrl = `${invoiceUrl}/getInvoiceOfBooking/${bookingID}`;

    const response = await fetch(getInvoiceUrl);

    const data = await response.json();
 
    if (data.statusCode === 200) {
        
        const invoiceData = data.invoice;
        
        Swal.fire({
            title: 'THÔNG TIN CHI TIẾT',
            imageAlt: "Custom image",
            html: `
                <hr>
                <div style="text-align:left">
                    [<i class="fa-regular fa-calendar"></i>]
                    <b>Ngày thanh toán: </b> 
                    <span class="ml-3"> 
                    ${invoiceData.PaymentDate}
                    </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-money-check"></i>]
                    <b>Dạng thanh toán: </b> 
                    <span class="ml-3"> 
                    ${invoiceData.PaymentMethod}
                    </span>
                </div>
                <hr>
                <div style="text-align:left">
                    [<i class="fa-solid fa-sack-dollar"></i>]
                    <b>Tổng tiền sân: </b> 
                    <span class="ml-3"> 
                    ${invoiceData.TotalAmount} đ
                    </span>
                </div>
                <hr>
                `
        });
    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Đã có lỗi xảy ra!",
            footer: '<div class="text-info">Hãy chắc rằng bạn đã phê duyệt thanh toán!</div>'
        });
    }

}


//pdf generate statistics
function removeVietnameseAccents(str) {
    // Chuyển chuỗi sang dạng chuẩn Unicode Normalization Form D (NFD)
    str = str.normalize('NFD');

    // Loại bỏ các ký tự dấu bằng cách thay thế các ký tự có dấu bằng ký tự không dấu
    str = str.replace(/[\u0300-\u036f]/g, '');

    return str;
}

const generatePDFStatistics = (buttonElement) => {
    const bookingsData = buttonElement.getAttribute('data-bookings');
    const totalRevenue = buttonElement.getAttribute('data-total-revenue');
    const businessInfoData = buttonElement.getAttribute('data-business-info');

    // Chuyển đổi JSON string thành đối tượng JavaScript
    const bookings = JSON.parse(bookingsData);
    const businessInfo = JSON.parse(businessInfoData);

    // Report Date
    const now = new Date();

    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
    const year = now.getFullYear();

    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');

    const currentDate = `${day}/${month}/${year}`;
    const currentTime = `${hours}:${minutes}`;

    //extract data from bookings varibale
    let fieldName = removeVietnameseAccents(bookings[0]['sport_field']['FieldName']);
    var props = {
        outputType: jsPDFInvoiceTemplate.OutputType.Save,
        returnJsPDFDocObject: true,
        fileName: `Statistics-SportField-${fieldName}-${currentDate}`,
        orientationLandscape: true,
        compress: true,
        logo: {
            src: "https://static.vecteezy.com/system/resources/previews/007/955/134/non_2x/sport-logo-free-vector.jpg",
            type: 'PNG', //optional, when src= data:uri (nodejs case)
            width: 60, //aspect ratio = width/height
            height: 32,
            margin: {
                top: 0, //negative or positive num, from the current position
                left: 0 //negative or positive num, from the current position
            }
        },
        stamp: {
            inAllPages: true, //by default = false, just in the last page
            src: "https://raw.githubusercontent.com/edisonneza/jspdf-invoice-template/demo/images/qr_code.jpg",
            type: 'JPG', //optional, when src= data:uri (nodejs case)
            width: 20, //aspect ratio = width/height
            height: 20,
            margin: {
                top: 0, //negative or positive num, from the current position
                left: 0 //negative or positive num, from the current position
            }
        },
        business: {
            name: "SPORT COURT RENTAL SYSTEM",
            address: "Go Vap, TP.HCM",
            phone: "+84372337713",
            email: "nghiaturtle2002@gmail.com",
        },
        contact: {
            label: "Statistical reports for businesses:",
            name: businessInfo.BusinessName,
            address: businessInfo.BusinessAddress,
            phone: businessInfo.PhoneNumber,
        },
        invoice: {
            label: "Sports field name: ",
            num: fieldName,
            invDate: `Report Date: ${currentDate} - ${currentTime}`,
            headerBorder: false,
            tableBodyBorder: false,
            header: [
                {
                    title: "#",
                    style: {
                        width: 10
                    }
                },
                {
                    title: "Field Name",
                    style: {
                        width: 40
                    }
                },
                {
                    title: "Order Date",
                    style: {
                        width: 30
                    }
                },
                {
                    title: "Rental Date",
                    style: {
                        width: 30
                    }
                },
                {
                    title: "Rental Hours",
                    style: {
                        width: 30
                    }
                },
                {
                    title: "Payment Status",
                    style: {
                        width: 30
                    }
                },
                {
                    title: "Payment Date",
                    style: {
                        width: 30
                    }
                },
                {
                    title: "Payment Method",
                    style: {
                        width: 30
                    }
                },
                {
                    title: "Total Amount",
                    style: {
                        width: 30
                    }
                }
            ],
            table: bookings.map((item, index) => ([
                `${index + 1}                   `,
                fieldName,
                item.created_at,
                item.BookingDate,
                item.RentalHours,
                item.PaymentStatus,
                item.invoice ? item.invoice.PaymentDate : "NULL",
                item.invoice ? item.invoice.PaymentMethod : "NULL",
                item.invoice ? item.invoice.TotalAmount + "(VND)" : "NULL"
            ])),
            additionalRows: [{
                col1: 'Total revenue:',
                col2: totalRevenue,
                col3: '(VND)',
                style: {
                    fontSize: 14 //optional, default 12
                }
            }],
            invDescLabel: "Statistics Note",
            invDesc: "The revenue above is the actual received revenue, meaning the revenue from invoices that have been paid!",
        },
        footer: {
            text: "The invoice is created on a computer and is valid without the signature and stamp.",
        },
        pageEnable: true,
        pageLabel: "Page ",
    };

    var pdfObject = jsPDFInvoiceTemplate.default(props); //returns number of pages created
}


//show payment-status for all sport fields of owner
document.addEventListener('DOMContentLoaded', function() {
    const radiosPaymentStatus = document.querySelectorAll('input[type="radio"][name="filter-payment-status"]');
    radiosPaymentStatus.forEach((radio) => {
        // Selected radio
        const currentUrl = new URL(window.location.href);
        const params = new URLSearchParams(currentUrl.search);
        const selectedStatus = params.get('status');
        if (selectedStatus) {
            radiosPaymentStatus.forEach((radio) => {
                if (radio.value === selectedStatus) {
                    radio.checked = true;
                }
            });
        }

        // Event listener for changing radio status
        radio.addEventListener('change', () => {
            //add new query param
            const params = new URLSearchParams();
            params.set('status', radio.value);
            //set param
            currentUrl.search = params.toString();
            //reload with new URL
            window.location.href = currentUrl.toString();
        });
    });
});


//show payment-status for one sport fields of owner
document.addEventListener('DOMContentLoaded', function() {
    const radiosDetailSportFieldPaymentStatus = document.querySelectorAll('input[type="radio"][name="filter-detail-sp-payment-status"]');
    radiosDetailSportFieldPaymentStatus.forEach((radio) => {
        // Selected radio
        const currentUrl = new URL(window.location.href);
        const params = new URLSearchParams(currentUrl.search);
        const selectedStatus = params.get('status');
        if (selectedStatus) {
            radiosDetailSportFieldPaymentStatus.forEach((radio) => {
                if (radio.value === selectedStatus) {
                    radio.checked = true;
                }
            });
        }

        // Event listener for changing radio status
        radio.addEventListener('change', () => {
            //add new query param
            const params = new URLSearchParams();
            params.set('status', radio.value);
            //set param
            currentUrl.search = params.toString();
            //reload with new URL
            window.location.href = currentUrl.toString();
        });
    });
});





