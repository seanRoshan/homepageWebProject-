<?
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Create connection	
$con = mysqli_connect($servername, $username, $password, $dbname);

if ($con == false){
	//echo "<br> Connection was not successfull<br>";
}
else {
	//echo "MySQL Connected successfully!<br>";
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = str_replace("'","''",$data);
	return $data;
}

function test_input1($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = str_replace("'","''",$data);
	$data = str_replace(" ","",$data);
	return $data;
}

function test_input2($data) {
	$data = str_replace("'","''",$data);
	return $data;
}

function decode_html($data){
	return(htmlspecialchars_decode($data, ENT_NOQUOTES)); 
}


function splitWords($word) {
	
	if (strtoupper($word)==$word){
		return $word;
	}
	
	$splitWord = preg_replace('/[A-Z]/', ' ${0}', $word);
	
	return $splitWord;
}


function num_to_month($monthNumber) {

	switch ($monthNumber) {
    case 1:
        return ("January");
        break;
			
    case 2:
        return ("February");
        break;
			
    case 3:
        return ("March");
        break;
	
	case 4:
        return ("April");
        break;
	
	case 5:
        return ("May");
        break;
	
	case 6:
        return ("June");
        break;
	
	case 7:
        return ("July");
        break;
	
	case 8:
        return ("Augest");
        break;
	
	case 9:
        return ("September");
        break;
	
	case 10:
        return ("October");
        break;
	
	case 11:
        return ("Novermber");
        break;
	
	case 12:
        return ("December");
        break;
	}
	
	return ("NONE");
	
}
?>