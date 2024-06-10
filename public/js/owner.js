
const ownerRequest = '../../public/fieldowner';

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
            title: "Đã đăng ký thành công doanh nghiệp.",
            text: "Vui lòng đợi hệ thống xác nhận doanh nghiệp của bạn!",
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
      return `
       <tr>
        <th scope="col">${o.OwnerID}</th>
        <th scope="col">
        ${`<span class="${ (o.Status === "INACTIVE") ? "text-danger" : "text-success"}"> ${o.Status} </span>`
        }
        </th>
        <th scope="col">${o.BusinessName}</th>
        <th scope="col">${o.BusinessAddress}</th>
        <th scope="col">${o.PhoneNumber}</th>
        <th scope="col">
        <button onclick="handleUpdateOnwerStatus(${o.OwnerID})" class="btn  ${ (o.Status === "INACTIVE") ? "btn-success" : "btn-danger"}" title="Mở khóa/Xác nhận doanh nghiệp">
          ${ (o.Status === "INACTIVE") ? "Mở" : "Khóa"}
        </button>
      </tr>
    `;
    });

    htmlContent = htmlContent.join('');
    return htmlContent;
  }

}

const handleBusiness = async () => {
  const rowsContent = await getAllOwners();
  console.log(typeof rowsContent);
  const htmlContent = `
    <table class="table">
    <thead style="color:#FF6347">
      <tr>
        <th scope="col">Owner ID</th>
        <th scope="col">Trạng Thái</th>
        <th scope="col">Tên Doanh Nghiệp</th>
        <th scope="col">Địa chỉ</th>
        <th scope="col">Số Điện Thoại</th>
        <th scope="col">Mở / Khóa</th>
      </tr>
    </thead>
    <tbody>
     ${rowsContent}
    </tbody>
  </table>
  `;

  Swal.fire({
    title: "Doanh Nghiệp",
    width: '70%',
    padding: "1em",
    color: "#716add",
    background: "#fff url(https://sweetalert2.github.io/images/trees.png)",
    backdrop: `
      rgba(0,0,123,0.4)
      url("https://sweetalert2.github.io/images/nyan-cat.gif")
      left top
      no-repeat
    `,
    html: htmlContent

  });

}
