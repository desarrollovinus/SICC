<?php
require 'lib/Pusher.php';

$mensaje = $_POST['msj'];

$pusher = PusherInstance::get_pusher();

$pusher->trigger(
    'canal_prueba',
    'nuevo_comentario',
    array('mensaje' => $mensaje),
    $_POST['socket_id']
);

echo json_encode(array('mensaje' => $mensaje));
