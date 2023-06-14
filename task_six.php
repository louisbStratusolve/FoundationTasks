<?php

class Timer {
    protected $TimeFlt;
    protected $DeltaFlt;

    function __construct() {
        $this->TimeFlt = microtime(true);
        $this->DeltaFlt = microtime(true);
    }

    public function reset() {
        $this->TimeFlt = 0;
        $this->DeltaFlt = 0;
    }

    public function read() {
        $TotalFlt = $this->evaluate($this->TimeFlt);
        $this->reset();
        return $TotalFlt;
    }

    public function delta($NameStr = '') {
        $ReturnFlt = $this->evaluate($this->DeltaFlt);
        $this->DeltaFlt = microtime(true);
        echo $NameStr.': '.$ReturnFlt.'s<br>';
    }

    protected function evaluate($TimeFlt) {
        return round(microtime(true) - $TimeFlt, 3);
    }
}
class BaseClass {
    private $ConnectionObj = null;

    function __construct($ConnectionObj) {
        $this->ConnectionObj = $ConnectionObj;
    }

    public function createRows($TableNameStr, $ObjArr) {
        $KeyArr = [];
        foreach (reset($ObjArr) as $KeyStr => $ValueMixed) {
            $KeyArr[] = $KeyStr;
        }
        $KeySqlStr = implode(',', $KeyArr);
        $SqlValuesArr = [];
        foreach ($ObjArr as $Obj) {
            $ValueMixedArr = [];
            foreach ($Obj as $KeyStr => $ValueMixed) {
                $ValueMixedArr[] = '"'.$ValueMixed.'"';
            }
            $SqlValuesArr[] = '('.implode(',', $ValueMixedArr).')';
        }
        return 'INSERT INTO '.$TableNameStr.' ('.$KeySqlStr.') VALUES '.implode(',', $SqlValuesArr);
    }

}

class Logging extends BaseClass {
    private $TimerObj = [];

    function __construct($ConnectionObj) {
        $this->ConnectionObj = $ConnectionObj;
        parent::__construct($ConnectionObj);
    }

    function startLog() {
        $this->TimerObj = new Timer();
    }

    function endLog($NameStr) {
        $LogArr = [
            (object)['Name' => $NameStr, 'Created' => date("Y-m-d h:i"), 'QueryTime' => $this->TimerObj->read()]];
        $this->createLogs($LogArr);

        return true;
    }

    private function createLogs($LogArr) {
        $SqlStr = $this->createRows("Logging", $LogArr);
        return mysqli_query($this->ConnectionObj, $SqlStr);
    }

    private function createLog($LogObj) {
        return $this->createLogs([$LogObj]);
    }
}

class Person extends BaseClass {
    private $ConnectionObj = null;

    function __construct($ConnectionObj) {
        $this->ConnectionObj = $ConnectionObj;
        parent::__construct($ConnectionObj);
    }

    function loadPerson($IdInt) {
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

    function savePerson($PersonObj) {
        // $strDate = $PersonObj->dateOfBirth->format('Y-m-d H:i:s');
        $QueryStr = "UPDATE Person SET 
                        FirstName = '$PersonObj->FirstName',
                        Surname = '$PersonObj->Surname', 
                        DateOfBirth = '$PersonObj->DateOfBirth', 
                        EmailAddress = '$PersonObj->EmailAddress', 
                        Age = '$PersonObj->Age'
                      WHERE Id = $PersonObj->Id";

        echo $QueryStr;
        $QueryResultBool = mysqli_query($this->ConnectionObj, $QueryStr);

        if (!$QueryResultBool) {
            echo "Failed inserting ".$this->ConnectionObj->error;
            return;
        }
        return $QueryResultBool;
    }

    function deletePerson($id) {
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

    function createPeople($PeopleArr): bool {
        $SqlStr = $this->createRows("Person", $PeopleArr);
        return mysqli_query($this->ConnectionObj, $SqlStr);
    }

    function createPerson($PersonObj) {
        return $this->createPeople([$PersonObj]);
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

$LogObj = new Logging($ConnectionObj);
$PersonObj = new Person($ConnectionObj);
$ReturnJsonStr = "";
$MethodStr = "";

$MethodStr = $_POST['Type'];

switch ($MethodStr) {
    case 'getPerson':
        $ReturnJsonStr = json_encode($PersonObj->loadPerson($_POST["Id"]));
        break;
    case 'updatePerson':
        $PersonDtoArr = (object)['FirstName' => $_POST["FirstName"], 'Surname' => $_POST["Surname"],
            'DateOfBirth' => $_POST["DateOfBirth"],
            'EmailAddress' => $_POST["EmailAddress"], 'Age' => $_POST["Age"], 'Id' => $_POST["Id"]];
        $ReturnJsonStr = json_encode($PersonObj->savePerson($PersonDtoArr));
        break;
    case 'createPerson':
        $PersonDtoArr = (object)['FirstName' => $_POST["FirstName"], 'Surname' => $_POST["Surname"],
            'DateOfBirth' => $_POST["DateOfBirth"],
            'EmailAddress' => $_POST["EmailAddress"], 'Age' => $_POST["Age"]];
        $ReturnJsonStr = json_encode($PersonObj->createPerson($PersonDtoArr));
        break;
    case 'deletePerson':
        $ReturnJsonStr = json_encode($PersonObj->deletePerson($_POST["Id"]));
        break;
    case 'deleteAllPeople':
        $ReturnJsonStr = json_encode($PersonObj->deleteAllPeople());
        break;
    case 'getAllPeople':
        $LogObj->startLog();
        $ReturnJsonStr = json_encode($PersonObj->loadAllPeople());
        $LogObj->endLog("loadAllPeople");
        break;
    case 'addMockData':
        $ReturnJsonStr = json_encode($PersonObj->addMockData());
        break;
    default:
}
echo $ReturnJsonStr;

//TODO: Change to POST // Remove REST
//TODO: Extract start and end timer into class/method
//TODO: Add headers in JQuery AJAX
//TODO: Add JQUERY AJAX in single location


?>