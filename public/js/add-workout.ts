interface ExerciseModel {
    id: number
    name: string
    filename: string
}

class WorkoutCreator {
    stagesElem: Element = document.querySelector('#stages');
    formElem: Element = document.querySelector('form');
    i = 1;

    constructor() {}

    public addExercise(exercise: ExerciseModel) {
        this.stagesElem.appendChild(this.getStageElem(exercise));
    }

    getStageElem(exercise: ExerciseModel) : Element {
        let container = document.createElement('div');
        container.id = "stage-" + this.i;
        container.classList.add('container');

        let hiddenExrID = document.createElement('input');
        hiddenExrID.type = 'hidden';
        hiddenExrID.value = String(exercise.id);
        hiddenExrID.name = 'stage_exid_' + this.i;
        container.appendChild(hiddenExrID);

        let image = document.createElement('img');
        image.src = '../../public/images/' + exercise.filename;
        image.classList.add('exercise-image');
        container.appendChild(image);

        let exrName = document.createElement('h3');
        exrName.textContent = exercise.name;
        exrName.classList.add('exercise-name')
        container.appendChild(exrName);


        let selectLabel = document.createElement('label');
        selectLabel.htmlFor = "#stage-type-" + this.i;
        selectLabel.textContent = 'Stage type';
        selectLabel.classList.add('stage-type-label');
        container.appendChild(selectLabel);

        let selectDiv = document.createElement('div');
        selectDiv.classList.add('stage-type-input')

        let select = document.createElement('select');
        select.name = 'stage_type_' + this.i;
        select.id = 'stage-type-' + this.i;

        let durOption = document.createElement('option');
        durOption.value = 'duration';
        durOption.textContent = 'Duration'
        select.add(durOption);

        let repsOption = document.createElement('option');
        repsOption.value = 'reps';
        repsOption.textContent = 'Reps'
        select.add(repsOption);

        selectDiv.appendChild(select);
        container.appendChild(selectDiv);




        let durLabel = document.createElement('label');
        durLabel.htmlFor = 'stage-data-input-' + this.i;
        durLabel.textContent = 'Duration';
        durLabel.classList.add('stage-data-label');
        container.appendChild(durLabel);

        let durInputDiv = document.createElement('div');
        durInputDiv.classList.add('stage-data-input');

        let durInput = document.createElement('input')
        durInput.id = 'stage-data-input-' + this.i;
        durInput.type = 'time';
        durInput.min = '00:00:01';
        durInput.name = 'stage_data_' + this.i;
        durInput.step = '1';
        durInput.value = '00:00:01';
        durInputDiv.appendChild(durInput)
        container.appendChild(durInputDiv);


        let repsLabel = document.createElement('label');
        repsLabel.htmlFor = 'stage-data-input-' + this.i;
        repsLabel.textContent = 'Reps';
        repsLabel.classList.add('stage-data-label');
        container.appendChild(repsLabel);

        let repsInputDiv = document.createElement('div');
        repsInputDiv.classList.add('stage-data-input');

        let repsInput = document.createElement('input')
        repsInput.id = 'stage-data-input-' + this.i;
        repsInput.type = 'number';
        repsInput.min = '1';
        repsInput.name = '';
        repsInput.classList.add('stage-data-input');
        repsInputDiv.appendChild(repsInput);
        container.appendChild(repsInputDiv);



        const i = this.i;

        WorkoutCreator.showDuration(durLabel, durInput, repsLabel, repsInput, i);
        select.onchange = function(){
            if (select.value == 'duration') {
                WorkoutCreator.showDuration(durLabel, durInput, repsLabel, repsInput, i);
            } else if (select.value == 'reps') {
                WorkoutCreator.showReps(durLabel, durInput, repsLabel, repsInput, i);
            }
        };

        let removeStageButton = document.createElement('button');
        removeStageButton.classList.add('stage-remove');
        removeStageButton.textContent = 'Remove stage';
        removeStageButton.onclick = function(){
            container.remove();
        }
        container.appendChild(removeStageButton);
        removeStageButton.innerHTML = '<i class="fas fa-times"></i>';

        this.i++;
        return container;
    }

    static showDuration(durLabel, durInput, repsLabel, repsInput, i) {
        durLabel.style['visibility'] = 'visible';
        durInput.style['visibility'] = 'visible';
        durInput.setAttribute('required', '')
        durInput.name = 'stage_data_' + i;

        repsLabel.style['visibility'] = 'hidden';
        repsInput.style['visibility'] = 'hidden';
        repsInput.removeAttribute('required')
        repsInput.name = '';
    }

    static showReps(durLabel, durInput, repsLabel, repsInput, i) {
        durLabel.style['visibility'] = 'hidden';
        durInput.style['visibility'] = 'hidden';
        durInput.removeAttribute('required')
        durInput.name = '';

        repsLabel.style['visibility'] = 'visible';
        repsInput.style['visibility'] = 'visible';
        repsInput.setAttribute('required', '')
        repsInput.name = 'stage_data_' + i;
    }
}

class ExerciseList {
    exerciseListElem: Element = document.querySelector('.exercise-list');

    workoutCreator: WorkoutCreator;
    allExercises: ExerciseModel[];
    exercises: ExerciseModel[];
    currentExercisesIDs;

    constructor(workoutCreator: WorkoutCreator) {
        this.workoutCreator = workoutCreator;
        this.currentExercisesIDs = [];
        this.fetchExercises().then(() => {
            this.render();
        });
    }

    fetchExercises() {
        return fetch('/exercises', { method: 'GET' })
            .then(response => response.json())
            .then((data: { exercises: ExerciseModel[] }) => {
                // @ts-ignore
                this.exercises = data.exercises;
                this.allExercises = data.exercises;
            })
    }

    public render() {
        for (const exercise of this.exercises) {
            this.renderExercise(exercise);
            this.currentExercisesIDs.push(exercise.id);
        }
    }

    public rerender(exerciseName: string = null) {
        const filteredExercises = this.getFilteredExercises(exerciseName);

        const myNode = document.querySelector(".exercise-list");
        while (myNode.firstChild) {
            myNode.removeChild(myNode.lastChild);
        }

        for (const exercise of filteredExercises) {
            this.renderExercise(exercise);
        }
    }

    // public rerender(exerciseName: string = null) {
    //     const filteredIDs = this.getFilteredExerciseIDs(exerciseName);
    //
    //     this.clear(filteredIDs);
    //     this.renderNew(filteredIDs);
    //
    //     for (const exerciseID of filteredIDs) {
    //         // this.renderExercise(exercise);
    //         // console.log(exerciseID)
    //     }
    // }

    clear(newExerciseIDs) {
        let idsToRemove = this.currentExercisesIDs.filter(x => !newExerciseIDs.includes(x));
        for (const id of idsToRemove) {
            let exercise = document.querySelector("#exercise-" + id);
            exercise.remove();
            this.currentExercisesIDs = this.currentExercisesIDs.filter(e => e !== id)

            // console.log("Deleting: ", "#exercise-" + id, exercise)
        }
    }

    renderNew(newExerciseIDs) {
        let idsToRender = this.exercises.filter(x => newExerciseIDs.includes(x));
        for (const id of idsToRender) {
            console.log("Adding:", "#exercise-" + id)
            // let exercise = document.querySelector("#exercise-" + id);
            // exercise.remove();
        }
    }

    getFilteredExercises(exerciseName: string) {
        return this.exercises.filter(exercise => (
            exercise.name.toLowerCase().indexOf(exerciseName.toLowerCase()) !== -1
        ));
    }

    getFilteredExerciseIDs(exerciseName: string) {
        return this.exercises.filter(exercise => (
            exercise.name.toLowerCase().indexOf(exerciseName.toLowerCase()) !== -1
        )).map(exercise => exercise.id);
    }

    renderExercise(exercise: ExerciseModel) {
        let exerciseElem = this.getExerciseElem(exercise);
        exerciseElem.addEventListener('click', () => {
            this.workoutCreator.addExercise(exercise);
        });
        this.exerciseListElem.appendChild(exerciseElem);
    }

    getExerciseElem(exercise: ExerciseModel) : Element {
        let exrElem = document.createElement('div');
        exrElem.classList.add('exercise');
        exrElem.id = 'exercise-' + exercise.id;

        let exrImageElem = document.createElement('img');
        exrImageElem.src = '../../public/images/' + exercise.filename;
        exrElem.appendChild(exrImageElem);

        let exrNameElem = document.createElement('h3');
        exrNameElem.textContent = exercise.name;
        exrElem.appendChild(exrNameElem);

        let addElem = document.createElement('h2');
        addElem.textContent = '+';
        addElem.style['position'] = 'fixed';
        addElem.style['left'] = '50%';
        // addElem.style['top'] = '0%';
        addElem.style['transform'] = 'translate(-50%, -50%)';
        exrElem.appendChild(addElem);

        return exrElem;
    }
}

let workoutCreator = new WorkoutCreator();
let exerciseList = new ExerciseList(workoutCreator);

const exerciseFilter = document.querySelector('#exercise-filter-input');
exerciseFilter.addEventListener('input', (e: Event) => {
    let exerciseName = (e.target as HTMLTextAreaElement).value;
    exerciseList.rerender(exerciseName)
});

let submitHandler = function(e){
    e.preventDefault();

    let formData = new FormData(document.querySelector('form'));

    let formDataMap: { [p: string]: FormDataEntryValue | string } = Object.fromEntries(formData.entries());

    let groupedData = groupFormData(formDataMap);
    let jsonData = JSON.stringify(groupedData)

    fetch('/workout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: jsonData
    })
        .then(response => response.json())
        .then((response) => {
            console.log(response);
        });
}

const formElem = document.querySelector('form');
formElem.onsubmit = submitHandler;

function groupFormData(formDataMap: { [key: string]: FormDataEntryValue | string; }) {
    let groupedData: {} = {
        ...formDataMap,
    };

    groupedData['set_rest_duration'] = parseToSeconds(groupedData['set_rest_duration']);

    let stagesMap = {};
    let orderedStagesMap = {};
    for (let [field, value] of Object.entries(formDataMap)) {
        const field_slice = field.slice(0, 10);
        const id = field.slice(11);

        if (field_slice == 'stage_exid') {
            delete groupedData[field]
            if (id in stagesMap)
                stagesMap[id].exercise_id = Number(value);
            else
                stagesMap[id] = { 'exercise_id': value };

        } else if (field_slice == 'stage_data') {
            delete groupedData[field]
            if (id in stagesMap)
                stagesMap[id].stage_data = parseToSeconds(value);
            else
                stagesMap[id] = { 'stage_data': parseToSeconds(value) };

        } else if (field_slice == 'stage_type') {
            delete groupedData[field]

            let stageTypeID = (value == 'duration') ? 1 : 2;
            if (id in stagesMap)
                stagesMap[id].stage_type_id = Number(stageTypeID);
            else {
                stagesMap[id] = { 'stage_type_id':  Number(stageTypeID) };
            }
        }
    }

    let order = 1;
    for (let [, stage] of Object.entries(stagesMap)) {
        orderedStagesMap[order] = stage;
        order++;
    }
    groupedData['stages'] = orderedStagesMap;

    return groupedData;
}

function parseToSeconds(value) {
    const pattern = '(\\d\\d):(\\d\\d):(\\d\\d)';
    const match = value.match(pattern);
    if (match !== null) {
        const hours = Number(match[1]);
        const minutes = Number(match[2]);
        const seconds = Number(match[3]);
        return seconds + minutes * 60 + hours * 3600;
    }
    return Number(value);
}
