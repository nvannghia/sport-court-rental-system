
const ownerRequest = '/sport-court-rental-system/public/fieldowner';

// OLD FUNCTION REGISTER BUSINESS (FIELD OWNER) BY OTP 
// const handleOwnerRegister = async (ownerID) => {

//   const isOwnerRegisterd = await checkOwnerRegisterd(ownerID);
//   if (isOwnerRegisterd)
//     return;

//   Swal.fire({
//     title: "Thông tin doanh nghiệp",
//     html: `
//           <input id="businessName" class="swal2-input" placeholder="Tên doanh nghiệp...">
//           <input id="businessAddress" class="swal2-input" placeholder="Địa chỉ doanh nghiệp...">
//           <input id="businessPhone" class="swal2-input" placeholder="SĐT đại diện...">
//         `,
//     focusConfirm: false,
//     showCancelButton: true,
//     confirmButtonText: "Đăng ký",
//     cancelButtonText: "Hủy",
//     showLoaderOnConfirm: true,
//     customClass: {
//       title: 'custom-title',
//       confirmButton: 'custom-confirm-button',
//     },
//     preConfirm: async () => {
//       const businessName = document.getElementById('businessName').value;
//       const businessAddress = document.getElementById('businessAddress').value;
//       const businessPhone = document.getElementById('businessPhone').value;

//       if (!businessName || !businessAddress || !businessPhone) {
//         Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin.');
//         return false;
//       }

//       try {
//         const formData = new URLSearchParams();
//         formData.append('action', 'ownerRegister');
//         formData.append('businessName', businessName);
//         formData.append('businessAddress', businessAddress);
//         formData.append('businessPhone', businessPhone);

//         const ownerRegisterUrl = `${ownerRequest}/createBusiness`;
//         const response = await fetch(`${ownerRegisterUrl}`, {
//           method: 'POST',
//           headers: {
//             "Content-Type": "application/x-www-form-urlencoded",
//           },
//           body: formData.toString(),
//         });

//         const data = await response.json();

//         if (data.statusCode === 201) {
//           Swal.fire({
//             position: "center-center",
//             icon: "success",
//             title: "Đã đăng ký thành công doanh nghiệp.",
//             text: "Vui lòng đợi hệ thống xác nhận doanh nghiệp của bạn!",
//             showConfirmButton: true,
//           });
//         } else {
//           Swal.fire({
//             position: "center-center",
//             icon: "error",
//             title: "Đăng ký doanh nghiệp thất bại! Vui lòng liên hệ quản trị viên!",
//             showConfirmButton: true,
//           });
//         }

//       } catch (error) {
//         Swal.showValidationMessage(`Request failed: ${error}`);
//       }
//     },
//     allowOutsideClick: () => !Swal.isLoading()
//   })
// }

const handleOwnerRegister = async (ownerID) => {

  const isOwnerRegisterd = await checkOwnerRegisterd(ownerID);
  if (isOwnerRegisterd)
    return;

  $.ajax({
    url: "/sport-court-rental-system/app/utils/GenerateCaptcha.php", // Gọi file PHP để lấy CAPTCHA mới
    type: "GET",
    success: function (captchaImage) {
      Swal.fire({
        title: "Thông tin doanh nghiệp",
        html: `
              <input id="businessName" class="swal2-input" placeholder="Tên doanh nghiệp...">
              <input id="businessAddress" class="swal2-input" placeholder="Địa chỉ doanh nghiệp...">
              <input id="businessPhone" class="swal2-input" placeholder="SĐT đại diện...">
              <input id="captcha" class="swal2-input" type="text"  placeholder="Nhập captcha . . .">
              <div>
                <img id="captchaImage" src="data:image/png;base64,${captchaImage}" alt="CAPTCHA" style="margin-top:10px;">
                <button id="refreshCaptcha" style="margin-top:10px;" class="btn btn-primary"> <i class="fa-solid fa-rotate"></i></button>
              </div>
            `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Đăng ký",
        cancelButtonText: "Hủy",
        showLoaderOnConfirm: true,
        customClass: {
          title: 'custom-title',
          confirmButton: 'custom-confirm-button',
        },
        didOpen: () => {
          document.getElementById('refreshCaptcha').addEventListener('click', function () {
            fetch('/sport-court-rental-system/app/utils/GenerateCaptcha.php')
              .then(response => response.text())
              .then(captchaImage => {
                if (captchaImage) {
                  document.getElementById('captchaImage').src = 'data:image/png;base64,' + captchaImage;
                } else
                  alert("ERROR: The captcha is not available!");
              });
          });
        },
        preConfirm: async () => {
          const businessName = document.getElementById('businessName').value;
          const businessAddress = document.getElementById('businessAddress').value;
          const businessPhone = document.getElementById('businessPhone').value;
          const captcha = document.getElementById('captcha').value;

          if (!businessName || !businessAddress || !businessPhone || !captcha) {
            Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin.');
            return false;
          }

          try {
            const formData = new URLSearchParams();
            formData.append('action', 'ownerRegister');
            formData.append('businessName', businessName);
            formData.append('businessAddress', businessAddress);
            formData.append('businessPhone', businessPhone);
            formData.append('captcha', captcha);

            const ownerRegisterUrl = `${ownerRequest}/createBusiness`;
            const response = await fetch(`${ownerRegisterUrl}`, {
              method: 'POST',
              headers: {
                "Content-Type": "application/x-www-form-urlencoded",
              },
              body: formData.toString(),
            });

            const data = await response.json();

            if (data.statusCode === 201) {
              Swal.fire({
                position: "center-center",
                icon: "success",
                title: "ĐĂNG KÝ THÀNH CÔNG.",
                text: "Vui lòng đợi hệ thống xác nhận doanh nghiệp của bạn!",
                showConfirmButton: true,
              });
            } else {
              Swal.showValidationMessage(`Request failed: ${data.errorMessage}`);
            }

          } catch (error) {
            Swal.showValidationMessage(`Request failed: ${error}`);
          }
        },
        allowOutsideClick: () => !Swal.isLoading()
      })
    },
    error: function (e) {
      alert("The CAPTCHA is not available!");
    }
  });

}


const checkOwnerRegisterd = async (ownerID) => {
  const formData = new URLSearchParams();
  formData.append('action', 'checkOwnerRegisterd');
  formData.append('ownerID', ownerID);

  const ownerRegisterUrl = `${ownerRequest}/isOwnerRegistered`;
  const response = await fetch(`${ownerRegisterUrl}`, {
    method: 'POST',
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: formData.toString(),
  });

  const data = await response.json();

  if (data.statusCode == 409) {
    await Swal.fire({
      title: "Bạn đã đăng ký doanh nghiệp của mình!",
      showClass: {
        popup: `
            animate__animated
            animate__fadeInUp
            animate__faster
          `
      },
      hideClass: {
        popup: `
            animate__animated
            animate__fadeOutDown
            animate__faster
          `
      },
      text: "Nếu doanh nghiệp vẫn chưa được xác nhận vui lòng đợi thêm hoặc liên hệ QTV!",
      icon: "warning",
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "OK"
    })
    return true;
  }
}

const handleUpdateOnwerStatus = async (ownerID) => {
  // prevent double click when click to Khóa/Mở Button
  let btnStatus = document.getElementById(`btnStatus_${ownerID}`);
  btnStatus.setAttribute("disabled", true);

  setTimeout(() => {
    btnStatus.removeAttribute("disabled");
  }, 2000)

  const formData = new URLSearchParams();
  formData.append('action', 'updateOwnerStatus');
  formData.append('ownerID', ownerID);

  const ownerUpdateUrl = `${ownerRequest}/updateOwnerStatus`;
  const response = await fetch(ownerUpdateUrl, {
    method: 'POST',
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: formData.toString(),
  })

  const data = await response.json();

  if (data.statusCode === 200) {
    let textStatus = document.getElementById(`textStatus_${ownerID}`);

    if (data.fieldOwnerStatus === 0) {
      textStatus.innerText = "TẠM NGƯNG";
      btnStatus.innerHTML = "<i class='fa-solid fa-lock-open'></i>";
      textStatus.classList.remove("text-success");
      textStatus.classList.add("text-danger");
      btnStatus.classList.remove("btn-danger");
      btnStatus.classList.add("btn-success");
      btnStatus.setAttribute("title", "KHÓA DOANH NGHIỆP NÀY");
    } else {
      textStatus.innerText = "ĐANG HOẠT ĐỘNG";
      btnStatus.innerHTML  = "<i class='fa-solid fa-lock'></i>";
      textStatus.classList.remove("text-danger");
      textStatus.classList.add("text-success");
      btnStatus.classList.remove("btn-success");
      btnStatus.classList.add("btn-danger");
      btnStatus.setAttribute("title", "MỞ KHÓA DOANH NGHIỆP NÀY");
    }

  } else if (data.statusCode === 404)
    Swal.showValidationMessage('Not found!');
  else
    Swal.showValidationMessage('Server Internal Error!');
}


const getAllOwners = async () => {
  const formData = new URLSearchParams();
  formData.append('action', 'getAllOwners');

  const getAllOwnersUrl = `${ownerRequest}/getAllOwners`;
  const response = await fetch(`${getAllOwnersUrl}`, {
    method: 'POST',
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: formData.toString(),
  });

  const data = await response.json();
  let htmlContent = '';
  if (data.statusCode === 200) {
    htmlContent = data.owners.map((o) => {
      let status       = "ĐANG HOẠT ĐỘNG";
      let statusIcon   = "fa-lock";
      let bgColorClass = "danger";
      let btnTitle     = "KHÓA DOANH NGHIỆP";
      if (o.Status === 0) {
        status       = "TẠM NGƯNG";
        statusIcon   = "fa-lock-open";
        bgColorClass = "success";
        btnTitle     = "MỞ KHÓA DOANH NGHIỆP";
      }
      return `
       <tr class="d-flex align-items-center">
        <td scope="col" style="width: 25%" >${o.BusinessName}</td>
        <td scope="col" style="width: 15%" >
        ${`<small id="textStatus_${o.OwnerID}" class="${(o.Status === 0) ? "text-danger" : "text-success"} font-weight-bold "> ${status} </small>`}
        </td>
        <td scope="col" style="width: 30%" >${o.BusinessAddress}</td>
        <td scope="col" style="width: 15%" >${o.PhoneNumber}</td>
        <td scope="col" style="width: 10%">
          <button id="btnStatus_${o.OwnerID}" onclick="handleUpdateOnwerStatus(${o.OwnerID})" class="btn btn-${bgColorClass} rounded" title="${btnTitle}">
            <i class="fa-solid ${statusIcon}"></i>
          </button>   
        </td>
      </tr>
    `;
    });

    htmlContent = htmlContent.join('');
    return htmlContent;
  }

}

const handleBusiness = async () => {
  const rowsContent = await getAllOwners();

  const htmlContent = `
    <div class="table-container">
        <table class="table">
        <thead>
          <tr>
            <th scope = "col  style="width: 25%">DOANH NGHIỆP</th>
            <th scope = "col" style="width: 15%">TRẠNG THÁI</th>
            <th scope = "col" style="width: 30%">ĐỊA CHỈ</th>
            <th scope = "col" style="width: 15%">SĐT</th>
            <th scope = "col" style="width: 15%">MỞ / KHÓA</th>
          </tr>
        </thead>
        <tbody>
        ${rowsContent}
        </tbody>
      </table>
    </div>
  `;

  Swal.fire({
    title            : "QUẢN LÝ DOANH NGHIỆP",
    width            : '80%',
    padding          : "1em",
    color            : "#716add",
    html             : htmlContent,
    showCancelButton : false,
    showConfirmButton: true,
    confirmButtonText: 'Đóng'
  });

}
