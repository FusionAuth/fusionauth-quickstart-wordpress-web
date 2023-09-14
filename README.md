# FusionAuth Express Quickstart

## Documentation

This repository is documented at https://fusionauth.io/docs/quickstarts/quickstart-javascript-express-web.

Further reading:
- [Express security best practice](https://expressjs.com/en/advanced/best-practice-security.html)
- [Passport.js authentication concepts](https://www.passportjs.org/concepts/authentication/downloads/html)
- [Passport.js Oauth2](https://github.com/jaredhanson/passport-oauth2)
- [FusionAuth OAuth Docs](https://fusionauth.io/docs/v1/tech/oauth/endpoints)

## Prerequisites

Install Docker 20 or higher.

## How To Run

In a terminal run the following to start FusionAuth.

```shell
docker-compose up
```

In another terminal start the app.

```shell
cd complete-application
docker compose up; # https://hub.docker.com/_/wordpress
# change to this - https://github.com/FusionAuth/fusionauth-example-wordpress-sso/blob/main/docker-compose.yml
```

Browse to the app at http://localhost:3000.

- http://localhost:3000/wp-admin/install.php
- English US - Continue
- 1.jpg + admin@example.com
- login with u u

plugins - add new
#paste https://wordpress.org/plugins/miniorange-login-with-eve-online-google-facebook into search
paste OpenID Connect Generic Client into search by daggerhart
add - activate
settings - OpenID Connect - Generic Client
source code is here - https://github.com/oidc-wp/openid-connect-generic


- Always use localhost to specify ports so you don't expose your containers to the entire network
    ```dockerfile
    ports:
        - 127.0.0.1:1025:25
    ```
- Call localhost from inside your container by adding to a service (or every service)
    ```
    extra_hosts:
      - "host.docker.internal:host-gateway"
    ```
    and then using `http://host.docker.internal` instead of `http://localhost` in your container apps.