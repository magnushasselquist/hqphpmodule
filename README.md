# hqphpmodule
HQ PHP Module for Joomla

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
