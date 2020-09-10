<?php

// sturcture:
// {
//   success: bool, // there was an error?
//   data: ?, // result or error msg
// }


/*** connection vars ***/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contra_tickets";


/*** connection init ***/
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully"; 
}
catch(Exception $e)
{
  echo json_encode(array('success'=>false, 'data'=>'Error connecting to DB'));
  exit();
} 


/*** db functions ***/
function fetchData()
{
  global $conn;
  try {
    $statement=$conn->prepare("SELECT id,name,email,ticket_num,used,last_update FROM `tickets`");
    $statement->execute();
    $results=$statement->fetchAll(PDO::FETCH_ASSOC);
    $json=json_encode(array('success'=>true, 'data'=>$results));

    return $json;
  }
  catch(Exception $e)
  {
    return json_encode(array('success'=>false, 'data'=>'Error fetching tickets data'));
  } 
}

function _is_ticketed($id)
{
  global $conn;

  try
  {
    // Prepare statement
    $stmt = $conn->prepare("SELECT used FROM `tickets` WHERE id=:id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // execute the query
    $stmt->execute();
    return $stmt->fetchColumn();
  }
  catch(Exception $e)
  {
    print json_encode(array('success'=>false, 'data'=>'Error checking is ticketed'));
    exit();
  }
}

function ticketing($id)
{
  global $conn;

  if (_is_ticketed($id))
  {
    return json_encode(array('success'=>false, 'data'=>'Already ticketed'));
  }
  else
  {
    try
    {
      // Prepare statement
      $stmt = $conn->prepare("UPDATE `tickets` SET used=1 WHERE id=:id");
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);

      // execute the query
      $stmt->execute();

      if ($stmt->rowCount() > 0)
      {
        return json_encode(array('success'=>true, 'data'=>'<3'));
      }
      else
        throw new Exception();
    }
    catch(Exception $e)
    {
      return json_encode(array('success'=>false, 'data'=>'Error updating ticket data'));
    }
  }
}