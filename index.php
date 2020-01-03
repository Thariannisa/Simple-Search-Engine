<?php
$command = escapeshellcmd('python3 core/query.py '.$_POST['t'].' '.$_POST['q']);
$output=shell_exec($command);
$search= json_decode($output, true);
    for ($i=0; $i< count($search); $i++){
        $run = shell_exec('cat data/crawl/'.$search[$i]['doc']);
        $sentence = explode("\n",$run);
        $search[$i]['title']=$sentence[0];
         $search[$i]['content']=$sentence[0];
         for($j=1;$j<count($sentence);$j++){
             $search[$i]['content'].=$sentence[$j];
         }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<head>
    <title>FINAL LAB PI</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-light bg-transparent">
            <form class="form-inline" method="post">
                <input class="form-control mr-sm-2" type="search" value="<?=$_POST['t']?>" name="t" placeholder="top" aria-label="Search">
                <input class="form-control mr-sm-2" type="search" value="<?=$_POST['q']?>" name="q" placeholder="query" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </nav>
        <div class="result">
            <?php foreach ($search as $data) : ?>
                <div class="box-card">
                       <h3>
                           <a href="
                        <?= $data['url'] ?>">
                        <?= $data['title'] ?>
                    </a>
                       </h3> 
                    <br>
                    <?= $data['content'] ?>
                    <br>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>