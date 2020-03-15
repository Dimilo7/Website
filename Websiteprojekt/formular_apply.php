<?php

try {
  $user = 'caught_123admin'; #our username and password, which should be adapted
  $pass = '-q5BysB.Z5YtGDj';
  $inputArray = [ 'surName' => $_POST['surName'], //array with all variables which will be put into the db
                  'lastName' => $_POST['lastName'],
                  'eMail' => $_POST['eMail'],
                  'phoneNumber' => $_POST['phoneNumber'],
                  'motivation' => $_POST['motivation'],
                  'comment' => $_POST['comment'],
                ];
    $tableName = 'apply'; //name of the table in the variable $tablename

    $pdo = new PDO('mysql:host=localhost;dbname=applications', $user, $pass); //creating connection with the db

    $sql = "INSERT INTO " .$tableName." (surName, lastName, eMail, phoneNumber, motivation, comment)
            VALUES (:surName, :lastName, :eMail, :phoneNumber, :motivation, :comment)"; //this sql code determines what values go in which table list

    $stmt= $pdo->prepare($sql);
    $stmt->execute($inputArray); //inserting the values of the array into the table

    $dbh = null;
} catch (PDOException $exception) { //if the connection fails, the program "catches" the user here and displays an error message
    print "Error!: " . $exception->getMessage() . "<br/>";
    die();
}

require_once __DIR__ . "/apply.html"; //directory of the html file

?>
