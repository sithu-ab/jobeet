# Jobeet

A Symfony project created on May 20, 2015, 5:17 am. This is a tutorial project followed to [jobeet.symfony.gr.jp](http://jobeet.symfony.gr.jp/).

## Installation

Clone the repo:

    cd /c/xampp/htdocs
    git clone https://github.com/sithu-ab/jobeet.git
    cd jobeet

Install Dependencies using Composer:

    composer install

### Database Setup

- Create a new database, e.g., `jobeet` which is the one you setup during `composer install`
- Install the database using the command:

        php app/console doctrine:schema:update --force

- Install the sample data using the command:

        php app/console doctrine:fixtures:load

### Enable PHP intl extension

- Open *php.ini* and remove comment from `extension=php_intl.dll`.
- Restart Apache.

### Virtural Host Configuration

Open `C:\xampp\apache\conf\extra\httpd-vhost.conf` and update it to have the settings below and then **restart Apache**.

    <VirtualHost *>
        DocumentRoot "C:\xampp\htdocs"
        ServerName localhost
    </VirtualHost>

    # ....
    # ....

    <VirtualHost *>
        ServerName jobeet.local
        ServerAlias jobeet.local

        DocumentRoot "C:\xampp\htdocs\jobeet\web"
        <Directory "C:\xampp\htdocs\jobeet\web">
            AllowOverride None
            Order Allow,Deny
            Allow from All

            <IfModule mod_rewrite.c>
                Options -MultiViews
                RewriteEngine On
                RewriteCond %{REQUEST_FILENAME} !-f
                RewriteRule ^(.*)$ app.php [QSA,L]
            </IfModule>
        </Directory>

        # uncomment the following lines if you install assets as symlinks
        # or run into problems when compiling LESS/Sass/CoffeScript assets
        # <Directory "C:\xampp\htdocs\jobeet\web">
        #     Options FollowSymlinks
        # </Directory>

        ErrorLog C:\xampp\apache\logs\project-error.log
        CustomLog C:\xampp\apache\logs\project-access.log combined
    </VirtualHost>

Copy `C:\Windows\System32\drivers\etc\hosts` to your desktop

Update the file on your desktop to add

    127.0.0.1   localhost
    127.0.0.1   jobeet.local

Copy and replace to `C:\Windows\System32\drivers\etc\hosts`

Browse
- `http://jobeet.local/app_dev.php` for development mode
- `http://jobeet.local/` for production mode
