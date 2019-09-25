<?php

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
  </body>
</html>