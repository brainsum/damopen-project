# Local DAMopen with DDEV

URL: https://damopen-local.ddev.site

```sh
ddev start
ddev launch
ddev drush uli
```

The local site runs Drupal 11.4.12, PHP 8.3, MariaDB 10.11, and Drush 13.
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
Both tests pass (16 assertions total). After the 10 November 2026 security
updates, Composer reports no vulnerability advisories but flags three abandoned
dependencies; see the distribution notes. Snapshot before those updates:
`pre-security-updates-20261110`.

Contributed dependencies still emit deprecations for APIs scheduled for removal
in Drupal 12/13. The functional test does not enforce full config schema coverage;
legacy contributed schemas need a separate cleanup.

## Automated upload test

Run `ddev test-damopen` to exercise a real two-image upload in headless Chrome.
DDEV starts a dedicated Selenium service. The test uses an isolated Drupal
installation and does not alter this site's uploaded images. See
[the test guide](app/packages/damopen/tests/README.md) for coverage and other tests.

## SNV Library and category uploads

Installed locally on 10 November 2026. The existing Category vocabulary now
contains SNV's 207 source folders/albums alongside the five original demo terms.
The import preserves source IDs, folder/album types, parents and sibling order;
an unchanged rerun creates or updates zero terms. No SNV media was imported.

- Browse [Library](https://damopen-local.ddev.site/library).
- Copy [category upload links](https://damopen-local.ddev.site/admin/content/category-upload-links).
- Example: [Bangladesh upload](https://damopen-local.ddev.site/upload-image?category=24).
- In People → Edit, administrators can set **Upload category**. Assigned users
  may upload only into that category and its descendants. Unassigned users keep
  existing unrestricted placement; no existing account assignments were changed.
- Links require sign-in and existing upload permission. Both upload interfaces
  apply the selected link category to every image; API and save-time checks
  reject out-of-scope categories. Administrators can upload anywhere.

Implementation and import instructions are in
[the feature README](app/packages/damopen/modules/damopen_category_upload/README.md).
The PHP changes are in `app/packages/damopen`; React source and its build are in
`app/packages/damo-theme-upload-errors`, with the changed upload files copied to
the installed `app/web/themes/contrib/damo_theme`. Existing installed upload-error
handling was preserved in the source checkout and build.

Validation: 8 kernel tests (235 assertions) and a browser workflow (45 assertions)
pass. The browser test uploads two images through each interface, verifies
categories and approval state, rejects parent/sibling URLs and a forged API
category change, and checks read-only staff access. Existing contributed-module
deprecations remain in the browser test output. PHP style, TypeScript build and
lint checks pass. Tests use isolated tables and files.

Pre-change database checkpoint: `pre-snv-categories-20261110`.
