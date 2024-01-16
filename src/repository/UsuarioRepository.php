<?php
namespace repository;
use lib\BaseDeDatos,
    PDO,
    PDOException;
class UsuarioRepository{
    public function __construct()
    {
        $this->db=new BaseDeDatos();
    }

    /**
     * Crear un nuevo usuario.
     * @param $usuario
     * @return bool Devuelve true si la operación es exitosa, o false en caso de excepción.
     */
    public function createUser($usuario){

        $id=null;
        $nombre=$usuario->getNombre();
        $apellidos=$usuario->getApellidos();
        $email=$usuario->getEmail();
        $password=$usuario->getPassword();
        $rol=$usuario->getRol();
        $this->db=new BaseDeDatos();
        try{
            $ins=$this->db->prepara("INSERT INTO usuarios (id,nombre,apellidos,email,password,rol) values (:id,:nombre,:apellidos,:email,:password,:rol)");
            $ins->bindValue(':id',$id);
            $ins->bindValue(':nombre',$nombre);
            $ins->bindValue(':apellidos',$apellidos);
            $ins->bindValue(':email',$email);
            $ins->bindValue(':password',$password);
            $ins->bindValue(':rol',$rol);
            $ins->execute();
            $result=true;
        }catch (PDOException $err){
            $result=false;
        } finally {
            $ins->closeCursor();
            $this->db->cierraConexion();
        }
        return $result;
    }

    /**
     * Comprueba si existe un usuario con el email y password indicados.
     * @param $email
     * @return bool|string Devuelve true si existe el usuario o false si no existe, o un string con el mensaje de error.
     */
    public function compruebaCorreo($email):bool|string{
        try{
            $sel=$this->db->prepara("SELECT email FROM usuarios WHERE email=:email");
            $sel->bindValue(':email',$email);
            $sel->execute();
            if ($sel->rowCount()>0) {
                return true;
            }else{
                return false;
            }
        }catch (PDOException $err){
            return $err->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();
        }
    }

    /**
     * Obtiene un usuario por su email.
     * @param $email string Email del usuario.
     * @return false|mixed|string Devuelve un array con los datos del usuario, o false si no existe, o un string con el
     * mensaje de error.
     */
    public function getUsuarioFromEmail($email){
        $this->db=new BaseDeDatos();
        try{
            $sel=$this->db->prepara("SELECT * FROM usuarios WHERE email=:email");
            $sel->bindValue(':email',$email);
            $sel->execute();
            if ($sel->rowCount()>0) {
                $usuario=$sel->fetch(PDO::FETCH_ASSOC);
                return $usuario;
            }else{
                return false;
            }
        }catch (PDOException $err){
            return $err->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();
        }
    }


    /**
     * Obtiene todos los usuarios de un rol.
     * @param $rol string Rol de los usuarios a obtener.
     * @return array|false|string
     */
    public function getUsuariosPorRol($rol){
        try{
            $sel=$this->db->prepara("SELECT * FROM usuarios WHERE rol=:rol");
            $sel->bindValue(':rol',$rol);
            $sel->execute();
            if ($sel->rowCount()>0) {
                $usuarios=$sel->fetchAll(PDO::FETCH_ASSOC);
                return $usuarios;
            }else{
                return "No se han encontrado usuarios con ese rol";
            }
        }catch (PDOException $err){
            return $err->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();
        }
    }

    /**
     * Obtiene todos los usuarios en orden ascendente por nombre.
     * @return array|false|string
     */
    public function getUsuarios(){
        try{
            $sel=$this->db->prepara("SELECT * FROM usuarios order by nombre asc");
            $sel->execute();
            if ($sel->rowCount()>0) {
                $usuarios=$sel->fetchAll(PDO::FETCH_ASSOC);
                return $usuarios;
            }else{
                return "No se han encontrado usuarios";
            }
        }catch (PDOException $err){
            return $err->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();
        }
    }

    /**
     * Obtiene un usuario por su ID.
     * @param $id int ID del usuario.
     * @return mixed|string
     */
    public function getUsuarioPorId($id):mixed{
        try{
            $sel=$this->db->prepara("SELECT * FROM usuarios WHERE id=:id");
            $sel->bindValue(':id',$id);
            $sel->execute();
            if ($sel->rowCount()>0) {
                $usuario=$sel->fetch(PDO::FETCH_ASSOC);
                return $usuario;
            }else{
                return "No se ha encontrado el usuario";
            }
        }catch (PDOException $err){
            return $err->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();
        }
    }

    /**
     * Actualiza el rol de un usuario.
     * @param $id int ID del usuario.
     * @param $rol string nuevo rol del usuario.
     * @return string|bool Devuelve true si la operación es exitosa, o un string con el mensaje de error.
     */
    public function updateRol($id, $rol):string|bool{
            $this->db=new BaseDeDatos();
            try{
                $upd = $this->db->prepara("UPDATE usuarios SET rol=:rol WHERE id=:id");
                $upd->bindValue(':id',(int)$id);
                $upd->bindValue(':rol',$rol);
                $upd->execute();
                if ($upd->rowCount()>0) {
                    return true;
                }else{
                    return "No se ha podido actualizar el rol";
                }
            }catch (PDOException $err){
                return $err->getMessage();
            } finally {
                $upd->closeCursor();
                $this->db->cierraConexion();
            }


    }

    /**
     * Cierra la conexión a la base de datos.
     * @return void
     */
    public function cierraConexion(){
        $this->db->cierraConexion();
    }
}
