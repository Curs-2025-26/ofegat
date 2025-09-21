#!/usr/bin/env php
<?php
declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

function ok(bool $b, int $t, int $f = 0): int { return $b ? $t : $f; }
function fileHas(string $path, string $needle): bool {
  return file_exists($path) && str_contains(file_get_contents($path), $needle);
}
function existsAll(array $files): bool { foreach ($files as $f) if (!file_exists(__DIR__."/../$f")) return false; return true; }

$stage = 3;
foreach ($argv as $a) {
  if (str_starts_with($a, '--stage=')) { $stage = (int)substr($a, 8); }
}

$rubric = Yaml::parseFile(__DIR__."/../rubric/entrega{$stage}.yml");
$w = $rubric['weights'];

$score = 0; $max = array_sum($w);

// Comuns
exec('composer lint', $lintOut, $lintCode);
$lintOk = ($lintCode === 0);
exec('composer stan', $stanOut, $stanCode);
$stanOk = ($stanCode === 0);

if ($stage === 1) {
  $filesOk = existsAll($rubric['checks']['files_required']);
  $cssOk = fileHas(__DIR__.'/../'.$rubric['checks']['css_class_present'][0], '.correct')
        && fileHas(__DIR__.'/../'.$rubric['checks']['css_class_present'][0], '.incorrect');

  exec('composer test --testsuite Entrega1', $out, $tcode);
  $testsOk = ($tcode===0);

  $initVars = fileHas(__DIR__.'/../src/functions.php', 'inicialitzaProgres');
  $funcCheck = fileHas(__DIR__.'/../src/functions.php', 'comprovarIntent');

  $score += ok($initVars && $filesOk, $w['init_vars']);
  $score += ok($funcCheck && $testsOk, $w['func_check'], 1);
  $score += ok($testsOk, $w['check_usage'], 1);
  $score += ok($cssOk, $w['css']);
  $score += ok($lintOk, $w['clarity'], 0);

} elseif ($stage === 2) {
  exec('composer test --testsuite Entrega2', $out, $tcode);
  $sessions = fileHas(__DIR__.'/../public/index.php', 'session_start')
           || fileHas(__DIR__.'/../src/SessionAuth.php', 'session_start');
  $cookies  = fileHas(__DIR__.'/../public/login.php', 'setcookie');
  $auth     = fileHas(__DIR__.'/../src/SessionAuth.php', 'login')
           && fileHas(__DIR__.'/../public/logout.php', 'session_destroy');
  $ui       = fileHas(__DIR__.'/../assets/style.css', '.correct') && fileHas(__DIR__.'/../assets/style.css', '.incorrect');

  $score += ok($tcode===0, $w['gameplay'], 1);
  $score += ok($sessions, $w['sessions']);
  $score += ok($cookies,  $w['cookies']);
  $score += ok($auth,     $w['auth'], 1);
  $score += ok($ui,       $w['ui']);
  // extra: manual

} else {
  exec('composer dump-autoload');
  exec('composer test --testsuite Entrega3', $out, $tcode);

  $autoloadOk = class_exists('App\\Joc') && class_exists('App\\GestorPartida');
  $pooOk = fileHas(__DIR__.'/../app/Joc.php','class Joc')
        && fileHas(__DIR__.'/../app/Jugador.php','class Jugador');
  $fitxerOk = file_exists(__DIR__.'/../config/paraules.php');

  $score += ok($tcode===0, $w['gameplay_ok'], 1);
  $score += ok($pooOk,     $w['poo_ok'], 1);
  $score += ok($autoloadOk,$w['autoload']);
  $score += ok($fitxerOk,  $w['file_usage'], 1);
  // extras: manual
  $score += ok($lintOk && $stanOk, $w['code_org'], 0);
}

echo json_encode([
  'stage' => $stage,
  'score' => $score,
  'max'   => $max,
], JSON_PRETTY_PRINT) . PHP_EOL;
