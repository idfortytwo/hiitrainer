const collapsibles = document.getElementsByClassName("collapsible");
for (const coll of collapsibles) {
    coll.addEventListener("click", function() {
        this.classList.toggle("active");
        let content = this.nextElementSibling;
        if (content.style.maxHeight){
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = content.scrollHeight + "px";
        }
    });
}

const searchFormElem = document.querySelector('form');
const searchButton = document.querySelector('.search-button');
searchButton.addEventListener('click', () => {
    const formData = new FormData(searchFormElem);
    const formDataMap = Object.fromEntries(formData.entries());
    const parsedData = parseFormData(formDataMap);
    const jsonData = JSON.stringify(parsedData);

    const showOnlyFavourites = document.documentURI.split('?')[1] == 'favourite=true';

    let fetchPromise;
    if (jsonData != '{}') {
        const url = showOnlyFavourites ? '/workouts/filtered?favourite=true' : '/workouts/filtered';
        fetchPromise = fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: jsonData
        });
    } else {
        const url = showOnlyFavourites ? '/api/workouts?favourite=true' : '/api/workouts';
        fetchPromise = fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });
    }

    fetchPromise
        .then(response => response.json())
        .then((json: {'workouts': WorkoutModel[]}) => {
            rerenderWorkouts(json.workouts);
        })
})

function parseFormData(formDataMap: { [key: string]: FormDataEntryValue | string; }) {
    let parsedData = {};
    let types = [], difficulties = [], focuses = [];

    for (let [key, value] of Object.entries(formDataMap)) {
        if (key == 'title' && value != '') {
            parsedData[key] = value;
        }

        const [fieldType, fieldValue] = key.split('-');

        switch (fieldType) {
            case 'type':
                types.push(fieldValue);
                break
            case 'diff':
                difficulties.push(fieldValue);
                break
            case 'focus':
                focuses.push(fieldValue);
                break
        }
    }

    if (types.length != 0 && types.length != 5 )
        parsedData['types'] = types;
    if (difficulties.length != 0 && difficulties.length != 3)
        parsedData['difficulties'] = difficulties;
    if (focuses.length != 0 && focuses.length != 4)
        parsedData['focuses'] = focuses;

    return parsedData;
}

function rerenderWorkouts(workouts) {
    const myNode = document.querySelector(".workout-list");
    while (myNode.firstChild) {
        myNode.removeChild(myNode.lastChild);
    }

    for (const workout of workouts) {
        renderWorkout(workout);
    }
}

let workoutListElem = document.querySelector('.workout-list');
function renderWorkout(workout: WorkoutModel) {
    let workoutElem = document.createElement('div')
    workoutElem.innerHTML = `
    <div class="workout-item">
        <a href="/workouts/${workout.id}">
            <img class="image" src="${workout.image}" alt="">
        </a>
        <div class="tag-line">
            <div class="tag">Type: ${workout.type}</div>
            <div class="tag">Focus: ${workout.focus}</div>
            <div class="tag">Difficulty: ${workout.difficulty}</div>
        </div>
        <div class="action-buttons">
            <div onclick="switchLike(${workout.id}, ${workout.isFavourite})" 
                id="liked-${workout.id}" class="action-button">
                <i class="${workout.isFavourite ? 'fas' : 'far'} fa-heart"></i>
            </div>
        </div>
        <div class="title">${workout.title}</div>
    </div>`;
    workoutListElem.appendChild(workoutElem);
}

function switchLike(workoutID: number, isFavourite) {
    const likedButton = <HTMLButtonElement>document.querySelector("#liked-" + workoutID);
    if (isFavourite == true) {
        fetch('/unlike/' + workoutID, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.status === 200) {
                likedButton.innerHTML = '<i class="far fa-heart"></i>';
                likedButton.onclick = () => switchLike(workoutID, !isFavourite);
            }
        });
    } else {
        fetch('/like/' + workoutID, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.status === 200) {
                likedButton.innerHTML = '<i class="fas fa-heart"></i>';
                likedButton.onclick = () => switchLike(workoutID, !isFavourite);
            }
        });
    }
}

