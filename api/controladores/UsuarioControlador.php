<?php
// api/controllers/UsuarioController.php
require_once __DIR__ . '/../modelos/UsuarioModelo.php';

class UsuarioControlador
{


    // Login (no es parte del CRUD, pero es una función de usuario)
    public function login($datos)
    {
        if (!isset($datos->codigo_acceso)) {
            return ['error' => "El campo 'codigo_acceso' es requerido.", 'status' => 400];
        }

        $usuarioModel = new UsuarioModelo();
        $usuario = $usuarioModel->findByCodigo($datos->codigo_acceso);

        if ($usuario) {
            return ['data' => $usuario, 'status' => 200];
        } else {
            return ['error' => "Código de acceso inválido.", 'status' => 401];
        }
    }

    // POST /usuarios
    public function crearUsuario($datos, $admin_id)
    {
        if (!isset($datos->nombre_completo) || !isset($datos->rol)) {
            return ['error' => "Los campos 'nombre_completo' y 'rol' son requeridos.", 'status' => 400];
        }

        $usuarioModel = new UsuarioModelo();
        $codigo_nuevo = bin2hex(random_bytes(16));

        $nuevo_id = $usuarioModel->create($datos->nombre_completo, $datos->rol, $codigo_nuevo, $admin_id);

        if ($nuevo_id) {
            $respuesta = ['id' => $nuevo_id, 'nombre_completo' => $datos->nombre_completo, 'rol' => $datos->rol, 'codigo_acceso' => $codigo_nuevo];
            return ['data' => $respuesta, 'status' => 201];
        } else {
            return ['error' => "No se pudo crear el usuario.", 'status' => 500];
        }
    }

    // GET /usuarios
    public function listarUsuarios()
    {
        $usuarioModel = new UsuarioModelo();
        $usuarios = $usuarioModel->findAll();
        return ['data' => $usuarios, 'status' => 200];
    }

    // GET /usuarios/{id}
    public function obtenerUsuario($id)
    {
        if (!$id)
            return ['error' => 'Se requiere un ID de usuario.', 'status' => 400];

        $usuarioModel = new UsuarioModelo();
        $usuario = $usuarioModel->findById($id);

        if ($usuario) {
            return ['data' => $usuario, 'status' => 200];
        } else {
            return ['error' => 'Usuario no encontrado.', 'status' => 404];
        }
    }

    // PUT /usuarios/{id}
    public function actualizarUsuario($id, $datos)
    {
        if (!$id)
            return ['error' => 'Se requiere un ID de usuario.', 'status' => 400];
        if (!isset($datos->nombre_completo) || !isset($datos->rol)) {
            return ['error' => "Los campos 'nombre_completo' y 'rol' son requeridos.", 'status' => 400];
        }

        $usuarioModel = new UsuarioModelo();
        // Verificar primero si el usuario existe
        if (!$usuarioModel->findById($id)) {
            return ['error' => 'Usuario no encontrado.', 'status' => 404];
        }

        if ($usuarioModel->update($id, $datos->nombre_completo, $datos->rol)) {
            $usuario_actualizado = ['id' => $id, 'nombre_completo' => $datos->nombre_completo, 'rol' => $datos->rol];
            return ['data' => $usuario_actualizado, 'status' => 200];
        } else {
            return ['error' => 'No se pudo actualizar el usuario.', 'status' => 500];
        }
    }

    // DELETE /usuarios/{id}
    public function eliminarUsuario($id)
    {
        if (!$id)
            return ['error' => 'Se requiere un ID de usuario.', 'status' => 400];

        $usuarioModel = new UsuarioModelo();
        if (!$usuarioModel->findById($id)) {
            return ['error' => 'Usuario no encontrado.', 'status' => 404];
        }

        if ($usuarioModel->delete($id)) {
            return ['data' => ['mensaje' => 'Usuario eliminado correctamente.'], 'status' => 200];
        } else {
            return ['error' => 'No se pudo eliminar el usuario.', 'status' => 500];
        }
    }
}