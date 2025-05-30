const urlRequest = '/sport-court-rental-system/public/user';

const handleLogin = (evt) => {

  Swal.fire({
    title: "Đăng nhập",
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
        animate__fadeOutUp
        animate__faster
      `
    },
    html: `
        <input id="email" class="swal2-input" placeholder="Email..." value="@gmail.com">
        <input id="password" class="swal2-input" type="password" placeholder="Mật khẩu..." value="123456">
      `,
    focusConfirm: false,
    showCancelButton: true,
    confirmButtonText: "Đăng nhập",
    cancelButtonText: "Hủy",
    showLoaderOnConfirm: true,
    customClass: {
      title: 'custom-title',
      confirmButton: 'custom-confirm-button',
    },
    footer: '<div>Bạn chưa có tài khoản?</div><a href="#" onclick="handleRegister()">Đăng Ký Ngay</a>',
    preConfirm: async () => {
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      if (!email || !password) {
        Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin.');
        return false;
      }

      try {
        const formData = new URLSearchParams();
        formData.append('action', 'login');
        formData.append('email', email);
        formData.append('password', password);

        const loginUrl = `${urlRequest}/login`;
        const response = await fetch(`${loginUrl}`, {
          method: 'POST',
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: formData.toString(),
        });

        const data = await response.json();

        if (data.statusCode === 200) {
          window.location.reload();
        } else {
          Swal.showValidationMessage('Tài khoản hoặc mật khẩu không chính xác!');
        }

      } catch (error) {
        Swal.showValidationMessage(`Request failed: ${error}`);
      }
    },
    allowOutsideClick: () => !Swal.isLoading()
  })
};


const handleRegister = async () => {
  customerRegister();
}


const verifyOTP = () => {
  Swal.fire({
    title: "Nhập OTP . . .",
    showClass: {
      popup: `
        animate__animated
        animate__fadeInDown
        animate__faster
      `
    },
    hideClass: {
      popup: `
        animate__animated
        animate__fadeOutUp
        animate__faster
      `
    },
    html: `
      <input id="otp" class="swal2-input" placeholder="Nhập OTP . . ." required>
    `,
    inputAttributes: {
      autocapitalize: "off"
    },
    showCancelButton: true,
    confirmButtonText: "Xác thực",
    showLoaderOnConfirm: true,
    preConfirm: async () => {
      try {
        const otp = document.getElementById('otp').value;

        const formData = new URLSearchParams();
        formData.append('action', 'verifyOTP');
        formData.append('otp', otp);

        const registerUrl = `${urlRequest}/verifyOTPandSaveData`;
        const response = await fetch(registerUrl, {
          method: 'POST',
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: formData.toString(),
        });

        const data = await response.json();

        if (data.statusCode === 201) {
          // IF: register success
          await Swal.fire({
            title: 'Đăng ký thành công!',
            text: `Hãy đăng nhập`,
            icon: 'success'
          });

          handleLogin()
        } else {
          Swal.showValidationMessage('Đã xảy ra lỗi. Vui lòng liên hệ với admin hệ thống!');
        }

      } catch (error) {
        Swal.showValidationMessage(`
          Request failed: ${error}
        `);
      }
    },
    allowOutsideClick: () => !Swal.isLoading()
  })
}

function validateEmail(email) {
  // Biểu thức chính quy để kiểm tra định dạng email
  const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return re.test(String(email).toLowerCase());
}

// This old function is register user by OTP code via SMS (but not use more because the API is not free now)
// const customerRegister = () => {
//   Swal.fire({
//     title: "Khách hàng đăng ký",
//     showClass: {
//       popup: `
//         animate__animated
//         animate__fadeInLeft
//         animate__faster
//       `
//     },
//     hideClass: {
//       popup: `
//         animate__animated
//         animate__fadeOutRight
//         animate__faster
//       `
//     },
//     html: `
//         <input id="fullname" class="swal2-input" placeholder="Nhập tên đại diện . . .">
//         <input id="email" class="swal2-input"  placeholder="Nhập Email . . .">
//         <input id="password" class="swal2-input" type="password"  placeholder="Nhập mật khẩu . . .">
//         <input id="retypePassword" class="swal2-input" type="password"  placeholder="Nhập lại mật khẩu . . .">
//         <input id="address" class="swal2-input" type="text"  placeholder="Nhập địa chỉ . . .">
//         <input id="phoneNumber" class="swal2-input" type="text"  placeholder="Nhập SDT( nhận OTP) . . .">
//       `,
//     focusConfirm: false,
//     showCancelButton: true,
//     confirmButtonText: "Đăng ký",
//     cancelButtonText: "Hủy",
//     showLoaderOnConfirm: true,
//     customClass: {
//       title: 'custom-title',
//       confirmButton: 'custom-confirm-button',
//     },
//     footer: '<div>Bạn đã có tài khoản?</div><a href="#" onclick="handleLogin()">Đăng Nhập Ngay</a>',
//     preConfirm: async () => {
//       const fullname = document.getElementById('fullname').value;
//       const email = document.getElementById('email').value;
//       const password = document.getElementById('password').value;
//       const retypePassword = document.getElementById('retypePassword').value;
//       const address = document.getElementById('address').value;
//       let phoneNumber = document.getElementById('phoneNumber').value;

//       if (!fullname || !email || !password || !retypePassword || !address || !phoneNumber) {
//         Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin.');
//         return false;
//       }

//       if (!validateEmail(email)) {
//         Swal.showValidationMessage('Email không hợp lệ!');
//         return;
//       }

//       if (password !== retypePassword) {
//         Swal.showValidationMessage('Mật khẩu không khớp.');
//         return false;
//       }

//       const phoneRegex = /^0[0-9]{9}$/;
//       if (phoneRegex.test(phoneNumber) === false) {
//         Swal.showValidationMessage('Số điện thoại không hợp lệ!');
//         return;
//       } else {
//         phoneNumber = '+84' + parseInt(phoneNumber);
//       }

//       try {
//         const registerUrl = `${urlRequest}/verifyOTPandSaveData`;

//         const formData = new URLSearchParams();
//         formData.append('action', 'getOTP');
//         formData.append('email', email);
//         formData.append('password', password);
//         formData.append('fullname', fullname);
//         formData.append('address', address);
//         formData.append('phoneNumber', phoneNumber);

//         const response = await fetch(registerUrl,
//           {
//             method: 'POST',
//             headers: {
//               "Content-Type": "application/x-www-form-urlencoded",
//             },

//             body: formData.toString(),

//           });

//         const data = await response.json();

//         if (data.statusCode === 409) {
//           Swal.showValidationMessage(`Tên đăng nhập: ${data.emailExisted} đã tồn tại!`);
//           return;
//         }

//         if (data.status === "success") { //send otp via sms success
//           verifyOTP();
//         } else {
//           Swal.showValidationMessage('Gửi OTP qua sms không thành công!');
//         }

//         if (data.errorMessage) {
//           const errorMessages = [];
//           if (data.errorMessage) {
//             errorMessages.push(`Error Message: ${data.errorMessage}`);
//           }
//           return Swal.showValidationMessage(errorMessages.join('<br>'));
//         }



//       } catch (error) {
//         Swal.showValidationMessage(`Request failed: ${error}`);
//       }
//     },
//     allowOutsideClick: () => !Swal.isLoading()
//   })
// }


// New function customer register validate by CAPTCHA
const customerRegister = () => {
  $.ajax({
    url: "/sport-court-rental-system/app/utils/GenerateCaptcha.php", // Gọi file PHP để lấy CAPTCHA mới
    type: "GET",
    success: function (captchaImage) {
      Swal.fire({
        title: "Khách hàng đăng ký",
        showClass: {
          popup: `
            animate__animated
            animate__fadeInLeft
            animate__faster
          `
        },
        hideClass: {
          popup: `
            animate__animated
            animate__fadeOutRight
            animate__faster
          `
        },
        html: `
            <input id="fullname" class="swal2-input" value="Danh Ra Vút" placeholder="Nhập tên đại diện . . .">
            <input id="email" class="swal2-input" value="vut@gmail.com" placeholder="Nhập Email . . .">
            <input id="password" class="swal2-input" value="123456" type="password"  placeholder="Nhập mật khẩu . . .">
            <input id="retypePassword" class="swal2-input" value="123456" type="password"  placeholder="Nhập lại mật khẩu . . .">
            <input id="address" class="swal2-input" type="text" value="Hòa Hiệp, Tân Biên, Tây Ninh"  placeholder="Nhập địa chỉ . . .">
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
        footer: '<div>Bạn đã có tài khoản?</div><a href="#" onclick="handleLogin()">Đăng Nhập Ngay</a>',
        didOpen: () => {
          document.getElementById('refreshCaptcha').addEventListener('click', function () {
            fetch('/sport-court-rental-system/app/utils/GenerateCaptcha.php')
              .then(response => response.text())
              .then(captchaImage => {
                // console.log(captchaImage);
                if (captchaImage) {
                  document.getElementById('captchaImage').src = 'data:image/png;base64,' + captchaImage;
                } else
                  alert("ERROR: The captcha is not available!");
              });
          });
        },
        preConfirm: async () => {
          const fullname = document.getElementById('fullname').value;
          const email = document.getElementById('email').value;
          const password = document.getElementById('password').value;
          const retypePassword = document.getElementById('retypePassword').value;
          const address = document.getElementById('address').value;
          const captcha = document.getElementById('captcha').value;

          if (!fullname || !email || !password || !retypePassword || !address || !captcha) {
            Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin.');
            return false;
          }

          if (!validateEmail(email)) {
            Swal.showValidationMessage('Email không hợp lệ!');
            return;
          }

          if (password !== retypePassword) {
            Swal.showValidationMessage('Mật khẩu không khớp.');
            return false;
          }

          try {
            const registerUrl = `${urlRequest}/create`;

            const formData = new URLSearchParams();
            formData.append('email', email);
            formData.append('password', password);
            formData.append('fullname', fullname);
            formData.append('address', address);
            formData.append('captcha', captcha);

            const response = await fetch(registerUrl,
              {
                method: 'POST',
                headers: {
                  "Content-Type": "application/x-www-form-urlencoded",
                },

                body: formData.toString(),

              });

            const data = await response.json();

            if (data.statusCode === 409) {
              Swal.showValidationMessage(`Tên đăng nhập: ${data.emailExisted} đã tồn tại!`);
              return;
            }

            if (data.errorMessage) {
              const errorMessages = [];
              if (data.errorMessage) {
                errorMessages.push(`Error Message: ${data.errorMessage}`);
              }
              return Swal.showValidationMessage(errorMessages.join('<br>'));
            }

            if (data.statusCode === 201) {
              Swal.fire({
                title: 'Đăng ký thành công!',
                text: 'Vui lòng đăng nhập để sử dụng dịch vụ.',
                icon: 'success',
                confirmButtonText: 'Đăng nhập ngay',
                customClass: {
                  title: 'custom-title',
                  confirmButton: 'custom-confirm-button',
                },
              }).then((result) => {
                if (result.isConfirmed) {
                  handleLogin();
                }
              });
            } else {
              Swal.showValidationMessage('Đăng ký thất bại, vui lòng thử lại sau!');
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


const handleLogout = () => {
  Swal.fire({
    position: "top-right",
    title: 'Bạn có chắc chắn muốn đăng xuất?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Đăng xuất',
    cancelButtonText: 'Hủy',
    customClass: {
      title: 'my-custom-title-class',
      icon: 'my-custom-icon-class',
      popup: 'my-custom-popup',
      confirmButton: 'my-custom-small-confirm-cancel-button',
      cancelButton: 'my-custom-small-confirm-cancel-button',
    }
  }).then(async (result) => {
    const logoutUrl = `${urlRequest}/logout`;
    if (result.isConfirmed) {
      const response = await fetch(logoutUrl);

      const data = await response.json();

      if (data.statusCode === 200) {
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        await Toast.fire({
          icon: "success",
          title: "Đăng xuất thành công"
        });

        window.location.href = '/sport-court-rental-system/public/home';
      }
    }
  })
}







