<?php


$name = utf8_decode($_POST['name']);
// echo ($name);
$message =utf8_decode($_POST['message']);
// echo ($message);
$from = $_POST['email'];
$to = "jimmybackstrom@hotmail.com"; // ! SET YOUR EMAIL !
$headers = [
  'MIME-Version: 1.0\r\n',
  'Content-type: text/plain; charset=ISO-8859-1\r\n',
  'Content-Transfer-Encoding: quoted-printable'
  
];
$headers = implode("\r\n", $headers);
$send = mail($to, $name, $message);


if($send == true){
    header('Location: index.php');
    // echo 'Mailet har skickat';
    exit();
}
else{
    echo 'något gick fel';
}

?>