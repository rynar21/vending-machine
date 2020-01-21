<?php

namespace frontend\event;

/**
 * 猫类
 * Class: \frontend\event\Cat
 *
 * 为了让猫具有事件能力
 * 所以要继承 \yii\base\Component
 * >>> \yii\base\Component 对 \yii\base\Event 的 on 方法进行重写
 * >>> \yii\base\Event 适合类级绑定
 * >>> \yii\base\Component 适合对象级绑定
 */
class Cat extends \yii\base\Component
{
    /**
     * 猫发出叫声
     */
    public function shout()
    {
        echo '9 <br />';


        // 猫叫了之后 触发猫的 miao 事件
        $this->trigger('miao');
    }
}
