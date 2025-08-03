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
            background-color: orange;
        }

        a {
            color: #73879C;
            text-decoration: none !important;
        }

        a:hover {
            color: gold;
            font-weight: bold;
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
    <div style="text-align:center">
        <span class="h5 text-warning font-weight-bold">* Lưu ý: giá sân bên dưới bảng là giá mỗi giờ</span>
        <hr>
    </div>

    <?php
    $openingTime    = $sportField['OpeningTime'];
    $closingTime    = $sportField['ClosingTime'];
    $priceDay       = $sportField['PriceDay'];
    $priceEvening   = $sportField['PriceEvening'];
    $fieldSize      = $sportField['FieldSize'];
    $numberOfFields = $sportField['NumberOfFields'];
    $sportFieldID   = $sportField['ID'];
    ?>

    <table style="color: #73879C">
        <thead>
            <tr id="header-row">
                <th></th>
                <th>Sân</th>
                <!-- Các cột ngày sẽ được thêm tự động bằng JavaScript -->
            </tr>
        </thead>
        <tbody>
            <?php
            $pricePerHour = $priceDay;
            ?>
            <?php while ($openingTime < $closingTime) : ?>
                <?php
                if ($openingTime >= 17) { // > 17h => tính giá chiều
                    $pricePerHour = $priceEvening;
                }
                ?>
                <?php for ($j = 0; $j < $numberOfFields; $j++) : ?>
                    <?php if ($j == 0) : ?>
                        <tr>
                            <td data-start-time=<?= $openingTime ?> id="start-time" class="text-dark font-weight-bold" rowspan="<?= $numberOfFields ?>">
                                <?= $openingTime ?>:00
                            </td>
                            <td class="text-dark">
                                Sân số <span data-field-number=<?= $j + 1 ?> id="field-number"> <?= $j + 1 ?></span>
                                <br>
                                (Sân <?= $fieldSize ?>)
                            </td>
                            <?php for ($i = 0; $i < 7; $i++) : ?>
                                <td>
                                    <a href="/sport-court-rental-system/public/booking/bookingDetail/<?= $sportFieldID ?>" style="cursor: pointer; padding:15px 40px" class="bg-white rounded">
                                        <?= $pricePerHour ?> đ
                                    </a>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td class="text-dark">
                                Sân số <span data-field-number=<?= $j + 1 ?> id="field-number"> <?= $j + 1 ?></span>
                                <br>
                                (Sân <?= $fieldSize ?>)
                            </td>
                            <?php for ($i = 0; $i < 7; $i++) : ?>
                                <td>
                                    <a href="/sport-court-rental-system/public/booking/bookingDetail/<?= $sportFieldID ?>" style="cursor: pointer; padding:15px 40px" class="bg-white rounded">
                                        <?= $pricePerHour ?> đ
                                    </a>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php
                $openingTime += 2;
                ?>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
<!-- // booking.js -->
<script src="/sport-court-rental-system/public/js/booking.js"></script>