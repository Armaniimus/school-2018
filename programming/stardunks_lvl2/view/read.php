<!-- set header -->
<?php include 'view/header.html'; ?>

<!-- set Buttons -->
<div class="row">
    <div class="col-xs-6 float-l">
        <a class='generatedTableButton ' href='index.php?op=create'>Create</a>
    </div>

    <div class="col-xs-6 float-l">
        <form action='index.php?op=search' method='POST' >
            <input type='text' name='search'>
            <input type='submit' class='generatedTableButton' href='index.php?op=search' value='Search'>
        </form>
    </div>
</div>

<!-- set main and footer -->
<?php
echo $content;

if ( isset($pagination) ) {
    echo $pagination;
}
include 'view/footer.html';
?>
