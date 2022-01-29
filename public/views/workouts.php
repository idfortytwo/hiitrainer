<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Workouts</title>
    <link rel="stylesheet" href="/public/css/style.css" type="text/css">
    <link rel="stylesheet" href="/public/css/workouts.css" type="text/css">
    <script type="module" src="/public/js/workouts.js"></script>
</head>

<body>
    <header>
        <span class="nav-item">HIITrainer</span>
        <!--suppress HtmlUnknownTarget -->
        <a class="nav-item" href="/workouts/">Workouts</a>
    </header>

    <main class="content">
        <h1>Workouts</h1>

        <div class="workout-list">
            <?php /** @var array<\DB\Models\Workout> $workouts */
            foreach ($workouts as $workout): ?>

            <a href="<?='/workouts/'.$workout->getId();?>">
                <div class="workout-item">
                    <img class="image" src="<?= $workout->getImage();?>" alt="">
                    <div class="tag-line">
                        <div class="tag">Type: <?=$workout->getType();?></div>
                        <div class="tag">Focus: <?=$workout->getFocus();?></div>
                        <div class="tag">Difficulty: <?=$workout->getDifficulty();?></div>
                    </div>
                    <div class="title"><?= $workout->getTitle() ?></div>
                </div>
            </a>
            <?php endforeach; ?>

        </div>
    </main>

</body>

</html>
