<?php
$characters = [
    'A', 'B', 'C',
    'D', 'F', 'F'
];

$characters = array_unique($characters);

$groups = [];
$groupSize = [3, 2];

while (count($characters) > 1) {
    
    if (count($characters) == 4)
        $groupSize = [2];

    foreach ($groupSize as $size) {
        if (count($characters) >= $size) {
            $group = [];

            for ($i = 0; $i < $size; $i++) {
                $randomIndex = array_rand($characters);
                $group[] = $characters[$randomIndex];
                array_splice($characters, $randomIndex, 1);
            }

            $groups[] = $group;
            break;
        }
    }
}

echo "<pre>";
print_r($groups);
echo "</pre>";
