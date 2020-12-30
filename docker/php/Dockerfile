FROM php:7.4-fpm

RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        git \
        unzip \
        zip \
        gnupg2 \
        wget \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN wget -q -O - https://packages.blackfire.io/gpg.key | apt-key add -
RUN echo "deb http://packages.blackfire.io/debian any main" | tee /etc/apt/sources.list.d/blackfire.list
RUN apt update
RUN apt install blackfire-agent
RUN blackfire-agent --register --server-id=aff00ff8-8e83-4344-8303-4145b2e48c73 --server-token=9e7aa8a607ce409357436fbc0bf9270961cddd2ff07243ce7972cd5e6aa82547
RUN /etc/init.d/blackfire-agent restart
RUN apt install blackfire-php
RUN blackfire config --client-id=a213ec2f-cd1f-4a85-b55c-fc9aa2d6f144 --client-token=334bb6ebe0fe9ba4b35a281a75bfa8b5adab34a7469d983160ff61bfbc52fde2
RUN /etc/init.d/blackfire-agent restart

ENV HOME /var/www/html
ENV DOCKER_PHP ${HOME}/docker/php
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV COMPOSER_VERSION 2.0.2

RUN set -eux; \
  curl --silent --fail --location --retry 3 --output /tmp/installer.php --url https://raw.githubusercontent.com/composer/getcomposer.org/cb19f2aa3aeaa2006c0cd69a7ef011eb31463067/web/installer; \
  php -r " \
    \$signature = '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5'; \
    \$hash = hash('sha384', file_get_contents('/tmp/installer.php')); \
    if (!hash_equals(\$signature, \$hash)) { \
      unlink('/tmp/installer.php'); \
      echo 'Integrity check failed, installer is either corrupt or worse.' . PHP_EOL; \
      exit(1); \
    }"; \
  php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer --version=${COMPOSER_VERSION}; \
  composer --ansi --version --no-interaction; \
  rm -f /tmp/installer.php; \
  find /tmp -type d -exec chmod -v 1777 {} +

RUN pecl install xdebug-2.8.1 \
    && docker-php-ext-enable xdebug


# OTHER CONFIGURATION
ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN adduser --disabled-password --gecos "" user
RUN mkdir -p /var/www/html
RUN chown user:user /var/www/html
RUN chgrp -R user /var/www/html
