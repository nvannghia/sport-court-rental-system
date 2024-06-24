<?php
$arrayDuplicate = [1, 2, 3, 'a', 'av', 'b', 'c', 'av', 1, 3, 'h', '10', '20', '10'];
$arrayUnique = [];
for ($i = 0; $i < count($arrayDuplicate); $i++) {
    if (!checkValueExits($arrayUnique, $arrayDuplicate[$i])) {
        $arrayUnique[] = $arrayDuplicate[$i];
    }
}

echo "<pre>";
print_r($arrayUnique);
echo "</pre>";



function checkValueExits(array $arrayCheck, $value)
{
    foreach ($arrayCheck as $valueA) {
        if ($valueA === $value)
            return true;
    }

    return false;
}
