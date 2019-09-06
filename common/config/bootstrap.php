<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

//需按照 自己电脑入境 做出对应修改
Yii::setAlias('@upload', 'C:\wamp64\www\vending-machine\backend\image');  //保存图片入境

Yii::setAlias('@imagePath', 'http://localhost/vending-machine/backend/image/'); // localhost 加载图片入境
