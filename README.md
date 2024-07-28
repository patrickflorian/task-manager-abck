
# Task Manager

cette application permet a un utilisateur de manager ses taches : creer, modifier, supprimer ces differentes taches


## Features

- API : https://github.com/patrickflorian/task-manager-back
- Front: https://github.com/patrickflorian/task-manager-front



## Installation

### Backend
Install task manager with composer
no database configuration is needed all is stored in sqlite Database

```bash
  git clone https://github.com/patrickflorian/task-manager-back
  cd task-manager-back
  composer update
  php artisan migrate --seed
  php artisan serve
```
the server will start at http://localhost:8000
    
### Frontend
The Frontend is done with vuejs 3, Vite as server and Vuetify as template

Install task manager with npm

```bash
  git clone https://github.com/patrickflorian/task-manager-front
  cd task-manager-front
  npm install
  npm run dev
```
The project will start at http://localhost:3000
## API Reference

#### Get all items

```http
  GET /api/tasks
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `token` | `string` | **Required**. bearer auth token |
| `per_page` | `int` |  Numer of items per page|

#### Get item

```http
  GET /api/tasks/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `token` | `string` | **Required**. bearer auth token |
| `id`      | `string` | **Required**. Id of item to fetch |

#### Delete item

```http
  DELETE /api/tasks/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `token` | `string` | **Required**. bearer auth token |
| `id`      | `string` | **Required**. Id of item to delete |


#### Update item

```http
  PUT /api/tasks/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `token` | `string` | **Required**. bearer auth token |
| `id`      | `string` | **Required**. Id of item to update |
| `title`      | `string` | **Required**. title of item to update |
| `description`      | `string` | **Required**. Description of item to update |
| `due_date`      | `date time` | **Required**. Due date of item to update |
| `status`      | `string` | **Required**. status of item to update |

#### Create item

```http
  POST /api/tasks/
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `token` | `string` | **Required**. bearer auth token |
| `title`      | `string` | **Required**. title of item to create |
| `description`      | `string` | **Required**. Description of item to create |
| `due_date`      | `date time` | **Required**. Due date of item to create |
| `status`      | `string` | **Required**. status of item to create |



## Authors

- [@patrickflorian](https://www.github.com/patrickflorian)

