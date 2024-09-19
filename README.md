# Docker Compose Setup for Spotify Latest Track Redirect

This Docker Compose setup allows you to start a web service that automatically redirects users to the latest track of a specific Spotify artist.

## How it works
The service fetches your artist's latest release from Spotify and redirects any request to the URL of the track. This makes it easy to always point to your most recent song.

## Prerequisites
You will need to obtain a **client ID** and **client secret** from the Spotify Developer Portal. You can sign up and find this information here:  
[Spotify Developer Portal](https://developer.spotify.com/)

Additionally, you will need your **artist ID** from Spotify. To find your artist ID, follow these steps:
1. Go to your Spotify profile.
2. Open the menu and select **Share Profile**.
3. The URL will look something like this:  
   `open.spotify.com/artist/ARTIST_ID_HERE?si=xxxxx`

## Example Compose File

Here's an example of the `docker-compose.yml` file you can use to get started:

```yaml
services:
  php-apache:
    image: kschnieders/spotify-redirect:latest
    container_name: spotify-redirect
    environment:
      - SPOTIFY_CLIENT_ID=your-client-id
      - SPOTIFY_CLIENT_SECRET=your-client-secret
      - SPOTIFY_ARTIST_ID=your-artist-id
    ports:
      - "80:80"
    restart: always
