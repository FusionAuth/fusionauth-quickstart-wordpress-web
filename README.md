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
# paste https://wordpress.org/plugins/miniorange-login-with-eve-online-google-facebook into search
# source code is here - https://github.com/oidc-wp/openid-connect-generic
paste OpenID Connect Generic Client into search by daggerhart
add - activate
settings - OpenID Connect - Generic Client

clientid - E9FDB985-9173-4E01-9D73-AC2D60D1DC8E
secret - super-secret-secret-that-should-be-regenerated-for-production
scope - openid
loginurl - http://localhost:9011/oauth2/authorize
userinfo endpoint - http://fusionauth:9011/oauth2/userinfo
Token Validation Endpoint URL - http://fusionauth:9011/oauth2/token
End Session Endpoint URL - http://localhost:9011/oauth2/logout

- Check “Disable SSL Verify” since none of our docker instances are running HTTPS.
- Change the “Identity Key” and “Nickname Key” values to sub. This is what WordPress will use as Ids internally.
- Change the “Display Name Formatting” to {email}. This is what will be displayed to the user in the WordPress admin screen.
- Check “Link Existing Users” if users in your local WordPress database have the same emails as users in your FusionAuth database; otherwise you’ll see an error when those users try to log in.
- save

login redirect urls in fa:
# http://localhost:3000/wp-admin/admin-ajax.php?action=openid-connect-authorize
# http://localhost:3000/wp-login.php?loggedout=true&wp_lang=en_US