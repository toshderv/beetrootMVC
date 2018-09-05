<?
include_once ROOT . '/models/ModelNews.php';
include_once ROOT . '/controllers/Controller.php';

class MainController extends Controller {
  private $newsModel;

  public function __construct() {
    parent::__construct();
    $this->newsModel = new ModelNews();
  }

  public function actionIndex() {
    try {
      $this->view->lastNews = $this->newsModel->getLastNews();
      $this->view->topNews = $this->newsModel->getTopNews();
      $this->view->lastComments = $this->newsModel->getLastComments();
      // var_dump($this->view->topNews);die;

      $this->view->generate('template_view.phtml', 'main/index.phtml');
    } catch (Exception $e) {
      echo $e->getMessage();
    }

    return true;
  }
}