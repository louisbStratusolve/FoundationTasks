<?php


class ItemOwners
{
    public static function groupByOwners($ItemsArr)
    {
        $AssocArray = [];
        foreach ($ItemsArr as $xKey => $xValue) {
            $AssocArray[$xValue][] = $xKey;
        }
        return $AssocArray;
    }
}

$ItemsArr = array(
    "Baseball Bat" => "John",
    "Golf ball" => "Stan",
    "Tennis Racket" => "John"
);
echo json_encode(ItemOwners::groupByOwners($ItemsArr));

?>