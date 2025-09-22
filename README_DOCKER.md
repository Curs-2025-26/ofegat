# Quickstart amb Docker
## 1) Com començar
```bash
# 1) Clona el teu repo de Classroom
git clone <EL_TEU_REPO.git>
cd <EL_TEU_REPO>

# 2) (Opcional) Arrancar Docker
docker compose up -d --build

# 3) Instal·lar dependències (dins del directori php/)
cd php
composer install
```

> Si uses Docker:
```bash
docker compose exec php composer install
```

## 2) On edite el codi?
- Tot el projecte està dins de **`php/`**.  
- Per a cada entrega:  
  - **Entrega 1:** `php/src/functions.php`, `php/public/index.php`, `php/assets/style.css`  
  - **Entrega 2:** afegeix `php/src/SessionAuth.php`, `php/public/login.php`, `php/public/logout.php`, `php/public/reiniciar.php`  
  - **Entrega 3:** treballa a `php/app/` (classes `Joc.php`, `Jugador.php`, `GestorPartida.php`), `php/config/paraules.php` i `php/templates/`

## 3) Com provar abans d’enviar
```bash
# Des de php/
composer test                      # executa tests de totes les entregues
composer test -- --testsuite Entrega1   # només E1
composer test -- --testsuite Entrega2   # només E2
composer test -- --testsuite Entrega3   # només E3

composer stan        # anàlisi estàtica (qualitat)
composer lint        # comprova estil de codi
composer fix         # arregla estil automàticament

# Nota automàtica de l’entrega
composer grade:e1    # entrega 1
composer grade:e2    # entrega 2
composer grade:e3    # entrega 3
```
> Amb Docker:
```bash
docker compose exec php composer test
docker compose exec php composer grade:e1
```

## 4) Enviar canvis (push)
```bash
# (des de l’arrel del repo, no dins de php/)
git add .
git commit -m "E1: funcions bàsiques implementades"
git push
```
- Cada **push** llança l’**Autograding** (GitHub Actions).  
- Pots veure el resultat a la pestanya **Actions** del teu repo o a **Classroom → Autograding**.

## 5) On veure el feedback del profe
- Hi ha una branca **`feedback`** i un **pull request automàtic** cap a `master`.  
- Entra al teu repo → **Pull requests** → **Feedback PR**: allí trobaràs comentaris i indicacions.

## 6) Flux recomanat de treball
1. Implementa els **TODO** de l’entrega actual.  
2. Executa localment:
   - `composer test`  
   - `composer stan`  
   - `composer lint` / `composer fix`  
   - `composer grade:eX`  
3. Fes **commit + push** → revisa l’**Autograding**.  
4. Llig el **Feedback PR** i millora si cal.  
5. Repiteix fins que estiga OK.

## 7) Bones pràctiques
- Commits **curts i clars**: “E1: comprovarIntent i index.php”.  
- Passa `composer fix` abans de fer push.  
- No toques **fitxers protegits** (tests, `.github`, `rubric/`, `bin/grade.php`).

## 8) Errors típics i solucions
- **No veig la carpeta `.github`** → és oculta; activa “mostrar fitxers ocults” o usa `ls -la`.  
- **Fallen els tests** → llig l’error: diu exactament quina funció/comportament falta.  
- **Autograding no arranca** → comprova que has fet push a **`master`** (o `main`).  
- **Docker no obri la web** → entra a `http://localhost/` i comprova `docker compose ps`.  
- **`composer` no es troba** → instal·la Composer o executa les ordres dins del contenidor: `docker compose exec php ...`.
