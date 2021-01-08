docker-compose pull
docker-compose up -d

docker-compose exec php bin/console doctrine:schema:update --force
docker-compose exec php bin/console debug:router
docker-compose exec php bin/console cache:clear

docker-compose pull && docker-compose up --build --force-recreate

docker-compose up -d

docker exec -it <container-id> psql -U <username> -d postgres -c "DROP DATABASE <dbname>;"

docker exec -it note-api_database_1  psql -U api-platform -l
docker exec -it note-api_database_1  psql -U api-platform -d api

docker exec -it note-api_database_1 psql -U api-platform -d api

INSERT INTO "user" VALUES (1,’test@test.com', '123456');

$ docker-compose exec php sh -c '
    set -e
    apk add openssl
    mkdir -p config/jwt
    jwt_passphrase=${JWT_PASSPHRASE:-$(grep ''^JWT_PASSPHRASE='' .env | cut -f 2 -d ''='')}
    echo "$jwt_passphrase" | openssl genpkey -out config/jwt/private.pem -pass stdin -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
    echo "$jwt_passphrase" | openssl pkey -in config/jwt/private.pem -passin stdin -out config/jwt/public.pem -pubout
    setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
    setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
'

// use -k parameter or Install self signed certificate in Chrome
curl -X GET https://localhost/notes/1 -k

// register
curl -X POST -H "Content-Type: application/json" https://localhost/register -d '{"email":"test@test.com","password":"12345678"}' -k

// duplicate
curl -X POST -H "Content-Type: application/json" https://localhost/register -d '{"email":"test@test.com","password":"12345678"}' -k

// password need at least 8 characters
curl -X POST -H "Content-Type: application/json" https://localhost/register -d '{"email":"test2@test.com","password":"123456"}' -k

// get token
curl -X POST -H "Content-Type: application/json" https://localhost/authentication_token -d '{"username":"test@test.com","password":"123456"}' -k

// use token to create note
curl -X POST "https://localhost/notes" -H  "accept: application/ld+json" -H  "Content-Type: application/json" -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTAxMzc4NTMsImV4cCI6MTYxMDE0MTQ1Mywicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdEB0ZXN0LmNvbSJ9.mU6cUcFWvhI4oCd0cKh9l1nxvmsWkKxyFRErDTf6geiqr7dFW54vMH2gZMB9KbyREOt0DE9WKY6bsD-OsEWeZ7cMZMctfD1fA6HPr5f7rZDENmgH94mBnu0z1NcEsgBRWeA8vtedX5Fh02RrbgJZwfffFICrwYIUziw2-5KVkP6TWrswQ83uyZMr1x_1L8qx_4-wT-2R96uBgYVSpRiBouh4LsRulSm0rH31_QhngQT5tsNbE46LC1w6f8HrgyGi1M-ZHJYRDH3zVQzxMaNMIwWY1wsmkJZDW_CQMBpRoLbJ82WHuA8n4JZG37K_Ptzu9V12qflbJPEjYnhmIE-6kKylU33wVWdynCMspaeMg-FRk4H9bxEthupsVl7wDvDLuG8I8o8RN3Pc6o59Pwsuj_kXaehtStTmiwE0XZ4JY9WMUbZIFVqWv9BCEOGzNkSzlbLnVXyer4Si9TbjyP-T6X7mnFe3mdDZMdnXEnY6N9fuNKQHuvkPWq2SrVd2Re8Z5pAkZyUh_1wcBUqSLYG50Sg1Yv3dAr2-FtgihDz32R-RzCdYPDiqiRdwpAjLlMhVQw-sStmbhVCuWbxnuCM2ZBfwWTnrdlg4gH93GxrKfHMGiGT-emfippbs5y0FNhiypoM_t4wsXp-w8rjFm6HTK0JytK7645tGBq7u5s_pm0I" -d "{\"title\":\"mynote\",\"content\":\"something\",\"updatedAt\":\"2021-01-08T21:02:25.745Z\",\"createdAt\":\"2021-01-08T21:02:25.745Z\"}" -k

// user token to see note
curl -X GET "https://localhost/notes/2" -H  "accept: application/ld+json" -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTAxMzc4NTMsImV4cCI6MTYxMDE0MTQ1Mywicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidGVzdEB0ZXN0LmNvbSJ9.mU6cUcFWvhI4oCd0cKh9l1nxvmsWkKxyFRErDTf6geiqr7dFW54vMH2gZMB9KbyREOt0DE9WKY6bsD-OsEWeZ7cMZMctfD1fA6HPr5f7rZDENmgH94mBnu0z1NcEsgBRWeA8vtedX5Fh02RrbgJZwfffFICrwYIUziw2-5KVkP6TWrswQ83uyZMr1x_1L8qx_4-wT-2R96uBgYVSpRiBouh4LsRulSm0rH31_QhngQT5tsNbE46LC1w6f8HrgyGi1M-ZHJYRDH3zVQzxMaNMIwWY1wsmkJZDW_CQMBpRoLbJ82WHuA8n4JZG37K_Ptzu9V12qflbJPEjYnhmIE-6kKylU33wVWdynCMspaeMg-FRk4H9bxEthupsVl7wDvDLuG8I8o8RN3Pc6o59Pwsuj_kXaehtStTmiwE0XZ4JY9WMUbZIFVqWv9BCEOGzNkSzlbLnVXyer4Si9TbjyP-T6X7mnFe3mdDZMdnXEnY6N9fuNKQHuvkPWq2SrVd2Re8Z5pAkZyUh_1wcBUqSLYG50Sg1Yv3dAr2-FtgihDz32R-RzCdYPDiqiRdwpAjLlMhVQw-sStmbhVCuWbxnuCM2ZBfwWTnrdlg4gH93GxrKfHMGiGT-emfippbs5y0FNhiypoM_t4wsXp-w8rjFm6HTK0JytK7645tGBq7u5s_pm0I" -k