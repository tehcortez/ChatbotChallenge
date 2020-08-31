<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ChatbotTest\Controller;

use Chatbot\Controller\IndexController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('chatbot');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('home');
    }

//    public function testIndexActionViewModelTemplateRenderedWithinLayout()
//    {
//        $this->dispatch('/', 'GET');
//        $this->assertQuery('.container .jumbotron');
//    }

    public function testInvalidRouteDoesNotCrash()
    {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }
        
    public function testloginActionWithInvalidPassword()
    {
        $request = $this->getRequest();
        $request->setContent(json_encode(array(
            'user' => 'wrong',
            'password' => 'password'
        )));
        $this->dispatch('/bot/login', 'POST');

//        var_dump($this->getResponse()->getContent());
        $this->assertEquals('{"answer":"Not a match... Let\'s try again. Do I know you?","code":1}', $this->getResponse()->getContent());
        $this->assertResponseStatusCode(200);
    }
    
//    public function testloginActionWithValidPassword()
//    {
//        $request = $this->getRequest()->setContent($content);
//        $request->setContent(array(
//            'user' => 'luc',
//            'password' => 'pass'
//        ));
//        $this->dispatch('/bot/login', 'POST');
//
//        var_dump($this->getResponse()->getContent());
//        $this->assertEquals('{"answer":"Not a match... Let\'s try again. Do I know you?","code":1}', $this->getResponse()->getContent());
//        $this->assertResponseStatusCode(200);
//    }
}
