# HIITrainer

Web page for managing workouts and exercising.

Written in pure PHP with dynamic routing, following SOLID principles.
```php
/**
 * @Route(path="/workout/{id}", methods={"GET"})
 */
public function getWorkout(int $id): JSONResponse {
    ...
```

## UML

![diagram](diagram.svg)

## Examples
![image](https://user-images.githubusercontent.com/17951356/173579217-01452e08-688d-4e53-9f29-0a2a98874f53.png)
![image](https://user-images.githubusercontent.com/17951356/173579255-ac1c278a-6bfe-449f-92d3-5224d4c50c57.png)
![image](https://user-images.githubusercontent.com/17951356/173579394-69e3967b-1381-4ff8-bd32-2b2ac9398412.png)
