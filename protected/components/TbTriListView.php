<?php
/**
 * TbListView class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('zii.widgets.CListView');

/**
 * Bootstrap Zii list view.
 */
class TbTriListView extends CListView
{
	/**
	 * @var string the CSS class name for the pager container. Defaults to 'pagination'.
	 */
	public $pagerCssClass = 'pagination';
	/**
	 * @var array the configuration for the pager.
	 * Defaults to <code>array('class'=>'ext.bootstrap.widgets.TbPager')</code>.
	 */
	public $pager = array('class'=>'bootstrap.widgets.TbPager');
	/**
	 * @var string the URL of the CSS file used by this detail view.
	 * Defaults to false, meaning that no CSS will be included.
	 */
	public $cssFile = false;

        public function renderItems()
        {
                echo CHtml::openTag($this->itemsTagName,array('class'=>$this->itemsCssClass))."\n";
                $data=$this->dataProvider->getData();
                $i = -1 ;
                if(($n=count($data))>0)
                {
                        
                        $owner=$this->getOwner();
                        $viewFile=$owner->getViewFile($this->itemView);
                        $j=0;
                        foreach($data as $i=>$item)
                        {
                                $i++;
                                if($i%3===0) echo '<div class=row> ' ;
                                $data=$this->viewData;
                                $data['index']=$i;
                                $data['data']=$item;
                                $data['widget']=$this;
                                $owner->renderFile($viewFile,$data);
                                if($j++ < $n-1)
                                        echo $this->separator;
                                if($i%3===0) echo '</div> ' ;
                        }
                }
                else
                        $this->renderEmptyText();
                echo CHtml::closeTag($this->itemsTagName);
        }


}
