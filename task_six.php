<?php

class LoggingDto
{
    public $name;
    public $description;
    public $created;
    public $queryTime;

    function __construct($name, $description, $created, $queryTime)
    {
        $this->name = $name;
        $this->description = $description;
        $this->created = $created;
        $this->queryTime = $queryTime;
    }

}

class Logging
{
    private $conn = null;

    function __construct($con)
    {
        $this->conn = $con;
    }

    function createLog($log)
    {
        $theQuery = "
            INSERT INTO Logging (Name, Description, Created, QueryTime) VALUES (
            '$log->name',
            '$log->description', 
            '$log->created', 
            '$log->queryTime')";


        $query = mysqli_query($this->conn, $theQuery);

        if (!$query) {
            echo "Failed inserting " . $this->conn->error;
        }
        return $theQuery;
    }


}

class PersonDto
{
    public $firstName;
    public $surname;
    public $dateOfBirth;
    public $emailAddress;
    public $age;

    function __construct($firstName, $surname, $dateOfBirth, $emailAddress, $age, $id)
    {
        $this->firstName = $firstName;
        $this->surname = $surname;
        $this->dateOfBirth = $dateOfBirth;
        $this->emailAddress = $emailAddress;
        $this->age = $age;
        $this->id = $id;
    }

}

class Person
{
    private $conn = null;

    function __construct($con)
    {
        $this->conn = $con;
    }

    function addMockData($person)
    {
        $scaffoldedPersons = [
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
        foreach ($scaffoldedPersons as $scaffoldedPerson) {
            $person->createPerson($scaffoldedPerson);
        }
        return true;
    }

    function createPerson($person){
        $theQuery = "INSERT INTO Person(FirstName, Surname, DateOfBirth, EmailAddress, Age) VALUES (
            '$person->firstName',
            '$person->surname', 
            '$person->dateOfBirth', 
            '$person->emailAddress', 
            '$person->age')";;

        $query = mysqli_query($this->conn, $theQuery);

        if (!$query) {
            echo "Failed inserting " . $this->conn->error;
            return;
        }
        return $query;
    }

    function loadPerson($id){}

    function savePerson($person){}

    function deletePerson($id){}

    function loadAllPeople()
    {
        $theQuery = "SELECT * FROM Person";
        $result = $this->conn->query($theQuery);
        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    function deleteAllPeople()
    {
        $theQuery = "DELETE FROM Person";
        $query = mysqli_query($this->conn, $theQuery);

        if (!$query) {
            echo "Failed inserting " . $this->conn->error;
            return;
        }
        return $query;
    }

}


$servername = "127.0.0.1";
$username = "user";
$password = "secret";
$database = "foundation_task";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    // echo("Connection failed. Please try again.");
    // return;
}

$logging = new Logging($conn);
$person = new Person($conn);

$currentTime = microtime(true);
$timestamp = time();
$currentDate = gmdate("Y-m-d H:i:s", $timestamp);

//Doing cleanup before adding more
$deleteAllPeopleResult = json_encode($person->deleteAllPeople());
$addMockDataResult = json_encode($person->addMockData($person));

if($addMockDataResult){
    $loggingDto = new LoggingDto("loadAllPeople()", "loadAllPeople() DB Query", $currentDate, 0);
    $dataResult = json_encode($person->loadAllPeople());
    $loggingDto->queryTime = round(microtime(true) - $currentTime, 3) * 1000;
    $logging->createLog($loggingDto);
    echo $dataResult;
}else{
echo    "Adding mock data failed";
}