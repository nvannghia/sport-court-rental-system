const handleLogin = (evt) => {

  Swal.fire({
    title: "Đăng nhập",
    html: `
        <input id="email" class="swal2-input" placeholder="Tên đăng nhập">
        <input id="password" class="swal2-input" type="password" placeholder="Mật khẩu">
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
    preConfirm: async () => {
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      if (!email || !password) {
        Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin.');
        return false;
      }

      try {
        const loginUrl = `${apiRouteConfig.domain}/login`;
        const response = await fetch(loginUrl,
          {
            method: 'POST',
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              email: email,
              password: password,
            }),
          });

        const data = await response.json();
        if (data.error) {
          const errorMessages = [];
          if (data.error.email) {
            errorMessages.push(`Email: ${data.error.email.join(', ')}`);
          }
          if (data.error.password) {
            errorMessages.push(`Password: ${data.error.password.join(', ')}`);
          }

          return Swal.showValidationMessage(errorMessages.join('<br>'));
        }

        //save token
        localStorage.setItem("token", data.token);

        AuthDispatch({
          type: "login",
          payload: data.user,
        });

        navigate("/");
      } catch (error) {
        Swal.showValidationMessage(`Request failed: ${error}`);
      }
    },
    allowOutsideClick: () => !Swal.isLoading()
  })
};


const handleRegister = () => {
  Swal.fire({
    title: "Đăng ký",
    html: `
        <input id="fullname" class="swal2-input" placeholder="Nhập tên đại diện . . .">
        <input id="username" class="swal2-input"  placeholder="Nhập tên đăng nhập . . .">
        <input id="password" class="swal2-input" type="password"  placeholder="Nhập mật khẩu . . .">
        <input id="retypePassword" class="swal2-input" type="password"  placeholder="Nhập lại mật khẩu . . .">
        <input id="phoneNumber" class="swal2-input" type="text"  placeholder="Nhập SDT( nhận OTP) . . .">
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
    preConfirm: async () => {
      const fullname = document.getElementById('fullname').value;
      const username = document.getElementById('username').value;
      const password = document.getElementById('password').value;
      const retypePassword = document.getElementById('retypePassword').value;
      let phoneNumber = document.getElementById('phoneNumber').value;

      if (!fullname || !username || !password || !retypePassword || !phoneNumber) {
        Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin.');
        return false;
      }

      if (password !== retypePassword) {
        Swal.showValidationMessage('Mật khẩu không khớp.');
        return false;
      }

      const phoneRegex = /^0[0-9]{9}$/;
      if (phoneRegex.test(phoneNumber) === false) {
        Swal.showValidationMessage('Số điện thoại không hợp lệ!');
        return;
      } else {
        phoneNumber = '+84' + parseInt(phoneNumber);
      }

      try {
        const registerUrl = '../../public/user/verifyOTPandSaveData';

        const formData = new URLSearchParams();
        formData.append('action', 'getOTP');
        formData.append('username', username);
        formData.append('password', password);
        formData.append('fullname', fullname);
        formData.append('phoneNumber', phoneNumber);

        const response = await fetch(registerUrl,
          {
            method: 'POST',
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },

            body: formData.toString(),

          });

        const data = await response.json();
        if (data.status === "success") {
          verifyOTP();
        }

        if (data.errorMessage) {
          const errorMessages = [];
          if (data.errorMessage) {
            errorMessages.push(`Error Message: ${data.errorMessage}`);
          }
          return Swal.showValidationMessage(errorMessages.join('<br>'));
        }



      } catch (error) {
        Swal.showValidationMessage(`Request failed: ${error}`);
      }
    },
    allowOutsideClick: () => !Swal.isLoading()
  })
}


const verifyOTP = () => {
  Swal.fire({
    title: "Nhập OTP . . .",
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

        const registerUrl = '../../public/user/verifyOTPandSaveData';
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
        }

        if (data.statusCode === 500) {
          alert("failed to register! please contact to admin for more information!");
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