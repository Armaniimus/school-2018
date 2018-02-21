<!DOCTYPE html>
<?php
    session_start();
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>show shizzle</title>
        <link rel="stylesheet" href="css/master.css">
    </head>
    <body>
         <table border="1">
             <thead>
                 <tr>
                     <th colspan="2">Plane Data</th>
                 </tr>
             </thead>
             <tbody>
                 <tr>
                     <td>Naam</td><td><?php echo $_SESSION["naam"] ?></td>
                 </tr>
                 <tr>
                     <td>Type</td><td><?php echo $_SESSION["type"] ?></td>
                 </tr>
                 <tr>
                     <td>Range</td><td><?php echo $_SESSION["range"] ?></td>
                 </tr>
                 <tr>
                     <td>Datum</td><td><?php echo $_SESSION["datum"] ?></td>
                 </tr>
                 <tr>
                     <td>Color</td><td><?php echo $_POST["color"] ?><div style="height: 10px; width: 100%; background-color: <?php echo $_POST["color"]?>"></div></td>
                 </tr>
                 <tr>
                     <td>Omschrijving</td><td><?php echo $_POST["omschrijving"] ?></td>
                 </tr>
             </tbody>
         </table>
    </body>
</html>
