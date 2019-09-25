<?php
  require 'vendor/autoload.php';

  function run(){
    if(isset($_GET['unicorn'])){
      echo "To be done";
    }
    else if(isset($_GET['subject'])){
      echo "To be done";
    }
    else{
      allUnicorns();
    }
  }

  function allUnicorns(){
    $headers = array('Accept' => 'application/json');
    $response = Unirest\Request::get("http://unicorns.idioti.se", $headers);
    $response->body;        
    $response->raw_body;
    $result = json_decode($response->raw_body, true);
    foreach($result as $item){
      $id = $item['id'];
      $name = $item['name'];
      if(!empty($name)){
        echo "<p>$id $name</p>  
        <form action='index.php' method='GET'>
        <button name='subject' type='submit' value='$id'>Visa mer</button>
        </form>";
        
      }  
    } 
    }
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Enhörningar</title>
    <link rel="stylesheet" type="text/css" href="./style.css"/>
  </head>
  <body>
  <form action="index.php" method="GET">
    <label for="unicorn">Id på enhörning</label>
    <input type="text" name="unicorn" id="unicorn">
    <input type="submit" name="submit">
  </form>

  <form action="index.php" method="GET">
    <input type="submit" name="submit" value="Visa alla">
  </form>
  <div id="container">
  <?php
    run();
  ?>
  </body>
</html>