<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // добавляем разрешение "createPost"
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // добавляем разрешение "updatePost"
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // добавляем роль "author" и даём роли разрешение "createPost"
        $author = $auth->createRole('author');
        $author->description = 'Автор';
        $auth->add($author);
        $auth->addChild($author, $createPost);

         // добавляем роль "administering" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $administering = $auth->createRole('administering');
        $administering->description = 'Администратор';
        $auth->add($administering);
        $auth->addChild($administering, $updatePost);
        $auth->addChild($administering, $author);

        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $admin->description = 'Админ';
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        // $auth->assign($administering, 3);
        // $auth->assign($author, 2);
        $auth->assign($admin, 1);

        // $auth = Yii::$app->authManager;

        // add the rule
        $rule = new \app\rbac\AuthorRule;
        $auth->add($rule);

        // добавляем разрешение "updateOwnPost" и привязываем к нему правило.
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);

        // "updateOwnPost" будет использоваться из "updatePost"
        $auth->addChild($updateOwnPost, $updatePost);

        // разрешаем "автору" обновлять его посты
        $auth->addChild($author, $updateOwnPost);
    }

    public function actionUpdateOwnPost()
    {

    }
}