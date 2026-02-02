# Airline-Management-System

Eine Webanwendung zur Verwaltung von Flugoperationen, entwickelt mit **Laravel 12** und **PHP 8.2**.
Dieses Projekt entstand im Rahmen des Moduls **"Software Engineering und KI"** an der Technischen Hochschule Ingolstadt.

## Übersicht

Die Webanwendung bietet ein System zur Verwaltung von Flugoperationen mit rollenbasierten Dashboards für verschiedene Abteilungen:

- **Planung**: Flugplanung und Flugzeugzuweisung
- **Disposition**: Dynamische Crew-Zuweisung und Flugmodifikationen
- **Operations**: Flugdurchführung und Störungsbehebung

## Motivation

- **Kreatives Konzept**: Ein realweltliches Szenario aus der Luftfahrttechnik, das komplexe Problemstellungen bietet
- **Praxisbezug**: Modelierung echter Flugbetriebsprozesse mit interessanten Herausforderungen bei der technischen Umsetzung

## Zielsetzung

- Sicherstellung eines **Reibungslosen Flugbetriebs**
- **Ressourcen-Management** für Flugzeuge, Crews und Flughäfen
- **Störungsbehebung** durch flexible Crew-Zuweisung und Flugmodifikationen
- **Rollenbasierte Unterteilung** der Aufgaben zwischen verschiedenen Abteilungen

Diese Anwendung ist ein **stark vereinfachtes Abbild** realer Abläufe:
- **Nicht für den produktiven Einsatz** gedacht
- Didaktisches Modell zur **Demonstration von Konzepten**
- **Begrenzte Funktionalität** gegenüber industriellen Lösungen

## Technologie-Stack

- **Framework**: [Laravel 12](https://laravel.com)
- **Sprache**: PHP 8.3+
- **Frontend**: Blade-Templates mit Tailwind CSS
- **Build-Tool**: Vite
- **Datenbank**: Eloquent ORM mit Migrations

## Projektstruktur

```
airline-mvc/
├── app/                         # Anwendungskern
│   ├── Models/                  # Eloquent Datenmodelle
│   ├── Http/                    # HTTP-Handler
│   │   ├── Controllers/         # Anwendungslogik
│   │   └── Requests/            # Formularvalidierung
│   ├── Services/                # Geschäftslogik
│   ├── Providers/               # Service Provider (ungenutzt)
│   └── View/                    # View-Komponenten
├── config/                      # Konfigurationsdateien
├── database/                    # Datenbank-Management
│   ├── migrations/              # Datenbankmigrationen
│   ├── factories/               # Model Factories
│   └── seeders/                 # Datenbank-Seeder
├── public/                      # Web root Verzeichnis
├── resources/                   # Frontend-Ressourcen
│   ├── css/                     # Stylesheets
│   ├── js/                      # JavaScript
│   └── views/                   # Blade-Templates
├── routes/                      # Route-Definitionen
```

## Hauptfunktionen

### Flugverwaltung
- Flüge erstellen und planen
- Flugstatus verfolgen (geplant, geschätzt, aktuell)
- Abflugs-, Ankunfts- und Ausweichflughäfen verwalten
- Flugzeugzuweisung und Verfolgung

### Crew-Management
- Crews Flügen zuweisen
- Crew-Pläne und Zuweisungen anzeigen
- Crew zwischen Flügen mit anderen Flügen transferieren
- Arbeitszeit-Limits verfolgen

## Rollenkonzept

Die Anwendung ist in drei spezialisierte Module unterteilt, die verschiedene Aspekte der Flugoperationen abdecken:

### Planung (Planner)
- **Aufgabe**: Erstellung von Flügen und Zuweisung von Flugzeugen
- **Funktionen**:
  - Neue Flüge erstellen und planen
  - Flugzeug und Registrierung zuweisen
  - Abflug- und Ankunftsflughäfen definieren
  - Zeitliche Planung vornehmen

### Disposition
- **Aufgabe**: Zuweisung und Verwaltung von Crews
- **Funktionen**:
  - Flügen Crews zuweisen
  - Crews transferieren
  - Flugdetails bei Bedarf aktualisieren
  - Crew-Verfügbarkeit überwachen

### Operations
- **Aufgabe**: Durchführung und Überwachung des Flugbetriebs
- **Funktionen**:
  - Flugstatus ~~in Echtzeit~~ überwachen
  - Zeiten anpassen, Flüge stornieren oder umleiten
  - Störungen und Probleme erkennen und beheben
  - Flugdetails und Informationen abrufen
  - Crew-Status und Verfügbarkeit prüfen

## Wichtige Modelle und Beziehungen

- **Flight**: 
    - 1 Aircraft
    - je 1 Abflug-/Ankunfts-/Ausweichflughafen (Aiport)
    - 1 operating Crew
    - 0..n Crew-Transfers 
- **Crew**: 
    - 0..n Flüge
    - 0..n Transfer-Flüge
- **Aircraft**:
    - 0..n Flüge
- **Airport**:
    - 0..n ankommende und abgehende Flüge

## Datenbankschema

Die Anwendung nutzt Migrations zur Verwaltung folgender Tabellen:
- `flights` - Flugdaten und Planung
- `aircraft` - Flugzeugbestand
- `crews` - Personalbestand (auf Crew-Einheiten vereinfacht)
- `airports` - Flughäfen
- `flight_crew_transfers` - Crew-Transferflüge

## Einrichtung und Installation

### Voraussetzungen

- PHP 8.3 oder höher
- Composer
- Node.js und npm
- SQLite (Standard) oder MySQL

### Schnellstart

1. **Abhängigkeiten installieren:**
   ```bash
   composer install
   npm install
   ```

2. **Umgebung einrichten:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Migrations und ggf. Seeders ausführen:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Frontend-Assets erstellen:**
   ```bash
   npm run build
   ```

5. **Anwendung starten:**
   ```bash
   php artisan serve
   ```

Die Anwendung ist unter `http://localhost:8000` verfügbar.

### Entwicklungsmodus

Alle Services gleichzeitig ausführen (Server, Queue, Logs und Vite):
```bash
composer run dev
```

## Verfügbare Routen

- `/` - Startseite
- `/planner` - Flugplanung und Terminplanung
- `/disposition` - Crew-Zuweisung und Verwaltung
- `/ops` - Operations und Überwachung

### Ressourcen-ähnliche Endpunkte

- `planner/flights` - Vollständiges CRUD für Flugplanung
- `disposition/flights` - Anzeigen, aktualisieren, Flugdetails einsehen
- `disposition/crews` - Crews überwachen
- `ops/flights` - Flüge überwachen
- `ops/crews` - Crews überwachen

## Tests (WIP)

Tests mit Pest ausführen:
```bash
php artisan test
```

## Ausblick und zukünftige Entwicklungen

Das Projekt bietet eine solide Grundlage für weitere Entwicklungen und Verbesserungen, z.B. als Virtual-Airline-Management-System:

### Kurzfristig
- **Authentifizierung**: Implementierung eines umfassenden Login-Systems
- **Benutzeroberfläche**: Überarbeitung des UI mit verbessertem Menü, Pagination und responsiven Dashboards
- **View-Struktur**: Neuorganisation und Optimierung der Blade-Templates

### Mittelfristig
- **Architektur-Refactoring**: 
  - Trennung in Backend-API und Frontend-Anwendung
  - RESTful API zur Backend-Verwaltung
- **Multi-Platform-Support**: 
  - Webbasiertes Frontend
  - Native Anwendungen (Android, iOS, Windows, Linux)

### Langfristig
- **Funktionserweiterung**: Ersatzflüge, erweiterte Ressourcenplanung, Echtzeitanpassungen
- **Anpassung an realen Einsatzzweck**: z.B. VA Management...

## Lizenz

Dieses Projekt ist Free Open Source und unter ISC-Lizenz veröffentlicht. Siehe [LICENSE](LICENSE) für Details.
