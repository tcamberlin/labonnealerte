#!/bin/bash
LOCAL_ROOT_DIR=/Applications/MAMP/htdocs/labonnealerte
#/homez.356/tcamberl/labonnealerte
REMOTE_ROOT_DIR=/homez.356/tcamberl/labonnealerte
LOCAL_HOST=localhost
REMOTE_HOST=ftp.cluster010.ovh.net
VERSION=current
PASSWORD=wwkdJANg
USERNAME=tcamberl
EXCLUDE_FILE=/Applications/MAMP/htdocs/labonnealerte/application/scripts/exclude.txt


## Execution of sync command
rsync -rv --exclude-from=$EXCLUDE_FILE /Applications/MAMP/htdocs/labonnealerte/ $USERNAME@$REMOTE_HOST:$REMOTE_ROOT_DIR/$VERSION 
