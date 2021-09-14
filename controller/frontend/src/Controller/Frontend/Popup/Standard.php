<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2021
 * @package Controller
 * @subpackage Frontend
 */


namespace Aimeos\Controller\Frontend\Popup;


/**
 * Default implementation of the popup frontend controller
 *
 * @package Controller
 * @subpackage Frontend
 */
class Standard
	extends \Aimeos\Controller\Frontend\Base
	implements Iface, \Aimeos\Controller\Frontend\Common\Iface
{
	private $domain = 'attribute';
	private $domains = [];
	private $filter;
	private $manager;


	/**
	 * Common initialization for controller classes
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Common MShop context object
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );

		$this->manager = \Aimeos\MShop::create( $context, 'popup' );
		$this->filter = $this->manager->filter( true );
		$this->addExpression( $this->filter->getConditions() );
	}


	/**
	 * Clones objects in controller and resets values
	 */
	public function __clone()
	{
		$this->filter = clone $this->filter;
	}


	/**
	 * Adds popup IDs for filtering
	 *
	 * @param array|string $attrIds Popup ID or list of IDs
	 * @return \Aimeos\Controller\Frontend\Popup\Iface Popup controller for fluent interface
	 * @since 2019.04
	 */
	public function popup( $attrIds ) : Iface
	{
		if( !empty( $attrIds ) ) {
			$this->addExpression( $this->filter->compare( '==', 'popup.id', $attrIds ) );
		}

		return $this;
	}


	/**
	 * Adds generic condition for filtering popups
	 *
	 * @param string $operator Comparison operator, e.g. "==", "!=", "<", "<=", ">=", ">", "=~", "~="
	 * @param string $key Search key defined by the popup manager, e.g. "popup.status"
	 * @param array|string $value Value or list of values to compare to
	 * @return \Aimeos\Controller\Frontend\Popup\Iface Popup controller for fluent interface
	 * @since 2019.04
	 */
	public function compare( string $operator, string $key, $value ) : Iface
	{
		$this->addExpression( $this->filter->compare( $operator, $key, $value ) );
		return $this;
	}


	/**
	 * Adds the domain of the popups for filtering
	 *
	 * @param string $domain Domain of the popups
	 * @return \Aimeos\Controller\Frontend\Popup\Iface Popup controller for fluent interface
	 * @since 2019.04
	 */
	public function domain( string $domain ) : Iface
	{
		$this->domain = $domain;
		return $this;
	}


	/**
	 * Returns the popup for the given popup code
	 *
	 * @param string $code Unique popup code
	 * @param string $type Type assigned to the popup
	 * @return \Aimeos\MShop\Popup\Item\Iface Popup item including the referenced domains items
	 * @since 2019.04
	 */
	public function find( string $code, string $type ) : \Aimeos\MShop\Popup\Item\Iface
	{
		return $this->manager->find( $code, $this->domains, $this->domain, $type, true );
	}


	/**
	 * Creates a search function string for the given name and parameters
	 *
	 * @param string $name Name of the search function without parenthesis, e.g. "popup:prop"
	 * @param array $params List of parameters for the search function with numeric keys starting at 0
	 * @return string Search function string that can be used in compare()
	 */
	public function function( string $name, array $params ) : string
	{
		return $this->filter->make( $name, $params );
	}


	/**
	 * Returns the popup for the given popup ID
	 *
	 * @param string $id Unique popup ID
	 * @return \Aimeos\MShop\Popup\Item\Iface Popup item including the referenced domains items
	 * @since 2019.04
	 */
	public function get( string $id ) : \Aimeos\MShop\Popup\Item\Iface
	{
		return $this->manager->get( $id, $this->domains, true );
	}


	/**
	 * Adds a filter to return only items containing a reference to the given ID
	 *
	 * @param string $domain Domain name of the referenced item, e.g. "price"
	 * @param string|null $type Type code of the reference, e.g. "default" or null for all types
	 * @param string|null $refId ID of the referenced item of the given domain or null for all references
	 * @return \Aimeos\Controller\Frontend\Popup\Iface Popup controller for fluent interface
	 * @since 2019.04
	 */
	public function has( string $domain, string $type = null, string $refId = null ) : Iface
	{
		$params = [$domain];
		!$type ?: $params[] = $type;
		!$refId ?: $params[] = $refId;

		$func = $this->filter->make( 'popup:has', $params );
		$this->addExpression( $this->filter->compare( '!=', $func, null ) );
		return $this;
	}


	/**
	 * Parses the given array and adds the conditions to the list of conditions
	 *
	 * @param array $conditions List of conditions, e.g. ['&&' => [['>' => ['popup.status' => 0]], ['==' => ['popup.type' => 'color']]]]
	 * @return \Aimeos\Controller\Frontend\Popup\Iface Popup controller for fluent interface
	 * @since 2019.04
	 */
	public function parse( array $conditions ) : Iface
	{
		if( ( $cond = $this->filter->parse( $conditions ) ) !== null ) {
			$this->addExpression( $cond );
		}

		return $this;
	}


	/**
	 * Adds a filter to return only items containing the property
	 *
	 * @param string $type Type code of the property, e.g. "htmlcolor"
	 * @param string|null $value Exact value of the property
	 * @param string|null $langId ISO country code (en or en_US) or null if not language specific
	 * @return \Aimeos\Controller\Frontend\Popup\Iface Popup controller for fluent interface
	 * @since 2019.04
	 */
	public function property( string $type, string $value = null, string $langId = null ) : Iface
	{
		$func = $this->filter->make( 'popup:prop', [$type, $langId, $value] );
		$this->addExpression( $this->filter->compare( '!=', $func, null ) );
		return $this;
	}


	/**
	 * Returns the popups filtered by the previously assigned conditions
	 *
	 * @param int &$total Parameter where the total number of found popups will be stored in
	 * @return \Aimeos\Map Ordered list of popup items implementing \Aimeos\MShop\Popup\Item\Iface
	 * @since 2019.04
	 */
	public function search( int &$total = null ) : \Aimeos\Map
	{
		$this->addExpression( $this->filter->compare( '==', 'popup.domain', $this->domain ) );

		$this->filter->setConditions( $this->filter->and( $this->getConditions() ) );
		$this->filter->setSortations( $this->getSortations() );

		return $this->manager->search( $this->filter, $this->domains, $total );
	}


	/**
	 * Sets the start value and the number of returned popups for slicing the list of found popups
	 *
	 * @param int $start Start value of the first popup in the list
	 * @param int $limit Number of returned popups
	 * @return \Aimeos\Controller\Frontend\Popup\Iface Popup controller for fluent interface
	 * @since 2019.04
	 */
	public function slice( int $start, int $limit ) : Iface
	{
		$maxsize = $this->getContext()->config()->get( 'controller/frontend/common/max-size', 250 );
		$this->filter->slice( $start, min( $limit, $maxsize ) );
		return $this;
	}


	/**
	 * Sets the sorting of the result list
	 *
	 * @param string|null $key Sorting of the result list like "position", null for no sorting
	 * @return \Aimeos\Controller\Frontend\Popup\Iface Popup controller for fluent interface
	 * @since 2019.04
	 */
	public function sort( string $key = null ) : Iface
	{
		$list = $this->splitKeys( $key );

		foreach( $list as $sortkey )
		{
			$direction = ( $sortkey[0] === '-' ? '-' : '+' );
			$sortkey = ltrim( $sortkey, '+-' );

			switch( $sortkey )
			{
				case 'position':
					$this->addExpression( $this->filter->sort( $direction, 'popup.type' ) );
					$this->addExpression( $this->filter->sort( $direction, 'popup.position' ) );
					break;
				default:
				$this->addExpression( $this->filter->sort( $direction, $sortkey ) );
			}
		}

		return $this;
	}


	/**
	 * Adds popup types for filtering
	 *
	 * @param array|string $codes Popup ID or list of IDs
	 * @return \Aimeos\Controller\Frontend\Popup\Iface Popup controller for fluent interface
	 * @since 2019.04
	 */
	public function type( $codes ) : Iface
	{
		if( !empty( $codes ) ) {
			$this->addExpression( $this->filter->compare( '==', 'popup.type', $codes ) );
		}

		return $this;
	}


	/**
	 * Sets the referenced domains that will be fetched too when retrieving items
	 *
	 * @param array $domains Domain names of the referenced items that should be fetched too
	 * @return \Aimeos\Controller\Frontend\Popup\Iface Popup controller for fluent interface
	 * @since 2019.04
	 */
	public function uses( array $domains ) : Iface
	{
		$this->domains = $domains;
		return $this;
	}
}
