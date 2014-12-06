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

## Compass installation and run/watch

    sudo apt-get install ruby-dev
    sudo gem install compass
    cd {app_folder}
    compass watch --poll -c config.rb
