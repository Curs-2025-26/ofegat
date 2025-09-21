<?php
// ENTREGA 2 — Helpers d'autenticació i estat

class SessionAuth {
    public static function start(): void {
        // TODO: session_start() si no iniciada
    }

    public static function login(string $usuari, bool $recorda): void {
        // TODO: guardar usuari en sessió i, si $recorda, setcookie(...)
    }

    public static function logout(): void {
        // TODO: session_destroy() i esborrar cookies relacionades
    }

    public static function ensureAuthenticated(): void {
        // TODO: si no hi ha usuari en sessió, redirigir a login.php
    }
}
