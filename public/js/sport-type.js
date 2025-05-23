const sportTypeUrl = '/sport-court-rental-system/public/sporttype'

const parseToTime = (timestamp) => {
  // Chuyển đổi chuỗi thời gian thành đối tượng Date
  const date = new Date(timestamp);

  // Lấy ngày từ đối tượng Date
  const day = date.getUTCDate();
  const month = date.getUTCMonth() + 1; // Tháng bắt đầu từ 0 nên cần cộng thêm 1
  const year = date.getUTCFullYear();

  // Định dạng ngày theo DD-MM-YYYY
  const formattedDate = `${day.toString().padStart(2, '0')}-${month.toString().padStart(2, '0')}-${year}`;
  return formattedDate;
}

const updateSportType = async (sportTypeID, sportTypeName) => {


  const displayValidateElement = document.getElementById('displayValidate');
  const messageValidateElement = document.getElementById('messageValidate');
  const iconValidateElement = document.getElementById("iconValidate");

  const formData = new URLSearchParams();
  formData.append('action', 'editSportType');
  formData.append('sportTypeID', sportTypeID);
  formData.append('typeName', sportTypeName);


  const editSportTypeUrl = `${sportTypeUrl}/updateSportType`;
  const response = await fetch(`${editSportTypeUrl}`, {
    method: 'POST',
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: formData.toString(),
  });
  const data = await response.json();

  switch (data.statusCode) {
    case 200:
      displayValidateElement.classList.add("d-block");
      messageValidateElement.classList.remove("text-danger");
      iconValidateElement.classList.remove("text-danger");
      messageValidateElement.innerText = "Cập nhật thành công!";
      messageValidateElement.classList.add("text-success");
      iconValidateElement.classList.add("fa-circle-check", "text-success");

      const trUpdated = document.querySelector(`tr#row-${sportTypeID}`);
      const tdTypeNameUpdated = trUpdated.querySelector(`td#col-typeName-${sportTypeID}`);
      const tdUpdatedAt = trUpdated.querySelector(`td#col-updatedAt-${sportTypeID}`);

      tdTypeNameUpdated.innerText = data.sportType.TypeName;
      tdUpdatedAt.innerText = parseToTime(data.sportType.updated_at);

      //remove old onlick event and add new onlick event with new params
      let iconEdit = document.getElementById(`edit-sporttype-${sportTypeID}`);
      iconEdit.removeAttribute("onclick");
      iconEdit.setAttribute("onclick", `displayComponentEditSportType(${sportTypeID}, '${data.sportType.TypeName}')`);
      break;

    case 400:
      displayValidateElement.classList.add("d-block");
      messageValidateElement.innerText = "Cập nhật thất bại!";
      messageValidateElement.classList.remove("text-success");
      messageValidateElement.classList.add("text-danger");
      iconValidateElement.classList.remove("fa-circle-check", "text-success");
      iconValidateElement.classList.add("fa-circle-exclamation", "text-danger");
      break;

    case 409:
      displayValidateElement.classList.add("d-block");
      messageValidateElement.innerText = "Đã tồn tại tên thể loại!";
      messageValidateElement.classList.remove("text-success");
      messageValidateElement.classList.add("text-danger");
      iconValidateElement.classList.remove("fa-circle-check", "text-success");
      iconValidateElement.classList.add("fa-circle-exclamation", "text-danger");
      break;

    default:
      Swal.showValidationMessage('Server Internal Error!');
      break;
  }
}


const displayComponentEditSportType = (sportTypeID, sportTypeName) => {
  //hide add component and validate notify
  const addSportTypeComponent = document.getElementById("addSportType");
  const displayValidate = document.getElementById("displayValidate");

  if (addSportTypeComponent.classList.contains("d-block"))
    addSportTypeComponent.classList.remove("d-block");

  if (displayValidate.classList.contains("d-block"))
    displayValidate.classList.remove("d-block");

  if (addSportTypeComponent.classList.contains("d-block"))
    addSportTypeComponent.classList.remove("d-block");

  const editSportTypeElement = document.getElementById("editSportType");
  editSportTypeElement.classList.add("d-block");

  const inputElement = editSportTypeElement.querySelector("input#typeNameEdit");
  inputElement.value = sportTypeName;

  const btnEdit = editSportTypeElement.querySelector("button#editTypeSport");
  // Remove any existing event listeners to avoid multiple triggers
  const newBtnEdit = btnEdit.cloneNode(true);
  btnEdit.parentNode.replaceChild(newBtnEdit, btnEdit);

  // Add event listener with closure to pass parameters
  newBtnEdit.addEventListener("click", () => updateSportType(sportTypeID, inputElement.value));
}

const deleteSportType = async (sportTypeID) => {

  const displayValidateElement = document.getElementById('displayValidate');
  const messageValidateElement = document.getElementById('messageValidate');
  const iconValidateElement = document.getElementById("iconValidate");

  const deleteSportTypeUrl = `${sportTypeUrl}/deleteSportTypeByID/${sportTypeID}`;
  const response = await fetch(`${deleteSportTypeUrl}`);

  const data = await response.json();
  if (data.statusCode === 200) {

    // Clear previous classes and text
    messageValidateElement.classList.remove("text-danger");
    iconValidateElement.classList.remove("fa-circle-exclamation", "text-danger");

    // Add success classes and text
    displayValidateElement.classList.add("d-block");
    messageValidateElement.innerText = "Xóa thành công!";
    messageValidateElement.classList.add("text-success");
    iconValidateElement.classList.add("fa-circle-check", "text-success");

    //remove element
    const trRemove = document.querySelector(`tr#row-${sportTypeID}`);
    if (trRemove)
      trRemove.remove();

  }
  else if (data.statusCode === 400) {

    displayValidateElement.classList.add("d-block");
    messageValidateElement.innerText = "Xóa Thất Bại!";
    messageValidateElement.classList.add("text-danger");
    iconValidateElement.classList.add("fa-circle-exclamation", "text-danger");

  } else {
    Swal.fire({
      title: "Server Internal Error",
      text: "Lỗi phía server!",
      icon: "error"
    });
  }
}


const getAllSportTypes = async () => {
  const formData = new URLSearchParams();
  formData.append('action', 'getAllSportTypes');

  const getAllSportTypesUrl = `${sportTypeUrl}/getAllSportTypes`;
  const response = await fetch(`${getAllSportTypesUrl}`, {
    method: 'POST',
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: formData.toString(),
  });

  const data = await response.json();
  let htmlContent = '';
  if (data.statusCode === 200) {
    htmlContent = data.sportTypes.map((spT) => {
      return `
         <tr id="row-${spT.ID}">
          <td scope="col">${spT.ID}</td>
          <td scope="col" id="col-typeName-${spT.ID}">${spT.TypeName}</td>
          <td scope="col">${parseToTime(spT.created_at)}</td>
          <td scope="col" id="col-updatedAt-${spT.ID}">${parseToTime(spT.updated_at)}</td>
          <td scope="col d-flex">
            <i id="edit-sporttype-${spT.ID}" style="cursor:pointer" onclick="displayComponentEditSportType(${spT.ID},'${spT.TypeName}')" class="fa-solid fa-pen-to-square h3 text-warning fa-lg"></i>
            <span>|</span>
            <i style="cursor:pointer" onclick="deleteSportType(${spT.ID})" class="fa-solid fa-trash-can h3 text-danger fa-lg"></i>
          </td>
        </tr>
      `;
    });

    htmlContent = htmlContent.join('');
    return htmlContent;
  } else if (data.statusCode === 204) {
    return htmlContent;
  } else {
    Swal.showValidationMessage('Server Internal Error!');
    return false;
  }

}

const addSportType = async () => {
  const typeName = document.getElementById('typeName').value;
  const displayValidateElement = document.getElementById('displayValidate');
  const messageValidateElement = document.getElementById('messageValidate');
  const iconValidateElement = document.getElementById("iconValidate");

  iconValidateElement.classList.add("fa-circle-exclamation");
  iconValidateElement.classList.add("text-danger");
  messageValidateElement.classList.add("text-danger");

  if (!typeName) {
    displayValidateElement.classList.add("d-block");
    messageValidateElement.innerText = 'Vui lòng điền tên loại sân!'
    return false;
  }

  const formData = new URLSearchParams();
  formData.append('action', 'addSportType');
  formData.append('typeName', typeName);

  const addSportTypeUrl = `${sportTypeUrl}/addSportType`;
  const response = await fetch(`${addSportTypeUrl}`, {
    method: 'POST',
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: formData.toString(),
  });

  const data = await response.json();

  if (data.statusCode === 204) {
    displayValidateElement.classList.add("d-block");
    messageValidateElement.innerText = 'Vui lòng điền tên loại sân!'

  } else if (data.statusCode === 409) {
    displayValidateElement.classList.add("d-block");
    messageValidateElement.innerText = `Tên loại sân: \`${data.typeName}\` đã tồn tại!`

  } else if (data.statusCode === 200) {
    let tbodyContent = document.getElementById("tbodyContent");

    const tr = `<tr id="row-${data.sportType.ID}">
          <td scope="col">${data.sportType.ID}</td>
          <td scope="col" id="col-typeName-${data.sportType.ID}">${data.sportType.TypeName}</td>
          <td scope="col">${parseToTime(data.sportType.created_at)}</td>
          <td scope="col" id="col-updatedAt-${data.sportType.ID}">${parseToTime(data.sportType.updated_at)}</td>
          <td scope="col">
            <i style="cursor:pointer" onclick="displayComponentEditSportType(${data.sportType.ID},'${data.sportType.TypeName}')" class="fa-solid fa-pen-to-square h3 text-warning"></i>
            <span class="h3">|</span>
            <i style="cursor:pointer" onclick="deleteSportType(${data.sportType.ID})" class="fa-solid fa-trash-can h3 text-danger"></i>
          </td>
        </tr>`;

    tbodyContent.innerHTML += tr;

    displayValidateElement.classList.add("d-block");

    iconValidateElement.classList.remove("fa-circle-exclamation", "text-danger");
    iconValidateElement.classList.add("fa-circle-check", "text-success");

    messageValidateElement.classList.remove("text-danger");
    messageValidateElement.classList.add("text-success");
    messageValidateElement.innerText = "Thêm Thành Công"

    //clear text 
    document.getElementById('typeName').value = '';

    if (document.getElementById('noSportType'))
      document.getElementById('noSportType').remove(); // Xóa text "Không có thể loại nào" nếu lần đầù tiên add
  } else {
    displayValidateElement.classList.add("d-block");
    messageValidateElement.innerText = `Server Internal Error!`
  }

}


const displayComponentAddSportType = () => {
  //hide edit component and validate notify
  const editComponent = document.getElementById("editSportType");
  const displayValidate = document.getElementById("displayValidate");

  if (editComponent.classList.contains("d-block"))
    editComponent.classList.remove("d-block");

  if (displayValidate.classList.contains("d-block"))
    displayValidate.classList.remove("d-block");

  const addSportType = document.getElementById("addSportType");
  addSportType.classList.toggle("d-block");
}


const handleSportType = async () => {
  const rowsContent = await getAllSportTypes();


  const htmlContent = `
    <button onclick="displayComponentAddSportType()" type="button" class=" custom-button btn btn-outline-primary ms-1 mb-3">
    <i class="fa-solid fa-plus" ></i>
      <span>Thêm Loại Sân</span>
    </button>
    
    <div id="addSportType" class="d-none text-center">
      <div  class="row g-3 d-flex align-items-center justify-content-center mb-3">
        <div class="col-auto">
          <label for="typeName" class="col-form-label font-weight-bold" style="color:#FF6347">Thể Loại</label>
        </div>
        <div class="col-auto d-flex align-items-center justify-content-center">
          <input type="text" id="typeName" class="form-control" placeholder="Tên Thể Loại . . ." >
          <span id="passwordHelpInline" class="form-text text-danger font-weight-bold ml-2">
            *
          </span>
        </div>
        <div class="col-auto">
          <button onclick="addSportType()" type="button" class="custom-button btn btn-outline-primary ms-1">
            <i class="fa-solid fa-check-to-slot"></i>
            <span> Thêm </span>
          </button>
        </div> 
      </div>
      
    </div>

    <div id="editSportType" class="d-none text-center">
      <div  class="row g-3 d-flex align-items-center justify-content-center mb-3">
        <div class="col-auto">
          <label for="typeNameEdit" class="col-form-label font-weight-bold" style="color:#FF6347">Thể Loại</label>
        </div>
        <div class="col-auto d-flex align-items-center justify-content-center">
          <input type="text" id="typeNameEdit" class="form-control" placeholder="Tên Thể Loại . . ." >
          <span id="passwordHelpInline" class="form-text text-danger font-weight-bold ml-2">
            *
          </span>
        </div>
        <div class="col-auto">
          <button id="editTypeSport" type="button"  class="custom-button btn btn-outline-primary ms-1">
            <i class="fa-regular fa-pen-to-square"></i>
            <span> Sửa </span>
          </button>
        </div> 
      </div>
      
    </div>

    <div id="displayValidate" class="d-none border border-black" >
        <div style="padding: 8px;" class="text-danger bg-white d-flex align-items-center justify-content-center">
          <i id="iconValidate" class="fa-solid fa-circle-exclamation mr-3"></i>
          <span id="messageValidate"> validation message </span>
        </div>
    </div>

    <div class="table-container">
      <table class="table">
        <thead style="color:#123366">
          <tr class="bg-light ">
            <th scope="col">ID</th>
            <th scope="col">TÊN LOẠI SÂN</th>
            <th scope="col">NGÀY TẠO</th>
            <th scope="col">NGÀY SỬA</th>
            <th scope="col">SỬA | XÓA</th>
          </tr>
        </thead>
        <tbody id="tbodyContent">
        ${rowsContent ? rowsContent : ' <td id="noSportType" style="font-family: sans-serif;" class="text-danger font-weight-bold" colspan="5"> CHƯA CÓ DỮ LIỆU!</td>'}
        </tbody>
      </table>
    </div>
    `;

  Swal.fire({
    title     : "QUẢN LÝ LOẠI SÂN",
    width     : '60%',
    padding   : "1em",
    color     : "#716add",
    background: "#fff  no-repeat center center / contain ", 
    backdrop  : `
        rgba(0,0,123,0.4)
        url("/sport-court-rental-system/public/images/gif/sport-type-management_1.gif")
        left top
        no-repeat
      `,
    html: htmlContent,
    showCancelButton : false,
    showConfirmButton: true,
    confirmButtonText: 'Đóng',
  });


}