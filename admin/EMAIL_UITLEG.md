# E-mail voor het schoolproject (kort)

## Wat je moet weten

PHP heeft een ingebouwde functie: **`mail()`**. Die gebruikt dit project op de **live server** (bureau.gluwebsite.nl).

Op je **eigen computer (XAMPP)** werkt `mail()` bijna nooit. Dat is normaal. Lokaal worden test-mails in een bestand gezet: `admin/logs/mail.log`.

## Wat jij instelt (1 bestand)

Open: `admin/includes/mail_config.php`

```php
'from_email' => 'noreply@gluwebsite.nl',  // ← jouw no-reply adres
'from_name'  => 'Bureau Jobs',
'reply_to'   => 'info@gluwebsite.nl',     // ← waar antwoorden naartoe gaan
'transport'  => 'auto',                   // ← laat op auto staan
```

Vraag je docent welk **exact** no-reply-adres je mag gebruiken (bijv. `noreply@gluwebsite.nl`).

## Testen

| Waar | Wat gebeurt er |
|------|----------------|
| Localhost (XAMPP) | Bericht in `admin/logs/mail.log` |
| https://bureau.gluwebsite.nl/vacatures/ | Echte mail via `mail()` |

Admin → **E-mail testen** (knop bij Inzendingen) → vul je eigen schoolmail in → verstuur.

## Voor je docent / hosting

Op de server moet het afzender-adres (`from_email`) bestaan of door de host als verzender worden toegestaan. Anders belandt mail in spam of wordt het geweigerd.

Geen Gmail-wachtwoorden nodig tenzij de host SMTP verplicht stelt.
