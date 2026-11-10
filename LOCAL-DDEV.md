# Local DAMopen with DDEV

URL: https://damopen-local.ddev.site

```sh
ddev start
ddev launch
ddev drush uli
```

The local site runs Drupal 11.4.7, PHP 8.3, MariaDB 10.11, and Drush 13.
FFmpeg, FFprobe, and ImageMagick are available in the DDEV web container.
Use `ddev stop` to stop it and `ddev composer` to manage dependencies in `app`.

## Repositories

- The outer checkout is `brainsum/damopen-project`, branch `feature/drupal11-ddev`.
- `app/packages/` is not tracked here. Clone these before `ddev composer install`:
  - `app/packages/damopen`: `brainsum/damopen`, branch
    `feature/asset-rejection-comment` (based on `4.0.x`). Upgrade changes to
    the distribution live here.
  - `app/packages/damopen-extras`: `brainsum/damopen-extras`, branch
    `feature/ai-alt-text`. `app/composer.json` applies a patch from it.
  - Optional: `app/packages/damo-theme-upload-errors`: `brainsum/damo-theme`,
    branch `feature/asset-rejection-comment`.
- Composer symlinks the DAMopen checkout to `app/web/profiles/contrib/damopen`.
  The local path repository uses `reference: config` to detect Composer metadata
  changes without requiring commits.
- `app/composer.lock` records the tested versions together with those branches.
- `app/drush/drush.yml` is left at its Docker defaults. Run Drush through
  `ddev drush`.

See [the distribution's Drupal 11 upgrade notes](app/packages/damopen/DRUPAL11.md)
for application requirements, compatibility patches, and test commands.

## Local settings

Project name `damopen-local` avoids another DDEV registration. Direct Docker
mounts avoid a Mutagen permission problem. Drush paths use `app/web`; DDEV supplies
the local database connection through `settings.ddev.php`.

## Rollback checkpoint

A database snapshot was taken before the upgrade: `pre-drupal11-20260916`.
The pre-upgrade application Composer files are saved in
`/tmp/damopen-pre-drupal11-20260916/`. To roll back, restore both those Composer
files and the matching installed dependencies, then restore the DDEV snapshot
with `ddev snapshot restore pre-drupal11-20260916`. Change DDEV's type back to
`drupal10`. Restoring only the database while retaining Drupal 11 code is not a
complete rollback. Temporary-directory backups are local and not durable.

## Validation

Database updates complete; Drupal boots and connects to MariaDB. Authenticated
checks cover the asset library, collections, upload form, image/document/video
creation forms, theme-switching settings, FFmpeg settings, and JSON:API.
The media-normalizer unit test checks that only media entities are supported.
The functional test installs a fresh profile with isolated test tables and verifies
image creation, rendering, and a byte-for-byte private download as an administrator.
Both tests pass (16 assertions total). Composer reports no vulnerability advisories,
but flags two existing abandoned dependencies; see the distribution notes.

Contributed dependencies still emit deprecations for APIs scheduled for removal
in Drupal 12/13. The functional test does not enforce full config schema coverage;
legacy contributed schemas need a separate cleanup.

## Automated upload test

Run `ddev test-damopen` to exercise a real two-image upload in headless Chrome.
DDEV starts a dedicated Selenium service. The test uses an isolated Drupal
installation and does not alter this site's uploaded images. See
[the test guide](app/packages/damopen/tests/README.md) for coverage and other tests.
