# FusionAuth Express Quickstart

## Documentation

This repository is documented at https://fusionauth.io/docs/quickstarts/quickstart-wordpress-web.

Further reading:
- [FusionAuth OAuth Docs](https://fusionauth.io/docs/v1/tech/oauth/endpoints)

## Prerequisites

Install Docker 20 or higher.

## How To Run

In a terminal run the following to start FusionAuth and WordPress.

```shell
cd complete-application
docker compose up
```

Browse to [http://localhost:3000](http://localhost:3000) and login with `admin@example.com` and `password`.

Follow the tutorial at https://fusionauth.io/docs/quickstarts/quickstart-wordpress-web to learn how to configure WordPress to work with FusionAuth.