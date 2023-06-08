CREATE TABLE `Person` (
      `FirstName` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
      `Surname` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
      `DateOfBirth` date DEFAULT NULL,
      `EmailAddress` varchar(100) DEFAULT NULL,
      `Age` int(10) DEFAULT NULL,
      `Id` int(255) unsigned NOT NULL AUTO_INCREMENT,
      PRIMARY KEY (`Id`)
)

CREATE TABLE `Logging` (
       `Id` int(11) NOT NULL AUTO_INCREMENT,
       `Name` varchar(255) NOT NULL,
       `Description` varchar(255) DEFAULT NULL,
       `Created` datetime DEFAULT NULL,
       `QueryTime` int(100) DEFAULT NULL,
       PRIMARY KEY (`Id`)
)