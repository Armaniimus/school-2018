<?php include 'view/header.html'; ?>

<!-- include table navigation -->
<div class="row">
    <div class="col-xs-6 float-l">
        <a class='generatedTableButton ' href='index.php?op=create'> <i class='buttonIconColor fas fa-plus'></i> Create</a>
        <a class='generatedTableButton' href='index.php?op=read'> <i class='buttonIconColor fas fa-book'></i> Read All</a>
    </div>

    <div class="col-xs-6 float-l">
        <form action='index.php?op=search' method='POST' >
            <input type='text' name='search'>
            <button type='submit' class='generatedTableButton' href='index.php?op=search' value='Search'>
                <i class="fas buttonIconColor fa-search"></i>
                Search
            </button>
        </form>
    </div>
</div>

<!-- Include table and footer -->
<?php
echo $content;
if (isset($pagination) ) {
    echo $pagination;
}
include 'view/footer.html';?>
