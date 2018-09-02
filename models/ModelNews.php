<?
class ModelNews extends Db {
  const TOP_NEWS = 1;

  public function __construct() {
    parent::__construct();
  }

  public function getNewsById($id) {
    // $result = $this->connection->query(
    //   "SELECT *
    //     FROM news
    //     WHERE news_id = $id
    //     ORDER BY news_date DESC
    //     LIMIT 10"
    // );

    // return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getNewsList() {
    $result = $this->connection->query(
      "SELECT *
        FROM news
        ORDER BY news_date DESC"
    );

    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getLastNews($count = 3) {
    $sth = $this->connection->prepare('SELECT * FROM `news` LIMIT :count');
    $sth->bindParam(':count', $count, PDO::PARAM_INT);
    $sth->execute();

    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getTopNews() {

    $sth = $this->connection->prepare('
      SELECT *
      FROM news
      LEFT JOIN category ON news.news_cat_id = category.cat_id
      WHERE `news_day` = :newsTop
    ');
    $sth->bindValue(':newsTop', self::TOP_NEWS, PDO::PARAM_INT);
    $sth->execute();

    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }
}
