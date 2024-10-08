
const ownerRequest = '/sport-court-rental-system/public/fieldowner';

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
  // prevent double click when click to Khóa/Mở Button
  let btnStatus = document.getElementById("btnStatus");
  btnStatus.setAttribute("disabled", true);

  setTimeout(() => {
    btnStatus.removeAttribute("disabled");
  }, 3000)

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
    const btnStatus = document.getElementById("btnStatus");
    const textStatus = document.getElementById("textStatus");
    const div = btnStatus.querySelector('div');
    const span = btnStatus.querySelector('span');
    const icon = btnStatus.querySelector('i');
    btnStatus.innerHTML = ""; // Xóa các phần tử con hiện có nằm trong btnStatus

    if (data.fieldOnwerStatus === "INACTIVE") {
      if (icon.classList.contains("fa-lock"))
        icon.classList.remove("fa-lock");

      icon.classList.add("fa-unlock");

      span.innerText = "Mở";
      btnStatus.classList.remove("btn-danger");
      btnStatus.classList.add("btn-success");
      textStatus.classList.remove("text-success");
      textStatus.classList.add("text-danger");

      // Thêm icon và span vào btnStatus
      div.appendChild(icon);
      div.appendChild(span);
      btnStatus.appendChild(div);
      textStatus.innerHTML = "INACTIVE";
    } else {
      if (icon.classList.contains("fa-lock"))
        icon.classList.remove("fa-lock");

      icon.classList.add("fa-lock");
      span.innerText = "Khóa";

      btnStatus.classList.remove("btn-success");
      btnStatus.classList.add("btn-danger");
      textStatus.classList.remove("text-danger");
      textStatus.classList.add("text-success");

      // Thêm icon và span vào btnStatus
      div.appendChild(icon);
      div.appendChild(span);
      btnStatus.appendChild(div);
      textStatus.innerHTML = "ACTIVE";
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
      return `
       <tr>
        <td scope="col">${o.OwnerID}</td>
        <td scope="col">
        ${`<span id="textStatus" class="${(o.Status === "INACTIVE") ? "text-danger" : "text-success"}"> ${o.Status} </span>`}
        </td>
        <td scope="col">${o.BusinessName}</td>
        <td scope="col">${o.BusinessAddress}</td>
        <td scope="col">${o.PhoneNumber}</td>
        <td scope="col">
          <button id="btnStatus" onclick="handleUpdateOnwerStatus(${o.OwnerID})" class="w-100 btn  ${(o.Status === "INACTIVE") ? "btn-success" : "btn-danger"}" title="Mở khóa/Xác nhận doanh nghiệp">
            <div class="d-flex  align-items-center justify-content-around">
              ${(o.Status === "INACTIVE")
          ?
          "<i class='fa-solid fa-unlock'></i> <span> Mở </span>"
          :
          "<i class='fa-solid fa-lock'></i> <span> Khóa </span>"
        } 
            </div>  
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
