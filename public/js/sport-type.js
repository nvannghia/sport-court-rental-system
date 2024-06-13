const sportTypeUrl = '../../public/sporttype'

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
         <tr>
          <th scope="col">${spT.ID}</th>
          <th scope="col">${spT.TypeName}</th>
          <th scope="col">${spT.TypeName}</th>
          <th scope="col">${spT.TypeName}</th>
          <th scope="col">${spT.TypeName}</th>
        </tr>
      `;
        });

        htmlContent = htmlContent.join('');
        return htmlContent;
    } else if (data.statusCode === 204) {
        Swal.showValidationMessage('Không Có Thể Loại Sân Nào!');
        return false;
    } else {
        Swal.showValidationMessage('Server Internal Error!');
        return false;
    }

}

const handleSportType = async () => {
    const rowsContent = await getAllSportTypes();

    const htmlContent = `
    <table class="table">
    <thead style="color:#FF6347">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Tên Loại Sân</th>
        <th scope="col">Ngày Tạo</th>
        <th scope="col">Ngày Sửa</th>
        <th scope="col">Sửa / Xóa</th>
      </tr>
    </thead>
    <tbody>
     ${rowsContent}
    </tbody>
  </table>
  `;

  Swal.fire({
    title: "Thể Loại Sân",
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