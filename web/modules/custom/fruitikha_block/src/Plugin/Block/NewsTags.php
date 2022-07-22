<?php 
namespace Drupal\fruitikha_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
/**
 * @Block(
 *   id = "news_tag_block",
 *   admin_label = @Translation("Custom News Tags")
 * )
 */
class NewsTags extends BlockBase {

    public function build() {
        $result = [];
        $node = \Drupal::routeMatch()->getParameter('node');
        if ($node instanceof \Drupal\node\NodeInterface) {
            $terms = $node->get('field_tags')->referencedEntities();
            foreach ($terms as $term) {
                //get taxonomy term url
                $aliasManager = \Drupal::service('path_alias.manager');
                $url = $aliasManager->getAliasByPath('/taxonomy/term/'.$term->tid->value);
                $result['node_tags'][] =[
                    '#type' => 'link',
                    '#url' => $url,
                    '#title' => $term->getName(),
                  ];
              }
            // cache tags and cache context.
            // cache tags - clear cache if any changes happens.
            // Cache Context -  save cache based on request such as url,user etc.
            $result["#cache"] = [
                "tags" => ['node_list:article'],
                'contexts' => ['url']
            ];
            //dump($result);exit;
            return $result;
          }
       
    }
}