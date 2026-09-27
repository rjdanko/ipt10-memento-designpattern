# Memento pattern in PHP 8.1+: a farming game save system

In fulfillment of the course IPT10 Midterm Lecture research requirement

The farm (Originator) creates its own save when the player goes to bed. The save file (Memento) is immutable. The save slot (Caretaker) stores saves and draws the load menu but can only see the day number and save time.

| Role | Class |
|---|---|
| Originator | `src/Farm.php` |
| Memento | `src/FarmSave.php` (narrow interface: `src/SaveFile.php`) |
| Caretaker | `src/SaveSlot.php` |
| Client | `farmgame.php` |

## Requirements

PHP 8.1 or newer. No external libraries.

## Run

```bash
php farmgame.php
```

Composer is optional. To use its autoloader instead of the built-in fallback:

```bash
composer install
php farmgame.php
```

Expected output (the save time will differ):

```
After sleeping:  Day 2 | 1025g | energy 270 | empty bag
Mid-day:         Day 2 | 1725g | energy 190 | parsnip x20
Load menu:       Day 2 (saved 06:01)
After reloading: Day 2 | 1025g | energy 270 | empty bag
```

## Syntax check

```bash
for f in farmgame.php src/*.php; do php -l "$f"; done
```

## Diagrams

PlantUML sources are in `docs/`. Render them at plantuml.com or in draw.io and export as PNG. Diagrams are the author's own work, licensed CC BY-SA 4.0.
