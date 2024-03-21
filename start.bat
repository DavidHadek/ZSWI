@echo off
setlocal

:: Spustí Docker Compose
docker-compose up -d

:: Cyklus, který každé 2 minuty exportuje schéma databáze
:loop
docker exec -it zswi-db mysqldump -u root web > ./database_data/schema.sql
timeout /t 20 /nobreak
goto loop