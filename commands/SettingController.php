<?php


namespace app\commands;

use yii\console\Controller;

use app\models\Setting;

use Yii;
use yii\db\Connection;


/**
 *
 */
class SettingController extends Controller
{
    /**
     * 
     */
    public function actionInit()
    {
        Yii::$app->db->createCommand()->batchInsert('setting', ['setting_key', 'value'], [
            ['app-name', 'Моя компания'],
            ['count-material', '']
        ])->execute();
    }
}
