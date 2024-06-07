
const handleOwnerRegister = async (ownerID) => {

  const isOwnerRegisterd = await checkOwnerRegisterd(ownerID);
  if (isOwnerRegisterd) 
    return;

  Swal.fire({
    title: "Thông tin doanh nghiệp",
    html: `
          <input id="businessName" class="swal2-input" placeholder="Tên doanh nghiệp...">
          <input id="businessAddress" class="swal2-input" placeholder="Địa chỉ doanh nghiệp...">
          <input id="businessPhone" class="swal2-input" placeholder="SĐT đại diện...">
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
      const businessName = document.getElementById('businessName').value;
      const businessAddress = document.getElementById('businessAddress').value;
      const businessPhone = document.getElementById('businessPhone').value;

      if (!businessName || !businessAddress || !businessPhone) {
        Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin.');
        return false;
      }

      try {
        const formData = new URLSearchParams();
        formData.append('action', 'ownerRegister');
        formData.append('businessName', businessName);
        formData.append('businessAddress', businessAddress);
        formData.append('businessPhone', businessPhone);

        const ownerRegisterUrl = '../../public/fieldowner/createBusiness';
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
            title: "Đã đăng ký thành công doanh nghiệp. Vui lòng đợi hệ thống xác nhận doanh nghiệp của bạn",
            showConfirmButton: true,
          });
        } else {
          Swal.fire({
            position: "center-center",
            icon: "error",
            title: "Đăng ký doanh nghiệp thất bại! Vui lòng liên hệ quản trị viên!",
            showConfirmButton: true,
          });
        }

      } catch (error) {
        Swal.showValidationMessage(`Request failed: ${error}`);
      }
    },
    allowOutsideClick: () => !Swal.isLoading()
  })
}


const checkOwnerRegisterd = async (ownerID) => {
  const formData = new URLSearchParams();
  formData.append('action', 'checkOwnerRegisterd');
  formData.append('ownerID', ownerID);

  const ownerRegisterUrl = '../../public/fieldowner/createBusiness';
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
