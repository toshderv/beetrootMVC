<?
include_once ROOT . '/models/ModelNews.php';
include_once ROOT . '/controllers/Controller.php';

class NewsController extends Controller {
  private $newsModel;

  public function __construct() {
    parent::__construct();
    $this->newsModel = new ModelNews();
  }

  public function actionIndex($category = NULL) {
    try {
      $this->view->title = 'News Index Page';
      $this->view->news = $this->newsModel->getNewsList();
      // var_dump($this->view);

      $this->view->generate('template_view.phtml', 'news/index.phtml');
    } catch (Exception $e) {
      echo $e->getMessage();
    }

    return true;
  }
}