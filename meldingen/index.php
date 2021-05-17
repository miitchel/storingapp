<?php
session_start();
if(!isset($_SESSION['user_id']))
{
    $msg = "Je moet eerst inloggen!";
    header("Location: ../login.php?msg=$msg");
    exit;
}
?>
<!doctype html>
<html lang="nl">

<head>
    <title>StoringApp / Meldingen</title>
    <?php require_once '../head.php'; ?>
    <?php
if(!isset($_SESSION['user_id']))
{
    $msg = "Je moet eerst inloggen!";
    header("Location: login.php?msg=$msg");
    exit;
}
?>
</head>

<body>

    <?php require_once '../header.php'; ?>
    
    <div class="container">
        <h1>Meldingen</h1>
        <a href="create.php">Nieuwe melding &gt;</a>
        <div class="group">
        <p>Aantal meldingen: <strong><?php 
        require_once '../backend/conn.php';
            $query = "SELECT COUNT(*) AS aantalMeldingen FROM meldingen";
            $statement = $conn->prepare($query);
            $statement->execute();
            $aantalMeldingen = $statement->fetch(PDO::FETCH_ASSOC);
            echo $aantalMeldingen["aantalMeldingen"];
         ?></strong></p>
         <form action="" method="GET">
            <select name="typeFilter" id="typeFilter">
                    <option value="">– kies een type –</option>
                    <option value="achtbaan">Achtbaan</option>
                    <option value="draaiend">Draaiende attractie</option>
                    <option value="kinder">Kinderattractie</option>
                    <option value="horeca" selected="">Horeca tenten</option>
                    <option value="show">Shows</option>
                    <option value="water">Water plekken/achtbananen</option>
                    <option value="overig">Overig</option>
                </select>
                <input type="submit" value="Filter">
        </form>
        </div>

        <?php if(isset($_GET['msg']))
        {
            echo "<div class='msg'>" . $_GET['msg'] . "</div>";
        } ?>

        
        <div>
            <?php
            $typeFilter = $_GET['typeFilter'];
            if(empty($_GET['typeFilter']))
            {
            require_once '../backend/conn.php';
            $query = "SELECT * FROM meldingen";
            $statement = $conn->prepare($query);
            $statement->execute();
            $meldingen = $statement->fetchALL(PDO::FETCH_ASSOC);
            }

            else
            {
                require_once '../backend/conn.php';
                $query = "SELECT * FROM meldingen WHERE type = :typeFilter";
                $statement = $conn->prepare($query);
                $statement->execute([
                    "typeFilter" => $_GET['typeFilter']
                ]);
                $meldingen = $statement->fetchALL(PDO::FETCH_ASSOC);
            }

            ?>
            <table>
                <tr>
                    <th>Attractie</th>
                    <th>Type</th>
                    <th>Capaciteit</th>
                    <th>Melder</th>
                    <th>Overige info</th>
                    <th>Prioriteit</th>
                    <th>Gemeld op</th>
                    <th>Aanpassen</th>
                </tr>
                <?php foreach($meldingen as $melding): ?>
                    <tr>
                        <td><?php echo $melding['attractie'] ?></td>
                        <td><?php echo ucfirst($melding['type']) ?></td>
                        <td><?php echo $melding['capaciteit'] ?></td>
                        <td><?php echo $melding['melder'] ?></td>
                        <td><?php echo $melding['overige_info'] ?></td>
                        <td><?php
                        if ($melding['prioriteit'] == 1)
                            {
                                echo "Ja";
                            }
                            else 
                            {
                                echo "Nee";
                            }?>
                                
                            </td>
                            <td><?php echo $melding['gemeld_op'] ?></td>
                            <td><?php echo "<a href='edit.php?id={$melding["id"]}'>aanpassen
                            </td>"?>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>  

</body>

</html>
