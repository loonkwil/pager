<?php

namespace SPE\Pager;

/**
 * Useful class for generating paginator
 */
class Pager
{
    /**
     * @var integer $numberOfItems >= 0
     */
    protected $numberOfItems;

    /**
     * @var integer $itemsInOnePage > 0
     */
    protected $itemsInOnePage;

    /**
     * @var integer $currentPage > 0 and < $numberOfPages
     */
    protected $currentPage;

    /**
     * @var integer $numberOfPages > 0
     */
    protected $numberOfPages;


    /**
     * @param integer $numberOfItems
     * @param integer $itemsInOnePage
     * @param integer $currentPage = 1
     */
    public function __construct($numberOfItems, $itemsInOnePage, $currentPage = 1)
    {
        $this->numberOfItems = max((int)$numberOfItems, 0);

        $this->itemsInOnePage = max((int)$itemsInOnePage, 1);

        $this->numberOfPages = 1;
        if( $this->numberOfItems !== 0 ) {
            $this->numberOfPages = (int)ceil($this->numberOfItems / $this->itemsInOnePage);
        }

        $this->currentPage = (int)$currentPage;
        $this->currentPage = max($this->currentPage, 1);
        $this->currentPage = min($this->currentPage, $this->numberOfPages);
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
     * @return boolean (is more than one page?)
     */
    public function haveToPagignate()
    {
        return $this->numberOfPages > 1;
    }

    /**
     * @return integer
     */
    public function getItemsFrom()
    {
        if( $this->numberOfItems === 0 ) {
            return 0;
        }

        return ($this->currentPage - 1) * $this->itemsInOnePage + 1;
    }

    /**
     * @return integer
     */
    public function getItemsTo()
    {
        return min(
            $this->currentPage * $this->itemsInOnePage,
            $this->numberOfItems
        );
    }

    /**
     * @return integer|null
     */
    public function getFirst()
    {
        if( $this->currentPage === 1 ) {
            return null;
        }

        return 1;
    }

    /**
     * @return integer|null
     */
    public function getLast()
    {
        if( $this->currentPage === $this->numberOfPages ) {
            return null;
        }

        return $this->numberOfPages;
    }

    /**
     * @return integer|null
     */
    public function getPrev()
    {
        if( $this->currentPage === 1 ) {
            return null;
        }

        return min(
            $this->currentPage - 1,
            $this->numberOfPages
        );
    }

    /**
     * @return integer|null
     */
    public function getNext()
    {
        if( $this->currentPage === $this->numberOfPages ) {
            return null;
        }

        return $this->currentPage + 1;
    }

    /**
     * @param integer $showNPages = 5
     *
     * @return array
     */
    public function getNeighbors($showNPages = 5)
    {
        $min = max(
            $this->currentPage - (int)floor($showNPages / 2),
            1
        );

        $max = min(
            $this->currentPage + (int)floor($showNPages / 2),
            $this->numberOfPages
        );

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
