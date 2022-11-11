[![deutsche Version](https://logos.oxidmodule.com/de2_xs.svg)](README.md)
[![english version](https://logos.oxidmodule.com/en2_xs.svg)](README.en.md)

# Hilfstools für besser testbaren Code

Dieses Paket stellt Hilfstools bereit, um Schwierigkeiten beim Testen von Plugincode aus frei erweiterbaren Frameworks (z.B. Shopsoftware) zu umgehen.

- Methodenbundles lassen sich als Trait klassenabhängig einbinden

- `Production\IsMockable`: enthält Methoden zum Mocken von Parentaufrufen
- `Development\CanAccessRestricted`: enthält Methoden für bessere Zugänglichkeit von protected Code

## Inhaltsverzeichnis

- [Installation](#installation)
- [Verwendung](#verwendung)
- [Changelog](#changelog)
- [Beitragen](#beitragen)
- [Lizenz](#lizenz)

## Installation

Dieses Paket erfordert ein mit Composer installiertes Projekt.

Öffnen Sie eine Kommandozeile und navigieren Sie zum Stammverzeichnis Ihrer Installation. Führen Sie den folgenden Befehl aus. Passen Sie die Pfadangaben an Ihre Installationsumgebung an.


```bash
php composer require d3/d3/testingtools:^1.0
```

## Verwendung

Binden Sie den jeweiligen Trait in Ihre Klasse ein und verwenden die gewünschte Methode in Ihrem Code:

```
use \D3\TestingTools\Production\IsMockable;
```

## Changelog

Siehe [CHANGELOG](CHANGELOG.md) für weitere Informationen.

## Beitragen

Wenn Sie eine Verbesserungsvorschlag haben, legen Sie einen Fork des Repositories an und erstellen Sie einen Pull Request. Alternativ können Sie einfach ein Issue erstellen. Fügen Sie das Projekt zu Ihren Favoriten hinzu. Vielen Dank.

- Erstellen Sie einen Fork des Projekts
- Erstellen Sie einen Feature Branch (git checkout -b feature/AmazingFeature)
- Fügen Sie Ihre Änderungen hinzu (git commit -m 'Add some AmazingFeature')
- Übertragen Sie den Branch (git push origin feature/AmazingFeature)
- Öffnen Sie einen Pull Request

## Lizenz
(Stand: 11.11.2022)

Vertrieben unter der MIT Lizenz.

```
Copyright (c) D3 Data Development (Inh. Thomas Dartsch)
```

Die vollständigen Copyright- und Lizenzinformationen entnehmen Sie bitte der [LICENSE](LICENSE.md)-Datei, die mit diesem Quellcode verteilt wurde.