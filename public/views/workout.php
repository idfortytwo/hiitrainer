<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Workout</title>
    <link rel="stylesheet" href="/public/css/style.css" type="text/css">
    <link rel="stylesheet" href="/public/css/workout.css" type="text/css">
    <script src="/public/js/workout.js" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/js/splide.min.js" integrity="sha256-b/fLMBwSqO9vy/phDPv6OufPpR+VfUL+OsTEkJMPg+Q=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide-core.min.css" integrity="sha256-1U5SwRVek9kn0fmZgkF/i8vGpypqJrpdtHAUrpf038U=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.12/dist/css/splide.min.css" integrity="sha256-sB1O2oXn5yaSW1T/92q2mGU86IDhZ0j1Ya8eSv+6QfM=" crossorigin="anonymous">

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

    <div id="sliders">
        <div id="main-slider" class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php /** @var \DB\Models\Workout $workout */
                    foreach ($workout->getStages() as $stage): ?>

                        <li class="splide__slide">
                            <img src="/public/images/<?=$stage->getExercise()->getFilename();?>">
                        </li>

                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div id="thumbnail-slider" class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php /** @var \DB\Models\Workout $workout */
                    foreach ($workout->getStages() as $stage): ?>

                        <li class="splide__slide thumbnail-slide">
                            <img src="/public/images/<?=$stage->getExercise()->getFilename();?>">
                        </li>

                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <button id="start-or-stop-button" onclick="workout.startOrStop()">Start set</button>

    <div id="stage-countdown">
        <span></span>
    </div>

    <section class="workout">
        <br>
        <section id="stages-section"></section>
    </section>
</main>

</body>

</html>
