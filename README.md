# About this repository

This repository contains all the customization files for the AMO wiki.

Note that there are 2 custom submodules, an extension for the AMO Login OpenID Connect and a custom skin.

Additionally there are a bunch of third-party extension submodules

# Installation

In this chapter we'll describe how to setup a MediaWiki instance containing the AMO customizations.

## 1. Getting the MediaWiki Core

Clone the MediaWiki Core into the publicly accessible root of your webserver by going to the root directory and running:

Official: `git clone https://gerrit.wikimedia.org/r/p/mediawiki/core.git .`

Official Mirror: `git clone https://github.com/wikimedia/mediawiki .

_(Alternatively you could switch to a stable branch instead of the master)_

## 2. Symlink these customizations


### 2.1 Linux
Follow the instructions after running `_symlink_linux.sh` to symlink the contents of this repo to the wiki project.

_I have not tested if this bash script works. The batch script for Linux is a bit crude at the moment, any help to clean it up is appreciated_

### 2.2 Windows

Follow the instructions after running `_symlink_windows.bat` to symlink the contents of this repo to the wiki project.

_The batch script for Windows is a bit crude at the moment, any help to clean it up is appreciated._

## 3. Important: install the dependencies

Before you do anything else: run ```composer install``` in a command prompt/shell inside the root of the wiki project to install the required dependencies (for MediaWiki and also the customizations).

(You can get composer for your system here: https://getcomposer.org/)

## 4. Configuring MediaWiki

Without a `LocalSettings.php` MediaWiki will prompt for configuration. Follow the steps and configure with your database/server details.

After you have successfully completed configuration, you will be able to download a `LocalSettings.php`. Put this file in the root of the wiki project.

Edit `LocalSettings.php` and put the following lines at the bottom of it:

```php
#
# Useful third-party extensions
#

wfLoadExtension( 'Renameuser' );
wfLoadExtension( 'WikiEditor' );
wfLoadExtension( 'ParserFunctions' );

#
# AmoClient Extension + Config
#
# IMPORTANT: $wgAmoLoginClientClientSecret MUST be in LocalSettings.php OR another file which is IN the .gitignore and is loaded by MediaWiki
#

# For remote authentication (we are going to use this for AMO Login)
$wgAmoLoginClientRemoteURL = 'https://login.amo.rocks/oauth/authorize';
$wgAmoLoginClientRemoteTokenURL = 'https://login.amo.rocks/oauth/token';
$wgAmoLoginClientTeachersOnly = false;
$wgAmoLoginClientClientID = -1; // Set -1 to your app id (configured in login.amo.rocks)
$wgAmoLoginClientClientSecret = 'secret'; // set secret to your app secret (configured in login.amo.rocks)

wfLoadExtension( 'AmoClient' );

#
# Additional settings
#

# Show exceptions
$wgShowExceptionDetails = true;

# Create the teachers namespace which we will protect.
define("NS_TEACHERS", 1600);

# Add namespaces.
$wgExtraNamespaces[NS_TEACHERS] = "Docent";

#
# Lockdown extension + config
#

require_once( "$IP/extensions/Lockdown/Lockdown.php" );

# Prevent inclusion of pages from that namespace
$wgNonincludableNamespaces[] = NS_TEACHERS;

# Create teacher group
$wgGroupPermissions['student'] = $wgGroupPermissions['user'];
$wgGroupPermissions['teacher'] = $wgGroupPermissions['user'];

# Set permissions:
$wgNamespacePermissionLockdown[NS_TEACHERS]['*'] = array('teacher');

$wgNamespacePermissionLockdown['*']['move'] = array('teacher');
$wgNamespacePermissionLockdown['*']['edit'] = array('teacher');
$wgNamespacePermissionLockdown['*']['read'] = array('teacher', 'student');

$wgSpecialPageLockdown['Export'] = array('teacher');
$wgSpecialPageLockdown['Recentchanges'] = array('teacher');
$wgActionLockdown['history'] = array('teacher');

#
# Custom Skins
#

# Radius AMO Skin
wfLoadSkin( 'RadiusAMO' );

#
# VisualEditor Extension + Config
#

wfLoadExtension( 'VisualEditor' );

// Enable by default for everybody
$wgDefaultUserOptions['visualeditor-enable'] = 1;

// Optional: Set VisualEditor as the default for anonymous users
// otherwise they will have to switch to VE
// $wgDefaultUserOptions['visualeditor-editor'] = "visualeditor";

// Don't allow users to disable it
$wgHiddenPrefs[] = 'visualeditor-enable';

// OPTIONAL: Enable VisualEditor's experimental code features
#$wgDefaultUserOptions['visualeditor-enable-experimental'] = 1;

# Supported skins
$wgVisualEditorSupportedSkins = [ 'vector', 'radiusamo' ];

# Namespaces VisualEditor will work in
$wgVisualEditorAvailableNamespaces = [
    NS_MAIN => true,
    NS_USER => true,
    NS_USER_TALK => true,
    NS_TEACHERS => true,
    NS_HELP => true,
    NS_HELP_TALK => true,
    NS_TALK => true,
];

# Link VisualEditor with parsoid
$wgVirtualRestConfig['modules']['parsoid'] = array(
    // URL to the Parsoid instance
    // Use port 8142 if you use the Debian package
    'url' => 'http://localhost:8000',
    // Parsoid "domain", see below (optional)
    'domain' => 'localhost',
    // Parsoid "prefix", see below (optional)
    'prefix' => 'localhost'
);
```

Note that there are 2 global variables related to the AMO Login OpenID connect. Make sure you get the values for these variables by creating an app at login.amo.rocks (you can only do this if you have a teacher-account)

There are also configurations for Parsoid which need to be set. See the next paragraph for information about that.

## 5. Setting up Parsoid and VisualEditor

In order to have the VisualEditor extension function you need to first install Parsoid:
* Clone this repo somewhere on your server: https://github.com/wikimedia/parsoid/
* Follow the instructions described in that repo's `README.md`

After starting up parsoid it will tell you what port it is running on (usually 8000) and you can then configure the `$wgVirtualRestConfig['modules']['parsoid']` array in `LocalSettings.php`

# Contributing

If you're thinking of contributing or you've already booted up your favorite IDE then kudo's to you! I'm in dire need of someone who can help me clean up this project as well as the included submodules:
* https://github.com/TheJjokerR/amoskin-mediawiki
* https://github.com/TheJjokerR/amoclient-mediawiki

**Note: Do not edit core MediaWiki files! Any changes to the core will be reset upon updating MediaWiki.**