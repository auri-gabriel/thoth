# Thoth: Systematic Review Tool [![Awesome](https://cdn.rawgit.com/sindresorhus/awesome/d7305f38d29fed78fa85652e3a63e154dd8e8829/media/badge.svg)](https://github.com/ProjetoESE/Thoth)

## License

> This project is licensed under the MIT License - see the [LICENSE.txt](license.txt) file for details.

## Running Locally with Docker

1. **Clone the repository:**
   ```sh
   git clone https://github.com/unipampa-lesse/thoth-legacy.git
   cd thoth-legacy
   ```

2. **Copy and configure application settings:**
   ```sh
   cp application/config/database_sample.php application/config/database.php
   cp application/config/config_sample.php application/config/config.php
   # (Optional) Edit these files to adjust database credentials or other settings
   ```

3. **Build and start the containers:**
   ```sh
   docker compose up --build
   ```
   - The app will be available at [http://localhost:8080](http://localhost:8080)

4. **Initialize the database:**
   ```sh
   docker exec -i <mysql_container_name> mysql -uthoth -pthoth thoth < docs/database/thoth.sql
   ```
   Replace `<mysql_container_name>` with the actual name (e.g., `thoth-db-1`).

5. **Default credentials:**
   - Check your database seed or ask your admin for the default login.

6. **Stopping the app:**
   ```sh
   docker compose down -v
   ```

---

For more details, see [DOCKER_SETUP.md](DOCKER_SETUP.md).
