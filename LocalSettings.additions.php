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

# Prevent inclusion of pages from that namespace
$wgNonincludableNamespaces[] = NS_TEACHERS;

# Create teacher group
$wgGroupPermissions['student'] = $wgGroupPermissions['user'];
$wgGroupPermissions['teacher'] = $wgGroupPermissions['user'];

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

# Set permissions:
$wgNamespacePermissionLockdown['*']['move'] = array('teacher');
$wgNamespacePermissionLockdown['*']['edit'] = array('teacher');
$wgNamespacePermissionLockdown['*']['read'] = array('teacher', 'student');

# Only allow teachers to query the api for pages
$wgNamespacePermissionLockdown['*']['api_read'] = array('teacher');

$wgNamespacePermissionLockdown[NS_TALK]['edit'] = array('teacher', 'student');
$wgNamespacePermissionLockdown[NS_USER]['edit'] = array('teacher', 'student');
$wgNamespacePermissionLockdown[NS_USER_TALK]['edit'] = array('teacher', 'student');

# Allow teachers and students to query the api for talk and user pages
$wgNamespacePermissionLockdown[NS_TALK]['api_read'] = array('teacher', 'student');
$wgNamespacePermissionLockdown[NS_USER]['api_read'] = array('teacher', 'student');
$wgNamespacePermissionLockdown[NS_USER_TALK]['api_read'] = array('teacher', 'student');

# Only allow teachers to do anything with the teacher namespace
$wgNamespacePermissionLockdown[NS_TEACHERS]['*'] = array('teacher');

# Specifically say only teachers can read teachers pages, otherwise '$wgNamespacePermissionLockdown['*']['read'] = array('teacher', 'student');' will allow students to read it as well.
$wgNamespacePermissionLockdown[NS_TEACHERS]['read'] = array('teacher');

$wgSpecialPageLockdown['Export'] = array('teacher');
$wgSpecialPageLockdown['Recentchanges'] = array('teacher');

# Block history and edit completely for all namespaces except the user and user talk pages
$wgActionLockdown['move'] = array('teacher');
$wgActionLockdown['history'] = array('teacher');
$wgActionLockdown['edit'] = array('teacher');

$wgNamespaceActionLockdown[NS_TALK]['*'] = array('teacher', 'student');
$wgNamespaceActionLockdown[NS_USER]['*'] = array('teacher', 'student');
$wgNamespaceActionLockdown[NS_USER_TALK]['*'] = array('teacher', 'student');

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