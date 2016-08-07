<?php 
	

	// if the 'term' variable is not sent with the request, exit
	if ( !isset($_REQUEST['term']) )
		exit;

	
    
    $data = array();
    $con=mysql_connect("localhost","root","Web@dminUb");
    $db=mysql_select_db("Fw.To",$con);
    $rs=mysql_query('select * from Users where Owner LIKE "%'. mysql_real_escape_string($_REQUEST['term']) .'%"');
    if ( $rs && mysql_num_rows($rs) )
	{
		while( $row = mysql_fetch_array($rs, MYSQL_ASSOC) )
		{
			array_push($data, $row['Owner']);
		}
	}
    echo json_encode($data);

    flush();

	/*include 'db_connect.php';



    $key=$_GET['key'];
    $array = array();
    
    $query=mysql_query("select * from Users where Owner LIKE '%{$key}%'");
    $result = mysqli_query($mysqli, $sql);
    while($rows = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
      $array[] = $row['Owner'];
    }
    echo json_encode($array);*/
?>