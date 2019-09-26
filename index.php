<?php
  require 'vendor/autoload.php';
  use Monolog\Logger;
  use Monolog\Handler\StreamHandler;

  function run(){
    if(isset($_GET['unicorn'])){
      searchUnicorn();
    }
    else if(isset($_GET['subject'])){
      getUnicornFromList();
    }
    else{
      allUnicorns();
    }
  }

  function allUnicorns(){
    $log = new Logger('UnicornAll');
    $log->pushHandler(new StreamHandler('visits.log', Logger::INFO));
    $headers = array('Accept' => 'application/json');
    $response = Unirest\Request::get("http://unicorns.idioti.se", $headers);
    $response->body;        
    $response->raw_body;
    $result = json_decode($response->raw_body, true);
    $log->info("Requested info about all unicorns");
    foreach($result as $item){
      $id = $item['id'];
      $name = $item['name'];
      if(!empty($name)){
        echo "<p>$id $name</p>  
        <form action='index.php' method='GET'>
        <button class='btn btn-success' name='subject' type='submit' value='$id'>Visa mer</button>
        </form>";
        
      }  
    } 
  }

  function searchUnicorn(){
    $log = new Logger('UnicornSearch');
    $log->pushHandler(new StreamHandler('visits.log', Logger::INFO));
    if(isset($_GET['unicorn'])){
    
    $unicorn = $_GET['unicorn'];
    
    $headers = array('Accept' => 'application/json');
    $response = Unirest\Request::get("http://unicorns.idioti.se/" . $unicorn, $headers);
    $response->body;        
    $response->raw_body;

    $result = json_decode($response->raw_body, true);
    
    $id = $result['id'];
    $name = $result['name'];
    $date = substr($result['spottedWhen'], 0, 10);
    $picture = $result['image'];
    $reportedBy = $result['reportedBy'];
    $description = $result['description'];
    echo "<div>";
    echo "<h2>$name</h2>";
    echo "<p>$date</p>";
    echo "<p>$description</p>";
    echo "<img src='$picture'>";
    echo "<p>Rapporterad av: $reportedBy</p>";
    echo "</div>";
    $log->info("Requested info about $name");
    }
    else{
      echo "Ange ett id på en enhörning";
      echo $_GET['unicorn'];
    }
      
    
    }

    function getUnicornFromList(){
      $log = new Logger('UnicornList');
      $log->pushHandler(new StreamHandler('visits.log', Logger::INFO));
      if(isset($_GET['subject'])){
        $clickedUnicorn = $_GET['subject'];
        $headers = array('Accept' => 'application/json');
        
  
        $response = Unirest\Request::get("http://unicorns.idioti.se/" . $clickedUnicorn, $headers);
        
        $response->body;        
        $response->raw_body;
  
        $result = json_decode($response->raw_body, true);
        $id = $result['id'];
        $name = $result['name'];
        $date = substr($result['spottedWhen'], 0, 10);
        $picture = $result['image'];
        $reportedBy = $result['reportedBy'];
        $description = $result['description'];
  
        echo "<h2>$name</h2>";
        echo "<p>$date</p>";
        echo "<p>$description</p>";
        echo "<img src='$picture'>";
        echo "<p>Rapporterad av: $reportedBy</p>";
        $log->info("Requested info about specific $name");
    }
    }
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Enhörningar</title>
    <link rel="stylesheet" type="text/css" href="./style.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
  <div class="container">
    <div class="col-xs-12 text-center mt-5">
      <div class="form-group">
      <form action="index.php" method="GET">
        <label for="unicorn">Id på enhörning</label>
        <div class="btn-group">
          <input class="form-control" type="text" name="unicorn" id="unicorn">
          <input class="btn btn-primary" type="submit" name="submit">
        </div>
      </form>
      </div>
    </div>

    <div class="col-xs-12 text-center">
      <form action="index.php" method="GET">
        <input class="btn btn-primary" type="submit" name="submit" value="Visa alla">
      </form>
    </div>
    <hr>
  </div>
  
  <div id="content-div" class="container text-center">
  <?php
    run();
  ?>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>