interface ExerciseModel {
    id: number
    name: string
    filename: string
}

interface StageModel {
    exercise: ExerciseModel;
    order: number;
    type: string;
    value: string;
}

interface WorkoutModel {
    id: number;
    title: number;
    type: string;
    difficulty: string;
    focus: string;
    setCount: number;
    setRestDuration: number;
    stages: StageModel[];
    image: string;
    isFavourite: boolean;
}



class Workout {
    stageInfoLabel: Element = <HTMLElement>document.querySelector('#stage-countdown');
    setsCompletedLabel: Element = document.querySelector('#sets-completed').firstElementChild;
    startOrTopButton: Element = document.querySelector('#start-or-stop-button');

    mainSlider;
    stageTimer;
    restTimer;

    workoutData: WorkoutModel;
    stages: StageModel[];
    stagesCount: number;
    currentStageNumber: number;
    setsCompleted: number;
    active: boolean;

    constructor(mainSlider) {
        this.mainSlider = mainSlider;
        this.stages = [];
        this.setsCompleted = 0;
        this.reset();
    }

    public fetchStages() {
        const url = document.documentURI;
        const urlParts = url.split('/');
        const workoutID = urlParts[urlParts.length - 1]

        fetch('/workout/' + workoutID, { method: 'GET' })
            .then(response => response.json())
            .then((data: { workout: WorkoutModel }) => {
                this.workoutData = data.workout;
                this.stages = data.workout.stages;
                this.stagesCount = data.workout.stages.length;
                this.updateSetsCompletedLabel();
            })
    }


    public startOrStop() {
        if (this.active) {
            this.stop();
        } else {
            this.start();
        }
    }

    stop() {
        this.active = false;
        this.startOrTopButton.textContent = 'Start set';
        this.reset();
    }

    reset() {
        this.mainSlider.go(0);
        this.currentStageNumber = 0;
        this.clearRestCountdownLabel()
        this.clearStageCountdownLabel()
        clearInterval(this.stageTimer);
        clearInterval(this.restTimer);
    }

    start() {
        this.active = true;
        this.startOrTopButton.textContent = 'Reset set';
        this.startStage(0);
    }

    startStage(stageNumber: number) {
        let stage = this.stages[stageNumber];

        let stageDuration = parseInt(stage.value);
        this.updateStageCountdownLabel(0, stageDuration);

        if (stage.type == 'duration') {
            let seconds = 0;
            this.stageTimer = setInterval(() => {
                this.updateStageCountdownLabel(seconds + 1, stageDuration);

                if (seconds == stageDuration - 1) {
                    clearInterval(this.stageTimer)
                    this.finishStage(stage, stageNumber);
                }

                seconds++;
            }, 1000);
        }
    }

    finishStage(stage: StageModel, stageNumber: number) {
        this.mainSlider.go('>');

        this.clearStageCountdownLabel();

        if (stageNumber + 1 < this.stagesCount) {
            this.startStage(stageNumber + 1);
        } else {
            this.finishSet();
        }
    }

    updateStageCountdownLabel(seconds: number, totalSeconds: number) {
        this.stageInfoLabel.classList.remove('countdown-hidden')
        const timeLabel = this.getFormattedTime(seconds);
        const totalTimeLabel = this.getFormattedTime(totalSeconds);
        this.stageInfoLabel.textContent = timeLabel + ' / ' + totalTimeLabel;
    }

    clearStageCountdownLabel() {
        this.stageInfoLabel.textContent = ' ';
        this.stageInfoLabel.classList.add('countdown-hidden')
    }

    getFormattedTime(seconds: number) {
        const secondsRemainder = seconds % 60;
        const minutes = Math.floor(seconds / 60);

        const formattedSeconds = this.leadingZeroes(secondsRemainder);
        const formattedMinutes = this.leadingZeroes(minutes);
        return formattedMinutes + ':' + formattedSeconds;
    }

    leadingZeroes(value: number) {
        return value < 10 ? '0' + value : value;
    }

    finishSet() {
        this.setsCompleted += 1;
        this.updateSetsCompletedLabel();

        if (this.setsCompleted < this.workoutData.setCount) {
            const restDuration = this.workoutData.setRestDuration;
            this.updateRestCountdownLabel(restDuration);
            this.stageInfoLabel.classList.remove('countdown-hidden')

            let seconds = restDuration;
            this.updateRestCountdownLabel(seconds);
            this.restTimer = setInterval(() => {
                this.updateRestCountdownLabel(seconds - 1);

                if (seconds == 1) {
                    clearInterval(this.restTimer)
                    this.clearRestCountdownLabel()
                    this.startStage(0);
                }

                seconds--;
            }, 1000);
        } else {
            this.finishWorkout();
        }
    }

    finishWorkout() {
        this.stop();

        this.stageInfoLabel.classList.remove('countdown-hidden')
        this.stageInfoLabel.textContent = 'Finished';
    }

    updateSetsCompletedLabel() {
        this.setsCompletedLabel.textContent = 'Sets completed: ' + this.setsCompleted + ' / ' + this.workoutData.setCount;

    }
    updateRestCountdownLabel(seconds: number) {
        this.stageInfoLabel.classList.remove('countdown-hidden')
        const timeLabel = this.getFormattedTime(seconds);
        this.stageInfoLabel.textContent = 'Rest now ' + timeLabel;
    }

    clearRestCountdownLabel() {
        this.stageInfoLabel.textContent = ' ';
        this.stageInfoLabel.classList.add('countdown-hidden')
    }
}

let mainSlider;
let thumbnailsSlider;
let workout;

document.addEventListener( 'DOMContentLoaded', function () {
    // @ts-ignore
    mainSlider = new Splide('#main-slider', {
        type      : 'fade',
        rewind    : true,
        pagination: false,
        arrows    : false,
        width     : 300
    } );

    // @ts-ignore
    thumbnailsSlider = new Splide('#thumbnail-slider', {
        fixedWidth  : 100,
        fixedHeight : 100,
        gap         : 10,
        rewind      : true,
        pagination  : false,
        arrows      : false,
        cover       : false,
        isNavigation: false,
    } );

    mainSlider.sync(thumbnailsSlider);
    mainSlider.mount();
    thumbnailsSlider.mount();

    workout = new Workout(mainSlider);
    workout.fetchStages();
});
