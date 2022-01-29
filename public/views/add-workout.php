<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Workouts</title>
    <link rel="stylesheet" href="/public/css/style.css" type="text/css">
    <link rel="stylesheet" href="/public/css/add-workout.css" type="text/css">
    <script src="/public/js/add-workout.js" defer></script>
</head>

<body>
<header>
    <span class="nav-item">HIITrainer</span>
    <!--suppress HtmlUnknownTarget -->
    <a class="nav-item" href="/workouts/">Workouts</a>
</header>

<main class="content">
    <h1>Workout creator</h1>

    <div class="creator-panel">
        <div class="workout-panel">
            <h1>Left</h1>
        </div>

        <div class="exercises-panel">
            <div class="exercise-filter">
                <label for="exercise-filter-input">Exercise</label>
                <input id="exercise-filter-input" type="text" />
            </div>
            <div class="exercise-list"></div>
        </div>
    </div>
</main>


</body>

</html>
