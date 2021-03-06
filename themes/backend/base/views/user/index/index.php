<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\user\models\User;
use dosamigos\datepicker\DatePicker;
use common\modules\user\models\UserGroup;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'User Management');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h3><?= Html::encode($this->title) ?></h3>
    
    <p>
        <?= Html::a('创建用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => '#',
                'attribute' => 'user_id',
                'value' => 'user_id',
                'options'=> ['width'=>"80px"]
            ],
            [
                'label' => Yii::t('backend/user','Mobile'),
                'attribute' => 'mobile',
                'value' => 'mobile'
            ],
            [
                'label' => Yii::t('backend','Email'),
                'attribute' => 'email',
                'value' => 'email'
            ],
            'nickname',
            [
                'attribute' => 'user_group_id',
                'filter' => Html::activeDropDownList($searchModel, 'user_group_id', UserGroup::find()->select(['group_name', 'user_group_id'])->indexBy('user_group_id')->column(),['class'=>'form-control','prompt' => '全部']),
                'value' => function($model) {
                    if (!empty($model->userGroup)) {
                        return $model->userGroup->group_name;
                    } else {
                        return;
                    }
                },
                'options'=> ['width'=>"90px"]
            ],
            [
                'label' => Yii::t('backend','Status'),
                'attribute' => 'status',
                'filter'=> Html::activeDropDownList($searchModel,'status',User::getStatus(),['prompt'=>'全部','class'=>'form-control']),
                'format' => 'raw',
                'value' => function($m) {
                    switch($m->status) {
                        case 0:
                            $className = 'text-danger';
                            break;
                        case 1:
                            $className = 'text-success';
                            break;
                        case 2:
                            $className = 'text-warning';
                    }
                    return Html::label(User::getStatus()[$m->status],null,['class' => $className]);
                },
                'options'=> ['width'=>"90px"]
            ],
            [
                'label' => '注册时间',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'name' => 'created_at',
                    'attribute' => 'created_at',
                    'inline' => false, 
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]),
                'attribute' => 'created_at',
                'value' => 'created_at',
                'headerOptions' => [
                    'style' => 'width:200px'
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

</div>
