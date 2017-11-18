# About this repository

This repository contains all the customization files for the AMO wiki.

Note that there are 2 custom submodules, an extension for the AMO Login OpenID Connect and a custom skin.

Additionally there are a bunch of third-party extension submodules

# Installation

In this chapter we'll describe how to setup a MediaWiki instance containing the AMO customizations.

## 1. Getting the MediaWiki Core

Clone the MediaWiki Core into the publicly accessible root of your webserver from:

Official: `https://gerrit.wikimedia.org/r/p/mediawiki/core.git`

Official Mirror: `https://github.com/wikimedia/mediawiki`

## 2. Important: install the dependencies

Before you do anything, please run ```composer install``` in a command prompt/shell inside the root of the wiki project to install the required dependencies.

(You can get composer for your system here: https://getcomposer.org/)

## MediaWiki

Without a LocalSettings.php MediaWiki will prompt for configuration. Follow the steps and configure with your database/server details.

After you have successfully completed configuration, you will be able to download a LocalSettings.php. Put this file in the root of the wiki project.

Edit LocalSettings.php and put the following line at the bottom of it to use the AMO wiki configuration:

```php
$wgAmoLoginClientClientID = 0; // Make sure to change 0 to the client id of your app, registered with AMO Login.
$wgAmoLoginClientClientSecret = '<PUT AMO LOGIN SECRET KEY HERE>'; // Put the secret string in this variable.
require_once("AMOSettings.php");
```

# Contributing

If you're thinking of contributing or you've already booted up your favorite IDE then kudo's to you! I'm in dire need of someone who can help me clean up this project as well as the included submodules:
* https://github.com/TheJjokerR/amoskin-mediawiki
* https://github.com/TheJjokerR/amoclient-mediawiki

**Note: Do not edit core MediaWiki files! Any changes to the core will be reset upon updating MediaWiki.**