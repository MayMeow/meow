FROM ghcr.io/maymeow/php-ci-cd/php-ci-cd:8.0.11-cs

# arguments in docker-compose file
ARG user=vscode
ARG uid=1000

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

USER $user

EXPOSE 7777