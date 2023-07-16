FROM ubuntu:20.04
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update -y --fix-missing
RUN apt-get upgrade -y
RUN apt-get install -y php
RUN apt-get install -y php-dev
RUN apt-get install -y php-mysql
RUN apt-get install -y php-curl
RUN apt-get install -y php-json
RUN apt-get install -y php-common
RUN apt-get install -y php-mbstring
RUN apt-get install -y php-xdebug
RUN apt-get install -y libapache2-mod-php
RUN apt-get install -y nano
RUN apt-get install -y lsof
RUN apt-get install -y mysql-client

COPY ./apache2.conf /etc/apache2/apache2.conf
COPY ./service-config/server.conf /etc/apache2/sites-available/server.conf

RUN rm -rfv ./config/*.conf

RUN a2dissite 000-default.conf
RUN a2ensite server.conf
RUN a2enmod headers
RUN a2enmod rewrite

CMD apachectl -D FOREGROUND

EXPOSE 8000