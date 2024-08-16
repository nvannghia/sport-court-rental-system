
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
    console.log(data)
    if (data.statusCode === 200) {
        const invoiceData = data.invoice;
        console.log(invoiceData)
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


