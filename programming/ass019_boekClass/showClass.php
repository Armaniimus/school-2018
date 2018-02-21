<?php
    require_once 'boekClass.php';

    $boek = new boek('My awsomness', 12, 150);
    echo $boek->GetInfoBoek();

    echo "<br />";
    $paperback = new paperback('My awsomness', 12, 150);
    echo $paperback->GetInfoPaperback();
 ?>
