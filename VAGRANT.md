## Run local commands after initial setup
````
su
sudo echo 'APPLICATION_ENV=development' >> /etc/environment
````


````
cd /home/koding/data/www/monitorbacklinks.koding.io
composer install
./yii migrate/up
````

(soon): compass/sass install & watch yii css folder
