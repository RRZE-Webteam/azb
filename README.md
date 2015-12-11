Einleitung
==========
AZB ist ein Projekt des RRZE mit dem man ein Portal für die Bewerbung von Auszubildenden bereitstellen kann. Die Bewerbungen werden einschl. der hochgeladenen Dokumente in einer PostgreSQL-Datenbank abgelegt. 

Bewerbung
=========

Zunächst muss sich ein Bewerber registrieren. Hierzu sind grundsätzliche persönliche Daten, sowie eine E-Mail-Adresse und ein selbstgewähltes Passwort zu hinterlegen. Die Registrierung wird mit einem Aktivierungslink, der per Mail versand wird abgeschlossen. E-Mail-Adresse und Passwort stellen also die Zugangsdaten zum Portal dar. Mit diesen kann jede Bewerbung zu beliebigen Zeitpunkten fortgesetzt oder zurückgezogen werden. Der Rest der Bewerbung wird in den Schritten *Kontakt*, *Ausbildung*, *Praktika*, *IT-Kenntnisse*, *Unterlagen* und *Sonstiges* eingereicht.

Technisches
===========

Im Verzeichnis `application/config` sollten die beiden Dateien `config_editme.php` und `database_editme.php` angepasst werden und danach ohne die Suffixe `_editme` umbenannt.

In `config.php` muss mindestens die `base_url` angepasst werden. In `database.php` sind die Einstellungen zum Datenbankzugriff vorzunehmen. Das Schema der Datenbank befindet sich unter `util/schema.sql`.

Bei Änderungen am Design muss evtl. die SASS Datei neu kompiliert werden:

```sass assets/scss/style-rrze.scss assets/css/style-rrze.css```

Verwendete Bibliotheken
=======================

* Font OpenSans
* jQuery - jQuery UI
* Bootstrap 3.2.0

Lizenz
=====

GNU General Public License (GPL) Version 2 

