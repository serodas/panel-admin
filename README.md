<h1 align="center">
  WebApp con Symfony 6 y Google Auth
</h1>

<p align="center">
 This project is a web application developed with the Symfony 6 framework that allows users to register, authenticate with Google and access an administration panel. The application connects to a relational database and uses interactive forms to create, read, update and delete data. In addition, users can post comments on the web using Symfony forms.
  <br />
  <br />
  <a href="https://github.com/serodas/panel-admin">Stars are welcome 😊</a>
</p>

## Preview
![Preview](/panel_admin.gif)

## Stack thechnologies
- Symfony 6
- PHP 8.2
- MySQL
- Docker
- NGINX
- Bootstrap 5
- Twig
- JavaScript

## Installation

1. Clone the repository: `git clone https://github.com/serodas/panel-admin.git`

2. Create the file `./.docker/.env.nginx.local` using `./.docker/.env.nginx` as a guide. The value of the variable `NGINX_BACKEND_DOMAIN` is the `server_name` used in NGINX.

3. Add to the file `C:\Windows\System32\drivers\etc\hosts` the line `127.0.0.1` and its corresponding value of the variable used in `NGINX_BACKEND_DOMAIN`.

4. Go to `./docker` and run `docker-compose up -d --build` to build the containers for the first time. From now on, just run `docker-compose up -d`.

5. You must work inside the container `php`. This project is configured to work with [Remote Container](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers). So you can run the command `Reopen in container` after opening the project.

6. Inside the container `php`, run `composer install` to install the dependencies from the folder `/var/www/project`.

7. Create the file `.env.local` using `.env` as a guide.

```
You should have created the Google authentication token beforehand to replace the GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET variables.
```

8. Use the following value for the environment variable DATABASE_URL and work with the database of the container `mysql`:
```
DATABASE_URL="mysql://root:1234@mysql/admin_panel?serverVersion=5.7&charset=utf8mb4"
```
You can change the username and password of the database in `./docker/.env`.

9.Run `yarn install` to install the JavaScript dependencies.