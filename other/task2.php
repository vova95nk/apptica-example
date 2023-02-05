<?php

$result = 0;

function checkNum(int $num)
{
    $numCount = strlen((string)$num);

    if ($numCount < 2) {
        return false;
    }

    $numbers = str_split((string)$num);

    for ($i = 0; $i < count($numbers) - 1; $i++) {
        $a = (int) $numbers[$i];
        $b = (int) $numbers[$i + 1];

        if ($a + 1 != $b)  {
            return false;
        }
    }

    return true;
}

for ($i = 1; $i <= 10000; $i++) {
    if (checkNum($i)) {
        $result += $i;
    }
}

var_dump($result);
