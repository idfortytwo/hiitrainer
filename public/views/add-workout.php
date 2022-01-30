<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://kit.fontawesome.com/723297a893.js" crossorigin="anonymous"></script>

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
            <form id="workout-form"">
                <div class="workout-title">
                    <label for="workout-title-input">Workout title</label>
                    <input id="workout-title-input" name="workout-title" type="text">
                </div>

                <div class="rest-dur">
                    <label for="rest-dur-input">Set rest duration</label>
                    <input id="rest-dur-input" name="rest-duration" type="time" value="00:00:00" min="00:00:00" step="1">
                </div>

                <div id="stages">
<!--                    <li id="stage-1">-->
<!--                        <img src="/public/images/march_steps.png" alt="">-->
<!--                        <h3>March steps</h3>-->
<!---->
<!--                        <label for="stage-type-1">Stage type</label>-->
<!--                        <select name="Stage type" class="stage-type" id="stage-type-1">-->
<!--                            <option value="duration">Duration</option>-->
<!--                            <option value="reps">Reps</option>-->
<!--                        </select>-->
<!---->
<!--                        <div id="stage-data-1">-->
<!--                            <label for="stage-data-input-1">Exercise</label>-->
<!--                            <input id="stage-data-input-1" type="number"/>-->
<!--                        </div>-->
<!---->
<!--                        <button>Remove stage</button>-->
<!--                    </li>-->
                </div>

                <button id="submitWorkout" type="submit">Submit</button>
            </form>
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
