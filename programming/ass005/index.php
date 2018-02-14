




<form action="" method="post">
    <h2>members</h2>

    <label for="id">id</label>
    <input type="number" name="id" id="id" value="0"><br>

    <label for="name">Naam</label>
    <input type="text" name="name" id="name" value=""><br>

    <label for="leeftijd">Leeftijd</label>
    <input type="number" name="leeftijd" id="leeftijd" value="0"><br>

    <button type="submit" name="dbcrud" value="create">create</button>
    <button type="submit" name="dbcrud" value="read">read</button>
    <button type="submit" name="dbcrud" value="update">update</button>
    <button type="submit" name="dbcrud" value="delete">delete</button>
</form>

<?php
    include "php_includes/main.php";
?>
