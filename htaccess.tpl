
RedirectPermanent /my-movies http://my-movies.loc

<IfModule mod_headers.c>
    Header set Access-Control-Allow-Origin "*"
</IfModule>

RewriteEngine On
RewriteRule  ^login$ index.php?controller=user&action=login
RewriteRule  ^login/check$ index.php?controller=user&action=check
RewriteRule  ^logout$ index.php?controller=user&action=logout

RewriteRule  ^api/author/([0-9]+)$ index.php?controller=api&action=author&id=$1
RewriteRule  ^api/authors$ index.php?controller=api&action=authors

RewriteRule  ^(authors|movies)/(edit|store|delete)/?([0-9]*)$ index.php?controller=$1&action=$2&id=$3
RewriteRule  ^(authors|movies)/([0-9]+)$ index.php?controller=$1&action=show&id=$2
RewriteRule  ^(authors|movies)$ index.php?controller=$1&action=index

RewriteCond $1 !^(css|js|uploads)/ [NC]
RewriteRule  ^(.*)$ index.php
