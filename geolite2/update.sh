#!/bin/bash

# Current directory
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"

# Maxmind license key
key=$1
while [ -z "$key" ]; do
	read -p "Your Maxmind license key: " key
done

wget -O "$DIR/GeoLite2-City.tar.gz" "https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key=$key&suffix=tar.gz"
tar xzf "$DIR/GeoLite2-City.tar.gz" -C "$DIR" --strip-components 1 --wildcards --no-anchored "*.mmdb"
rm "$DIR/GeoLite2-City.tar.gz"

wget -O "$DIR/GeoLite2-Country.tar.gz" "https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-Country&license_key=$key&suffix=tar.gz"
tar xzf "$DIR/GeoLite2-Country.tar.gz" -C "$DIR" --strip-components 1 --wildcards --no-anchored '*.mmdb'
rm "$DIR/GeoLite2-Country.tar.gz"
