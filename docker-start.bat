@echo off
setlocal

docker-compose up -d

SET /p doLoop="Keep exporting the database scheme from the container? (Y/N): "

IF /i "%doLoop%" == "Y" GOTO loop

IF /i "%doLoop%" == "y" GOTO loop

exit

:loop
timeout /t 30 /nobreak
docker exec -it zswi-db mysqldump -u root --no-data=False --databases web > ./database_data/schema.sql
echo Export completed successfully
goto loop

