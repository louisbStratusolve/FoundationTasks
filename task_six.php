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

    function addMockData($PersonObjObj) {
        $ScaffoldedPersonsArr = [
            new PersonDto('John', 'Smith', '1990-05-15', 'john.smith@example.com', 33, null),
            new PersonDto('Emma', 'Johnson', '1982-09-10', 'emma.johnson@example.com', 41, null),
            new PersonDto('Michael', 'Brown', '1978-07-23', 'michael.brown@example.com', 45, null),
            new PersonDto('Sophia', 'Miller', '1995-03-19', 'sophia.miller@example.com', 28, null),
            new PersonDto('Daniel', 'Wilson', '1988-11-08', 'daniel.wilson@example.com', 33, null),
            new PersonDto('Olivia', 'Davis', '1992-02-14', 'olivia.davis@example.com', 31, null),
            new PersonDto('James', 'Anderson', '1984-06-30', 'james.anderson@example.com', 39, null),
            new PersonDto('Isabella', 'Taylor', '1997-08-25', 'isabella.taylor@example.com', 25, null),
            new PersonDto('William', 'Thomas', '1991-12-03', 'william.thomas@example.com', 31, null),
            new PersonDto('Ava', 'Harris', '1987-04-12', 'ava.harris@example.com', 36, null)
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
        $KeysArr = array_keys($PeopleArr["0"]);
        $ValuesArr = [];
        foreach ($PeopleArr as $PersonObj) {
            foreach ($PersonObj as $key => $value) {
                $ValuesArr[] = array_values($value);
            }
            $this->insertRecords("Person", $KeysArr, $ValuesArr);
        }
    }

    function insertRecords($TableNameStr, $KeyArr, $ValuesArr) {
        $TheQueryStr = "INSERT INTO $TableNameStr (implode(', ', $KeyArr)) VALUES (";
        for ($RowIteratorInt = 0; $RowIteratorInt <= count($ValuesArr); $RowIteratorInt++) {
            $Row = $ValuesArr[$RowIteratorInt];
            $TheQueryStr .= "(implode(', ', $Row))";
        }
        echo $TheQueryStr;
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
$ReturnDataObj = json_encode($PersonObj->addMockData($PersonObj));

$CurrentTimeFlt = microtime(true);
$TimeStampInt = time();
$CurrentDateStr = gmdate("Y-m-d H:i:s", $TimeStampInt);
$LoggingDtoObj = new LoggingDto("loadAllPeople()", "loadAllPeople() DB Query", $CurrentDateStr, 0);
$ReturnDataObj = json_encode($PersonObj->loadAllPeople());
$LoggingDtoObj->QueryTimeInt = round(microtime(true) - $CurrentTimeFlt, 3) * 1000;
$LoggingObj->createLog($LoggingDtoObj);

echo $ReturnDataObj;


?>