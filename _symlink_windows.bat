@echo off

echo This batch script needs to be run as administrator, testing permissions...

net session >nul 2>&1
if %errorLevel% == 0 (
    echo Success: Administrative permissions confirmed.
    echo.
    
    GOTO :StartSymlinking
) else (
    echo Failure: Please run this script as an Administrator
    
    GOTO :CancelSymlinking
)

:StartSymlinking
rem Reset if we used this batch before
set targetDirectory=../
set extensionsDir=extensions/
set skinsDir=skins/

set /p targetDirectory= What is the relative/full path of the target directory to symlink to (trailed with a /)? [../]: 
set /p extensionsDir= What is the extensions directory called? [extensions/]: 
set /p skinsDir= What is the skins directory called? [skins/]: 

echo.
echo ================================================
echo.
echo Preparing symbolic linking to %targetDirectory%:
echo - Extensions will be linked to %targetDirectory%%extensionsDir% 
echo - Skins will be linked to %targetDirectory%%skinsDir% 
echo.
echo ================================================
echo.

rem The files that need to be symlinked to the target directory:
set filesToLink[0]=composer.local.json
set filesToLink[1]=favicon.ico
set filesToLink[2]=LocalSettings.php

rem The extensions that need to be symlinked to the target directories extensions folder
set extensionsToLink[0]=AmoClient
set extensionsToLink[1]=Lockdown
set extensionsToLink[2]=ParserFunctions
set extensionsToLink[3]=Renameuser
set extensionsToLink[4]=VisualEditor
set extensionsToLink[5]=WikiEditor

rem The extensions that need to be symlinked to the target directories skins folder
set skinsToLink[0]=Vector
set skinsToLink[1]=MonoBook
set skinsToLink[2]=Modern
set skinsToLink[3]=CologneBlue
set skinsToLink[4]=RadiusAMO

setlocal enableextensions
if errorlevel 1 echo Unable to enable extensions

echo.
echo Making symbolic links for customization files:
set x=0

:SymFileLoop
if defined filesToLink[%x%] (
    call echo %x%: mklink "%targetDirectory%%%filesToLink[%x%]%%" "%%filesToLink[%x%]%%"
    call mklink "%targetDirectory%%%filesToLink[%x%]%%" "%%filesToLink[%x%]%%"
    set /a "x+=1"
    GOTO :SymFileLoop
)

echo.
echo Making symbolic links for customization extensions:
set x=0

:SymExtensionsLoop
if defined extensionsToLink[%x%] (
    call echo %x%: mklink "%targetDirectory%%extensionsDir%%%extensionsToLink[%x%]%%" "%extensionsDir%%%extensionsToLink[%x%]%%"
    call mklink /D "%targetDirectory%%extensionsDir%%%extensionsToLink[%x%]%%" "%extensionsDir%%%extensionsToLink[%x%]%%"
    set /a "x+=1"
    GOTO :SymExtensionsLoop
)

echo.
echo Making symbolic links for customization skins:
set x=0

:SymSkinsLoop
if defined skinsToLink[%x%] (
    call echo %x%: mklink "%targetDirectory%%skinsDir%%%skinsToLink[%x%]%%" "%skinsDir%%%skinsToLink[%x%]%%"
    call mklink /D "%targetDirectory%%skinsDir%%%skinsToLink[%x%]%%" "%skinsDir%%%skinsToLink[%x%]%%"
    set /a "x+=1"
    GOTO :SymSkinsLoop
)

echo.
echo Done!

:CancelSymlinking