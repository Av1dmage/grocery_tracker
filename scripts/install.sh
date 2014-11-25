#!/usr/bin/env bash
#
# Script installs contents of www into nginx default web folder /usr/share/nginx/html/grocery_list
# Could add case for apache...

# Assume www folder in ./
LOCAL_PATH='./www/'

# Build WWW_USEDIR
WWW_PREFIX='/usr/share/nginx/html/'
WWW_SUBDIR='grocery_list/'
WWW_USEDIR="${WWW_PREFIX}${WWW_SUBDIR}"

# Create WWW_USDIR if not exists.
if [ ! -d $WWW_USEDIR ]; then
  printf 'Creating directory: %s\n' $WWW_USEDIR;
  sudo mkdir -p $WWW_USEDIR;
fi

# Copy and install the things.
printf 'Copying files from %s to %s...\n' $LOCAL_PATH $WWW_USEDIR
sudo rm -rf $WWW_USEDIR*
sudo cp -r $LOCAL_PATH* $WWW_USEDIR

if [ $? != 0 ]; then
  printf 'Error copying files.\n'
else
  printf 'Done.\n'
fi
