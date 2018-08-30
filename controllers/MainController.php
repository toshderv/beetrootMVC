<?
include_once ROOT . '/controllers/Controller.php';

class MainController extends Controller {

  public function __construct() {
    parent::__construct();
  }

  public function actionIndex($category = NULL) {
    try {
      $main = $this->view;
      $main->title = 'Main Page';
      $main->linkToNewsPages = '/news/';
      $main->textToNewsPages = 'News page';


      $this->view->generate('template_view.php', 'main/index.php');
    } catch (Exception $e) {
      echo $e->getMessage();
    }

    return true;
  }
}