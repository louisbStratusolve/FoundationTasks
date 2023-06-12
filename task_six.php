<?php

class LoggingDto {
    public $IdInt;
    public $NameStr;
    public $DescriptionStr;
    public $CreatedStr;
    public $QueryTimeInt;

    function __construct($NameStr, $DescriptionStr, $CreatedStr, $QueryTimeInt) {
        $this->NameStr = $NameStr;
        $this->DescriptionStr = $DescriptionStr;
        $this->CreatedStr = $CreatedStr;
        $this->QueryTimeInt = $QueryTimeInt;
    }

}

class PersonDto {
    public $IdInt;
    public $FirstNameStr;
    public $SurnameStr;
    public $DateOfBirthStr;
    public $EmailAddressStr;
    public $AgeInt;

    function __construct($FirstNameStr, $SurnameStr, $DateOfBirthDate, $EmailAddressStr, $AgeInt, $IdInt) {
        $this->FirstNameStr = $FirstNameStr;
        $this->SurnameStr = $SurnameStr;
        $this->DateOfBirthStr = $DateOfBirthDate;
        $this->EmailAddressStr = $EmailAddressStr;
        $this->AgeInt = $AgeInt;
        $this->IdInt = $IdInt;
    }

}

class Logging {
    private $ConnectionObj = null;

    function __construct($ConnectionObj) {
        $this->ConnectionObj = $ConnectionObj;
    }

    function createLog($Log) {
        $QueryStr = "
            INSERT INTO Logging (Name, Description, Created, QueryTime) 
            VALUES (
            '$Log->NameStr',
            '$Log->DescriptionStr', 
            '$Log->CreatedStr', 
            '$Log->QueryTimeInt')";

        if (!mysqli_query($this->ConnectionObj, $QueryStr)) {
            echo "Failed inserting ".$this->ConnectionObj->error;
        }
        return $QueryStr;
    }
}

class Person {
    private $ConnectionObj = null;

    function __construct($ConnectionObj) {
        $this->ConnectionObj = $ConnectionObj;
    }

    function addMockData() {
        $ScaffoldedPersonsArr = [
            (object)['FirstName' => 'John', 'Surname' => 'Smith', 'DateOfBirth' => '1990-05-15',
                'EmailAddress' => 'john.smith@example.com', 'Age' => 33
            ],
            (object)['FirstName' => 'Emma', 'Surname' => 'Johnson', 'DateOfBirth' => '1982-09-10',
                'EmailAddress' => 'emma.johnson@example.com', 'Age' => 41
            ],
            (object)['FirstName' => 'Michael', 'Surname' => 'Brown', 'DateOfBirth' => '1978-07-23',
                'EmailAddress' => 'michael.brown@example.com', 'Age' => 45
            ],
            (object)['FirstName' => 'Sophia', 'Surname' => 'Miller', 'DateOfBirth' => '1995-03-19',
                'EmailAddress' => 'sophia.miller@example.com', 'Age' => 28
            ],
            (object)['FirstName' => 'Daniel', 'Surname' => 'Wilson', 'DateOfBirth' => '1988-11-08',
                'EmailAddress' => 'daniel.wilson@example.com', 'Age' => 33
            ],
            (object)['FirstName' => 'Olivia', 'Surname' => 'Davis', 'DateOfBirth' => '1992-02-14',
                'EmailAddress' => 'olivia.davis@example.com', 'Age' => 31
            ],
            (object)['FirstName' => 'James', 'Surname' => 'Anderson', 'DateOfBirth' => '1984-06-30',
                'EmailAddress' => 'james.anderson@example.com', 'Age' => 39
            ],
            (object)['FirstName' => 'Isabella', 'Surname' => 'Taylor', 'DateOfBirth' => '1997-08-25',
                'EmailAddress' => 'isabella.taylor@example.com', 'Age' => 25
            ],
            (object)['FirstName' => 'William', 'Surname' => 'Thomas', 'DateOfBirth' => '1991-12-03',
                'EmailAddress' => 'william.thomas@example.com', 'Age' => 31
            ],
            (object)['FirstName' => 'Ava', 'Surname' => 'Harris', 'DateOfBirth' => '1987-04-12',
                'EmailAddress' => 'ava.harris@example.com', 'Age' => 36
            ]
        ];

        $this->createPeople($ScaffoldedPersonsArr);
        return true;
    }

    //TODO change to createPeople($PersonArr), and
    //TODO Remove word "THE"
    //TODO TASK 2,5,6
    //TODO change PersonDto()
    //$PersonObj = (object)[
    //'FirstName' => 'Brett',
    //]

    //TODO createPeople([$PersonObj]){}
    //  insertRows("Person", $PersonArr) //
    //TODO: col names try build wit this for propnames
    //        foreach ($obj as $key => $value) {
    //            echo "$key => $value\n";
    //        }

    function createPeople($PeopleArr) {
        //echo(json_encode($PeopleArr));
        $FirstElement = reset($PeopleArr);
        $KeyArr = [];
        foreach ($FirstElement as $KeyStr => $ValueStr) {
            $KeyArr[] = $KeyStr;
        }
        $ValueArr = [];
        foreach ($PeopleArr as $PersonObj) {
            $PersonValueArr = [];
            foreach ($PersonObj as $PersonPropertyKeyStr => $PersonPropertyValueStr) {
                $PersonValueArr[] = $PersonPropertyValueStr;
            }
            $ValueArr[] = $PersonValueArr;
        }
        $this->insertRecords("Person", $KeyArr, $ValueArr);
    }

    function insertRecords($TableNameStr, $KeyArr, $ValueArr) {
        $KeyStr = implode(', ', $KeyArr);
        $TheQueryStr = "INSERT INTO $TableNameStr ($KeyStr) VALUES ";
        for ($RowIteratorInt = 0; $RowIteratorInt < count($ValueArr); $RowIteratorInt++) {
            $Row = $ValueArr[$RowIteratorInt];
            $TheQueryStr .= "(";
            for ($CellIteratorInt = 0; $CellIteratorInt < count($Row); $CellIteratorInt++) {
                $TheQueryStr .= "'$Row[$CellIteratorInt]'";
                if ($CellIteratorInt != count($Row)-1) {
                    $TheQueryStr .= ", ";
                }
            }
            if ($RowIteratorInt != count($ValueArr)-1) {
                $TheQueryStr .= "), ";
            } else {
                $TheQueryStr .= ")";
            }
        }

        $TheQueryStr = rtrim($TheQueryStr,",");
        $QuerySuccessful = mysqli_query($this->ConnectionObj, $TheQueryStr);
        if (!$QuerySuccessful) {
            echo "Failed inserting ".$this->ConnectionObj->error;
            return;
        }
        return $QuerySuccessful;
    }

    function loadPerson($IdInt) {
    }

    function savePerson($PersonObj) {
    }

    function deletePerson($id) {
    }

    function loadAllPeople() {
        $TheQueryStr = "SELECT * FROM Person;";
        $QueryResultObj = $this->ConnectionObj->query($TheQueryStr);
        $QueryReturnResultArr = [];

        if ($QueryResultObj->num_rows > 0) {
            while ($row = mysqli_fetch_array($QueryResultObj, MYSQLI_ASSOC)) {
                $QueryReturnResultArr[] = $row;
            }
        }
        return $QueryReturnResultArr;
    }

    function deleteAllPeople() {
        $TheQueryStr = "DELETE FROM Person";
        $QueryResultBool = mysqli_query($this->ConnectionObj, $TheQueryStr);

        if (!$QueryResultBool) {
            echo "Failed inserting ".$this->ConnectionObj->error;
            return;
        }
        return $QueryResultBool;
    }

}

//Connection
$ServerNameStr = "127.0.0.1";
$UsernameStr = "user";
$PasswordStr = "secret";
$DatabaseStr = "foundation_task";
$ConnectionObj = new mysqli($ServerNameStr, $UsernameStr, $PasswordStr, $DatabaseStr);
if ($ConnectionObj->connect_error) {
    die("Connection failed: ".$ConnectionObj->connect_error);
}

$LoggingObj = new Logging($ConnectionObj);
$PersonObj = new Person($ConnectionObj);
$ReturnDataObj = "";

$ReturnDataObj = json_encode($PersonObj->deleteAllPeople());
$ReturnDataObj = json_encode($PersonObj->addMockData());

$CurrentTimeFlt = microtime(true);
$TimeStampInt = time();
$CurrentDateStr = gmdate("Y-m-d H:i:s", $TimeStampInt);
$LoggingDtoObj = new LoggingDto("loadAllPeople()", "loadAllPeople() DB Query", $CurrentDateStr, 0);
$ReturnDataObj = json_encode($PersonObj->loadAllPeople());
$LoggingDtoObj->QueryTimeInt = round(microtime(true) - $CurrentTimeFlt, 3) * 1000;
$LoggingObj->createLog($LoggingDtoObj);

echo $ReturnDataObj;


?>