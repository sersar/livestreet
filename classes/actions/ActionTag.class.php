<?
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

/**
 * Обрабатывает поиск по тегам
 *
 */
class ActionTag extends Action {	
	/**
	 * Инициализация
	 *
	 */
	public function Init() {		
		/**
		 * Определяем какие блоки выводить
		 */
		$this->Viewer_AddBlocks('right',array('tags','stream'));	
	}
	
	protected function RegisterEvent() {						
	}
		
	
	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */
	
	/**
	 * Отображение топиков
	 *
	 */
	protected function EventNotFound() {
		/**
		 * Получаем тег из УРЛа
		 */
		$sTag=urldecode($this->sCurrentEvent);
		/**
		 * Передан ли номер страницы
		 */
		if (preg_match("/^page(\d+)$/i",$this->getParam(0),$aMatch)) {			
			$iPage=$aMatch[1];
		} else {
			$iPage=1;
		}		
		/**
		 * Получаем список топиков
		 */
		$iCount=0;			
		$aResult=$this->Topic_GetTopicsByTag($sTag,$iCount,$iPage,BLOG_TOPIC_PER_PAGE);		
		$aTopics=$aResult['collection'];	
		/**
		 * Формируем постраничность
		 */		
		$aPaging=$this->Viewer_MakePaging($aResult['count'],$iPage,BLOG_TOPIC_PER_PAGE,4,DIR_WEB_ROOT.'/tag/'.htmlspecialchars($sTag));
		/**
		 * Загружаем переменные в шаблон
		 */				
		$this->Viewer_Assign('aPaging',$aPaging);
		$this->Viewer_Assign('aTopics',$aTopics);
		$this->Viewer_Assign('sTag',$sTag);
		$this->Viewer_AddHtmlTitle('Поиск по тегам');
		$this->Viewer_AddHtmlTitle($sTag);
		/**
		 * Устанавливаем шаблон вывода
		 */
		$this->SetTemplateAction('index');		
	}	
}
?>