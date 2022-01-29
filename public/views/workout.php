<!DOCTYPE html>
<html lang="en">

<head>
    <title>Workouts</title>
    <link rel="stylesheet" href="/public/css/style.css" type="text/css">
    <link rel="stylesheet" href="/public/css/workout.css" type="text/css">
    <script src="/public/js/workout.js" defer></script>
</head>

<body>
<header>
    <span class="nav-item">HIITrainer</span>
    <!--suppress HtmlUnknownTarget -->
    <a class="nav-item" href="/workouts/">Workouts</a>
</header>

<main class="content">
    <div id="sets-completed">
        <span>Sets completed: </span>
    </div>

    <div id="rest-countdown">
        <span></span>
    </div>
    <br>

    <button id="startOrStopButton" onclick="workout.startOrStop()">Start</button>

    <div id="stage-countdown">
        <span></span>
    </div>

    <section class="workout">
        <br>
        <section id="stages-section"></section>
    </section>
</main>

<footer>
    Artem Buhera 2022
</footer>
</body>

</html>
