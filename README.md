# DAMopen - Composer template

Composer template to kickstart Digital Assets Management projects.

This template was based on the following:

- [Drupal composer project](https://github.com/drupal-composer/drupal-project)
- [Drupal recommended project](https://www.drupal.org/docs/develop/using-composer/starting-a-site-using-drupal-composer-project-templates)
- [Thunder distro](https://github.com/thunder/thunder-project).

## Structure

- `app`: the actual Drupal folder. This is the only folder mounted into the docker container, installing Drupal, adding dependencies, using drush, etc. should be executed from here.
    - Note, in a containerized environment this is the only folder that should be available to the image at build time.
    - Git root should still be the project root.
- `docker`: contains Dockerfiles and some helpers for building the images 

## Installation

Note: These commands have been tested on linux (ubuntu), they might need changes to work on other systems.

### Native composer

For the latest release:
```shell script
composer create-project brainsum/damopen-project my-damopen-project
```

For a specific release:
```shell script
composer create-project brainsum/damopen-project=2.0.x-dev my-damopen-project
```

### Composer in docker

For the latest release:
```shell script
DAMOPEN_PROJECT_DIR=my-damopen-project; mkdir "${DAMOPEN_PROJECT_DIR}" && docker run --rm -u "$(id -u)":"$(id -g)" -w /app --mount type=bind,src="$(pwd)"/"${DAMOPEN_PROJECT_DIR}",dst=/app brainsum/damopen-php:7.4-dev-4.22.1 composer create-project brainsum/damopen-project .
```

For a specific release:
```shell script
DAMOPEN_PROJECT_DIR=my-damopen-project; mkdir "${DAMOPEN_PROJECT_DIR}" && docker run --rm -u "$(id -u)":"$(id -g)" -w /app --mount type=bind,src="$(pwd)"/"${DAMOPEN_PROJECT_DIR}",dst=/app brainsum/damopen-php:7.4-dev-4.22.1 composer create-project brainsum/damopen-project=2.0.x-dev .
```

This creates the base structure. After the project installed, you need to enter go to the `app` folder and use `composer install`.

Note: Drupal released 9.2, but the damopen distro applies a patch that's not compatible with that version. If `composer install` fails, you can work around this by adding the following to `app/composer.json` / extra (See: `cweagans/composer-patches`) and running it again:
```json
"patches": {
    "Implement a generic revision UI (Drupal 9.2)": "https://www.drupal.org/files/issues/2021-03-24/2350939-164.patch"
},
"patches-ignore": {
    "brainsum/damopen": {
        "drupal/core": {
            "Implement a generic revision UI": "https://www.drupal.org/files/issues/2021-02-04/2350939-156-9.1.x.patch"
        }
    }
},
```

## Setup

### Environment variables

By default, the project depends on some environment variables. See the [settings.php](./app/web/sites/default/settings.php) as well the files in the [settings folder](./app/settings).

### (Optional) Docker-compose

If you want to use docker-compose for development, you should update `.env` as needed (e.g. replaceing damopen with your project's name, adding the hash salt, ...).

For starting and stopping the environment you can use the helper scripts provided with the project (`startup.sh` and `shutdown.sh`). These also look for a `docker-compose.local.yml` file so you can version control a generic config file and do local overrides (e.g ports, mounts).

### Drush

Copy `app/drush/example.drush.yml` as `app/drush/drush.yml` and update its contents as required.

### Filesystem permission fixes

E.g. on linux, you must fix file and directory permissions as well, e.g for "private_files", "web/sites/default/files", "tmp", ...

### Additional settings files

`app/settings/example` contains multiple pre-defined settings files. Copy `settings.local.php` to `settings` to bootstrap your local settings, `web/sites/default/settings.php` automatically includes it, if present. This helps avoid issues with file permissions for the main `settings.php`.

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
