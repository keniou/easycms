<?php

namespace common\modules\admin\models\source;

use Yii;

class Yesno
{
    public function toArray()
    {
        return array(
            1 => Yii::t('admin', 'Yes'),
            0 => Yii::t('admin', 'No'),
        );
    }
}