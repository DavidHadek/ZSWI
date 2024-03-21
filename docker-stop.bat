@echo off
setlocal

SET /p doExport="Export the database before stopping Docker? (Y/N): "

IF "%doExport%" == "Y" (
    docker exec -it zswi-db mysqldump -u root --no-data=False --databases web > ./database_data/schema.sql
    echo Export completed successfully
) ELSE IF "%doExport%" == "y" (
    docker exec -it zswi-db mysqldump -u root --no-data=False --databases web > ./database_data/schema.sql
    echo Export completed successfully
)

docker-compose down