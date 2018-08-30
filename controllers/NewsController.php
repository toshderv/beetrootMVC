<?
include_once ROOT . '/controllers/Controller.php';

class NewsController extends Controller {
  // private $newsModel;

  public function __construct() {
    parent::__construct();
    // $this->newsModel = new Model_News();
  }

  public function actionIndex($category = NULL) {
    try {
      //$result = $this->newsModel->getNewsList();

      $this->view->title = 'News Index Page';

      $this->view->generate('template_view.php', 'news/index.php');
    } catch (Exception $e) {
      echo $e->getMessage();
    }

    return true;
  }
}