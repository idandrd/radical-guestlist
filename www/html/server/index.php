<?php
require 'db.php';
// TODO: verify authentication
if (isset($_GET['cmd']) && !empty($_GET['cmd'])) {
  switch ($_GET['cmd']) {
    case 'fetch':
      print fetchData();
      break;
    case 'ticket':
      if (isset($_GET['id']) && ctype_digit($_GET['id']))
      {
        $id = intval($_GET['id']);
        print ticketing($id); // lame lame lame lame lame
        break;
      }
    // default:
    //   # code...
    //   break;
  }
}


?>