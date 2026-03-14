
# Thoth Legacy Revived

Thoth is a web platform that supports the workflow of a Systematic Literature Review (SLR), including project organization, extraction activities, and progress tracking.

This repository is a **revived and refactored** version of the original Thoth legacy codebase, carried out as a learning experience. It modernizes the front-end stack and improves the internal architecture while preserving the original feature set.

> For production usage and the latest features, visit **[Thoth 2.0](https://thoth-slr.com/)**.

## What changed from the original legacy

The original codebase used plain PHP views, monolithic controllers, and static Bootstrap dist files copied directly into the project. This revived version introduces the following changes:

### Twig template engine

All views were migrated from inline PHP to [Twig](https://twig.symfony.com/). This enforces a clean separation between presentation and logic, makes templates more readable, and enables template inheritance through layouts and partials.

### Controller refactoring

Several large, multi-responsibility controllers were broken down into smaller, focused controllers. This makes the routing and business logic easier to follow, test, and extend.

### npm-managed front-end dependencies

Static vendor JS and CSS files were removed from the repository. All front-end dependencies are now declared in `package.json` and installed via npm. This includes:

- [Bootstrap 5](https://getbootstrap.com/) (via npm, compiled from source)
- [DataTables](https://datatables.net/) with Bootstrap 5 integration
- [Highcharts](https://www.highcharts.com/)
- [Quill](https://quilljs.com/) rich text editor
- [Select2](https://select2.org/)
- [SweetAlert2](https://sweetalert2.github.io/)
- [JSZip](https://stuk.github.io/jszip/) and [pdfmake](http://pdfmake.org/)

### Bootstrap with SCSS

Instead of loading pre-compiled Bootstrap CSS from a `dist/` folder, the project now imports Bootstrap via SCSS. Custom styles live in `assets/scss/` and are compiled into a single `assets/css/theme.css` file using the `sass` CLI.

To rebuild styles:

```sh
npm run build-css
```

To watch for changes during development:

```sh
npm run watch-scss
```

### Docker and PHP upgrade

The project was fully Dockerized using Docker Compose, making local setup reproducible without any manual PHP/Apache configuration. The PHP runtime was upgraded from the original **PHP 5.x** to **PHP 8.1** (`php:8.1-apache`), bringing modern language features, improved performance, and continued security support.

## Screenshot

<p align="center">
   <img src="./docs/readme/screenshot.png" alt="Thoth Systematic Review Platform Screenshot" width="800" />
</p>

<p align="center"><em>Example of the Thoth dashboard and progress tracking interface.</em></p>

## Tech stack

| Layer | Technology |
|---|---|
| Framework | CodeIgniter 3 (PHP 8.1) |
| Templating | Twig 3 |
| Styling | Bootstrap 5 · SCSS · Sass CLI |
| Front-end libs | DataTables · Highcharts · Quill · Select2 · SweetAlert2 |
| Package manager | npm (front-end) · Composer (PHP) |
| Database | MySQL |
| Runtime | Docker / Docker Compose (`php:8.1-apache`) |

## Getting started (Docker)

### 1) Clone the repository

```sh
git clone https://github.com/auri-gabriel/thoth.git
cd thoth
```

### 2) Install PHP dependencies

```sh
composer install
```

### 3) Install Node.js dependencies

```sh
npm install
```

### 4) Build CSS

```sh
npm run build-css
```

### 5) Configure application files

```sh
cp application/config/database_sample.php application/config/database.php
cp application/config/config_sample.php application/config/config.php
```

Optionally edit these files to match your local database settings.

### 6) Start containers

```sh
docker compose up --build
```

Application URL: [http://localhost:8080](http://localhost:8080)

### 7) Initialize the database

```sh
docker exec -i <mysql_container_name> mysql -uthoth -pthoth thoth < docs/database/thoth.sql
```

Replace `<mysql_container_name>` with your actual container name (for example, `thoth-db-1`).

### 8) Session directory permissions (if needed)

If you get session path/permission errors:

```sh
mkdir -p application/cache/sessions
chmod 777 application/cache/sessions
```

### 9) Default credentials

Check the database seed data (or ask your admin) for available default users.

### 10) Stop containers

```sh
docker compose down -v
```

### 11) Xdebug (optional)

Xdebug is installed in the `web` container and is disabled by default.

Start the stack with debug mode enabled:

```sh
XDEBUG_MODE=debug,develop docker compose up --build
```

Then set a breakpoint in VS Code and start listening on port `9003`.

Because `xdebug.start_with_request=trigger`, only requests with a trigger will start debugging. Use one of these:

```text
Cookie: XDEBUG_TRIGGER=1
```

```text
Query string: ?XDEBUG_TRIGGER=1
```

For coverage commands, use:

```sh
XDEBUG_MODE=coverage docker compose run --rm web composer test:coverage
```

## Troubleshooting

- If login fails, confirm the SQL import was executed successfully.
- If sessions do not persist, verify `application/cache/sessions` exists and is writable.
- If containers fail to start, run `docker compose logs` to inspect service errors.
- If styles look broken, make sure you ran `npm run build-css` after installing dependencies.

## Contributing

Contributions are welcome. See [contributing.md](contributing.md) for contribution guidelines.

## License

This project is licensed under the MIT License. See [license.txt](license.txt) for details.

## Contact

For questions or support, open an issue in this repository: [auri-gabriel/thoth](https://github.com/auri-gabriel/thoth).

