# L’Ofegat · PHP (E1–E3) · Repo d’aula

## ✅ Objectius
- Aprendre a estructurar projectes PHP progressivament (procedimental → sessions → POO).
- Treballar amb **Composer**, **PHPUnit** (tests), **PHP-CS-Fixer** (estil) i **PHPStan** (anàlisi estàtica).
- Fer **autoavaluació**: totes les proves (tests + rúbriques) estan disponibles a l’alumnat.

## 🧰 Requisits
- PHP 8.3+ i Composer
- Navegador web

**Instal·lació**
```bash
composer install
```

**Comandes útils**
```bash
# Executar totes les proves (tests)
composer test

# Anàlisi estàtica
composer stan

# Linting (estil) i auto-arreglar estil
composer lint
composer fix

# Nota automàtica per entrega
composer grade:e1
composer grade:e2
composer grade:e3

# Servidor local (opcional)
php -S localhost:8000 -t public
```

## 🗂️ Estructura (ja creada al repo)
```
ofegat/
├─ README.md
├─ composer.json
├─ phpunit.xml
├─ phpstan.neon
├─ .php-cs-fixer.php
├─ rubric/
│  ├─ entrega1.yml
│  ├─ entrega2.yml
│  └─ entrega3.yml
├─ bin/
│  └─ grade.php
├─ assets/
│  └─ style.css
├─ public/
│  ├─ index.php
│  ├─ login.php
│  ├─ logout.php
│  └─ reiniciar.php
├─ src/
│  ├─ functions.php
│  └─ SessionAuth.php
├─ app/
│  ├─ Joc.php
│  ├─ Jugador.php
│  └─ GestorPartida.php
├─ config/
│  └─ paraules.php
└─ tests/
   ├─ Entrega1/FunctionTest.php
   ├─ Entrega2/SessionTest.php
   └─ Entrega3/JocPooTest.php
```

> **IMPORTANT:** Els fitxers tenen comentaris `TODO` que indiquen què completar en cada entrega.

## 🗓️ Calendari i entregues

### 🟩 Entrega 1 — Joc bàsic (procedimental)
- Paraula predefinida
- Funcions en `src/functions.php`: `inicialitzaProgres`, `imprimirProgres`, `comprovarIntent`
- Formulari per provar lletra en `public/index.php`
- Mostrar progrés, encerts en verd i errors en roig (.correct / .incorrect)

**Executa**
```bash
composer test
composer grade:e1
```

### 🟨 Entrega 2 — Estat amb Sessions + Cookies + Autenticació
- Sessions: estat del joc (paraula, lletres, intents)
- Reiniciar partida i tancar sessió
- Cookies per “Recordar-me”
- Autenticació bàsica d’usuari

**Executa**
```bash
composer test
composer grade:e2
```

### 🟦 Entrega 3 — Versió POO + Composer (PSR-4)
- Classes `Joc`, `Jugador`, `GestorPartida` (en `app/`)
- Autoload PSR-4 (Composer)
- `config/paraules.php` i selecció aleatòria
- Templates en `templates/` (capçalera, joc, peu)

**Executa**
```bash
composer dump-autoload
composer test
composer grade:e3
```

## 🧪 Proves disponibles
- **E1**: `tests/Entrega1/FunctionTest.php`
- **E2**: `tests/Entrega2/SessionTest.php`
- **E3**: `tests/Entrega3/JocPooTest.php`

## 🧠 Consells
- Passa `composer fix` abans d’entregar.
- Llig els errors de tests: indiquen el punt exacte a corregir.

## 🤖 Ús d’IA (opcional)
- Pots usar IA com a ajuda, però indica-ho al final de l’entrega (apartat “Notes”) i entén el codi.

## ✅ Checklist
- [ ] `composer test` OK
- [ ] `composer stan` OK
- [ ] `composer lint` OK (i `composer fix` aplicat)
- [ ] `composer grade:eX` mostra la nota esperada
