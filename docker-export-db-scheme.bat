docker exec -it zswi-db mysqldump -u root --no-data=False --databases web > ./database_data/schema.sql