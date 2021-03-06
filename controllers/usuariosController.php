<?php

class usuariosController extends  APPController
{
	private $pass;
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->_view->usuarios = $this->db->find('usuarios', 'all');
		$this->_view->renderizar('index');

	}
/**
* Nos permite agregar nuevas tareas
* @author  Dalia Nahomi Santos Xiu 
* @version  1
* */
  public function add(){
		if ($_POST){
			$pass = new Password();

			$_POST['password'] = $pass->getPassword($_POST['password']);

			if ($this->db->save("usuarios", $_POST)) {
				$this->redirect(array('controller'=>'usuarios', 'action'=>'index'));
			}else{
				$this->redirect(array('controller'=>'usuarios', 'action'=>'add'));
			}
		}else{
			$this->_view->titulo = "Agregar usuario";
			$this->_view->renderizar('add');
		}

	}

	/**
	 * Nos permite Editar Tareas previamente capturados
	 * @param  $Id ayuda a identificar y realizar cambios a un valor en específicos.
	 * @return nos devuelve el valor seleccionado
	 * @author  Dalia Nahomi Santos Xiu
	 * @version  1
	 */ 
public function edit($id = null){
		if ($_POST){
			if (!empty($_POST['pass'])) {
				$pass = new Password();
				$_POST['password'] = $pass->getPassword($_POST['pass']);;
			}
			if ($this->db->update("usuarios", $_POST)) {
				$this->redirect(array('controller'=>'usuarios', 'action'=>'index'));
			}else{
				$this->redirect(array('controller'=>'usuarios', 'action'=>'edit'));
			}
		}else{
			$this->_view->titulo = "Editar usuario";
			$this->_view->usuario = $this->db->find('usuarios', 'first', array('conditions'=>'id='.$id));
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
		if ($this->db->delete('usuarios', $conditions)) {
			$this->redirect(
					array(
						'controller'=>'usuarios',
						'action'=>'index'
					)	
			);
		}
	}

/**
	 * Permite que el usuario pueda ingresar
	 * @param  $pass
	 * @param  $filter
	 * @param  $aut
	 * @author  Dalia Nahomi Santos Xiu
	 * @version  1
	 */ 
	public function login(){

		if ($_POST) 
		{

			$pass = new Password();
			$filter = new Validations();
			$aut = new Authorization();

			$username = $filter->sanitizeText($_POST['username']);
			$password = $filter->sanitizeText($_POST['password']);

			$options['conditions'] = "username = '$username'";
			$usuario = $this->db->find('usuarios','first', $options);

			if ($pass->isValid($password, $usuario['password'])) {
				 $aut->login($usuario);
				 $this->redirect(array('controller'=>'tareas'));
			}else{
				echo "Usuario Invalido";
			}
		}
		$this->_view->renderizar('login');
	}

/**
	 * Permite que el usuario cierre sesion
	 * @param  $aut
	 * @author  Dalia Nahomi Santos Xiu
	 * @version  1
	 */ 

	public function logout(){
		$aut = new Authorization();
		$aut->logout();

	}

}