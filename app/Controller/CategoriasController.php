<?php 

class CategoriasController extends AppController{
	
	public function beforeFilter(){
		parent::beforeFilter();
	}

	public function index() {
		$options = array(
			'fields' => array('id', 'parent_id', 'nome'),
			'order' => array('nome ASC')
		);
		$categorias = $this->Categoria->find('threaded', $options);
		$this->set(compact('categorias'));
	}

	public function add() {
		return $this->edit();
	}

	public function edit($id = null) {

		if ($this->request->isPost() || $this->request->isPut()) {

			if ($this->Categoria->save($this->request->data)) {
				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_warning');
				$this->redirect(array('action' => 'add'));
			} else {
				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_warning');
			}

		} else {

			if ($id != null) {
				$this->request->data = $this->Categoria->findById($id);
				if (empty($this->request->data)) {
					$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
					$this->redirect(array('action'=> 'index'));
				}
			}

		}

		$categoryList = $this->Categoria->generateTreeList(null, null, null, '---- ');
		$this->set(compact('categoryList'));

		$this->render('edit');

	}

	public function delete($id) {
		if($this->request->isDelete()) {
			if ($this->Categoria->delete($id)) {
				$this->Session->setFlash($this->mmCrud['deleted'], 'layout/flash/flash_success');
			} else {
				$this->Session->setFlash($this->mmCrud['not_deleted'], 'layout/flash/flash_success');
			}
			$this->redirect(array('action'=> 'index'));
		}

		$this->request->data = $this->Categoria->findById($id);
		if (empty($this->request->data)) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action'=> 'index'));
		}

		$deleteCategoryList = $this->Categoria->children($id);
		$this->set(compact('deleteCategoryList'));
	}

	public function movedown($id = null, $delta = null) {

		$this->Categoria->id = $id;
		if (!$this->Categoria->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}

		if ($delta > 0) {
			$this->Categoria->moveDown($this->Categoria->id, abs($delta));
		} else {
			$this->Session->setFlash('movedown-> delta invalido', 'layout/flash/flash_warning');
		}

		$this->redirect(array('action' => 'index'), null, true);

	}

	public function moveup($id = null, $delta = null) {

		$this->Categoria->id = $id;
		if (!$this->Categoria->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}

		if ($delta > 0) {
			$this->Categoria->moveUp($this->Categoria->id, abs($delta));
		} else {
			$this->Session->setFlash('movedown-> delta invalido', 'layout/flash/flash_warning');
		}

		$this->redirect(array('action' => 'index'), null, true);

	}

}

?>