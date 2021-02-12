# DAMopen - Composer template

Composer template to kickstart Digital Assets Management projects.

This template was based on the following:

- [Drupal composer project](https://github.com/drupal-composer/drupal-project)
- [Drupal recommended project](https://www.drupal.org/docs/develop/using-composer/starting-a-site-using-drupal-composer-project-templates)
- [Thunder distro](https://github.com/thunder/thunder-project).

## Installation

Note: These commands have been tested on linux (ubuntu), they might need changes to work on other systems.

### Native composer

For the latest release:
```shell script
composer create-project brainsum/damopen-project my-damopen-project
```

For a specific release:
```shell script
composer create-project brainsum/damopen-project:0.1.0 my-damopen-project
```

### Composer in docker

For the latest release:
```shell script
DAMOPEN_PROJECT_DIR=my-damopen-project; mkdir "${DAMOPEN_PROJECT_DIR}" && docker run --rm -u "$(id -u)":"$(id -g)" -w /app --mount type=bind,src="$(pwd)"/"${DAMOPEN_PROJECT_DIR}",dst=/app wodby/drupal-php:7.3-dev-4.14.3 composer create-project brainsum/damopen-project .
```

For a specific release:
```shell script
DAMOPEN_PROJECT_DIR=my-damopen-project; mkdir "${DAMOPEN_PROJECT_DIR}" && docker run --rm -u "$(id -u)":"$(id -g)" -w /app --mount type=bind,src="$(pwd)"/"${DAMOPEN_PROJECT_DIR}",dst=/app wodby/drupal-php:7.3-dev-4.14.3 composer create-project brainsum/damopen-project:0.1.0 .
```

Note: The wodby/drupal-php image is just an example.
Note: Using an image with the `hirak/prestissimo` composer package will speed up the process, although it also might break things (see: <https://github.com/drupal-composer/drupal-scaffold/issues/101>).

## Setup

### Environment variables

By default, the project depends on some environment variables. See the [settings.php scaffold file](./composer/damopen/assets/default.settings.php) as well the files in the [settings folder](./settings).

### (Optional) Docker-compose

If you want to use docker-compose for development, you should copy `example.env` as `.env`, e.g `cp example.env .env`. Update its contents as required.

For starting and stopping the environment you can use the helper scripts provided with the project (`startup.sh` and `shutdown.sh`). These also look for a `docker-compose.local.yml` file so you can version control a generic config file and do local overrides (e.g ports, mounts).

### Drush

Copy `drush/example.drush.yml` as `drush/drush.yml`. Update its contents as required.

### Filesystem permission fixes

E.g. on linux, you must fix file and directory permissions as well, e.g for "private_files", "web/sites/default/files", "tmp", ...

### Install

Use `drush site-install --account-pass=somestrongpass --site-mail=mail@currentsite.com --site-name=DAMopen damopen -y`

You also might want to add `--account-name` and `--account-mail`.

## Usage
### Main site

Upload your assets and that's it. You can download them, images can be styled for social media purposes, logo can be added, etc.

### API

The JSON:API module has been enabled, so you can serve your assets through that. An example would be using the [FileField Sources JSON API
](https://www.drupal.org/project/filefield_sources_jsonapi) module that allows you to configure file fields to allow downloading files from DAMopen directly via the API.

## Development

For development info see the [DEVELOPMENT.md](./DEVELOPMENT.md) file.
