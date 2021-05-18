<!doctype html>
<html lang="nl">

<head>
    <title>StoringApp</title>
    <?php require_once 'head.php'; ?>
</head>

<body>

    <?php require_once 'header.php'; ?>
    
    <div class="container home">
        <?php 
        if(isset($_GET['msg']))
        {
            echo "<div class='msg'>" . $_GET['msg'] . "</div>";
        }
        ?>
    	<form action="backend/registerController.php" method="POST">
    		<div class="form-group">
    			<label for="E-mail">E-mailadres:</label>
    			<input type="email" name="email" id="email">
    		</div>

    		<div class="form-group">
    			<label for="password">Wachtwoord:</label>
    			<input type="password" name="password" id="password">
    		</div>

            <div class="form-group">
                <label for="password_check">Bevestig wachtwoord:</label>
                <input type="password" name="password_check" id="password_check">
            </div>

    		<input type="submit" value="Registeren">
    	</form>

    </div>

</body>

</html>
