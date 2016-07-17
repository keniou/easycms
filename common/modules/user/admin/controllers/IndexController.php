<?php

namespace common\modules\user\admin\controllers;

use Yii;
use common\modules\user\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use common\modules\user\models\search\UserSearch;
use common\modules\user\models\form\UserForm;
use yii\web\UploadedFile;

class IndexController extends \common\modules\admin\components\BaseController
{
    public $userStatus = [
        0 => 'Forbidden',
        1 => 'Active',
        2 => 'Suspended',
    ];
    
    public function behaviors()
    {
        $behaviors = [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
        return array_merge(parent::behaviors(), $behaviors);
    }
    
    /**
     * 用户管理列表
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }
    
    
    /**
     * 创建用户
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserForm();
        
        $model->setScenario(UserForm::SCENARIOS_BACKEND_CREATE);
        if(Yii::$app->request->isPost) {
            $avatar = UploadedFile::getInstance($model, 'avatar');
            $model->load(Yii::$app->request->post());
            $model->avatar = $avatar;
        }
        
        if(Yii::$app->request->isPost && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create',[
                'model' => $model,
            ]);
        }
    }
    
    /**
     * 用户更新
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = new UserForm();
        if($model->initUser($id) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->setScenario(UserForm::SCENARIOS_BACKEND_UPDATE);
        if(Yii::$app->request->isPost) {
            $avatar = UploadedFile::getInstance($model, 'avatar');
            $model->load(Yii::$app->request->post());
            $model->avatar = $avatar;
        }
        
        if(Yii::$app->request->isPost && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    
    /**
     * 查看用户详情
     * @param type $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    
    
    /**
     * 删除用户
     * @param type $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        
        return $this->redirect(['index']);
    }
    
    
    /**
     * 等级列表
     * @return mixed
     */
    public function actionGrade()
    {
        $query = Grade::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('grade', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    public function actionUpdateGrade($id)
    {
        $model = Grade::findOne($id);
        
        if($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        } else {
            if($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['user/grade']);
            }
            
            return $this->render('updateGrade', [
                'model' => $model
            ]);
        }
    }
    

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
