<?php
class wikilayer extends controller {

  public function index() {
    $lat = 45.511;
    $lng = -122.682;
    $radius = 400;
    $data = $this->getWithinRadius($lat, $lng, $radius);
    return($data);
  }

  public function getWithinRadius($lat, $lng, $radius = 400) {
    $url = "http://api.wikilocation.org/articles?lat={$lat}&lng={$lng}&radius={$radius}&format=json";
    $json = $this->get_data($url);
    $data = json_decode($json, true);
    $articles = $data['articles'];

    $articles_to_return = array();
    $articles_to_delete = array();
    $article_ids = array();
    foreach($articles as $article) {
      if (in_array($article['id'], $article_ids)){
        $articles_to_delete[] = $article['id'];
      } else {
        $article_ids[] = $article['id'];
        $articles_to_return[] = array(
          'id' => $article['id'],
          'lat' => $article['lat'],
          'lng' => $article['lng'],
          'title' => $article['title']
        );
      }
    }
    foreach($articles_to_return as $index => $article) {
      if (in_array($article['id'], $articles_to_delete)) {
        unset($articles_to_return[$index]);
      } else {
        $sentence = $this->getSignificantSentence($article['id']);
        if($sentence) {
          $articles_to_return[$index]['summary'] = $sentence;
        } else {
          $articles_to_return[$index]['summary'] = '';
        }
      }
    }
   return $articles_to_return;

  }

  public function getSignificantSentence($id) {
    $url = 'http://en.wikipedia.org/w/index.php?curid=' . $id;
    $html = $this->get_data($url);

    // Article text is between "bodytext" comment tags
    if(preg_match('/<!-- bodytext -->(.+)<!-- \/bodytext -->/s', $html, $match)) {
      $article = $match[1];

      // Remove tables since they don't contain explanatory text
      $article = preg_replace('#<table[^>]*>.+?</table>#is', '', $article);

      // Remove thumbnail pictures
      $article = preg_replace('#<div class="thumb[^>]+>.+?</div>\s*</div>\s*</div>#s', '', $article);

      // Strip all remaining HTML tags to get plain text
      $article = strip_tags($article);

      // Split the text into sentences
      $sentences = preg_split('/(?<!(mr|ms|dr|mt|st))\.\s*/i', $article);

      // Look for the first sentence not in the format (* is * in *)
      $sentence = FALSE;
      foreach($sentences as $s) {
        $s = trim($s);
        if(preg_match('/.+ is .+ in .+/', $s) == FALSE) {
          $sentence = $s;
          break;
        }
      }
      return $sentence;
    } else {
      return false;
    }
  }

  protected function get_data($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Geoloqi (Geo-coded Wikipedia Article Layer) http://geoloqi.com');
    $data = curl_exec($ch);
    return $data;
  }

}
