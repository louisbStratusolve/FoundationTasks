<?php

//TODO TASK 2,5,6
//DONE change to createPeople($PersonArr), and
//DONE Remove word "THE"
//DONE change PersonDto()
//$PersonObj = (object)[
//'FirstName' => 'Brett',
//]

//DONE createPeople([$PersonObj]){}
//  insertRows("Person", $PersonArr) //
//DONE: col names try build wit this for propnames
//        foreach ($obj as $key => $value) {
//            echo "$key => $value\n";
//        }

class BaseClass{
    private $ConnectionObj = null;
    function __construct($ConnectionObj) {
        $this->ConnectionObj = $ConnectionObj;
    }

    public function insertRecords($TableNameStr, $KeyArr, $ValueArr) {
        $KeyStr = implode(', ', $KeyArr);
        $QueryStr = "INSERT INTO $TableNameStr ($KeyStr) VALUES ";
        for ($RowIteratorInt = 0; $RowIteratorInt < count($ValueArr); $RowIteratorInt++) {
            $Row = $ValueArr[$RowIteratorInt];
            $QueryStr .= "(";
            for ($CellIteratorInt = 0; $CellIteratorInt < count($Row); $CellIteratorInt++) {
                $QueryStr .= "'$Row[$CellIteratorInt]'";
                if ($CellIteratorInt != count($Row)-1) {
                    $QueryStr .= ", ";
                }
            }
            if ($RowIteratorInt != count($ValueArr)-1) {
                $QueryStr .= "), ";
            } else {
                $QueryStr .= ")";
            }
        }

        $QueryStr = rtrim($QueryStr,",");
        $QuerySuccessful = mysqli_query($this->ConnectionObj, $QueryStr);
        if (!$QuerySuccessful) {
            echo "Failed inserting ".$this->ConnectionObj->error;
            return;
        }
        return $QuerySuccessful;
    }
    public function shapeDataForInsert($DynamicObj){
        $FirstElement = reset($DynamicObj);
        $KeyArr = [];
        foreach ($FirstElement as $KeyStr => $ValueStr) {
            $KeyArr[] = $KeyStr;
        }
        $ValueArr = [];
        foreach ($DynamicObj as $SubDynamicObj) {
            $LocalValueArr = [];
            foreach ($SubDynamicObj as $PropertyKeyStr => $PropertyValueStr) {
                $LocalValueArr[] = $PropertyValueStr;
            }
            $ValueArr[] = $LocalValueArr;
        }
        return (object)["KeyArr"=>$KeyArr, "ValueArr"=>$ValueArr];
    }

}

class Logging extends BaseClass {
    function __construct($ConnectionObj) {
        $this->ConnectionObj = $ConnectionObj;
        parent::__construct($ConnectionObj);
    }

    function createLog($LogArr) {
        $ShapedDataObj = $this->shapeDataForInsert($LogArr);
        $this->insertRecords("Logging", $ShapedDataObj->KeyArr, $ShapedDataObj->ValueArr);
    }
}

class Person extends BaseClass {
    private $ConnectionObj = null;

    function __construct($ConnectionObj) {
        $this->ConnectionObj = $ConnectionObj;
        parent::__construct($ConnectionObj);
    }

    function loadPerson($IdInt)
    {
        $QueryStr = "SELECT Id, FirstName, Surname, DateOfBirth, EmailAddress, Age 
                        FROM Person where id=$IdInt";
        $PersonQueryResultObj = $this->ConnectionObj->query($QueryStr);
        $PersonArr = [];
        if ($PersonQueryResultObj->num_rows > 0) {
            while ($PersonObj = mysqli_fetch_array($PersonQueryResultObj, MYSQLI_ASSOC)) {
                $PersonArr[] = $PersonObj;
            }
        }
        return $PersonArr;
    }

    function savePerson($PersonObj)
    {
        // $strDate = $PersonObj->dateOfBirth->format('Y-m-d H:i:s');
        $QueryStr = "UPDATE Person SET 
                        FirstName = '$PersonObj->FirstNameStr',
                        Surname = '$PersonObj->SurnameStr', 
                        DateOfBirth = '$PersonObj->DateOfBirthStr', 
                        EmailAddress = '$PersonObj->EmailAddressStr', 
                        Age = '$PersonObj->AgeInt'
                      WHERE Id = $PersonObj->IdInt";

        $QueryResultBool = mysqli_query($this->ConnectionObj, $QueryStr);

        if (!$QueryResultBool) {
            echo "Failed inserting ".$this->ConnectionObj->error;
            return;
        }
        return $QueryResultBool;
    }

    function deletePerson($id)
    {
        $QueryStr = "DELETE FROM Person WHERE Id = $id";
        $QueryResultBool = mysqli_query($this->ConnectionObj, $QueryStr);

        if (!$QueryResultBool) {
            echo "Failed inserting ".$this->ConnectionObj->error;
            return;
        }
        return $QueryResultBool;
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

    function createPeople($PeopleArr) {
        //echo(json_encode($PeopleArr));
        $ShapedDataObj = $this->shapeDataForInsert($PeopleArr);
        $this->insertRecords("Person", $ShapedDataObj->KeyArr, $ShapedDataObj->ValueArr);
    }


    function loadAllPeople() {
        $QueryStr = "SELECT * FROM Person;";
        $QueryResultObj = $this->ConnectionObj->query($QueryStr);
        $QueryReturnResultArr = [];

        if ($QueryResultObj->num_rows > 0) {
            while ($row = mysqli_fetch_array($QueryResultObj, MYSQLI_ASSOC)) {
                $QueryReturnResultArr[] = $row;
            }
        }
        return $QueryReturnResultArr;
    }

    function deleteAllPeople() {
        $QueryStr = "DELETE FROM Person";
        $QueryResultBool = mysqli_query($this->ConnectionObj, $QueryStr);

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

$Logging = new Logging($ConnectionObj);
$PersonObj = new Person($ConnectionObj);
$ReturnDataObj = "";

if ($_POST && !array_key_exists("_method", $_POST) && array_key_exists("Type", $_POST)) {
    if ($_POST["Type"] == "allPeople") {
        $CurrentTimeFlt = microtime(true);
        $TimeStampInt = time();
        $CurrentDateStr = gmdate("Y-m-d H:i:s", $TimeStampInt);
        $ReturnDataObj = json_encode($PersonObj->loadAllPeople());
        $QueryTime = round(microtime(true) - $CurrentTimeFlt, 3) * 1000;
        $LoggingDtoObj = [(object)['Name' => 'loadAllPeople()', 'Description'=>'loadAllPeople() DB Query', 'Created' => $CurrentDateStr, "QueryTime"=>$QueryTime]];
        $Logging->createLog($LoggingDtoObj);        
    } else if ($_POST["Type"] == "addMockData") {
        $ReturnDataObj = json_encode($PersonObj->addMockData());
    } else if ($_POST["Type"] == "createPerson") {
        $PersonDtoArr = [(object)['FirstName' => $_POST["FirstName"], 'Surname' => $_POST["Surname"], 'DateOfBirth' => $_POST["DateOfBirth"],
            'EmailAddress' => $_POST["EmailAddress"], 'Age' => $_POST["Age"]]];
            $ReturnDataObj = json_encode($PersonObj->createPeople($PersonDtoArr));
    }
} else if ($_GET && array_key_exists("Id", $_GET)) {
    $ReturnDataObj = json_encode($PersonObj->loadPerson($_GET["Id"]));
} else if (array_key_exists('_method', $_POST)) {
    if ($_POST['_method'] === 'PUT') {
        parse_str(file_get_contents("php://input"), $http_vars);
        $PersonDtoArr = new PersonDto($http_vars["FirstName"], $http_vars["Surname"], $http_vars["DateOfBirth"], $http_vars["EmailAddress"], $http_vars["Age"], $http_vars["Id"]);
        $ReturnDataObj = json_encode($PersonObj->savePerson($PersonDtoArr));
    } else if ($_POST['_method'] === 'DELETE') {
        parse_str(file_get_contents("php://input"), $http_vars);
        if (array_key_exists("Id", $http_vars)) {
            $ReturnDataObj = json_encode($PersonObj->deletePerson($http_vars["Id"]));
        } else {
            $ReturnDataObj = json_encode($PersonObj->deleteAllPeople());
        }
    }
}

echo $ReturnDataObj;

?>