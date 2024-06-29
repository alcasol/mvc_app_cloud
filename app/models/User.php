<?php
// ----------------------------------------------------------------------------
// app/models/User.php
// ----------------------------------------------------------------------------
// Lógica de negocio relacionada con los usuarios. Actúa como el modelo para la
// entidad "usuario"
// ----------------------------------------------------------------------------

namespace App\Models;

use Core\Model;
use Utils\Log;
use Exception;

class User extends Model {

    /**
     * Obtiene un usuario de la base de datos por su ID.
     *
     * @param int $id ID del usuario
     * @return array|false Retorna los datos del usuario como un array asociativo
     *                      o false si no se encontró ningún usuario.
     */
    public function getUserById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM user_details WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            Log::error('Error fetching user by ID: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene un usuario de la base de datos por su nombre de usuario.
     *
     * @param string $username Nombre de usuario
     * @return array|false Retorna los datos del usuario como un array asociativo
     *                      o false si no se encontró ningún usuario.
     */
    public function getUserByUsername($username) {
        try {
            $stmt = $this->db->prepare("
                SELECT u.*, c.username, c.password
                FROM user_details u
                JOIN user_credentials c ON u.id = c.user_id
                WHERE c.username = :username
            ");
            $stmt->execute(['username' => $username]);
            return $stmt->fetch();
        } catch (Exception $e) {
            Log::error('Error fetching user by username: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Crea un nuevo usuario en la base de datos.
     *
     * @param string $name Nombre del usuario
     * @param string $phone Teléfono del usuario
     * @param string $email Correo electrónico del usuario
     * @param string $username Nombre de usuario para login
     * @param string $password Contraseña del usuario
     * @return bool Retorna true si el usuario se creó exitosamente, false si hubo algún error.
     */
    public function createUser($name, $phone, $email, $username, $password) {
        try {
            $this->db->beginTransaction();
    
            $stmt = $this->db->prepare("
                INSERT INTO user_details (name, phone, email)
                VALUES (:name, :phone, :email)
            ");
            $stmt->execute(['name' => $name, 'phone' => $phone, 'email' => $email]);
            $userId = $this->db->lastInsertId();
    
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash seguro
    
            $stmt = $this->db->prepare("
                INSERT INTO user_credentials (user_id, username, password)
                VALUES (:user_id, :username, :password)
            ");
            $stmt->execute(['user_id' => $userId, 'username' => $username, 'password' => $hashedPassword]);
    
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            Log::error('Error creating user: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verifica las credenciales del usuario para iniciar sesión.
     *
     * @param string $username Nombre de usuario
     * @param string $password Contraseña del usuario
     * @return array|false Retorna los datos del usuario como un array asociativo
     *                      si las credenciales son válidas, o false si no son válidas.
     */
    public function login($username, $password) {
        try {
            $stmt = $this->db->prepare("
                SELECT u.*, c.username, c.password
                FROM user_details u
                JOIN user_credentials c ON u.id = c.user_id
                WHERE c.username = :username
            ");
            $stmt->execute(['username' => $username]);
            $userData = $stmt->fetch();
    
            if ($userData && password_verify($password, $userData['password'])) {
                return $userData; // Retorna los datos del usuario si las credenciales son válidas
            } else {
                return false; // Retorna false si las credenciales no son válidas
            }
        } catch (Exception $e) {
            Log::error('Error logging in user: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un usuario de la base de datos.
     *
     * @param string $username Nombre de usuario
     * @param string $password Contraseña del usuario para verificar la eliminación
     * @return bool Retorna true si el usuario se eliminó exitosamente, false si hubo algún error o las credenciales no son válidas.
     */
    public function delete($username, $password) {
        try {
            $this->db->beginTransaction();

            // Obtener el ID del usuario basado en el nombre de usuario y verificar las credenciales
            $stmt = $this->db->prepare("
                SELECT u.id, c.password
                FROM user_details u
                JOIN user_credentials c ON u.id = c.user_id
                WHERE c.username = :username
            ");
            $stmt->execute(['username' => $username]);
            $userData = $stmt->fetch();

            if ($userData && password_verify($password, $userData['password'])) {
                $userId = $userData['id'];

                // Eliminar de la tabla user_credentials
                $stmt = $this->db->prepare("DELETE FROM user_credentials WHERE user_id = :user_id");
                $stmt->execute(['user_id' => $userId]);

                // Eliminar de la tabla user_details
                $stmt = $this->db->prepare("DELETE FROM user_details WHERE id = :id");
                $stmt->execute(['id' => $userId]);

                // Confirmar la transacción
                $this->db->commit();
                return true;
            } else {
                // Si las credenciales no son válidas, revertir la transacción
                $this->db->rollBack();
                Log::error('Error deleting user: invalid credentials');
                return false;
            }
        } catch (Exception $e) {
            // En caso de error, revertir la transacción
            $this->db->rollBack();
            Log::error('Error deleting user: ' . $e->getMessage());
            return false;
        }
    }

}
?>
