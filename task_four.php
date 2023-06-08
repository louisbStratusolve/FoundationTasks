<?php


class ItemOwners
{
    public static function groupByOwners($ItemsArr) {
        $PeopleArr = [];
        foreach ($ItemsArr as $xKeyStr => $xValueStr) {
            $PeopleArr[$xValueStr][] = $xKeyStr;
        }
        return $PeopleArr;
    }
}

$ItemsArr = array(
    "Baseball Bat" => "John",
    "Golf ball" => "Stan",
    "Tennis Racket" => "John"
);
echo json_encode(ItemOwners::groupByOwners($ItemsArr));

?>