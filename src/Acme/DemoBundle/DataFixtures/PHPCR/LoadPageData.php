<?php

/*
* This file is part of the AcmeDemoBundle package.
*
* (c) Gabriel Théron <gabriel.theron90@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
 */

namespace Acme\DemoBundle\DataFixtures\PHPCR;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Cmf\Bundle\SimpleCmsBundle\Doctrine\Phpcr\Page;

/**
* @author Gabriel Théron <gabriel.theron90@gmail.com>
*/
class LoadPageData implements FixtureInterface, OrderedFixtureInterface
{    
    public function getOrder()
    {
        // refers to the order in which the class' load function is called
        // (lower return values are called first)
        return 10;
    }

    public function load(ObjectManager $documentManager)
    {
        if (!$documentManager instanceof DocumentManager) {
            $class = get_class($documentManager);
            throw new \RuntimeException("Fixture requires a PHPCR ODM DocumentManager instance, instance of '$class' given.");
        }

        $page = new Page(); // create a new Page object (document)
        $page->setName('new_page'); // the name of the node
        $page->setLabel('Another new Page');
        $page->setTitle('Another new Page');
        $page->setBody('I have added this page myself!');

        $simpleCmsRoot = $documentManager->find(null, '/cms/simple');

        $page->setParentDocument($simpleCmsRoot); // set the parent to the root

        $documentManager->persist($page); // add the Page in the queue
        $documentManager->flush(); // add the Page to PHPCR
    }
}
