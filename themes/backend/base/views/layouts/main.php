<?php
use common\modules\admin\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="<?= str_replace('/', '-', Yii::$app->controller->route) ?>">
<?php $this->beginBody() ?>
<div class="container-fluid">
    <div class="row dw_height">
        <div class="sidebar">
            <div class="logo">
                <img src="/img/logo.png" />
            </div>
            <ul class="nav dw_nav">
                <?php
                $currentControllerAction = '/' . Yii::$app->controller->route;
                foreach($this->context->getMenus() as $k=>$menu): ?>
                <li>
                    <a class="<?php echo (0 < $menu['children_count'])?(in_array($currentControllerAction,$menu['child_route']) ? '' : 'collapsed'):(in_array($currentControllerAction,$menu['child_route'])?'menu-on':'collapsed')?>" href="<?php if(0 < $menu['children_count']) { echo '#menu' . $menu['menu_id']; } else { echo Url::to([$menu['route']]); } ?>"<?php if(0 < $menu['children_count']): ?> data-toggle="collapse"<?php endif; ?>><i class="icon Hui-iconfont"><?= $menu['icon'] ?></i><?php if(0 < $menu['children_count']): ?> <i class="icon Hui-iconfont float-right">&#xe6d5;</i><?php endif; ?> <?= $menu['name'] ?></a>
                    <?php if(0 < $menu['children_count']):?>
                        <ul
                            <?php
                            if(in_array($currentControllerAction,$menu['child_route'])):
                                echo 'class="menu-on collapse in",aria-expanded="true"';
                            else:
                                echo 'class="collapse",aria-expanded="false"';;
                            endif;
                            ?>
                            id="menu<?= $menu['menu_id'] ?>"
                        >
                        <?php foreach($menu['children'] as $childrenMenu): ?>
                            <li><a class="<?php echo (in_array($currentControllerAction,$childrenMenu['child_route'])?'menu-on children':'')?>" href="<?= Url::to([$childrenMenu['route']]) ?>"><?= $childrenMenu['name'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-10 col-xs-10 dw_right">
            <div class="row top-links">
                <a data-method='post' href="<?= Url::to(['/admin/index/logout']) ?>">
                    <div>
                        <center>
                            <p><span class="glyphicon glyphicon-off"></span></p>
                            <span>退出系统</span>
                        </center>
                    </div>
                </a>
                <a href="javascript:void(0)">
                <div>
                    <center>
                        <p><span class="glyphicon glyphicon-user"></span></p>
                        <span><?= Yii::$app->user->identity->username ?></span>
                    </center>
                </div>
                </a>
            </div>
            <div class="col-main" role="main">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => ['class' => 'breadcrumb']
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>