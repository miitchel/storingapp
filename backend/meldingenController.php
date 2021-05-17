<?php

//Variabelen vullen
$attractie = $_POST['attractie'];
$type = $_POST['type'];
$capaciteit = $_POST['capaciteit']; 
$melder = $_POST['melder'];
if(isset($_POST['prioriteit']))
{
	$prioriteit = true;
}
else
{
	$prioriteit = false;
}
$prioriteit = $_POST['prioriteit'];

echo $attractie . " / " . $type . " / ". $capaciteit . " / " . $melder . " / " $prioriteit;

//1. Verbinding
require_once 'conn.php';

//2. Query
$query = "INSERT INTO meldingen (attractie, type, capaciteit, melder, prioriteit) VALUES(:attractie, :type, :capaciteit, :melder, :prioriteit)";
//3. Prepare
$statement = $conn->prepare($query);
//4. Execute
$statement->execute([
	":attractie" => $attractie,
	":type" => $type,
	"capaciteit" => $capaciteit,
	"melder" => $melder,
	"prioriteit" => $prioriteit
]);

header("Location: ../meldingen/index.php?msg=Meldingen opgeslagen")