# SLIM 4 
RESTful API exercise
Used technologies: `PHP 8, Slim 4, PHPUnit, dotenv, Docker & Docker Compose`.
## :gear: QUICK INSTALL:
### Requirements:
- Composer.
- PHP 7.4+ or 8.0+.
- or Docker.
### With Composer:
You can create a new project running the following commands:
```bash
$ composer create-project ayushmohanan/slim4 [my-api-name]
$ cd [my-api-name]
$ composer start
```
#### Configure your connection to MySQL Server:
You should check and edit this configuration in your `.env` file:
```
DB_HOST='127.0.0.1'
DB_NAME='yourMySqlDatabase'
DB_USER='yourMySqlUsername'
DB_PASS='yourMySqlPassword'
DB_PORT='3306'
```
### With Docker:
If you like Docker, you can use this project with **docker** and **docker-compose**.
**Minimal Docker Version:**
* Engine: 18.03+
* Compose: 1.21+
**Docker Commands:**
```bash
# Create and start containers for the API.
$ docker-compose up -d --build
# Checkout the API.
$ curl http://localhost:8081
# Stop and remove containers.
$ docker-compose down
```
### API:
- Get All: `GET /state`
- Create: `POST /move/{from}/{to}`
