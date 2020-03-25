<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

//需按照 自己电脑入境 做出对应修改
Yii::setAlias('@upload', 'http://localhost:21080/mel-img/');

Yii::setAlias('@imagePath', 'http://localhost:21080/mel-img'); // localhost 加载图片入境

Yii::setAlias('@url' , 'C:\Users\user\Desktop\up');
