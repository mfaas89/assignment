FROM php:8.1-fpm AS dependencies

EXPOSE 8080

ARG USER_ID=1000
ARG GROUP_ID=1000

# Set working directory
WORKDIR /opt/application

RUN apt-get update \
    && apt-get install -y  \
    nginx  \
    unzip  \
    libbz2-dev  \
    libicu-dev \
     bc  \
    netcat-openbsd  \
    sudo  \
    git  \
    zlib1g-dev  \
    libpng-dev  \
    libjpeg-dev  \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install bcmath bz2 intl pdo_mysql opcache gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create a non-root user
RUN addgroup --gid $GROUP_ID www && \
    adduser --disabled-password --gecos '' --uid $USER_ID --gid $GROUP_ID www && \
    passwd -d www && \
    echo 'www ALL=(ALL:ALL) NOPASSWD: ALL' > /etc/sudoers

# Correct permissions for non-root operations
RUN chown -R www:www \
    /run \
    /var/log/nginx \
    /var/lib/nginx \
    /opt/application

COPY .docker/entrypoint.sh /usr/bin/entrypoint.sh
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf

# Change current user to www
USER www

ENTRYPOINT ["sh", "/usr/bin/entrypoint.sh"]
