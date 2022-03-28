FROM node:16.14 as dependencies

ARG USER_ID=1000
ARG GROUP_ID=1000

EXPOSE 8080
WORKDIR /opt/application

# Install Dependencies
RUN apt-get update && apt-get install -y sudo && apt-get clean
COPY .docker/entrypoint.sh /usr/bin/entrypoint.sh

# Create a non-root user
RUN usermod -u 6666 node && \
    groupmod -g 6666 node && \
    chown -R node:node /home/node

RUN addgroup --gid $GROUP_ID www && \
    adduser --disabled-password --gecos '' --uid $USER_ID --gid $GROUP_ID www && \
    passwd -d www && \
    echo 'www ALL=(ALL:ALL) NOPASSWD: ALL' > /etc/sudoers

# Correct permissions for non-root operations
RUN chown -R www:www /opt/application

USER www

COPY package.json /opt/application/
RUN npm i

ENTRYPOINT ["sh", "/usr/bin/entrypoint.sh"]
