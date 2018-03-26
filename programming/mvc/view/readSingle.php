<?php

include 'view/header.html';
echo "<main>";
echo "<a class='generatedTableButton' href='index.php?op=create'>Create</a>";
echo "<a class='generatedTableButton' href='index.php?op=read'>Read All</a>";
echo $content;
include 'view/footer.html';



?>
