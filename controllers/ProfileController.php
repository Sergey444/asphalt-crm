<?php

namespace app\controllers;

use Yii;

use app\models\User;

use app\models\Profile;
use app\models\ProfileSearch;
use app\models\SignupForm;
use app\models\UpdateUserForm;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\helpers\ArrayHelper;

use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{

     /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['update-user', 'delete-photo'],
                        'allow' => true,
                        'roles' => ['@'],
                        // 'matchCallback' => function () {
                        //     return $this->findModel(Yii::$app->request->get('id'))->user_id === Yii::$app->user->id;
                        // }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();

        $role = array_key_first ( Yii::$app->authManager->getRolesByUser($model->user->id) );
        
        return $this->render('index.twig', [
            'model' => $model,
            'file_exists' => file_exists($model->photo),
            'role' => $role
        ]);
    }

   /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionUsers() 
    {
        $model = new SignupForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Пользователь успешно создан'));
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('users.twig', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $role = array_key_first ( Yii::$app->authManager->getRolesByUser($model->user->id) );
        
        return $this->render('index.twig', [
            'model' => $model,
            'file_exists' => file_exists($model->photo),
            'role' => $role
        ]);
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Пользователь успешно создан'));
            return $this->redirect(['view.twig', 'id' => $model->id]);
        }

        return $this->render('create.twig', [
            'model' => $model
        ]);
    }

    
    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user = new UpdateUserForm($model->user_id);

        if ($this->update($id, $model, $user)) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Пользователь успешно изменён'));
            return $this->redirect(['update', 'id' => $model->id]);
        };

        // Перенести в модель
        $model->date_of_birthday = Yii::$app->formatter->asDate($model->date_of_birthday, 'php:d.m.Y');
        $auth = Yii::$app->authManager;
        $roles = ArrayHelper::map($auth->getRoles(), 'name', 'description');
        
        return $this->render('update.twig', [
            'model' => $model,
            'file_exists' => file_exists($model->photo),
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateUser()
    {
        $id = Yii::$app->user->id;
        $model = Profile::find()->where(['user_id' => $id])->one();
        $user = new UpdateUserForm($id);

        if (Yii::$app->request->post() && $this->update($id, $model, $user)) {
            Yii::$app->session->setFlash('success', 'Пользователь успешно изменён');
            return $this->redirect(['update-user']);
        };

        $model->date_of_birthday = Yii::$app->formatter->asDate($model->date_of_birthday, 'php:d.m.Y');
        $auth = Yii::$app->authManager;
        $roles = ArrayHelper::map($auth->getRoles(), 'name', 'description');
        
        return $this->render('update.twig', [
            'model' => $model,
            'file_exists' => file_exists($model->photo),
            'user' => $user,
            'roles' => $roles
        ]);
    }

   /**
     * Update one from models
     * If updation is successful, the browser will be redirected to the 'update' page.
     * 
     * @param Object - $model
     * @param Object - $user
     * @return Boolean
     */
    private function update($id, $model, $user)
    {
        if ($model->load(Yii::$app->request->post())) {
            $photo = UploadedFile::getInstance($model, 'img');
            if ($photo && !$model->upload($photo)) {
                Yii::$app->session->setFlash('success', 'Фотография не загружена');
            }
            return $model->save();
        }

        if ($user->load(Yii::$app->request->post()) && $user->update($id)) {
            return true;
        }
        return false;
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'users' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $profile = $this->findModel($id);
        if (($user = User::findOne($profile->user_id)) !== null) {
            file_exists( $profile->photo) && unlink( $profile->photo);
            $profile->delete();
            if ($user->delete()) {
                Yii::$app->session->setFlash('success', 'Пользователь успешно удалён');
            }
        }
        return $this->redirect(['users']);
    }

    /**
     * @param integer $id
     */
    public function actionDeletePhoto($id)
    {
        $model = $this->findModel($id);
        if ($model->deletePhoto()) {
            Yii::$app->session->setFlash('success', 'Фотография успешно удалена');
        }

        if (Yii::$app->user->id == $id) {
            return $this->redirect(['update-user']);
        }

        return $this->redirect(['update-user', 'id' => $model->id]);
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

