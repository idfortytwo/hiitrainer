<!DOCTYPE html>
<head>
    <title>Workout</title>
    <link rel="stylesheet" href="/public/css/workout.css" type="text/css">
    <link rel="stylesheet" href="/public/css/style.css" type="text/css">
    <script type="text/javascript" src="/public/js/workout.js" defer></script>
</head>

<body>
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
</body>
