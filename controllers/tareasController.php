<?php
/**
 * @author  Jeronimo Mendez <Jero_mdz@gmail.com>
 * @version  1.0 Primera versión estable
 * @package  framework
 * @copyright  2015
 */
class tareasController extends Appcontroller
{
	public function __construct(){
		parent::__construct();
	}
	/**
	 * index lista las tareas
	 * @return  void
	 */
	public function index() {
	
		$conditions = array(
			"conditions"=>" tareas.categoria_id=categorias.id",
			"order"=>"tareas.id asc"
		);
		$this->_view->titulo = 'Listado de tareas';
		$tareas = $this->db->find('tareas, categorias', 'all', $conditions);
		$this->_view->tareas = $tareas->fetchAll(PDO::FETCH_NUM);
		$this->_view->renderizar('index');
	}
	/**
	 * edit lista las tareas
	 * @param  string $id contiene id de la fila
	 * @return void
	 */
	 
	public function edit($id = null){
		if ($_POST) {
				
				if ($this->db->update('tareas', $_POST)) {
				$this->redirect(
						array(
								'controller'=>'tareas',
								'action'=>'index'
							)
					);
				}else{
					$this->redirect(
							array(
									'controller'=>'tareas',
									'action'=>'edit/'.$_POST['id']
								)
						);
					}	
				
	
		} else {
				$conditions = array(
						'conditions'=>'id='.$id
					);
				$this->_view->tarea = $this->db->find('tareas', 'first', $conditions);
				$this->_view->categorias = $this->db->find('categorias','all');
				//$categorias = $this->_view->categorias->fetchAll(PDO::FETCH_NUM);
				//$categorias = $this->_view->categorias->fetchAll(PDO::FETCH_ASSOC);
				$this->_view->titulo = "Editar tarea";
				$this->_view->renderizar('edit');
		}

	}
	/**
	 *funcion add sirve para agregar nuevas tareas
	 * 
	 * @return void
	 */
	public function add(){
		if ($_POST) {
			if ($this->db->save('tareas', $_POST)) {
				$this->redirect(
						array(
								'controller'=>'tareas',
								'action'=>'index'
							)
					);
			}else{
				$this->redirect(
						array(
								'controller'=>'tareas',
								'action'=>'index'
							)
					);
			}
			
		}else{
			$this->_view->categorias = $this->db->find('categorias','all');
			$this->_view->titulo = "Agregar tarea";
			$this->_view->renderizar('add');
		}
	}
	/**
	 * Funcion delete sirve para eliminar tareas
	 * @param  string $id contiene id de la fila
	 * @return void
	 */
	public function delete($id){
		$conditions = "id=".$id;
		if ($this->db->delete('tareas', $conditions)) {
			$this->redirect(array('controller'=>'tareas'));
		}

	}




}