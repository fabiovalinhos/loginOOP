<?php include 'index.php'; ?>

<form method="POST" action="">
    <input type="text" name="username">
    <input type="password" name="password">
    <input type="submit" name="send">
</form>

<?php
    if (isset($_POST['send'])) {

        $object = new Login();

        $object->insertIntoTb($_POST['username'], $_POST['password']);

        foreach($object->errors as $error) {
            
            echo $error;
            
        }
    }

    ?>

<?php
    // Fechar conexao
    mysqli_close($conn);
?>