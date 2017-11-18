echo "Please enter the target directory: "
read targetDirectory

cp --symbolic-link "$targetDirectory/*" .