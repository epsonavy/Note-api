The simple Rest API application example build on [Api-platform](https://api-platform.com/) and [Symfony](https://symfony.com/) framework.

## Installation
### 1. Clone repository
```bash
git clone https://github.com/epsonavy/Note-api.git
```
### 2. Dependencies installation
Make sure you have docker in your machine, you can download from https://www.docker.com/
Pull docker image and install project dependencies by using the following command in the project folder
```bash
docker-compose pull
docker-compose up -d
```
### 3. Create necessary database structure.
Run 
```bash
docker-compose exec php bin/console doctrine:schema:update --force
```
## You are all set!!!


### Other commands:
#### Generate the public and private keys used for signing JWT tokens (already add this in docker-entrypoint.sh file )
```bash
docker-compose exec php sh -c '
    set -e
    apk add openssl
    mkdir -p config/jwt
    jwt_passphrase=${JWT_PASSPHRASE:-$(grep ''^JWT_PASSPHRASE='' .env | cut -f 2 -d ''='')}
    echo "$jwt_passphrase" | openssl genpkey -out config/jwt/private.pem -pass stdin -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
    echo "$jwt_passphrase" | openssl pkey -in config/jwt/private.pem -passin stdin -out config/jwt/public.pem -pubout
    setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
    setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
'
```

### Docker command
Debug route:
```bash
docker-compose exec php bin/console debug:router
```
Clear cache:
```bash
docker-compose exec php bin/console cache:clear
```
Rebuild docker env
```bash
docker-compose pull && docker-compose up --build --force-recreate
````

### Postgres
How to run postgres query in docker:
```bash
docker exec -it <container-id> psql -U <username> -d postgres -c "DROP DATABASE <dbname>;"
```
How to enter postgres cli:
```bash
docker exec -it note-api_database_1 psql -U api-platform -d api
```

### cURL commands to test the APIs

## use -k flag to ignore invalid and self signed ssl connection errors 
or Install self signed certificate in Chrome

Register a new user
```bash
curl -X POST -H "Content-Type: application/json" https://localhost/register -d '{"email":"test@note.com","password":"12345678"}' -k
```

Register second new user
```bash
curl -X POST -H "Content-Type: application/json" https://localhost/register -d '{"email":"test2@note.com","password":"12345678"}' -k
```

You will get Error: password need at least 8 characters
```bash
curl -X POST -H "Content-Type: application/json" https://localhost/register -d '{"email":"test3@test.com","password":"123456"}' -k
```

Get token
```bash
curl -X POST -H "Content-Type: application/json" https://localhost/authentication_token -d '{"username":"test@note.com","password":"123456"}' -k
```

Use token to create note
copy above token and replace following <token>, same as all other curl cmd.
```bash
curl -X POST "https://localhost/notes" -H  "accept: application/ld+json" -H  "Content-Type: application/json" -H "Authorization: Bearer <token>" -d "{\"title\":\"mynote\",\"content\":\"something\",\"updatedAt\":\"2021-01-08T21:02:25.745Z\",\"createdAt\":\"2021-01-08T21:02:25.745Z\"}" -k
```

// create another note use same above.

Use token to see note
```bash
curl -X GET "https://localhost/notes/1" -H  "accept: application/ld+json" -H "Authorization: Bearer <token>" -k
```

Test Put with token
```bash
curl -X PUT "https://localhost/notes/1" -H  "accept: application/ld+json" -H  "Content-Type: application/json" -d "{\"title\":\"updated\",\"content\":\"updated\",\"updatedAt\":\"2021-01-08T22:43:41.483Z\",\"createdAt\":\"2021-01-08T22:43:41.483Z\"}" -H "Authorization: Bearer <token>" -k
```

Test Patch with token
```bash
curl -X PATCH "https://localhost/notes/1" -H  "accept: application/ld+json" -H  "Content-Type: application/merge-patch+json" -d "{\"title\":\"patched\",\"content\":\"patched\",\"updatedAt\":\"2021-01-08T22:47:14.117Z\",\"createdAt\":\"2021-01-08T22:47:14.117Z\"}" -H "Authorization: Bearer <token>" -k
```

Test delete with token
```bash
curl -X DELETE "https://localhost/notes/1" -H  "accept: */*" -H "Authorization: Bearer <token>" -k
```

Check note 1 if not exist
```bash
curl -X GET "https://localhost/notes/1" -H  "accept: application/ld+json" -H "Authorization: Bearer <token>" -k
```
### Note API documentation
```bash
https://localhost/docs
```
