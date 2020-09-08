# <img src="https://www.clicksports.de/assets/img/clicksports-mark.svg" width=27> Laravel Docker-Container

### Setup

---

 1. Install python3 with supertools
    ```
    brew postinstall python3
    pip3 install setuptools
    ```
2. install docker-sync
    ```
    sudo gem install docker-sync
    brew install unison
    brew install eugenmayer/dockersync/unox
   ```
3. Copy .env.example to .env and configure it
4. Setup the application and install dependencies
   ```
   ./develop install
   ```
5. Start the Application
   ```
   ./develop start
   ```
6. Configure the database in PHPStorm
7. Import the database file

### Commands

---

#### docker

- `./develop start` - Stats the environment in background and serve the application at localhost
- `./develop stop` - Stops the environment
- `./develop install` - Install the Application when needed and install dependencies
- `./develop build` - Build docker containers
- `./develop run app bash` - Run bash environment in app container

#### npm

- `./develop npm run dev` - Onetime compilation of js and sass files (development mode)
- `./develop npm run watch` - Stats the file watching process that automatically compiles the js and sass files
- `./develop npm run prod` - Onetime compilation of js and sass files (production mode)

#### Artisan

##### key
- `./develop art key:generate` - Set the application key
##### cache
- `./develop art cache:clear` - Flush the application cache
##### db
- `./develop art db:seed` - Seed the database with records
- `./develop art db:wipe` - Drop all tables, views, and types

##### route
- `./develop art route:list` - List all registered routes