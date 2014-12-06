## Run local commands after initial setup

## APPLICATION_ENV

    sudo echo 'APPLICATION_ENV=development' >> /etc/environment

*Restart vagrant (vagrant halt / up)*

## composer and migrate

    cd /home/koding/data/www/monitorbacklinks.koding.io
    composer install
    ./yii migrate/up

## Update nginx (Add sendfile off;)

    vi /etc/nginx/sites-enabled/monitorbacklinks.koding.io
    
    Add:
    sendfile off;
    
    nginx reload


## Compass installation and run/watch

    sudo apt-get install ruby-dev
    sudo gem install compass
    
Open a new putty and run command:
    
    cd {app_folder}
    compass watch --poll -c config.rb

## Nginx

# Web server

You must point the application root path to `web` folder. Then you must add the
following environment variables at `/etc/nginx/fastcgi_params` file:

(P.S. **SW** stands for *Social Warming*).

```nginx
fastcgi_param SW_ENVIRONMENT "development";
fastcgi_param SW_COOKIE_VALIDATION_KEY "---------------";
fastcgi_param SW_DB_DSN "mysql:host=localhost;dbname=koding";
fastcgi_param SW_DB_USERNAME koding;
fastcgi_param SW_DB_PASSWORD "";
fastcgi_param SW_FACEBOOK_CLIENT_ID "------------";
fastcgi_param SW_FACEBOOK_CLIENT_SECRET "------------";
fastcg
i_param SW_TWITTER_CONSUMER_KEY "--------------";
fastcgi_param SW_TWITTER_CONSUMER_SECRET "------------------";
```

Finally, restart the server: `sudo service nginx restart`.

# Console

You must also add environment variables to your `~/.profile` file:

```bash
export SW_ENVIRONMENT="development"
export SW_DB_DSN='mysql:host=localhost;dbname=koding'
export SW_DB_USERNAME='koding'
export SW_DB_PASSWORD='---------'

```

Finally, reload your file with `source ~/.profile`.
