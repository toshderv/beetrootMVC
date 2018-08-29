<?
class View {
  private $content;

  public function __set($name, $value) {
    $this->$name = $value;
  }

  function generate($templateView, $mainView) {
    if (!$mainView) {
      echo 'Установите вид!'; die;
    }

    $this->content = $this->getRenderedHtml('views/' . $mainView);

    if (!$templateView) {
      echo 'Установите шаблон!'; die;
    }

    include 'views/layouts/' . $templateView;
  }

  public function getRenderedHtml($path) {
    ob_start();
    include($path);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
  }
}