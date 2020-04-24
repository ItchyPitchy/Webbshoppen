<?php
require_once './header.php';


$name = utf8_decode($_POST['name']);

$message =utf8_decode($_POST['message']);

$popMessage = 'Ditt meddelande har nu skickats till oss på Hemsson.';
$from = $_POST['email'];
$to = "jimmybackstrom@hotmail.com"; // ! SET YOUR EMAIL !
$headers = [
  'MIME-Version: 1.0\r\n',
  'Content-type: text/plain; charset=ISO-8859-1\r\n',
  'Content-Transfer-Encoding: quoted-printable\r\n',
  $from
  
];
$headers = implode("\r\n", $headers);
$send = mail($to, $name, $message, $headers);


if($send == true){
    
    $output = "<div class='popMessage'>
                <p class='popMessage-text'>$popMessage</p>
               <a href='index.php'>Tillbaka till startsidan</a></div>";
               echo $output;
   
    require_once "./footer.php";
 exit();
}
else{
    echo 'något gick fel';
}

?>
