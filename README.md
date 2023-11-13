# Quickstart: Wordpress app with FusionAuth

This repo holds an example Wordpress application that uses FusionAuth as the identity provider.

This repository is documented at https://fusionauth.io/docs/quickstarts/quickstart-wordpress-web.

Further reading:
- [FusionAuth OAuth Docs](https://fusionauth.io/docs/v1/tech/oauth/endpoints)

## Project Contents

The `docker-compose.yml` file and the `kickstart` directory are used to start and configure a local FusionAuth server.

The `complete-application` directory contains a fully working version of the application.

## Prerequisites

- Docker 20 or higher for running FusionAuth, Wordpress and MySQL database

## Running FusionAuth

To run FusionAuth, just stand up the docker containers using docker-compose

```shell
docker compose up
```

This will start a Wordpress container, MySQL for Wordpress,  PostgreSQL, Opensearch and the FusionAuth server

FusionAuth will initially be configured with these settings:

* Your client id is: `e9fdb985-9173-4e01-9d73-ac2d60d1dc8e`
* Your client secret is: `super-secret-secret-that-should-be-regenerated-for-production`
* Your example username is `richard@example.com` and your password is `password`.
* Your admin username is `admin@example.com` and your password is `password`.
* Your fusionAuthBaseUrl is 'http://localhost:9011/'

You can log into the [FusionAuth admin UI](http://localhost:9011/admin) and look around if you want, but with Docker/Kickstart you don't need to.

## Running the Example Application

To run the application, first go into the project directory

```shell
cd complete-application
```

Start up the application docker containers with the following

```shell
docker compose up
```

Browse to [http://localhost:3000](http://localhost:3000) and login with `richard@example.com` and `password`.

Follow the tutorial at https://fusionauth.io/docs/quickstarts/quickstart-wordpress-web to learn how to configure WordPress to work with FusionAuth.