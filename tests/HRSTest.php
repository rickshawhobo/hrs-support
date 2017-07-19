<?php

use HRS\Support\MyModel;

class HRSTest extends \PHPUnit_Framework_TestCase
{

    public function testDataSet()
    {

        // food is an invalid property
        $data = ['name' => 'Guy', 'color' => 'Green', 'food' => 'Pizza'];
        $model = new MyModel($data);

        $this->assertTrue($model->name === 'Guy');
        $this->assertTrue($model->color === 'Green');

        // this could throw an exception instead of null
        $this->assertTrue($model->food === null);


        $model->name = 'Jane';

        $this->assertTrue($model->name === 'Jane');

        $this->assertTrue(MyModel::getName() == 'MyModel');

        $properties = MyModel::getProperties();
        $this->assertTrue(in_array('name', $properties));

        $this->assertTrue(in_array('color', $properties));

        $this->assertFalse(in_array('food', $properties));


    }
    public function testRequestPassthrough()
    {
        $data = ['name' => 'Guy', 'color' => 'Green', 'food' => 'Pizza'];

        $model = new MyModel($data);
        $model->request('login');

    }


}
