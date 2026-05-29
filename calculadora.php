<?php
header('Content-Type: application/json; charset=utf-8');

// --- Validaciones ---

function verificarPost() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        enviarError('Método no permitido. Usa POST.', 405);
    }
}

function obtenerDatos() {
    $json = file_get_contents('php://input');
    $datos = json_decode($json, true);
    if (!$datos || !isset($datos['num1'], $datos['num2'], $datos['oper'])) {
        enviarError('Faltan datos. Envía num1, num2 y oper.', 400);
    }
    return $datos;
}

function validarNumeros($a, $b) {
    if (!is_numeric($a) || !is_numeric($b)) {
        enviarError('Los valores deben ser numéricos.', 400);
    }
    return [floatval($a), floatval($b)];
}

function validarOperacion($oper, $permitidas) {
    if (!in_array($oper, $permitidas)) {
        enviarError('Operación no válida. Usa: suma, resta, multiplicacion, division.', 400);
    }
}

function enviarError($mensaje, $codigo) {
    http_response_code($codigo);
    echo json_encode(['ok' => false, 'status' => 'error', 'error' => $mensaje]);
    exit;
}

// --- Operaciones (cada una en su propia función) ---

function suma($a, $b) { return $a + $b; }
function resta($a, $b) { return $a - $b; }
function multiplicacion($a, $b) { return $a * $b; }
function division($a, $b) {
    if ($b == 0) {
        enviarError('No es posible dividir entre cero.', 400);
    }
    return $a / $b;
}

// --- Flujo principal ---

verificarPost();
$datos = obtenerDatos();

list($num1, $num2) = validarNumeros($datos['num1'], $datos['num2']);
$oper = $datos['oper'];

$operacionesPermitidas = ['suma', 'resta', 'multiplicacion', 'division'];
validarOperacion($oper, $operacionesPermitidas);

// Ejecutar la función correspondiente dinámicamente
$resultado = call_user_func($oper, $num1, $num2);

echo json_encode([
    'ok' => true,
    'status' => 'success',
    'resultado' => $resultado
]);