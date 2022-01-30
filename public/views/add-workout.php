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
            <form id="workout-form">
                <div class="workout-inputs">
                    <div class="workout-title">
                        <label for="workout-title-input">Workout title</label>
                        <input class="workout-input" id="workout-title-input" name="title" type="text" required>
                    </div>

                    <div class="workout-type">
                        <label>
                            Type
                            <select class="workout-input" name="type">
                                <option value="HIIT">HIIT</option>
                                <option value="cardio">Cardio</option>
                                <option value="strength">Strength</option>
                                <option value="stretching">Stretching</option>
                                <option value="yoga">Yoga</option>
                            </select>
                        </label>
                    </div>

                    <div class="workout-difficulty">
                        <label>
                            Difficulty
                            <select class="workout-input" name="difficulty">
                                <option value="easy">Easy</option>
                                <option value="normal">Normal</option>
                                <option value="hard">Hard</option>
                            </select>
                        </label>
                    </div>

                    <div class="workout-focus">
                        <label>
                            Focus
                            <select class="workout-input" name="focus">
                                <option value="lower body">Lower body</option>
                                <option value="core">Core</option>
                                <option value="upper body">Upper body</option>
                                <option value="full body">Full body</option>
                            </select>
                        </label>
                    </div>

                    <div class="workout-set-count">
                        <label>
                            Sets
                            <input class="workout-input" type="number" min="1" value="1" name="set_count" required>
                        </label>
                    </div>

                    <div class="rest-dur">
                        <label for="rest-dur-input">Rest</label>
                        <input class="workout-input" id="rest-dur-input" name="set_rest_duration" type="time" value="00:00:01" min="00:00:01" step="1">
                    </div>
                </div>

                <h2>Stages</h2>

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
