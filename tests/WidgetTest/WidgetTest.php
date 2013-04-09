<?php

namespace WidgetTest;

use Widget\Widget;

class WidgetTest extends TestCase
{
    public function createUserWidget()
    {
        return new \WidgetTest\Fixtures\User(array(
            'widget' => $this->widget,
            'name' => 'twin'
        ));
    }


    public function testConfig()
    {
        $widget = $this->widget;
        
        $widget->config('key', 'value');

        $this->assertEquals('value', $widget->config('key'));

        $widget->config('first/second', 'value2');

        $this->assertEquals(array('second' => 'value2',), $widget->config('first'));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentExceptionForWidgetOption()
    {
        new \Widget\Request(array(
            'widget' => new \stdClass
        ));
    }
    
    public function testAppendOption()
    {
        $request = $this->request;
        
        $request->setOption('posts', array('a' => 'b'));
        $this->assertEquals(array('a' => 'b'), $request->getOption('posts'));
        
        $request->setOption('+posts', array('c' => 'd'));
        $this->assertEquals(array('a' => 'b', 'c' => 'd'), $request->getOption('posts'));
        
        $this->request->setOption('post', array());
    }
    
    public function testGetOption()
    {
        $user = $this->createUserWidget();
        
        $this->assertEquals('twin', $user->getName());
        
        $this->assertEquals('twin', $user->getOption('name'));
        
        $options = $user->getOption();
        
        $this->assertArrayHasKey('name', $options);
        $this->assertArrayHasKey('widget', $options);
        $this->assertArrayHasKey('deps', $options);
    }
    
    public function testSetInis()
    {
        $this->widget->setInis(array(
            'date.timezone' => 'Asia/Shanghai'
        ));
        $this->assertEquals('Asia/Shanghai', ini_get('date.timezone'));
    }
    
    public function testSet()
    {
        $request = new \Widget\Request(array(
            'widget' => $this->widget,
        ));
        
        $this->widget->set('request', $request);
        $this->assertSame($request, $this->widget->request);
    }
    
    public function testNewInstance()
    {
        $newRequest = $this->widget->newInstance('request');
        
        $this->assertInstanceOf('\Widget\Request', $newRequest);
        $this->assertEquals($this->request, $newRequest);
        $this->assertNotSame($this->request, $newRequest);
    }
    
    public function testGetClassFromAlias()
    {
        $this->widget->appendOption('alias', array(
            'request' => '\Widget\Request'
        ));
        
        $this->assertEquals('\Widget\Request', $this->widget->getClass('request'));
    }
    
    public function testRemove()
    {
        // Instance request widget
        $request = $this->widget->request;
        
        $this->assertTrue($this->widget->remove('request'));
        $this->assertFalse($this->widget->remove('request'));
        
        // Re-instance request widget
        $this->assertNotSame($request, $this->widget->request);
    }
    
    public function testHas()
    {
        $this->widget->request;
        
        $this->assertEquals('\Widget\Request', $this->widget->has('request'));
        $this->assertFalse($this->widget->has('request2'));
    }
    
    public function testAutoload()
    {
        $this->widget->setAutoload(false);
        $this->assertNotContains(array($this->widget, 'autoload'), spl_autoload_functions());
        
        $this->widget->setAutoload(true);
        $this->assertContains(array($this->widget, 'autoload'), spl_autoload_functions());
        
        $this->widget->setAutoloadMap(array(
            'WidgetTest' => dirname(__DIR__)
        ));
        
        $this->assertTrue(class_exists('WidgetTest\Fixtures\Autoload'));
        $this->assertFalse(class_exists('WidgetTest\Fixtures\AutoloadNotFound'));
    }
    
    public function testImport()
    {
        $this->widget->setImport(array(
            array(
                'dir' => __DIR__ . '/Fixtures/Import',
                'namespace' => '\WidgetTest\Fixtures\Import',
                'format' => 'test%s',
            )
        ));
        
        $this->assertEquals('\WidgetTest\Fixtures\Import\Widget1', $this->widget->has('testWidget1'));
        $this->assertEquals('\WidgetTest\Fixtures\Import\Widget2', $this->widget->has('testWidget2'));
        $this->assertFalse($this->widget->has('testWidget3'));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Parameter 1 should be valid directory
     */
    public function testImportInvalidDir()
    {
        $this->widget->import(__DIR__ . '/not found/', 'test');
    }
        
    public function testNewWidgetFromFactoryMethod()
    {
        $widget = Widget::create(array(), 'otherName');
        
        $this->assertInstanceOf('\Widget\Widget', $widget);
        $this->assertSame($widget, Widget::create(array(), 'otherName'));
    }
    
    public function testFileAsConfiguration()
    {
        $widget = Widget::create(__DIR__ . '/Fixtures/env/twin.php');
        
        $this->assertTrue($widget->config('twin'));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Configuration should be array or file
     */
    public function testInvalidArgumentExceptionOnCreate()
    {
        Widget::create(new \stdClass);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Configuration should be array or file
     */
    public function testInvalidArgumentExceptionWhenFileNotFind()
    {
        Widget::create('not existing file');
    }
    
    public function testReset()
    {
        $first = Widget::create(array(), 'first');
        $second = Widget::create(array(), 'second');
        
        Widget::reset('first');
        
        $this->assertNotSame($first, Widget::create(array(), 'second'));
        $this->assertSame($second, Widget::create(array(), 'second'));
        
        Widget::reset();
        $this->assertNotSame($first, Widget::create(array(), 'second'));
        $this->assertNotSame($second, Widget::create(array(), 'second'));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Widget instance "NotInstance" not found
     */
    public function testRestInvalidArgumentException()
    {
        Widget::reset('NotInstance');
    }
}
