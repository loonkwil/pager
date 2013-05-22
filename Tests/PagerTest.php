<?php

namespace SPE\PagerBundle\Tests;

use SPE\Pager\Pager;

class PagerTest extends \PHPUnit_Framework_TestCase
{
    // Pager($numberOfItems, $itemsInOnePage, $currentPage = 1)

    public function testGetNumberOfItems()
    {
        $pu = new Pager(0, 10, 1);
        $this->assertEquals($pu->getNumberOfItems(), 0);

        $pu = new Pager(-1, 10, 1);
        $this->assertEquals($pu->getNumberOfItems(), 0);

        $pu = new Pager(1, 10, 1);
        $this->assertEquals($pu->getNumberOfItems(), 1);
    }

    public function testGetItemsInOnePage()
    {
        $pu = new Pager(10, 0, 1);
        $this->assertEquals($pu->getItemsInOnePage(), 1);

        $pu = new Pager(10, 2, 1);
        $this->assertEquals($pu->getItemsInOnePage(), 2);
    }

    public function testGetCurrentPage()
    {
        $pu = new Pager(10, 10, 0);
        $this->assertEquals($pu->getCurrentPage(), 1);

        $pu = new Pager(10, 10, 10);
        $this->assertEquals($pu->getCurrentPage(), 1);

        $pu = new Pager(10, 10, 2);
        $this->assertEquals($pu->getCurrentPage(), 1);
    }

    public function testHaveToPagignate()
    {
        $pu = new Pager(1, 10, 1);
        $this->assertEquals($pu->haveToPagignate(), false);

        $pu = new Pager(0, 10, 1);
        $this->assertEquals($pu->haveToPagignate(), false);

        $pu = new Pager(20, 10, 2);
        $this->assertEquals($pu->haveToPagignate(), true);

        $pu = new Pager(20, 10, 1);
        $this->assertEquals($pu->haveToPagignate(), true);
    }

    public function testGetItemsFrom()
    {
        $pu = new Pager(1, 10, 1);
        $this->assertEquals($pu->getItemsFrom(), 1);

        $pu = new Pager(20, 10, 2);
        $this->assertEquals($pu->getItemsFrom(), 11);
    }

    public function testGetItemsTo()
    {
        $pu = new Pager(1, 10, 1);
        $this->assertEquals($pu->getItemsTo(), 1);

        $pu = new Pager(20, 10, 2);
        $this->assertEquals($pu->getItemsTo(), 20);
    }

    public function testGetFirst()
    {
        $pu = new Pager(20, 10, 2);
        $this->assertEquals($pu->getFirst(), 1);

        $pu = new Pager(20, 10, 1);
        $this->assertEquals($pu->getFirst(), null);
    }

    public function testGetLast()
    {
        $pu = new Pager(20, 10, 2);
        $this->assertEquals($pu->getLast(), null);

        $pu = new Pager(20, 10, 1);
        $this->assertEquals($pu->getLast(), 2);
    }

    public function testGetPrev()
    {
        $pu = new Pager(20, 10, 2);
        $this->assertEquals($pu->getPrev(), 1);

        $pu = new Pager(20, 10, 1);
        $this->assertEquals($pu->getPrev(), null);
    }

    public function testGetNext()
    {
        $pu = new Pager(20, 10, 2);
        $this->assertEquals($pu->getNext(), null);

        $pu = new Pager(20, 10, 1);
        $this->assertEquals($pu->getNext(), 2);
    }

    public function testGetNeighbors()
    {
        // 1 (2)
        $pu = new Pager(20, 10, 2);
        $this->assertEquals($pu->getNeighbors(5), array(1, 2));

        // 1 (2) 3
        $pu = new Pager(30, 10, 2);
        $this->assertEquals($pu->getNeighbors(5), array(1, 2, 3));

        // 1 (2) 3 4 5
        $pu = new Pager(80, 10, 2);
        $this->assertEquals($pu->getNeighbors(5), array(1, 2, 3, 4, 5));

        // (1) 2 3 4 5
        $pu = new Pager(80, 10, 1);
        $this->assertEquals($pu->getNeighbors(5), array(1, 2, 3, 4, 5));

        // 1 2 (3) 4 5
        $pu = new Pager(80, 10, 3);
        $this->assertEquals($pu->getNeighbors(5), array(1, 2, 3, 4, 5));

        // 3 4 (5) 6 7
        $pu = new Pager(80, 10, 5);
        $this->assertEquals($pu->getNeighbors(5), array(3, 4, 5, 6, 7));

        // 3 4 5 (6) 7
        $pu = new Pager(70, 10, 6);
        $this->assertEquals($pu->getNeighbors(5), array(3, 4, 5, 6, 7));

        // 3 4 5 6 (7)
        $pu = new Pager(70, 10, 7);
        $this->assertEquals($pu->getNeighbors(5), array(3, 4, 5, 6, 7));

        // 3 (4) 5
        $pu = new Pager(70, 10, 4);
        $this->assertEquals($pu->getNeighbors(2), array(3, 4, 5));

        // 3 (4) 5
        $pu = new Pager(70, 10, 4);
        $this->assertEquals($pu->getNeighbors(3), array(3, 4, 5));

        // (4)
        $pu = new Pager(70, 10, 4);
        $this->assertEquals($pu->getNeighbors(1), array(4));

        // 1
        $pu = new Pager(10, 10, 1);
        $this->assertEquals($pu->getNeighbors(5), array(1));
    }
}
