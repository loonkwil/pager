<?php

namespace SPE\PagerUtilitiesBundle;

/**
 * Lapozo gyartasaval kapcsolatos fuggvenyek
 */
class PagerUtilities
{
    /**
     * @var integer $numberOfItems Hany elem van osszesen
     */
    protected $numberOfItems;

    /**
     * @var integer $itemsInOnePage Egy oldalon hany elem talalhato
     */
    protected $itemsInOnePage;

    /**
     * @var integer $currentPage Melyik oldalon allok (minimum: 1)
     */
    protected $currentPage;

    /**
     * @var integer $numberOfPages Hany oldal lesz osszesen (minimum: 1)
     */
    protected $numberOfPages;


    /**
     * @param integer $numberOfItems Hany elem van osszesen
     * @param integer $itemsInOnePage Egy oldalon hany elem talalhato
     * @param integer $currentPage = 1 Melyik oldalon allok
     */
    public function __construct($numberOfItems, $itemsInOnePage, $currentPage = 1)
    {
        $this->numberOfItems  = (int)$numberOfItems;
        $this->itemsInOnePage = (int)$itemsInOnePage;
        $this->currentPage    = (int)$currentPage;
        if( $this->currentPage <= 0 ) {
            $this->currentPage = 1;
        }

        $this->numberOfPages = ($this->itemsInOnePage === 0 || $this->numberOfItems === 0)
            ? 1
            : (int)ceil($this->numberOfItems / $this->itemsInOnePage)
            ;
    }


    /**
     * @return integer
     */
    public function getNumberOfItems()
    {
        return $this->numberOfItems;
    }

    /**
     * @return integer
     */
    public function getItemsInOnePage()
    {
        return $this->itemsInOnePage;
    }

    /**
     * @return integer
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @return integer
     */
    public function getNumberOfPages()
    {
        return $this->numberOfPages;
    }


    /**
     * Szukseges-e a lapozo (egynel tobb oldal van-e)
     *
     * @return boolean
     */
    public function haveToPagignate()
    {
        return $this->numberOfPages > 1;
    }

    /**
     * Az aktualis oldalon hanyadik termektol kezdodoen lathatoak a talalatok
     *
     * @return integer
     */
    public function getItemsFrom()
    {
        return ($this->numberOfPages < $this->currentPage || $this->numberOfItems === 0)
            ? 0
            : ($this->currentPage - 1) * $this->itemsInOnePage + 1
            ;
    }

    /**
     * Az aktualis oldalon hanyadik termekig bezaroan lathatoak a talalatok
     *
     * @return integer
     */
    public function getItemsTo()
    {
        if($this->numberOfPages < $this->currentPage) {
            return 0;
        }

        $ret = $this->currentPage * $this->itemsInOnePage;

        return ( $ret > $this->numberOfItems ) ? $this->numberOfItems : $ret;
    }

    /**
     * Elso oldal. Ha az eslo oldalon allok null-t ad vissza, ha nem 1-et
     *
     * @return integer|null
     */
    public function getFirst()
    {
        return ($this->currentPage === 1) ? null : 1;
    }

    /**
     * Utolso oldal. Ha az utolso oldalon allok null-t ad vissza, ha nem
     * visszaadja az utolso oldal szamat
     *
     * @return integer|null
     */
    public function getLast()
    {
        if( $this->currentPage === $this->numberOfPages ) {
            return null;
        }

        return ($this->numberOfPages) ?  : 1;
    }

    /**
     * Elozo oldal. Ha az eslo oldalon allok null-t ad vissza, ha nem akkor az
     * elozo oldal szamat
     *
     * @return integer|null
     */
    public function getPrev()
    {
        if( $this->currentPage === 1 ) {
            return null;
        }

        $prev = $this->currentPage - 1;

        if( $prev === 0 ) {
            return 1;
        }
        else if( $prev > $this->numberOfPages ) {
            return $this->numberOfPages;
        }
        else {
            return $prev;
        }
    }

    /**
     * Kovetkezo oldal. Ha az utolso oldalon allok null-t ad vissza, ha nem
     * visszaadja a kovetkezo oldal szamat
     *
     * @return integer|null
     */
    public function getNext()
    {
        return ( $this->currentPage >= $this->numberOfPages )
            ? null
            : $this->currentPage + 1
            ;
    }

    /**
     * Visszaadja az aktualis oldal szomszedjait.
     * pl.: 5 eseten 4, 5, (6), 7, 8 vagy 1 (2) 3 4 5
     *
     * @param integer $showNPages = 5 Osszesen ennyi elemt adok vissza (ha van
     * ennyi)
     *
     * @return array
     */
    public function getNeighbors($showNPages = 5)
    {
        $min = $this->currentPage - floor($showNPages / 2);
        if( $min < 1 ) {
            $min = 1;
        }

        $max = $this->currentPage + floor($showNPages / 2);
        if( $max > $this->numberOfPages ) {
            $max = $this->numberOfPages;
        }

        while( ($max - $min + 1) < $showNPages ) {
            if( $min > 1 ) {
                --$min;
            }
            else if( $max < $this->numberOfPages ) {
                ++$max;
            }
            else {
                break;
            }
        }

        return range($min, $max);
    }
}

