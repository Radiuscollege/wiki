# About this repository

This repository contains all the customization files for the AMO wiki.

Note that there are 2 custom submodules, an extension for the AMO Login OpenID Connect and a custom skin.

Additionally there are a bunch of third-party extension submodules

# Installation

In this chapter we'll describe how to setup a MediaWiki instance containing the AMO customizations.

## 1. Getting the MediaWiki Core

Clone the MediaWiki Core into the publicly accessible root of your webserver by going to the root directory and running:

Official: `git clone https://gerrit.wikimedia.org/r/p/mediawiki/core.git .`

Official Mirror: `git clone https://github.com/wikimedia/mediawiki.git .`

_(Alternatively you could switch to a stable branch instead of the master)_

## 2. Get these customizations

To get these customizations, clone the repo to a folder on your server like so:
`git clone https://github.com/Radiuscollege/wiki.git . --recursive`

_--recursive will make it so the subrepo's also get cloned_

After cloning the repo and subrepo's you will have to symlink these files to the wiki project. See the following chapters for that.

### 2.1 Symlink on Linux
Follow the instructions after running `_symlink_linux.sh` to symlink the contents of this repo to the wiki project.

Note: you might have to run the bash script using sudo, e.g: `sudo bash ./_symlink_linux.sh`

_The batch script for Linux is a bit crude at the moment, any help to clean it up is appreciated_

### 2.2 Symlink Windows

Follow the instructions after running `_symlink_windows.bat` to symlink the contents of this repo to the wiki project.

_The batch script for Windows is a bit crude at the moment, any help to clean it up is appreciated._

## 3. Important: install the dependencies

Before you do anything else: run ```composer install``` in a command prompt/shell inside the root of the wiki project to install the required dependencies (for MediaWiki and also the customizations).

(You can get composer for your system here: https://getcomposer.org/)

## 4. Configuring MediaWiki

Without a `LocalSettings.php` MediaWiki will prompt for configuration. Follow the steps and configure with your database/server details.

After you have successfully completed configuration, you will be able to download a `LocalSettings.php`. Put this file in the root of the wiki project.

Edit `LocalSettings.php` and put the contents of `LocalSettings.additions.php` at the bottom of it.

**Note that there are 2 global variables related to the AMO Login OpenID connect. Make sure you get the values for these variables by creating an app at login.amo.rocks (you can only do this if you have a teacher-account)**

**There are also configurations for Parsoid which need to be set. See the next paragraph for information about that.**

## 5. Setting up Parsoid and VisualEditor

In order to have the VisualEditor extension function you need to first install Parsoid following the instructions here: https://www.mediawiki.org/wiki/Parsoid/Setup

After that run parsoid.

After starting up parsoid it will tell you what port it is running on (usually 8000 or 8142) and you can then configure the `$wgVirtualRestConfig['modules']['parsoid']` array in `LocalSettings.php`

_If you have a private wiki, see [this article](https://www.mediawiki.org/wiki/Extension:VisualEditor#Linking_with_Parsoid_in_private_wikis) for instructions._

# Contributing

If you're thinking of contributing or you've already booted up your favorite IDE then kudo's to you! I'm in dire need of someone who can help me clean up this project as well as the included submodules:
* https://github.com/TheJjokerR/amoskin-mediawiki
* https://github.com/TheJjokerR/amoclient-mediawiki

**Note: Do not edit core MediaWiki files! Any changes to the core will be reset upon updating MediaWiki.**