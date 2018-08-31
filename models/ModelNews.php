<?
class ModelNews extends Db {
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
        ORDER BY news_date DESC
        LIMIT 10"
    );

    return $result->fetchAll(PDO::FETCH_ASSOC);
  }
}
