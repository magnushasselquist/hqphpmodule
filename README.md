# hqphpmodule
HQ PHP Module for Joomla

Renders the output of a PHP file from the `ms-modules` directory below the
site root. The file is picked per module instance in the module settings.

## Requirements

| Component | Supported                                   |
|-----------|---------------------------------------------|
| Joomla    | 4.x, 5.x, 6.x                               |
| PHP       | 8.1 or newer. Linted against PHP 8.4 and 8.5 |

Only files directly inside `<site root>/ms-modules` with a `.php` extension
can be selected and included. Sub directories, symlinks pointing outside the
directory and path traversal in the stored parameter are rejected.

## Structure

Since 1.1.0 the module uses Joomla's namespaced module structure (no legacy
`mod_hqphpmodule.php` entry file). It does not depend on the
"Behaviour - Backward Compatibility" plugin.

| Path                              | Purpose                                                             |
|-----------------------------------|---------------------------------------------------------------------|
| `mod_hqphpmodule.xml`             | Manifest. Declares the `Hq\Module\Hqphpmodule` namespace.           |
| `services/provider.php`           | Registers the dispatcher and helper factory with the DI container.  |
| `src/Dispatcher/Dispatcher.php`   | Resolves the selected file and passes `$filePath` to the layout.    |
| `src/Helper/HqphpmoduleHelper.php`| File name validation. `DIRECTORY` names the allowed directory.      |
| `tmpl/default.php`                | Includes the file and echoes its output.                            |
| `script.php`                      | Installer script: version checks, removes the pre-1.1 entry file.   |
| `language/`                       | en-GB and sv-SE strings.                                            |

The included PHP file runs inside the layout and sees the layout variables:
`$module`, `$app`, `$input`, `$params` (a `Registry`), `$template`,
`$filePath` and `$canEdit`.

## Testing

There is no automated test in the repository. The 1.1.0 conversion was
verified by booting the Joomla 5.3.3 libraries without a database,
registering `services/provider.php` in a container and rendering the module
through `ModuleInterface::getDispatcher()` for valid, missing, traversing and
symlinked file names, on PHP 8.4 and 8.5.

Anyone who can edit this module in the Joomla backend can run any PHP file in
that directory, so treat `ms-modules` like code and keep write access to it
limited to deployers.

## Update server

The module manifest points Joomla's update system at:

```
https://raw.githubusercontent.com/magnushasselquist/hqphpmodule/main/hqphpmodule_update.xml
```

and the update XML downloads the package from:

```
https://github.com/magnushasselquist/hqphpmodule/archive/refs/heads/main.zip
```

Both URLs only work while the repository is **public**. GitHub returns 404 for
raw files and archive downloads of a private repository unless the request is
authenticated, and Joomla's updater does not authenticate. If the repository
is private, Joomla reports the update site as unreachable.

When releasing a new version:

1. Bump `<version>` in `mod_hqphpmodule.xml`.
2. Set the same version in `hqphpmodule_update.xml`. The two must match,
   otherwise Joomla keeps offering the same update after installing it.
3. Push to `main`.
