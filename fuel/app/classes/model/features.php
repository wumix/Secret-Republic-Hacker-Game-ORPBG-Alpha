<?php

namespace Model;

class Features extends \Model {
    public static function features() {
      return array(
        1 => array(
          'name' => 'Feature 1',
          'description' => '',
          'requires' => function($level) {
             return array(
                'level' => $level * 1,
                'features' => array(
                        2 => $level
                    ),
                'knows' => array(
                        2 => $level
                    ),
                'money' => $level * 3
              );
            },
        ),
        2 => array(
            'name' => 'Feature 2',
            'description' => '',
            'requires' => function($level) {
              return array(
                'level' => $level * 1,
                'features' => array(
                //        2 => $level
              ),
            'knows' => array(
                    2 => $level
                ),
              );
            },
        ),
        3 => array(
                'name' => 'Feature 3',
                'description' => '',
                'requires' => function($level) {
                  return array(
                    'level' => $level * 1,
                    'features' => array(
                    //        2 => $level
                    ),
                    'knows' => array(
                        2 => $level
                    ),
                  );
                },
            )
        );
    }

    public static function process($features_string) {
        if ($features_string) {
        	$node_features = json_decode($features_string, true);
        } else $node_features = array();

        $features = static::features();
        foreach($features as $k_id => $k) {
        	if (!isset($node_features[$k_id])) $node_features[$k_id] = array('level' => 0);
        }
        $knowledge = Knowledge::knowledge();
        $user_knowledge = Knowledge::process(\Hacker::get('knowledge'));

        foreach($features as $k_id => $k) {
          $nf = &$node_features[$k_id];
          $nf['requires'] = $k['requires']($nf['level'] + 1);
          $fulfilled = $nf['requires']['level'] <= \Hacker::get('level');
          if (isset($nf['requires']['money'])) $fulfilled = $nf['requires']['money'] <= \Hacker::get('money');
          foreach ($nf['requires']['features'] as $r_f_id => &$r_f) {
              $r_f = array('level' => $r_f, 'fulfilled' => $node_features[$r_f_id]['level'] >= $r_f);
              $fulfilled = !$r_f['fulfilled'] ? false : $fulfilled;
          }
          foreach ($nf['requires']['knows'] as $r_k_id => &$r_k) {
              $r_k = array('level' => $r_k, 'fulfilled' => $user_knowledge[$r_k_id]['level'] >= $r_k);
              $fulfilled = !$r_k['fulfilled'] ? false : $fulfilled;
          }
          $nf['requires']['fulfilled'] = $fulfilled;
        }
        return $node_features;
    }

    public static function save($user_id, $knows) {
        $knowsData = array();
        foreach($knows as $k_id => $k) $knowsData[$k_id] = array('level' => $k['level']);
        $knowsData = json_encode($knowsData);
        \Hacker::update(array('knowledge' => $knowsData), $user_id);
    }

}
