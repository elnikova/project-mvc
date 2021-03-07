<h1 class="bg-primary"><?= $title ?></h1>

<a href="/pdf-articles" class="btn btn-primary">Save articles in PDF</a>
<a href="/excel-articles" class="btn btn-primary">Save articles in Excel</a>
<a href="/article/add-form" class="btn btn-primary">Add Articles</a>
<a href="/import" class="btn btn-primary">Import from Excel</a>


<?php 
if($_SESSION['resultUpdate']): ?>
    <div><?php echo $_SESSION['resultUpdate'] ?></div>
<?php endif ?> 


<?php     
    foreach($articles as $article): ?>
    <h2><a href="/article/<?= $article->id ?>"><?= $article->name ?></a></h2>
    <a href="/article/<?= $article->id ?>/edit-form" class="btn btn-primary">Edit</a>


    <p><?= $article->text ?></p>

    <form action="/article/<?= $article->id ?>/delete" method="POST">
        <button class="btn btn-primary">Delete</button>
    </form>
<?php endforeach ?>







 




















