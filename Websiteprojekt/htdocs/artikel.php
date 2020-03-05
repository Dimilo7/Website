<?php

$html = "";
$errorMessage = "";

// Wenn eine Artikelnummer mit GET-Parameter ?id=# angegeben ist:
if(isset($_GET['id'])) {

   // Datenbankverbindung aufbauen:
   $dbh = mysql_connect("localhost", "webserver", "sda523erf");
   if(!$dbh) // Falls keine Verbindung aufgebaut werden konnte:
      $errorMessage .= '<div class="error">Keine
      Datenbankverbindung!</div>';
   // Artikeldatenbank öffnen
   $sql = "use test";
   $sqlResult = @mysql_query($sql, $dbh);
   if(!$sqlResult) // Artikeldatenbank konnte nicht geöffnet werden:
      $errorMessage .= '<div class="error">Artikeldatenbank
      konnte nicht geöffnet werden</div>';

   if($dbh and $sqlResult) { // Alles OK mit der Datenbank:

      // Prüfen, ob Kommentardaten zum Speichern vorliegen:
      if(isset($_POST['name']) and isset($_POST['mail'])
      and isset($_POST['text'])) {

         // Daten zum Speichern in der Datenbank vorbereiten:
         $_POST['name'] = stripslashes($_POST['name']);
         $_POST['mail'] = stripslashes($_POST['mail']);
         $_POST['text'] = stripslashes($_POST['text']);
         $_POST['name'] = strip_tags($_POST['name']);
         $_POST['mail'] = strip_tags($_POST['mail']);
         $_POST['text'] = strip_tags($_POST['text'], '<p><br><b><i><a>');
         $_POST['name'] = mysql_real_escape_string($_POST['name']);
         $_POST['mail'] = mysql_real_escape_string($_POST['mail']);
         $_POST['text'] = mysql_real_escape_string($_POST['text']);
         $_POST['name'] = "'" . $_POST['name'] . "'";
         $_POST['mail'] = "'" . $_POST['mail'] . "'";
         $_POST['text'] = "'" . $_POST['text'] . "'";

         // Restliche Datenfelder vorbereiten:
         $timestamp = time();
         $articleid = (int) $_GET['id'];
         // Kommentar in Datenbanktabelle 'comments' schreiben:
         $sql = "insert into comments";
            $sql .= "(articleid, name, mail, text, timestamp) values (";
            $sql .= $articleid.", ";
            $sql .= $_POST['name'].", ";
            $sql .= $_POST['mail'].", ";
            $sql .= $_POST['text'].", ";
            $sql .= $timestamp.")";
         $sqlResult = @mysql_query($sql, $dbh);
         if(!$sqlResult) // Datensatz konnte nicht gespeichert werden:
            $errorMessage .= '<div class="error">Kommentar
            konnte nicht gespeichert werden</div>';

      } // ENDE: if(isset($_POST['name']) and isset($_POST['mail']) ...

      // Artikel aus Datenbank lesen
      $sql = "select * from articles where id = " . (int) $_GET['id'];
      $sqlResult = mysql_query($sql, $dbh);
      if(!$sqlResult) // Keine Ergebnismenge:
         $errorMessage .= '<div class="error">Artikel
         nicht gefunden</div>';
      else  // Ergebnismenge vorhanden:
         // Datensatz des Artikels "holen":
         $articleData = mysql_fetch_array($sqlResult, MYSQL_ASSOC);
      // HTML-Ausgabe erzeugen:
         $html .= '<!DOCTYPE html>'."\n";
         $html .= '<html><head><meta charset="utf-8">'."\n";
         $html .= '<title>'.$articleData['title'].'</title>'."\n";
         $html .= '</head><body><h1>Das Artikelmagazin</h1>'."\n";
      if(strlen($errorMessage) > 0)  // Wenn es eine Fehlermeldung gibt:
            // Fehlermeldung einfügen:
            $html .= $errorMessage."\n";
         $html .= '<section><h2>'.$articleData['title'].'</h2>'."\n";
         $html .= '<article>'."\n";
         $html .= $articleData['text']."\n";
         $html .= '</article></section><section>'."\n";
      // Kommentare zum Artikel aus Datenbank lesen
      $sql = "select * from comments where articleid = ";
      $sql .= (int) $_GET['id'];
      $sql .= " order by timestamp";
      $sqlResult = mysql_query($sql, $dbh);
      if($sqlResult) { // Ergebnismenge vorhanden:
            $html .= '<h2>Kommentare</h2>'."\n";
            // Datensätze "holen":
         while($record = mysql_fetch_array($sqlResult, MYSQL_ASSOC)) {
               $html .= '<article><p>'.$record['name'];
            $html .= ' schrieb:</p>'."\n";
               $html .= '<div>'.$record['text'].'</div>'."\n";
               $html .= '</article>'."\n";
            } // ENDE: while(...)
      } // ENDE: if($sqlResult)
         $html .= '<h2>Ihr Kommentar:</h2>'."\n";
         $html .= '<form method="post"'."\n";
      $html .= 'action="artikel.php?id='.(int) $_GET['id'].'">'."\n";
         $html .= '<p><label>Name:<br>'."\n";
      $html .= '<input type="text" name="name"></label</p>'."\n";
         $html .= '<p><label>Mail:<br>'."\n";
      $html .= '<input type="text" name="mail"></label</p>'."\n";
         $html .= '<p><label>Kommentar:<br>'."\n";
         $html .= '<textarea name="text" cols="50" rows="8">';
         $html .= '</textarea></label</p>'."\n";
         $html .= '<input type="submit" value="OK">'."\n";
         $html .= '</form></section>'."\n";
         $html .= '</body></html>'."\n";

   } // ENDE: Alles OK mit der Datenbank

   else { // Nicht alles OK mit der Datenbank
      $html .= '<!DOCTYPE html>'."\n";
      $html .= '<html><head><meta charset="utf-8">'."\n";
      $html .= '<title>'.$articleData['title'].'</title>'."\n";
      $html .= '</head><body><h1>Das Artikelmagazin</h1>'."\n";
      // Fehlermeldung einfügen:
      $html .= $errorMessage."\n";
      $html .= '</body></html>'."\n";
   }

} // ENDE: if(isset($_GET['id']))

else { // kein GET-Parameter "id" vorhanden

  $errorMessage .= '<div class="error">Keinen
  Artikel ausgewählt!</div>';
   $html .= '<!DOCTYPE html>'."\n";
   $html .= '<html><head><meta charset="utf-8">'."\n";
   $html .= '<title>'.$articleData['title'].'</title>'."\n";
   $html .= '</head><body><h1>Das Artikelmagazin</h1>'."\n";
   // Fehlermeldung einfügen:
   $html .= $errorMessage."\n";
   $html .= '</body></html>'."\n";

}

// HTML ausgeben:
// Damit wird die Seite an den Browser gesendet:
echo $html;

?>
