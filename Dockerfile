FROM php:8.1-apache

COPY src/ /var/www/html/

ENV spotify_clientId="your-client-id"
ENV spotify_clientSecret="your-client-secret"
ENV spotify_artistId="your-artist-id"

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80