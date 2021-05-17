<?php
$action = $_POST['action'];
if($action == "create")
{

	//Variabelen vullen
	$attractie = $_POST['attractie'];
	if(empty($attractie))
	{
		$errors[] = "Vul de attractie-naam in.";
	}
	$type = $_POST['type'];
	if(empty($type))
	{
		$errors[] = "Kies een type.";
	}
	$capaciteit = $_POST['capaciteit'];
	if(!is_numeric($capaciteit))
	{
		$errors[] = "Vul voor capaciteit een geldig getal in.";
	} 
	if(isset($_POST['prioriteit']))
	{
		$prioriteit = true;
	}
	else
	{
		$prioriteit = false;
	}
	$melder = $_POST['melder'];
	if(empty($melder))
	{
		$errors[] = "Vul de naam van de melder in.";
	}
	$overig = $_POST['overig'];

	//1. Verbinding
	require_once 'conn.php';

	//2. Query
	$query = "INSERT INTO meldingen (attractie, type, capaciteit, prioriteit, melder, overige_info) VALUES(:attractie, :type, :capaciteit, :prioriteit, :melder, :overige_info)";
	//3. Prepare
	$statement = $conn->prepare($query);
	//4. Execute
	$statement->execute([
		":attractie" => $attractie,
		":type" => $type,
		"capaciteit" => $capaciteit,
		"prioriteit" => $prioriteit,
		":melder" => $melder,
		":overige_info" => $overig
	]);

	if(isset($errors))
	{
		var_dump($errors);
		die();
	}

	header("Location: ../meldingen/index.php?msg=Meldingen opgeslagen");
}

if($action == "update")
{
	$capaciteit = $_POST['capaciteit'];
	if(!is_numeric($capaciteit))
	{
		$errors[] = "Vul voor capaciteit een geldig getal in.";
	} 

	if(isset($_POST['prioriteit']))
	{
		$prioriteit = true;
	}
	else
	{
		$prioriteit = false;
	}

	$melder = $_POST['melder'];
	if(empty($melder))
	{
		$errors[] = "Vul de naam van de melder in.";
	}

	$overig = $_POST['overig'];
	$id = $_POST['id'];

	require_once 'conn.php';
	$query = "UPDATE meldingen SET capaciteit = :capaciteit, prioriteit = :prioriteit, melder = :melder, overige_info = :overige_info WHERE id = :id";
	$statement = $conn->prepare($query);
	$statement->execute([
		":capaciteit" => $capaciteit,
		":prioriteit" => $prioriteit,
		":melder" => $melder,
		":overige_info" => $overig,
		":id" => $id
	]);
	header("Location: ../meldingen/index.php?msg=Melding aangepast");
}

if($action == "delete")
{
	$id = $_POST['id'];

	require_once 'conn.php';
	$query = "DELETE FROM meldingen WHERE id = :id";
	$statement = $conn->prepare($query);
	$statement->execute([
		":id" => $id
	]);
	header("Location: ../meldingen/index.php?msg=Melding verwijderd");
}