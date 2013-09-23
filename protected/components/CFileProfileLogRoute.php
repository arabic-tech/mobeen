<?php
/**
 * CFileProfileLogRoute class file.
 *
 * @author Muayyad Alsadi <alsadi@gmail.com>
 */

class CFileProfileLogRoute extends CFileLogRoute
{
        public $sumThreshold=0;
        public $maxThreshold=0;
        public $avgThreshold=0;
        public $nThreshold=0;
        private $_logFile='profile.log';

	/**
	 * @return string log file name. Defaults to 'application.log'.
	 */
	public function getLogFile()
	{
		return $this->_logFile;
	}

        /**
         * Saves log messages in files.
         * @param array $logs list of log messages
         */
        protected function processLogs($logs)
        {
                $_t1=microtime(1);
                $stack=array(); // start time stack
                $results=array(); // hash => n sum avg max category token
                $route='-';
                $user='-';
                $date=Date('Y-m-d');
                if (Yii::app() instanceof CWebApplication) {
                    //$route=get_class(Yii::app()->getController()); // gives CFileProfileLogRoute so we can't //->getRoute();
                    $route=Yii::app()->getRequest()->getUrl();
                    $user=(Yii::app()->user->getIsGuest())?'guest':Yii::app()->user->id;
                }
                

                foreach($logs as $log)
                {
                    if($log[1]!==CLogger::LEVEL_PROFILE)
                        continue;
                    $message=$log[0];
                     if(!strncasecmp($message,'begin:',6)) {
                         $token=trim(str_replace(array("\n", "\r"), array(' ', ' '), substr($message,6)));
                         $hash=md5($token);
                         if (isset($stack[$hash]) && $stack[$hash]) {
                            $stack[$hash][]=$log[3];
                         } else {
                            $stack[$hash]=array($log[3]);
                         }
                     } else if(!strncasecmp($message,'end:',4))
                     {
                         $token=trim(str_replace(array('\n', '\r'), array(' ', ' '), substr($message,4)));
                         $hash=md5($token);
                         if(isset($stack[$hash]) && ($t0=array_pop($stack[$hash]))!==null) {
                            $delta=$log[3]-$t0;
                            if (!isset($results[$hash])) {
                                $results[$hash]=array('n'=>0, 'sum'=>0, 'avg'=>0, 'max'=>0, 'category'=>$log[2], 'token'=>$token);
                            }
                            $r=&$results[$hash];
                            ++$r['n'];
                            $r['sum']+=$delta;
                            if ($delta>$r['max']) $r['max']=$delta;
                         }
                     }
                }
                
                if (!$results) return;
                
                $logFile=$this->getLogPath().DIRECTORY_SEPARATOR.$this->getLogFile();
                if(@filesize($logFile)>$this->getMaxFileSize()*1024)
                        $this->rotateFiles();
                $fp=@fopen($logFile,'a');
                @flock($fp,LOCK_EX);
                foreach($results as $hash=>&$r) {
                    if ($r['n']==0) continue;
                    $r['avg']=$r['sum']/$r['n'];
                    if ($r['sum'] > $this->sumThreshold ||  $r['max'] > $this->maxThreshold=0 ||
                        $r['avg'] > $this->avgThreshold=0 || $r['n'] > $this->nThreshold=0)
                        @fwrite($fp, $this->render($date, $user, $route, $hash, $r));
                }

                $_dt=microtime(1)-$_t1;
                if ($_dt>$this->sumThreshold)
                    @fwrite($fp,$this->render($date, $user, $route, 'profiler',
                        array('n'=>1, 'sum'=>$_dt, 'avg'=>$_dt, 'max'=>$_dt, 'category'=>get_class($this), 'token'=>'profiler')));
                @flock($fp,LOCK_UN);
                @fclose($fp);
        }

    protected function render($date, $user, $route, $hash, $r) {
        return sprintf("%s ! %s ! %s ! %d %010.6f %010.6f %010.6f ! %s ! %s ! %s\n", $date, $user, $route, $r['n'], $r['sum'], $r['avg'], $r['max'], $hash, $r['category'], $r['token']);
    }
}
