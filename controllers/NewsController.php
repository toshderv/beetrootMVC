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
      $limitTopNews = 1;

      $this->view->allCategories = $this->newsModel->getCategoriesList();
      $this->view->news = $this->newsModel->getNewsList($category);
      $this->view->lastNews = $this->newsModel->getLastNews();
      $this->view->topNews = $this->newsModel->getTopNews($limitTopNews);
      // var_dump($this->view);die;

      $this->view->generate('template_view.phtml', 'news/index.phtml');
    } catch (Exception $e) {
      echo $e->getMessage();
    }

    return true;
  }

  public function actionDetail($id) {
    try {
      $limitTopNews = 1;

      $this->view->allCategories = $this->newsModel->getCategoriesList();
      $this->view->newsDetail = $this->newsModel->getNewsDetail($id);
      $this->view->lastNews = $this->newsModel->getLastNews();
      $this->view->topNews = $this->newsModel->getTopNews($limitTopNews);

      // Set views
      $this->newsModel->setViewCount($id);
      // Get Comments
      $this->view->comments = $this->newsModel->getComments($id);
      // Set Comments
      if (isset($_POST['submitComment'])) {
        // var_dump($_POST);die;
        $this->newsModel->setComment($id, $_POST);
      }

      // var_dump($this->view);die;

      $this->view->generate('template_view.phtml', 'news/detail.phtml');
    } catch (Exception $e) {
      echo $e->getMessage();
    }

    return true;
  }
}