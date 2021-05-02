<?php

header('Content-Type: text/html; charset=utf-8');
$method_type = $_SERVER['REQUEST_METHOD'];

if ($method_type == 'POST') {
  echo 'recebido um post' . PHP_EOL;
  print_r($_POST);
  if (isset($_POST['region'])) {
    echo "Region: {$_POST['region']}" . PHP_EOL;
    switch ($_POST['region']) {
      case 'rooms':
        if (isset($_POST['number']) && isset($_POST['sensor']) && isset($_POST['value']) && isset($_POST['time'])) {
          echo file_put_contents("data/{$_POST['region']}/{$_POST['number']}/{$_POST['sensor']}/value.txt", "$_POST[time]" . ';' . "$_POST[value]");
          echo file_put_contents("data/{$_POST['region']}/{$_POST['number']}/{$_POST['sensor']}/log.txt", "$_POST[time]" . ';' . "$_POST[value]" . PHP_EOL, FILE_APPEND);
        } else {
          echo 'ERRO: Dados em Falta!' . PHP_EOL;
        }
        break;
      case 'pool':
      case 'parking':
      case 'rooftop':
        if (isset($_POST['value']) && isset($_POST['time']) && isset($_POST['sensor'])) {
          echo file_put_contents("data/{$_POST['region']}/{$_POST['sensor']}/value.txt", "$_POST[time]" . ';' . "$_POST[value]");
          echo file_put_contents("data/{$_POST['region']}/{$_POST['sensor']}/log.txt", "$_POST[time]" . ';' . "$_POST[value]" . PHP_EOL, FILE_APPEND);
        } else {
          echo 'ERRO: Dados em Falta!' . PHP_EOL;
        }
        break;
      default:
        echo 'ERRO: A região indicada não existe!' . PHP_EOL;
        break;
    }
  } else {
    echo 'ERRO: Parâmetros inválidos' . PHP_EOL;
  }
} elseif ($method_type == 'GET') {
  echo 'recebido um get' . PHP_EOL;
  if (isset($_GET['nome'])) {
    echo file_get_contents("data/{$_GET['nome']}/temperature/value.txt");
  }
} else {
  echo 'ERRO: Método não permitido!';
}
