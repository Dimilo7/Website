<?php

try {
  $user = 'caught_123admin'; #our username and password, which should be adapted
  $pass = '-q5BysB.Z5YtGDj';
  $inputArray = [ 'surName' => $_POST['surName'], //array with all variables which will be put into the db
                  'lastName' => $_POST['lastName'],
                  'eMail' => $_POST['eMail'],
                  'phoneNumber' => $_POST['phoneNumber'],
                  'comment' => $_POST['comment'],
                ];
  $tableName = ''; //initialize variable $tablename


    switch($_POST['type']) { //switch is like multiple if statements, it chooses which form was sent to the server and adjusts the tablename based off of it
      case 'photoshooting': //photoshooting form
      $tableName = 'photoshooting';
      break;

    case 'coaching': //coaching form
      $tableName = 'coaching' ;
      break;

    case 'course': //cuorse form
      $tableName = 'course';
      break;
    }

    $pdo = new PDO('mysql:host=localhost;dbname=bookings', $user, $pass); //creating connection with db

    $sql = "INSERT INTO " .$tableName." (surName, lastName, eMail, phoneNumber, comment) /*SQL Code in String*/
            VALUES (:surName, :lastName, :eMail, :phoneNumber, :comment)"; //this sql code determines what values go in which table list

    $stmt= $pdo->prepare($sql);
    $stmt->execute($inputArray); //inserting the values of the array into the table

    $dbh = null;
} catch (PDOException $exception) { //if the connection fails, the program "catches" the user here and displays an error message
    print "Error!: " . $exception->getMessage() . "<br/>";
    die();
}

require_once __DIR__ . "/book-us.html"; //directory of the html file

?>
