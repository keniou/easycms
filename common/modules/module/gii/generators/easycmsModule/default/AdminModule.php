<?= '<?php' ?>
<?php
if(!isset($subModule)) {
    $subModule = '';
} else {
    $subModule = '\\' . $subModule;
}
?>

namespace common\modules\<?= $generator->name . $subModule ?>;

class Module extends \common\modules\admin\BaseModule
{
    public $controllerNamespace = 'common\modules\<?= $generator->name . $subModule ?>\controllers';
}
