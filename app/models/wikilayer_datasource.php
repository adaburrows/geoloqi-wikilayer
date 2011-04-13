<?php

app::getLib('http_request');

class wikilayer_datasource extends http_request {
/*
 * wikilayer::getWithinRadius()
 * -----------------------------------
 * Grabs all wikipedia articles within a given radius
 * If duplicates are found, they are removed.
 * =============================================================================
 */
  public function getWithinRadius($lat, $lng, $radius = 400) {
    // URL to call to grab geocoded articles
    $this->request_params['host'] = 'api.wikilocation.org';
    $this->request_params['path'] = '/articles';
    $this->request_params['query_params'] = array(
      'lat' => $lat,
      'lng' => $lng,
      'radius' => $radius,
      'format' => 'json'
    );
    // Grab the article info
    $this->do_request();
    $json = $this->get_data();
    $data = json_decode($json, true);
    $articles = $data['articles'];
    return $articles;
  }

/*
 * wikilayer::filterArticles()
 * ---------------------------
 * Filter duplicate articles.
 * =============================================================================
 */
  public function filterArticles($articles, $old_articles = array()) {
    $articles_to_return = array(); // Array of articles to return
    $articles_to_delete = array(); // Array of articles that are duplicate
    $article_ids = $old_articles;  // List of all article ids, used for filtering

    // Loop through all the articles, checking if it is already in the list.
    // Add it if it isn't.
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

    // Filter out all articles that are duplicated
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

   // Finally return all the data.
   return $articles_to_return;
  }

/*
 * wikilayer::getSignificantSentence()
 * -----------------------------------
 * Grabs the first significant sentence from a wikipedia article
 * =============================================================================
 */
  public function getSignificantSentence($id) {
    // Set up the request
    $this->request_params['host'] = 'en.wikipedia.org';
    $this->request_params['path'] = '/w/index.php';
    $this->request_params['query_params'] = array(
      'curid' => $id
    );
    // Grab the article info
    $this->do_request();
    $html = $this->get_data();

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

}
