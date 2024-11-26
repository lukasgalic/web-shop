A repo for creating a php web server using Docker

Start service by _running docker compose up -d_ in the root folder 


# reset db

The db is a docker volume, these are located at `/var/lib/docker/volumes' (on linux).
Do not remove these manually!
Use `docker volume rm web-security_db_data` instead.
After removing it and rebooting the container it should be inited with our initial datasets.