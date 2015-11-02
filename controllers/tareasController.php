<?php 

class tareasController extends AppController
{
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		//echo "Hola desde el metodo Index";
		$this->_view->titulo = "Pagina principal";
		$this->_view->tareas =$this->db->find('tareas', 'all', null);
		$this->_view->renderizar('index');
	}
/**
* Nos permite agregar nuevas tareas
* @author  Dalia Nahomi Santos Xiu 
* @version  1
* */
	public function add(){
		if ($_POST) {

			if ($this->db->save('tareas', $_POST)) {
				 $this->redirect(array('controller'=>'tareas'));
			}else{
				$this->redirect(
					array(
						'controller'=>'tareas',
						'action'=>'add'));
			}
		}else{
			$this->_view->titulo = "Agregar Tarea";
		}
 	$this->_view->renderizar('add');

}

	/**
	 * Nos permite Editar Tareas previamente capturados
	 * @param  $Id ayuda a identificar y realizar cambios a un valor en específicos.
	 * @return nos devuelve el valor seleccionado
	 * @author  Dalia Nahomi Santos Xiu
	 * @version  1
	 */ 
	public function edit($id = null){
		if ($_POST) {
			if ($this->db->update('tareas',$_POST)) {
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
		}else{
			$this->_view->titulo= "Editar Tarea";
			$this->_view->tarea = $this->db->find('tareas','first',
				array
				('conditions'=>'id='.$id
					)
				);
			$this->_view->renderizar('edit');
		}
	}

	/**
	 * Nos Eliminar el valor seleccionado.
	 * @param  $Id ayuda a identificar y realizar cambios a un valor en específicos.
	 * @author  Dalia Nahomi Santos Xiu
	 * @version  1
	 */ 
	public function delete($id = null){
		$conditions = 'id='.$id;

		if ($this->db->delete('tareas',$conditions)) {
			$this->redirect(
				array(
					'controller'=>'tareas',
					'action'=>'index'
					)
				);
		}

	}
}