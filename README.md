# bta-movies
## Einrichtung eines Virtuellen Host namens: bta-movies.loc
#### Für Windows DNS in host Datei eintragen (C:\Window\System32\drivers\etc\hosts)
#### Für Mac OSX, Linux DNS in host Datei eintragen (/etc/hosts)
- 127.0.0.1	bta-movies.loc

Zugriffsrechte unter Windows setzen
![Dateirechte](./win_access_hosts.png)

#### Apache -> httpd-vhosts.conf
- Windows: C:\xampp\apache\conf\extra\httpd-vhosts.conf
- Mac OSX: /Applications/XAMPP/etc/extra/httpd-vhosts.conf
```
<VirtualHost *:80>
	ServerName bta-movies.loc
        DocumentRoot "FULL PATH TO ... /htdocs/bta-movies"
	CustomLog "logs/access_bta-movies.log" common
	ErrorLog "logs/error_bta-movies.log"
</VirtualHost>
```

#### Apache -> httpd.conf überprüfen
- Windows: C:\xampp\apache\conf\httpd.conf
- Mac OSX: /Applications/XAMPP/etc/httpd.conf

In der zentralen Konfigurations-Datei des Apache-Servers 'httpd.conf' bitte überprüfen,
ob dort die httpd-vhosts.conf inkludiert wird. Folgende Zeile muß dort eingetragen sein:
```
Include etc/extra/httpd-vhosts.conf
```
Falls diese Zeile dort existiert und ein Rautezeichen (Zeichen für Kommentar-Zeile) davor steht, 
dann entfernt es bitte. 

#### MVC Design Pattern als Grundlage der Projekt Struktur
- M: Model = Funktionalitäten der Datenhaltung (CRUD - Aktionen: Create, Read, Update, Delete).
Betrifft die notwendigen DB-Funktionalitäten
- V: View = Die Anzeige Logik (HTML, CSS, Javascript). Implementierung der der Daten per PHP.
- C: Controller = Die spezielle Logik zur Behandlung aller Requests per Routing

#### Routing
Implementierung der Controller-Aktionen entsprechend der vorgegebener URL Parameter per GET-Requests.
Die GET-Parameter werden von uns definiert und zu Suchmaschinen-freundlichen URL's gemappt.
Es gibt folgende GET-Parameter:
- controller
- action
- id (optional)
Beispiele: 
- aus bta-movies/index.php?controller=authors&action=index wird: bta-movies/authors
- aus bta-movies/index.php?controller=authors&action=edit&id=1 wird: bta-movies/authors/edit/1

Das gesamte Routing wird in index.php implementiert. Eine bestimmte Route (z.B bta-movies/authors) 
instanziert einen bestimmten Controller und führt eine für diese Route vorgesehene Aktion (Controller Methode)
aus. Beispiel: bta-movies/authors => AuthorController::index()

#### Daten (Model) und Views
Die Controller inkludieren per require_once die vorgesehenen View-Files
und liefern ihnen über Model-Funktionen die notwendigen Daten per PHP-Variablen.



