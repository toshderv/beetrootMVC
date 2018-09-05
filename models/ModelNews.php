<?
class ModelNews extends Db {
  const TOP_NEWS = 1;

  public function __construct() {
    parent::__construct();
  }

  public function getCategoriesList() {
    $categoriesList = $this->connection->query(
      "SELECT *
        FROM category"
    );

    return $categoriesList->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getNewsList($category = NULL) {
    if (is_null($category)) {
      $result = $this->connection->query(
        "SELECT *
          FROM news
          LEFT JOIN category ON news.news_cat_id = category.cat_id
          ORDER BY news_date DESC"
      );
    } else {
      $result = $this->connection->prepare(
        "SELECT *
          FROM news
          LEFT JOIN category ON news.news_cat_id = category.cat_id
          WHERE cat_code = :category
          ORDER BY news_date DESC"
      );
      $result->bindParam(':category', $category, PDO::PARAM_STR);
      $result->execute();
    }

    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getLastNews($count = 3) {
    $sth = $this->connection->prepare('SELECT *
      FROM `news`
      LEFT JOIN category
      ON news.news_cat_id = category.cat_id
      ORDER BY news_date DESC
      LIMIT :count');
    $sth->bindParam(':count', $count, PDO::PARAM_INT);
    $sth->execute();

    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getTopNews($count = 10) {

    $sth = $this->connection->prepare('
      SELECT *
      FROM news
      LEFT JOIN category ON news.news_cat_id = category.cat_id
      WHERE `news_day` = :newsTop
      ORDER BY news_date DESC
      LIMIT :count
    ');
    $sth->bindValue(':newsTop', self::TOP_NEWS, PDO::PARAM_INT);
    $sth->bindValue(':count', $count, PDO::PARAM_INT);
    $sth->execute();

    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getNewsDetail($id = NULL) {
    if (is_null($id)) {
      $result = $this->connection->query(
        "SELECT *
          FROM news
          LEFT JOIN category ON news.news_cat_id = category.cat_id
          ORDER BY news_date DESC
          LIMIT 1"
      );
    } else {
      $result = $this->connection->prepare(
        "SELECT *
          FROM news
          LEFT JOIN category ON news.news_cat_id = category.cat_id
          WHERE news_id = :id"
      );
      $result->bindParam(':id', $id, PDO::PARAM_INT);
      $result->execute();
    }

    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getComments($id) {
    $comments = $this->connection->prepare(
      "SELECT *
          FROM Comments
          WHERE CommentNewsID = :id"
    );
    $comments->bindParam(':id', $id, PDO::PARAM_INT);
    $comments->execute();

    return $comments->fetchAll(PDO::FETCH_ASSOC);
  }

  public function setViewCount($id) {
    $increment = 1;

    $view = $this->connection->prepare(
      "UPDATE news
        SET news_views = news_views + :increment
        WHERE news_id = :id;"
    );
    $view->bindParam(':increment', $increment, PDO::PARAM_INT);
    $view->bindParam(':id', $id, PDO::PARAM_INT);
    $view->execute();
  }

  public function setComment($id, array $post = []) {
    $name = $post['name'];
    $name = trim($name);
    $name = substr($name, 0, 20);
    $name = preg_replace("/[a-z0-9]/i", "", $name);
    $name = htmlspecialchars($name);
    $name = stripslashes($name);

    $body = $post['comment'];
    $body = trim($body);
    $body = substr($body, 0, 200);
    $body = preg_replace("/[a-z0-9]/i", "", $body);
    $body = htmlspecialchars($body);
    $body = stripslashes($body);

    $view = $this->connection->prepare(
      "INSERT INTO Comments (CommentNewsID, CommentName, CommentBody)
        VALUES (:id, :nameAuthor, :body)"
    );
    $view->bindParam(':id', $id, PDO::PARAM_INT);
    $view->bindParam(':nameAuthor', $name, PDO::PARAM_STR);
    $view->bindParam(':body', $body, PDO::PARAM_STR);
    $view->execute();
  }
}
