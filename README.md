# Uruchomienie aplikacji

## Backend

Backend znajduje się w folderze `/api`.

### Baza danych

Należy wykonać operacje z plików: `api/db/car-manager.sql` oraz `api/db/const-db-data.sql`.

### Konfiguracja backendu

W pliku `.env` należy wskazać:

- CORS
- nazwę bazy danych
- login do bazy danych
- hasło do bazy danych

### Uruchomienie backendu

```sh
cd api
composer install
symfony server:start
```

## Frontend

Frontend znajduje się w folderze `/client`.

Należy utworzyć plik `.env` z zmiennymi środowiskowymi jak poniżej.

```
VUE_APP_API_URL=
VUE_APP_GOOGLE_API_KEY=
```

Zmienna `VUE_APP_API_URL` zawiera adres URL do backendu aplikacji.
Z kolei zmienna `VUE_APP_GOOGLE_API_KEY` zawiera klucz API dla map Google.

Następnie należy w pliku `vue.config.js` wskazać endpointy na których będzie dostępna aplikacja, odpowiednio dla kompilacji produkcyjnej i deweloperskiej:

```js
module.exports = {
    publicPath: process.env.NODE_ENV === 'production'
        ? '/~s197446/car-manager/' // wersja produkcyjna
        : '/'                      // wersja deweloperska
}
```

Serwer deweloperski można uruchomić poleceniem:

```sh
npm run serve
```

Z kolei wersję produkcyjną aplikacji należy zbudować poleceniem:

```sh
npm run build
```

Aplikacja budowana jest do folderu `dist`, którego zawartość należy umieścić na serwerze.
