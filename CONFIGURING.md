# Web server

You must point the application root path to `web` folder. Then you must add the
following environment variables at `/etc/nginx/fastcgi_params` file:

(P.S. **SW** stands for *Social Warming*).

```nginx
fastcgi_param SW_ENVIRONMENT "development";
fastcgi_param SW_COOKIE_VALIDATION_KEY "abcdefghij";
fastcgi_param SW_DB_DSN "mysql:host=localhost;dbname=koding";
fastcgi_param SW_DB_USERNAME koding;
fastcgi_param SW_DB_PASSWORD "";
fastcgi_param SW_FACEBOOK_CLIENT_ID "123456789";
fastcgi_param SW_FACEBOOK_CLIENT_SECRET "abcdefghijkl";
fastcgi_param SW_TWITTER_CONSUMER_KEY "abcdefghijkl";
fastcgi_param SW_TWITTER_CONSUMER_SECRET "abcdefghijkl";
fastcgi_param SW_ADMIN_HTTP_USERNAME "koding";
fastcgi_param SW_ADMIN_HTTP_PASSWORD "";
```

Finally, restart the server: `sudo service nginx restart`.

# Console

You must also add environment variables to your `~/.profile` file:

```bash
export SW_ENVIRONMENT="development"
export SW_DB_DSN='mysql:host=localhost;dbname=koding'
export SW_DB_USERNAME='koding'
export SW_DB_PASSWORD=''

```

Finally, reload your file with `source ~/.profile`.