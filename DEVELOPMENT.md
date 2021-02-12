# Development

Guidelines, workflows, info of the DAMopen project.

## Parts

### Project

<https://github.com/brainsum/damopen-project>

The template for new projects.

To reduce todos after `create-project`, the `.gitignore` and etc. files should be considered as files for the new project, not this repo, so only things that should be there after a `create-project` command must be committed, nothing else (so no composer.lock, no vendor, ...) and `.gitignore` should reflect only the new project.
Exceptions are documentation files, etc. 

Git tags should mirror at least the major tags of the distribution.

### Installing locally

1. Create a `packages.json` file somewhere with the following content:

```json
{
    "packages": {
        "brainsum/damopen-project": {
            "dev-master": {
                "name": "brainsum/damopen-project",
                "version": "dev-master",
                "dist": {
                    "type": "path",
                    "url": "<absolute path to damopen-project>"
                }
            }
        }
    }
}
```

2. (optional) Add the repo path of damopen to the `packages.json` 

```json
"localdamo": {
    "type": "path",
    "url": "<absolute path to damopen-distro>",
    "options": {
        "symlink": false
    }
},
```

Note, it might also work if you add it to your global `composer.json` and then you don't have to edit the one here.
Note, you might have to change teh damopen package to `"drupal/damopen": "*"`.

3. Then you can use this:

```shell
COMPOSER_MIRROR_PATH_REPOS=1 composer create-project --repository <full path to>/packages.json brainsum/damopen-project myproject
```

### Distribution/Profile

<https://www.drupal.org/project/damopen>

The profile of the project including modules, configs.

New modules, configs, update routines, ... must be committed to this repo.

Feature-specific theming should go into the module of the feature. These should only be added as needed, not globally (e.g, if it's only applicable to a form, don't add it to anything else but the form).

### Theme

<https://github.com/brainsum/damo-theme>

The theme of the project.

Only general theming should be added here, no feature-specific code.
