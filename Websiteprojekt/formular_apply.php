<?php

try {
  $user = 'caught_123admin';
  $pass = '-q5BysB.Z5YtGDj';
  $inputArray = [ 'surName' => $_POST['surName'],
                  'lastName' => $_POST['lastName'],
                  'eMail' => $_POST['eMail'],
                  'phoneNumber' => $_POST['phoneNumber'],
                  'motivation' => $_POST['motivation'],
                  'comment' => $_POST['comment'],
                ];
    $tableName = 'apply';

    $pdo = new PDO('mysql:host=localhost;dbname=applications', $user, $pass);

    $sql = "INSERT INTO " .$tableName." (surName, lastName, eMail, phoneNumber, motivation, comment) /*SQL Code in String*/
            VALUES (:surName, :lastName, :eMail, :phoneNumber, :motivation, :comment)";

    $stmt= $pdo->prepare($sql);
    $stmt->execute($inputArray);

    $dbh = null;
} catch (PDOException $exception) { /*wenn irgendwo error, print error and die = get me out of here, $exception = error*/
    print "Error!: " . $exception->getMessage() . "<br/>";
    die();
}

require_once __DIR__ . "/apply.html";

?>
