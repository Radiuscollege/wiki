<?php

#
# Useful third-party extensions
#

wfLoadExtension( 'Renameuser' );
wfLoadExtension( 'WikiEditor' );
wfLoadExtension( 'ParserFunctions' );

#
# UserFunctions Extension + Config
#

require_once "$IP/extensions/UserFunctions/UserFunctions.php";
$wgUFAllowedNamespaces[NS_MAIN] = true;
$wgUFAllowedNamespaces[NS_TEMPLATE] = true;

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

# Enable subpages in the main namespace
$wgNamespacesWithSubpages[NS_MAIN] = true;

# Enable subpages in the template namespace
$wgNamespacesWithSubpages[NS_TEMPLATE] = true;

# Enable subpages in the teachers namespace
$wgNamespacesWithSubpages[NS_TEACHERS] = true;

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