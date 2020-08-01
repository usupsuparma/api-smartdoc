#!/bin/bash

echo "=== Smartdoc BIJB Setup Bash Script ===="
echo "!CANCEL this operation if not sure!"

echo "Please enter code setup command ?"
read -p 'setup: ' setup

if [ "$target" == "letsgo" ]; then
    git remote add upstream git@github.com:aelgees/api-smartdoc-bijb.git
	echo "!...Fetching latest working copy from UPSTREAM...!"
	git fetch upstream
	echo "!...Finish fetching from upstream...!"
	git pull --rebase upstream master
	echo "!...Finish pulling data from Master...!"
	composer install
    echo "Composer Install Finished Successfuly"
	cp .env.example .env
	echo "Copy File .env.example -> .env Successfuly"
	php artisan migrate
	echo "Database Migration Finish Successfuly"
	php artisan db:seed
	echo "Database Seeder Finish Successfuly"
	cp ./public/assets/fonts/edwardian-script-itc.ttf ./vendor/tecnickcom/tcpdf/tools/edwardian-script-itc.ttf
	./vendor/tecnickcom/tcpdf/tools/tcpdf_addfont.php -b -t TrueTypeUnicode -i ./vendor/tecnickcom/tcpdf/tools/edwardian-script-itc.ttf
	echo "Finish Update Font PDF Successfuly"
	mkdir -p storage/app/public/outgoing_mail
	mkdir -p storage/app/public/incoming_mail
	mkdir -p storage/app/public/disposition
	mkdir -p storage/app/public/qr_code
	mkdir -p storage/app/public/digital_signature
	chown -R www-data:www-data storage
	echo "Finish Create Permission For Storage"
	php artisan passport:install --force
	echo "Finish Generate Passport For Website"
	php artisan passport:install --force
	echo "Finish Generate Passport For Mobile"
else
    echo "ERROR INVALID COMMAND !!!"
fi
