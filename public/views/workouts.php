<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Workouts</title>
    <link rel="stylesheet" href="/public/css/style.css" type="text/css">
    <link rel="stylesheet" href="/public/css/workouts.css" type="text/css">
    <script type="text/javascript" src="/public/js/workouts.js" defer></script>
</head>

<body>
    <?php include 'header.php'; ?>

    <main class="content">
        <h1>Workouts</h1>

        <form onsubmit='return false;'>
            <div class="workout-inputs">
                <div class="workout-title">
                    <label for="workout-title-input">Workout title</label><br>
                    <input class="workout-input" id="workout-title-input" name="title" type="text">
                </div>

                <div class="workout-type">
                    <button class="collapsible">
                        Type
                    </button>
                    <div id="type-checkboxes" class="collapsed-content">
                        <div>
                            <input type="checkbox" id="type-hiit" name="type-HIIT">
                            <label for="type-hiit">HIIT</label>
                        </div>
                        <div>
                            <input type="checkbox" id="type-cardio" name="type-cardio">
                            <label for="type-cardio">Cardio</label>
                        </div>
                        <div>
                            <input type="checkbox" id="type-strength" name="type-strength">
                            <label for="type-strength">Strength</label>
                        </div>
                        <div>
                            <input type="checkbox" id="type-stretching" name="type-stretching">
                            <label for="type-stretching">Stretching</label>
                        </div>
                        <div>
                            <input type="checkbox" id="type-yoga" name="type-yoga">
                            <label for="type-yoga">Yoga</label>
                        </div>
                    </div>
                </div>

                <div class="workout-difficulty">
                    <button class="collapsible">
                        Difficulty
                    </button>
                    <div id="diff-checkboxes" class="collapsed-content">
                        <div>
                            <input type="checkbox" id="diff-easy" name="diff-easy">
                            <label for="diff-easy">Easy</label>
                        </div>
                        <div>
                            <input type="checkbox" id="diff-normal" name="diff-normal">
                            <label for="diff-normal">Normal</label>
                        </div>
                        <div>
                            <input type="checkbox" id="diff-hard" name="diff-hard">
                            <label for="diff-hard">Hard</label>
                        </div>
                    </div>
                </div>

                <div class="workout-focus">
                    <button class="collapsible">
                        Focus
                    </button>
                    <div id="focus-checkboxes" class="collapsed-content">
                        <div>
                            <input type="checkbox" id="focus-lower" name="focus-lower">
                            <label for="focus-lower">Lower body</label>
                        </div>
                        <div>
                            <input type="checkbox" id="focus-core" name="focus-core">
                            <label for="focus-core">Core</label>
                        </div>
                        <div>
                            <input type="checkbox" id="focus-upper" name="focus-upper">
                            <label for="focus-upper">Upper body</label>
                        </div>
                        <div>
                            <input type="checkbox" id="focus-full" name="focus-full">
                            <label for="focus-full">Full body</label>
                        </div>
                    </div>
                </div>

                <button class="search-button">
                    Search
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <div class="workout-list">
            <?php /** @var array<\DB\Models\Workout> $workouts */
            foreach ($workouts as $workout): ?>
                <div class="workout-item">
                    <a href="<?='/workouts/'.$workout->getId();?>">
                        <img class="image" src="<?= $workout->getImage();?>" alt="">
                    </a>
                    <div class="tag-line">
                        <div class="tag">Type: <?=$workout->getType();?></div>
                        <div class="tag">Focus: <?=$workout->getFocus();?></div>
                        <div class="tag">Difficulty: <?=$workout->getDifficulty();?></div>
                    </div>
                    <div class="action-buttons">
                        <div onclick="switchLike(<?= $workout->getId();?>,
                                                 <?= $workout->getIsFavourite() ? 'true' : 'false' ;?>)"
                             id="liked-<?= $workout->getId();?>" class="action-button">
                            <?php if($workout->getIsFavourite() == true): ?>
                                <i class="fas fa-heart"></i>
                            <?php else:?>
                                <i class="far fa-heart"></i>
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="title"><?= $workout->getTitle() ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>
