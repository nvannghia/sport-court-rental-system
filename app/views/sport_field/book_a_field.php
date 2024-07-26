<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Table</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            color: black;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-between align-items-center mr-3 ml-3">
        <button class="btn btn-info mb-3 mt-3" id="this-week">
            <span>
                TUẦN NÀY
            </span>
        </button>
        <div class="h2 mt-3" style="color: #73879C">
            <i class="fa-solid fa-angle-left"></i>
            <i class=" font-weight-bold mr-5 ml-5">LỊCH ĐẶT SÂN</i>
            <i class="fa-solid fa-angle-right"></i>
            <hr>
        </div>
        <button class="btn btn-info mb-3 mt-3 d-flex align-items-center" id="next-week">
            <span>
                TUẦN SAU
            </span>
            <i class="fa-solid fa-circle-right ml-2" style="font-size: 22px;"></i>
        </button>
    </div>
    <table style="color: #73879C">
        <thead>
            <tr id="header-row">
                <th></th>
                <!-- Các cột ngày sẽ được thêm tự động bằng JavaScript -->
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="4">5:30</td>
                <td>Sân 1
                    <br>
                    (sân 5)
                </td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
            </tr>
            <tr>
                <td>Sân 2
                    <br>
                    (sân 5)
                </td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
            </tr>
            <tr>
                <td>Sân 3
                    <br>
                    (sân 5)
                </td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
            </tr>
            <tr>
                <td>Sân 4
                    <br>
                    (sân 5)
                </td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
                <td>300.000 đ</td>
            </tr>
            <!-- Các hàng khác tùy chỉnh -->
        </tbody>
    </table>
    <script src="script.js"></script>
</body>

</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const daysOfWeek = ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"];
        let today = new Date();
        const headerRow = document.getElementById("header-row");

        function updateTable(startDate) {
            // Clear existing header
            while (headerRow.children.length > 1) {
                headerRow.removeChild(headerRow.lastChild);
            }

            for (let i = 0; i < 7; i++) {
                let currentDate = new Date(startDate);
                currentDate.setDate(startDate.getDate() + i);
                let day = daysOfWeek[currentDate.getDay()];
                let date = currentDate.toLocaleDateString('vi-VN');

                let th = document.createElement("th");
                th.innerHTML = `${day}<br>${date}`;
                headerRow.appendChild(th);
            }
        }

        document.getElementById("next-week").addEventListener("click", function() {
            today.setDate(today.getDate() + 7);
            updateTable(today);
        });

        document.getElementById("this-week").addEventListener("click", function() {
            let today = new Date();
            updateTable(today);
        });

        updateTable(today);
    });
</script>