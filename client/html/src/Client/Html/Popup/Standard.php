<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package Client
 * @subpackage Html
 */


namespace Aimeos\Client\Html\Popup;


/**
 * Default implementation of catalog detail section HTML clients.
 *
 * @package Client
 * @subpackage Html
 */
class Standard
extends \Aimeos\Client\Html\Common\Client\Factory\Base
implements \Aimeos\Client\Html\Common\Client\Factory\Iface
{
	
	private $subPartPath = 'client/html/popup/subparts';
	private $subPartNames = ['seen', 'service'];

	private $tags = [];
	private $expire;
	private $view;


	public function getBody( string $uid = '' ) : string
	{
		$view = $this->getView();
		$context = $this->getContext();
		$prefixes = ['d_prodid', 'd_name'];

		$code = $context->getConfig()->get( 'client/html/popup/prodcode-default' );
		$id = $context->getConfig()->get( 'client/html/popup/prodid-default', $code );

		if( !$view->param( 'd_prodid', $id ) && !$view->param( 'd_name' ) ) {
			return '';
		}

		$confkey = 'client/html/popup';

		if( ( $html = $this->getCached( 'body', $uid, $prefixes, $confkey ) ) === null )
		{
			
			$tplconf = 'client/html/popup/template-body';
			$default = 'popup/body-standard';

			try
			{
				$html = '';

				if( !isset( $this->view ) ) {
					$view = $this->view = $this->getObject()->addData( $view, $this->tags, $this->expire );
				}

				foreach( $this->getSubClients() as $subclient ) {
					$html .= $subclient->setView( $view )->getBody( $uid );
				}
				$view->detailBody = $html;

				$html = $view->render( $view->config( $tplconf, $default ) );
				$this->setCached( 'body', $uid, $prefixes, $confkey, $html, $this->tags, $this->expire );

				return $html;
			}
			catch( \Aimeos\Client\Html\Exception $e )
			{
				$error = array( $context->getI18n()->dt( 'client', $e->getMessage() ) );
				$view->detailErrorList = array_merge( $view->get( 'detailErrorList', [] ), $error );
			}
			catch( \Aimeos\Controller\Frontend\Exception $e )
			{
				$error = array( $context->getI18n()->dt( 'controller/frontend', $e->getMessage() ) );
				$view->detailErrorList = array_merge( $view->get( 'detailErrorList', [] ), $error );
			}
			catch( \Aimeos\MShop\Exception $e )
			{
				$error = array( $context->getI18n()->dt( 'mshop', $e->getMessage() ) );
				$view->detailErrorList = array_merge( $view->get( 'detailErrorList', [] ), $error );
			}
			catch( \Exception $e )
			{
				$error = array( $context->getI18n()->dt( 'client', 'A non-recoverable error occured' ) );
				$view->detailErrorList = array_merge( $view->get( 'detailErrorList', [] ), $error );
				$this->logException( $e );
			}

			$html = $view->render( $view->config( $tplconf, $default ) );
		}
		else
		{
			$html = $this->modifyBody( $html, $uid );
		}

		return $html;
	}


	public function getHeader( string $uid = '' ) : ?string
	{
		$view = $this->getView();
		$context = $this->getContext();
		$prefixes = ['d_prodid', 'd_name'];
		$confkey = 'client/html/popup';

		$code = $context->getConfig()->get( 'client/html/popup/prodcode-default' );
		$id = $context->getConfig()->get( 'client/html/popup/prodid-default', $code );

		if( !$view->param( 'd_prodid', $id ) && !$view->param( 'd_name' ) ) {
			return '';
		}

		if( ( $html = $this->getCached( 'header', $uid, $prefixes, $confkey ) ) === null )
		{
			
			$tplconf = 'client/html/popup/template-header';
			$default = 'popup/header-standard';

			try
			{
				$html = '';

				if( !isset( $this->view ) ) {
					$view = $this->view = $this->getObject()->addData( $view, $this->tags, $this->expire );
				}

				foreach( $this->getSubClients() as $subclient ) {
					$html .= $subclient->setView( $view )->getHeader( $uid );
				}
				$view->detailHeader = $html;

				$html = $view->render( $view->config( $tplconf, $default ) );
				$this->setCached( 'header', $uid, $prefixes, $confkey, $html, $this->tags, $this->expire );

				return $html;
			}
			catch( \Exception $e )
			{
				$this->logException( $e );
			}
		}
		else
		{
			$html = $this->modifyHeader( $html, $uid );
		}

		return $html;
	}

	public function getSubClient( string $type, string $name = null ) : \Aimeos\Client\Html\Iface
	{

		return $this->createSubClient( 'popup/' . $type, $name );
	}


	
	public function modifyBody( string $content, string $uid ) : string
	{
		$content = parent::modifyBody( $content, $uid );

		return $this->replaceSection( $content, $this->getView()->csrf()->formfield(), 'popup.csrf' );
	}


	
	public function process()
	{
		$context = $this->getContext();
		$view = $this->getView();

		try
		{
			$site = $context->getLocale()->getSiteItem()->getCode();
			$params = $this->getClientParams( $view->param() );
			$context->getSession()->set( 'aimeos/popup/params/last/' . $site, $params );

			parent::process();
		}
		catch( \Aimeos\Client\Html\Exception $e )
		{
			$error = array( $context->getI18n()->dt( 'client', $e->getMessage() ) );
			$view->detailErrorList = array_merge( $view->get( 'detailErrorList', [] ), $error );
		}
		catch( \Aimeos\Controller\Frontend\Exception $e )
		{
			$error = array( $context->getI18n()->dt( 'controller/frontend', $e->getMessage() ) );
			$view->detailErrorList = array_merge( $view->get( 'detailErrorList', [] ), $error );
		}
		catch( \Aimeos\MShop\Exception $e )
		{
			$error = array( $context->getI18n()->dt( 'mshop', $e->getMessage() ) );
			$view->detailErrorList = array_merge( $view->get( 'detailErrorList', [] ), $error );
		}
		catch( \Exception $e )
		{
			$error = array( $context->getI18n()->dt( 'client', 'A non-recoverable error occured' ) );
			$view->detailErrorList = array_merge( $view->get( 'detailErrorList', [] ), $error );
			$this->logException( $e );
		}
	}


	
	protected function getSubClientNames() : array
	{
		return $this->getContext()->getConfig()->get( $this->subPartPath, $this->subPartNames );
	}



	public function addData( \Aimeos\MW\View\Iface $view, array &$tags = [], string &$expire = null ) : \Aimeos\MW\View\Iface
	{
		$attrMap = [];

		$options = $view->config( 'client/html/catalog/filter/attribute/types-option', [] );

		$oneof = $view->config( 'client/html/catalog/filter/attribute/types-oneof', [] );

		$attrTypes = $view->config( 'client/html/catalog/filter/attribute/types', [] );
		$attrTypes = ( !is_array( $attrTypes ) ? explode( ',', $attrTypes ) : $attrTypes );

		$domains = array( 'text', 'media' ) ;
        $items = [];
		$listitems=[];

        $popupType = 'standard';
		$rows = \Aimeos\Controller\Frontend::create( $this->getContext(), 'popup' )->uses($domains)->search();
		/*dd($rows);*/
		
        if($rows){
            foreach($rows->toArray() as $row ){

                $popupType = $row->get('popup.type');
				$image_url = "";
				$name = "";
				$button_text = "";
				$long = "";
				$short = "";

				if($popupType == "list-banner"){
				/*	foreach($row->getListItems() as $item){

						$refItem = $item->getRefItem();
						if($refItem){
							$list_banner_url = $refItem->get('media.url');
							if($list_banner_url){
								$langid = $this->getContext()->getLocale()->getLanguageId();
								$config = $item->getConfig();
								$content = isset($config['content-'.$langid])?$config['content-'.$langid]:'';
								$url = isset($config['url-'.$langid])?$config['url-'.$langid]:'';
								$button_text = isset($config['button_text-'.$langid])?$config['button_text-'.$langid]:'';
								$listitems[] = ['list_banner_url'=>$list_banner_url, 'content'=>$content, 'url'=>$url, 'button_text'=>$button_text];
							}
						}

					}*/
				}
				else{
					foreach($row->getListItems() as $item){

						$refItem = $item->getRefItem();
						if($refItem){
							if($refItem->get('media.url')) {
								$image_url= $refItem->get('media.url');
							}
				
							if($refItem->get('text.type') == "short") {
								$short = $refItem->get('text.content');
							}
							elseif($refItem->get('text.type') == "long") {
								$long= $refItem->get('text.content');
							}
							elseif($refItem->get('text.type') == "name") {
								$name= $refItem->get('text.content');	
							}
							elseif($refItem->get('text.type') == "button-text") {
						
								$button_text= $refItem->get('text.content');
							}
							
							
						}
				
					}
				
					$items[] = ['short'=>$short, 'long'=>$long, 'button_text'=>$button_text, 'name'=>$name, 'image_url'=> $image_url];




				}

            }
        }

        $view->popupType = $popupType;
        $view->items = $items;
	
		$view->listitems = $listitems;

		// Delete cache when attributes are added or deleted even in "tag-all" mode
		$params = $this->getClientParams( $view->param() );

		$view->attributeResetParams = $params;

		return parent::addData( $view, $tags, $expire );
	}
}
