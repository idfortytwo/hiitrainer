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
    setCount: number;
    setRestDuration: number;
    stages: StageModel[];
}

class Stage {
    public data: StageModel;
    public element: Element;
    public number: number;

    constructor(stageData: StageModel) {
        this.data = stageData;
        this.element = Stage.generateElement(stageData.order, stageData.exercise.name, stageData.exercise.filename);
        this.number = parseInt(this.element.id);
    }

    static generateElement(order: number, exerciseName: string, imageFilename: string) {
        let stageElem = document.createElement('div');
        stageElem.classList.add('stage');
        stageElem.classList.add('inactive');
        stageElem.id = String(order);

        let exerciseNameElem = document.createElement('h4');
        exerciseNameElem.classList.add('exerciseName');
        exerciseNameElem.textContent = exerciseName;
        stageElem.appendChild(exerciseNameElem);

        let imageElem = document.createElement('img');
        imageElem.src = '../../public/images/' + imageFilename;
        stageElem.appendChild(imageElem);

        return stageElem;
    }

    public activate() {
        this.element.classList.remove('inactive');
        this.element.classList.add('active');
    }

    public deactivate() {
        this.element.classList.remove('active');
        this.element.classList.add('inactive');
    }
}

class Workout {
    stagesSection: Element = document.querySelector('#stages-section');
    stageCountdownLabel: Element = document.querySelector('#stage-countdown').firstElementChild;
    restCountdownLabel: Element = document.querySelector('#rest-countdown').firstElementChild;
    setsCompletedLabel: Element = document.querySelector('#sets-completed').firstElementChild;

    workoutData: WorkoutModel;
    stages: Stage[];
    stagesCount: number;
    currentStageNumber: number;
    currentSet: number;
    setsCompleted: number;
    active: boolean;

    constructor() {
        this.stages = [];
        this.setsCompleted = 0;
        this.reset();
    }

    public render() {
        const url = document.documentURI;
        const urlParts = url.split('/');
        const workoutID = urlParts[urlParts.length - 1]

        fetch('/workout/' + workoutID, { method: 'GET' })
            .then(response => response.json())
            .then((data: { workout: WorkoutModel }) => {
                this.workoutData = data.workout;
                this.renderStages(data.workout.stages)
                this.stagesCount = data.workout.stages.length;
            })
    }

    renderStages(stages: StageModel[]) {
        for (let stage of stages) {
            this.renderAndSaveStage(stage);
        }
    }

    renderAndSaveStage(stageData: StageModel) {
        const stage = new Stage(stageData);
        this.stages.push(stage);
        this.stagesSection.appendChild(stage.element);
    }

    public startOrStop() {
        if (this.active) {
            this.stop();
        } else {
            this.start();
        }
    }

    stop() {
        this.reset();
    }

    reset() {
        this.currentStageNumber = 0;
        this.currentSet = 0;
        this.active = false;
    }

    start() {
        this.startStage(0);
    }

    startStage(stageNumber: number) {
        let stage = this.stages[stageNumber];
        stage.activate();

        let stageDuration = parseInt(stage.data.value);
        this.updateStageCountdownLabel(0, stageDuration);

        if (stage.data.type == 'duration') {
            let seconds = 0;
            let timer = setInterval(() => {
                this.updateStageCountdownLabel(seconds + 1, stageDuration);

                if (seconds == stageDuration - 1) {
                    clearInterval(timer)
                    this.finishStage(stage, stageNumber);
                }

                seconds++;
            }, 1000);
        }
    }

    finishStage(stage: Stage, stageNumber: number) {
        this.clearStageCountdownLabel();
        stage.deactivate()

        if (stageNumber + 1 < this.stagesCount) {
            this.startStage(stageNumber + 1);
        } else {
            this.finishSet();
        }
    }

    updateStageCountdownLabel(seconds: number, totalSeconds: number) {
        const timeLabel = this.getFormattedTime(seconds);
        const totalTimeLabel = this.getFormattedTime(totalSeconds);
        this.stageCountdownLabel.textContent = timeLabel + ' / ' + totalTimeLabel;
    }

    clearStageCountdownLabel() {
        this.stageCountdownLabel.textContent = '';
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

        const restDuration = this.workoutData.setRestDuration;
        this.updateRestCountdownLabel(restDuration);

        let seconds = restDuration;
        this.updateRestCountdownLabel(seconds);
        let timer = setInterval(() => {
            this.updateRestCountdownLabel(seconds - 1);

            if (seconds == 1) {
                clearInterval(timer)
                this.clearRestCountdownLabel()
                this.startStage(0);
            }

            seconds--;
        }, 1000);
    }

    updateSetsCompletedLabel() {
        this.setsCompletedLabel.textContent = 'Sets completed: ' + this.setsCompleted;
    }

    updateRestCountdownLabel(seconds: number) {
        const timeLabel = this.getFormattedTime(seconds);
        this.restCountdownLabel.textContent = 'Rest now ' + timeLabel;
    }

    clearRestCountdownLabel() {
        this.restCountdownLabel.textContent = '';
    }
}

const workout = new Workout();
workout.render()
