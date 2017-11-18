#!/bin/bash

printf "What is the relative/full path of the target directory to symlink to (trailed with a /)? [../]: "
read targetDirectory
printf "\nWhat is the extensions directory called? [extensions/]: "
read extensionsDir
printf "\nWhat is the skins directory called? [skins/]: "
read skinsDir

if [ -z "$targetDirectory" ]; then
    targetDirectory=../
fi

if [ -z "$extensionsDir" ]; then
    extensionsDir=extensions/
fi

if [ -z "$skinsDir" ]; then
    skinsDir=skins/
fi

printf "\n\n================================================\n"
printf "Preparing symbolic linking to $targetDirectory:\n"
printf "* Extensions will be linked to $targetDirectory$extensionsDir\n"
printf "* Skins will be linked to $targetDirectory$skinsDir\n"
printf "================================================\n"

# The files that need to be symlinked to the target directory:
filesToLink[0]=composer.local.json
filesToLink[1]=favicon.ico
filesToLink[2]=LocalSettings.php
filesToLink[3]=composer.lock

# The extensions that need to be symlinked to the target directories extensions folder
extensionsToLink[0]=AmoClient
extensionsToLink[1]=Lockdown
extensionsToLink[2]=ParserFunctions
extensionsToLink[3]=Renameuser
extensionsToLink[4]=VisualEditor
extensionsToLink[5]=WikiEditor

#The extensions that need to be symlinked to the target directories extensions folder
skinsToLink[0]=Vector
skinsToLink[1]=MonoBook
skinsToLink[2]=Modern
skinsToLink[3]=CologneBlue
skinsToLink[4]=RadiusAMO

printf "\n"
printf "Making symbolic links for customization files:\n"

for i in "${filesToLink[@]}"
do
   : 
   printf "ln -sf \"$i\" \"$targetDirectory$i\"\n"
   ln -sf "$i" "$targetDirectory$i"
done

printf "\n"
printf "Making symbolic links for customization extensions:\n"

for i in "${extensionsToLink[@]}"
do
   : 
   printf "ln -sf \"$i\" \"$targetDirectory$extensionsDir$i\"\n"
   ln -sf "$i" "$targetDirectory$extensionsDir$i"
done

printf "\n"
printf "Making symbolic links for customization skins:\n"

for i in "${skinsToLink[@]}"
do
   : 
   printf "ln -sf \"$i\" \"$targetDirectory$skinsDir$i\"\n"
   ln -sf "$i" "$targetDirectory$skinsDir$i"
done

printf "\n\nDone!"