<?php

class CacheCommand extends CConsoleCommand
{

  public function actionClear() {
    if (Yii::app()->cache instanceof CMemCache) {
        echo "sending cache clear: ";
        system("( sleep 1; echo flush_all; sleep 1; echo quit; ) | nc localhost 11211");
    } else {
        system("redis-cli keys '*:dbschemamysql:*' | xargs -r redis-cli del");
        system("redis-cli keys '*COutputCache*' | xargs -r redis-cli del");
        system("redis-cli keys '*auth_item_parents_for_child*' | xargs -r redis-cli del");
    }
    if (isset(Yii::app()->authManager) && Yii::app()->authManager instanceof CachingDbAuthManager) Yii::app()->authManager->purgeCache();
  }

  public function actionBenchmark() {
     $t0=microtime(1);
     for($i=0;$i<10000;++$i) {
         Yii::app()->redis->getClient()->set("mykey1", "10");
     }
     $delta=microtime(1)-$t0;
     echo "YiiRedis delta $delta\n";
     
     $t0=microtime(1);
     for($i=0;$i<10000;++$i) {
         Yii::app()->redis2->set('mykey2', "10");
     }
     $delta=microtime(1)-$t0;
     echo "Predis delta $delta\n";
  }


}


