<?php

namespace SPE\PagerUtilitiesBundle\Tests;

use SPE\PagerUtilitiesBundle\PagerUtilities;

class PagerUtilitiesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * PagerUtilities osztaly konstruktoranak parameterei:
     *
     * @param integer $numberOfItems Hany elem van osszesen
     * @param integer $itemsInOnePage Egy oldalon hany elem talalhato
     * @param integer $currentPage = 1 Melyik oldalon allok
     */

    public function testGetItemsFrom()
    {
        $pu = new PagerUtilities(1, 10, 0);
        $this->assertEquals($pu->getItemsFrom(), 1);

        $pu = new PagerUtilities(1, 10, 1);
        $this->assertEquals($pu->getItemsFrom(), 1);

        $pu = new PagerUtilities(20, 10, 2);
        $this->assertEquals($pu->getItemsFrom(), 11);

        $pu = new PagerUtilities(0, 10, 1);
        $this->assertEquals($pu->getItemsFrom(), 0);

        $pu = new PagerUtilities(5, 10, 2);
        $this->assertEquals($pu->getItemsFrom(), 0);
    }

    public function testGetItemsTo()
    {
        $pu = new PagerUtilities(1, 10, 1);
        $this->assertEquals($pu->getItemsTo(), 1);

        $pu = new PagerUtilities(20, 10, 2);
        $this->assertEquals($pu->getItemsTo(), 20);

        $pu = new PagerUtilities(0, 10, 1);
        $this->assertEquals($pu->getItemsTo(), 0);

        $pu = new PagerUtilities(5, 10, 2);
        $this->assertEquals($pu->getItemsTo(), 0);
    }

    public function testGetItemsInOnePage()
    {
        $pu = new PagerUtilities(1, 10, 1);
        $this->assertEquals($pu->getItemsInOnePage(), 10);

        $pu = new PagerUtilities(1, 0, 1);
        $this->assertEquals($pu->getItemsInOnePage(), 0);
    }

    public function testGetFirst()
    {
        $pu = new PagerUtilities(20, 10, 2);
        $this->assertEquals($pu->getFirst(), 1);

        $pu = new PagerUtilities(20, 10, 1);
        $this->assertEquals($pu->getFirst(), null);

        $pu = new PagerUtilities(20, 10, 3);
        $this->assertEquals($pu->getFirst(), 1);

        $pu = new PagerUtilities(20, 0, 3);
        $this->assertEquals($pu->getFirst(), 1);

        $pu = new PagerUtilities(0, 10, 3);
        $this->assertEquals($pu->getFirst(), 1);
    }

    public function testGetLast()
    {
        $pu = new PagerUtilities(20, 10, 2);
        $this->assertEquals($pu->getLast(), null);

        $pu = new PagerUtilities(20, 10, 1);
        $this->assertEquals($pu->getLast(), 2);

        $pu = new PagerUtilities(20, 10, 3);
        $this->assertEquals($pu->getLast(), 2);

        $pu = new PagerUtilities(20, 0, 3);
        $this->assertEquals($pu->getLast(), 1);

        $pu = new PagerUtilities(0, 10, 3);
        $this->assertEquals($pu->getLast(), 1);
    }

    public function testGetPrev()
    {
        $pu = new PagerUtilities(20, 10, 2);
        $this->assertEquals($pu->getPrev(), 1);

        $pu = new PagerUtilities(20, 10, 1);
        $this->assertEquals($pu->getPrev(), null);

        $pu = new PagerUtilities(20, 0, 3);
        $this->assertEquals($pu->getPrev(), 1);

        $pu = new PagerUtilities(0, 10, 3);
        $this->assertEquals($pu->getPrev(), 1);
    }

    public function testGetNext()
    {
        $pu = new PagerUtilities(20, 10, 2);
        $this->assertEquals($pu->getNext(), null);

        $pu = new PagerUtilities(20, 10, 1);
        $this->assertEquals($pu->getNext(), 2);

        $pu = new PagerUtilities(20, 0, 3);
        $this->assertEquals($pu->getNext(), null);

        $pu = new PagerUtilities(0, 10, 3);
        $this->assertEquals($pu->getNext(), null);
    }

    public function testGetNeighbors()
    {
        // 1 (2)
        $pu = new PagerUtilities(20, 10, 2);
        $this->assertEquals($pu->getNeighbors(5), array(1, 2));

        // 1 (2) 3
        $pu = new PagerUtilities(30, 10, 2);
        $this->assertEquals($pu->getNeighbors(5), array(1, 2, 3));

        // 1 (2) 3 4 5
        $pu = new PagerUtilities(80, 10, 2);
        $this->assertEquals($pu->getNeighbors(5), array(1, 2, 3, 4, 5));

        // (1) 2 3 4 5
        $pu = new PagerUtilities(80, 10, 1);
        $this->assertEquals($pu->getNeighbors(5), array(1, 2, 3, 4, 5));

        // 1 2 (3) 4 5
        $pu = new PagerUtilities(80, 10, 3);
        $this->assertEquals($pu->getNeighbors(5), array(1, 2, 3, 4, 5));

        // 3 4 (5) 6 7
        $pu = new PagerUtilities(80, 10, 5);
        $this->assertEquals($pu->getNeighbors(5), array(3, 4, 5, 6, 7));

        // 3 4 5 (6) 7
        $pu = new PagerUtilities(70, 10, 6);
        $this->assertEquals($pu->getNeighbors(5), array(3, 4, 5, 6, 7));

        // 3 4 5 6 (7)
        $pu = new PagerUtilities(70, 10, 7);
        $this->assertEquals($pu->getNeighbors(5), array(3, 4, 5, 6, 7));

        // 3 (4) 5
        $pu = new PagerUtilities(70, 10, 4);
        $this->assertEquals($pu->getNeighbors(2), array(3, 4, 5));

        // 3 (4) 5
        $pu = new PagerUtilities(70, 10, 4);
        $this->assertEquals($pu->getNeighbors(3), array(3, 4, 5));

        // (4)
        $pu = new PagerUtilities(70, 10, 4);
        $this->assertEquals($pu->getNeighbors(1), array(4));

        // 1
        $pu = new PagerUtilities(20, 0, 3);
        $this->assertEquals($pu->getNeighbors(5), array(1));

        // 1
        $pu = new PagerUtilities(0, 10, 3);
        $this->assertEquals($pu->getNeighbors(5), array(1));
    }
}
