<?php

try {
  $user = 'caught_123admin';
  $pass = '-q5BysB.Z5YtGDj';
  $inputArray = [ 'surName' => $_POST['surName'],
                  'lastName' => $_POST['lastName'],
                  'eMail' => $_POST['eMail'],
                  'phoneNumber' => $_POST['phoneNumber'],
                  'comment' => $_POST['comment'],
                ];
  $tableName = '';


    switch($_POST['type']) {
      case 'photoshooting':
      $tableName = 'photoshooting';
      break;

    case 'coaching':
      $tableName = 'coaching';
      break;

    case 'course':
      $tableName = 'course';
      break;
    }

    $pdo = new PDO('mysql:host=localhost;dbname=bookings', $user, $pass);

    $sql = "INSERT INTO " .$tableName." (surName, lastName, eMail, phoneNumber, comment) /*SQL Code in String*/
            VALUES (:surName, :lastName, :eMail, :phoneNumber, :comment)";

    $stmt= $pdo->prepare($sql);
    $stmt->execute($inputArray);

    $dbh = null;
} catch (PDOException $exception) { /*wenn irgendwo error, print error and die = get me out of here, $exception = error*/
    print "Error!: " . $exception->getMessage() . "<br/>";
    die();
}

require_once __DIR__ . "/book-us.html";

?>
