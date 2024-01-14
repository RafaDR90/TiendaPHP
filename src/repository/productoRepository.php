<?php
namespace repository;
use lib\BaseDeDatos,
    PDO,
    PDOException;
class productoRepository{
    private $db;
    public function __construct()
    {
        $this->db=new BaseDeDatos();
    }

    /**
     * Obtiene un producto por ID de categoria.
     * @param int $id
     * @return array|false|string
     */
    public function productosPorCategoria($id){
        try{
            $sel=$this->db->prepara("SELECT * FROM productos WHERE categoria_id=:id");
            $sel->bindParam(':id',$id,PDO::PARAM_INT);
            $sel->execute();
            $resultado=$sel->fetchAll(PDO::FETCH_ASSOC);

        }catch (\PDOException $e){
            $resultado=$e->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();
            return $resultado;
        }
    }

    /**
     * Obtiene un producto por ID de categoria que no esté eliminado.
     * @param $id int ID de la categoria.
     * @return array|false|string
     */
    public function productosPorCategoriaNotDeleted($id){
        try{
            $sel=$this->db->prepara("SELECT * FROM productos WHERE categoria_id=:id AND deleted=false");
            $sel->bindParam(':id',$id,PDO::PARAM_INT);
            $sel->execute();
            $resultado=$sel->fetchAll(PDO::FETCH_ASSOC);

        }catch (\PDOException $e){
            $resultado=$e->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();
            return $resultado;
        }
    }

    /**
     * Añade un producto a la base de datos.
     * @param $producto
     * @return string|null
     */
    public function addProducto($producto){
        $error=null;
        try{
            $insert=$this->db->prepara("INSERT INTO productos VALUES (null,:categoria_id,:nombre,:descripcion,:precio,:stock,:oferta,:fecha,:imagen,:deleted)");
            $insert->bindValue(':categoria_id',$producto->getCategoriaId());
            $insert->bindValue(':nombre',$producto->getNombre());
            $insert->bindValue(':descripcion',$producto->getDescripcion());
            $insert->bindValue(':precio',$producto->getPrecio());
            $insert->bindValue(':stock',$producto->getStock());
            $insert->bindValue(':oferta',$producto->getOferta());
            $insert->bindValue(':fecha',$producto->getFecha());
            $insert->bindValue(':imagen',$producto->getImagen());
            $insert->bindValue(':deleted',false);
            $insert->execute();
        }catch (PDOException $e){
            $error=$e->getMessage();
        } finally {
            $insert->closeCursor();
            $this->db->cierraConexion();
            return $error;
        }
    }

    /**
     * Marca un producto como eliminado.
     * @param $id int ID del producto a eliminar.
     * @return bool Devuelve true si la operación es exitosa, o false en caso contrario.
     */
    public function eliminarProducto($id){
        try{
            $update=$this->db->prepara("UPDATE productos SET deleted=true WHERE id=:id");
            $update->bindValue(':id',$id);
            $update->execute();
            $exito=true;
        }catch (PDOException){
            $exito=false;
        } finally {
            $update->closeCursor();
            $this->db->cierraConexion();
            return $exito;
        }
    }

    /**
     * Obtiene el nombre de la imagen de un producto.
     * @param $id int ID del producto.
     * @return mixed|string
     */
    public function obtenerNombreImagen($id):mixed{
        try{
            $sel=$this->db->prepara("SELECT imagen FROM productos WHERE id=:id");
            $sel->bindValue(':id',$id);
            $sel->execute();
            $resultado=$sel->fetch(PDO::FETCH_ASSOC);
        }catch (\PDOException $e){
            $resultado=$e->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();
            return $resultado;
        }
    }

    /**
     * Obtiene un producto por su ID
     * @param $id int ID del producto.
     * @return mixed|string Devuelve un array con los datos del producto o un string con el error.
     */
    public function getProductoByIdProducto($id):mixed{
        try{
            $sel=$this->db->prepara("SELECT * FROM productos WHERE id=:id");
            $sel->bindValue(':id',$id);
            $sel->execute();
            $resultado=$sel->fetch(PDO::FETCH_ASSOC);
        }catch (\PDOException $e){
            $resultado=$e->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();
            return $resultado;
        }
    }

    /**
     * Edita un producto de la base de datos.
     * @param $id int ID del producto a editar.
     * @param $producto array Datos del producto.
     * @return string|null Devuelve null si la operación es exitosa, o un mensaje de error en caso de excepción.
     */
    public function editarProducto($id, $producto):?string{
        $error=null;
        try{
            $this->db=new BaseDeDatos();
            $update=$this->db->prepara("UPDATE productos SET nombre=:nombre,descripcion=:descripcion,precio=:precio,stock=:stock,oferta=:oferta,imagen=:imagen, categoria_id=:categoria_id WHERE id=:id");
            $update->bindValue(':id',$id);
            $update->bindValue(':nombre',$producto['nombre']);
            $update->bindValue(':descripcion',$producto['descripcion']);
            $update->bindValue(':precio',$producto['precio']);
            $update->bindValue(':stock',$producto['stock']);
            $update->bindValue(':oferta',$producto['oferta']);
            $update->bindValue(':imagen',$producto['imagen']);
            $update->bindValue(':categoria_id',$producto['categoria']);
            $update->execute();
        }catch (PDOException $e){
            $error=$e->getMessage();
        } finally {
            $update->closeCursor();
            $this->db->cierraConexion();
            return $error;
        }
    }

    /**
     * Edita la imagen de un producto.
     * @param $id int ID del producto a editar.
     * @param $imagen string Nombre de la imagen.
     * @return string|null Devuelve null si la operación es exitosa, o un mensaje de error en caso de excepción.
     */
    public function editarImagenProducto($id, $imagen):?string{
        $error=null;
        try{
            $this->db=new BaseDeDatos();
            $update=$this->db->prepara("UPDATE productos SET imagen=:imagen WHERE id=:id");
            $update->bindValue(':id',$id);
            $update->bindValue(':imagen',$imagen);
            $update->execute();
        }catch (PDOException $e){
            $error=$e->getMessage();
        } finally {
            $update->closeCursor();
            $this->db->cierraConexion();
            return $error;
        }
    }

    /**
     * Resta unidades al stock de un producto.
     * @param $id int ID del producto.
     * @param $unidades int Unidades a restar.
     * @return string|null Devuelve null si la operación es exitosa, o un mensaje de error en caso de excepción.
     */
    public function restarStock($id, $unidades):?string{
        $error=null;
        try{
            $this->db=new BaseDeDatos();
            $update=$this->db->prepara("UPDATE productos SET stock=stock-:unidades WHERE id=:id");
            $update->bindValue(':id',$id);
            $update->bindValue(':unidades',$unidades);
            $update->execute();
        }catch (PDOException $e){
            $error=$e->getMessage();
        } finally {
            $update->closeCursor();
            $this->db->cierraConexion();
            return $error;
        }
    }

    /**
     * Obtiene los productos que no tienen categoria asignada.
     * @return array|string Devuelve un array con los productos o un string con el error.
     */
    public function productosDescatalogados():array|string{
        try{
            $sel=$this->db->prepara("SELECT * FROM productos WHERE categoria_id IS NULL");
            $sel->execute();
            $resultado=$sel->fetchAll(PDO::FETCH_ASSOC);
        }catch (\PDOException $e){
            $resultado=$e->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();
            return $resultado;
        }
    }

    /**
     * Obtiene los productos que han sido eliminados.
     * @return array|string Devuelve un array con los productos o un string con el error.
     */
    public function productosEliminados():array|string{
        try{
            $sel=$this->db->prepara("SELECT * FROM productos WHERE deleted=true");
            $sel->execute();
            $resultado=$sel->fetchAll(PDO::FETCH_ASSOC);
        }catch (\PDOException $e){
            $resultado=$e->getMessage();
        } finally {
            $sel->closeCursor();
            $this->db->cierraConexion();
            return $resultado;
        }
    }

    /**
     * Restablece un producto eliminado.
     * @param $id int ID del producto.
     * @return string|null Devuelve null si la operación es exitosa, o un mensaje de error en caso de excepción.
     */
    public function reestablecerProducto($id):?string{
        $error=null;
        try{
            $update=$this->db->prepara("UPDATE productos SET deleted=false WHERE id=:id");
            $update->bindValue(':id',$id);
            $update->execute();
        }catch (PDOException $e){
            $error=$e->getMessage();
        } finally {
            $update->closeCursor();
            $this->db->cierraConexion();
            return $error;
        }
    }

}