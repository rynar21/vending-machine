<?php

namespace frontend\controllers;

use frontend\event\Cat;
use frontend\event\Mouse;

/**
* Class: \frontend\controllers\Event
*/
class EventController extends \yii\web\Controller
{
    public function actionTest()
    {
        $cat = new Cat();
        $mouse = new Mouse();

        // 需事先给猫绑定 miao 事件才可以触发此事件
        // 猫一叫，就触发老鼠的 run 方法
        $cat->on('miao', [$mouse, 'run']);

        // 猫发出叫声
        $cat->shout();
    }
}
