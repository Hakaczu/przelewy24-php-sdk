FROM php:5.6-cli-alpine 
RUN mkdir /przelewy24
WORKDIR /przelewy24
COPY . /przelewy24/
ENTRYPOINT [ "php", "init.php" ]