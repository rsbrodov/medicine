<?php

namespace backend\controllers;

use common\models\AnketPreschoolers;
use common\models\AuthAssignment;
use common\models\AuthItem;
use common\models\User;
use common\models\UserSearch;
use Yii;
use common\models\UserForm;
use common\models\Classes;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rbac\DbManager;
use yii\web\Request;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends Controller
{
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
            $searchModel = new UserSearch();
            $search = Yii::$app->request->queryParams;

            $dataProvider = $searchModel->search($search);


            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);

    }

    public function actionView($id)
    {
        if(Yii::$app->user->can('admin')) {
            $user_device = new ActiveDataProvider([
                'query' => UserDevice::find()->where(['user_id' => $id])->orderBy(['created_at'=> SORT_DESC]),
            ]);
            return $this->render('view', [
                'model' => $this->findModel($id),
                'user_device' => $user_device,
            ]);
        }
        else{
            return $this->goHome();
        }
    }

    public function actionCreate()
    {
        $model = new UserForm();
        $usermodel = new User();
        if(Yii::$app->user->can('admin')) {
            if (Yii::$app->request->post()) {
                $post = Yii::$app->request->post()['UserForm'];
                $usermodel->username = $post['username'];
                $usermodel->email = $post['email'];
                $usermodel->phone = $post['phone'];
                $usermodel->setPassword($post['password']);
                $usermodel->status = '10';
                $usermodel->generateAuthKey();
                if ($post['role'])
                {
                    $role = $post['role'];
                }
                else{
                    Yii::$app->session->setFlash('error', "Произошла ошибка с определением роли. Данные не были сохранены");
                    return $this->redirect(['site/index']);
                }
                if ($usermodel->save())
                {
                    $r = new DbManager();
                    $r->init();
                    $assign = $r->createRole($role);
                    $r->assign($assign, $usermodel->id);

                }
                else{
                    Yii::$app->session->setFlash('error', "Ошибка сохранения пользователя. Пользователь не был зарегистрирован!");
                    return $this->goHome();
                }
                return $this->redirect(['users/index']);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
        else{
            return $this->goHome();
        }
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionLogin($id){
        $model = User::findOne($id);

        Yii::$app->user->login($model);

        return $this->redirect(['site/index']);
    }

    
    /*public function actionUpdate($id)
    {
        if(Yii::$app->user->can('admin')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        else{
            return $this->goHome();
        }
    }*/

    /*public function actionUpdateuser($id)
    {
        $my_organization = Yii::$app->user->identity->organization_id;
        $my_users = User::find()->where(['organization_id' => $my_organization])->all();
        $my_users_ids = [];
        foreach ($my_users as $m_user)
        {
            $my_users_ids[$m_user->id] = $m_user->id;
        }
        //print_r($my_users_ids);exit;
        if (!array_key_exists($id, $my_users_ids))
        {
            Yii::$app->session->setFlash('error', "Отказ в редактировании!");
            return $this->redirect(['level']);
        }
        $model = $this->findModel($id);
        if(Yii::$app->request->post())
        {
            $my_organization = Yii::$app->user->identity->organization_id;
            $my_users = User::find()->where(['organization_id' => $my_organization])->all();
            $my_users_ids = [];
            foreach ($my_users as $m_user)
            {
                $my_users_ids[$m_user->id] = $m_user->id;
            }
            //print_r($my_users_ids);exit;
            if (!array_key_exists($id, $my_users_ids))
            {
                Yii::$app->session->setFlash('error', "Отказ в редактировании!");
                return $this->redirect(['level']);
            }
            else
            {
                $model->name = Yii::$app->request->post()['User']['name'];
                $model->login = Yii::$app->request->post()['User']['email'];
                $model->email = Yii::$app->request->post()['User']['email'];
                if (Yii::$app->user->id != $id)
                {
                    if (Yii::$app->request->post()['User']['post'] == 1)
                    {
                        $role = 'medic';
                    }
                    elseif (Yii::$app->request->post()['User']['post'] == 2)
                    {
                        $role = 'foodworker';
                    }
                    elseif (Yii::$app->request->post()['User']['post'] == 3)
                    {
                        $role = 'teacher';
                    }

                    else
                    {
                        Yii::$app->session->setFlash('error', "Произошла ошибка с определением роли. Данные не были сохранены");
                        return $this->redirect(['level']);
                    }

                    $model->post = AuthItem::find()->where(['name' => $role])->one()->description;
                    if ($model->save())
                    {
                        $auth = AuthAssignment::find()->where(['user_id' => $id])->one();
                        $auth->item_name = $role;
                        $auth->save();
                    }
                }else{
                    $model->save();
                }


                Yii::$app->session->setFlash('success', "Данные успешно сохранены");
                return $this->redirect(['level']);
            }
        }
        return $this->render('updateuser', [
            'model' => $model,
        ]);
    }*/

    

    public function actionDelete($id)
    {
        if(Yii::$app->user->can('admin')) {
            $this->findModel($id)->delete();
            $role = AuthAssignment::find()->where(['user_id' => $id])->one();
            $role->delete();
            Yii::$app->session->setFlash('success', "Пользователь удален.");
            return $this->redirect(['index']);
        }
        else{
            Yii::$app->session->setFlash('error', "У вас нет прав для удаления пользователя. Пользователь не удален!");
            return $this->redirect(['level']);
        }
        return $this->redirect(['users/index']);

    }
   
}
