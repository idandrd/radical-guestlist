<?php

// sturcture:
// {
//   success: bool, // there was an error?
//   data: ?, // result or error msg
// }


/*** connection vars ***/
$servername = "localhost";
$username = "root";
$password = "!qaz2wsX";
$dbname = "radical_guestlist";


/*** connection init ***/
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
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
    $statement=$conn->prepare("SELECT id,first_name,last_name,personal_id,email,confirmation,checked,last_update FROM `guests` WHERE checked = 0");
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
    $stmt = $conn->prepare("SELECT checked FROM `guests` WHERE id=:id");
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
      $stmt = $conn->prepare("UPDATE `guests` SET checked=1 WHERE id=:id");
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
