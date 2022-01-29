interface ExerciseModel {
    id: number
    name: string
    filename: string
}

class ExerciseList {
    exerciseListElem: Element = document.querySelector('.exercise-list');
    allExercises: ExerciseModel[];
    exercises: ExerciseModel[];
    currentExercisesIDs;

    constructor() {
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

        return exrElem;
    }
}

let exerciseList = new ExerciseList();

const exerciseFilter = document.querySelector('#exercise-filter-input');
exerciseFilter.addEventListener('input', (e: Event) => {
    let exerciseName = (e.target as HTMLTextAreaElement).value;
    exerciseList.rerender(exerciseName)
});
