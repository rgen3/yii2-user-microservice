<?php
declare(strict_types = 1);

namespace app\http\controllers;

use app\http\requests\info\JsonSchemaRequest;
use app\models\InfoModel;
use app\repositories\driver\User;
use rgen3\controller\json\BaseController;
use app\http\requests\info\InfoRequest;
use yii\web\Response;

class InfoController extends BaseController
{
    /**
     * @return array
     */
    public function actionError()
    {
        \Yii::$app->response->statusCode = 404;
        \Yii::$app->response->statusText = Response::$httpStatuses[404];
        return $this->error(['message' => 'Page not found']);
    }

    /**
     * @param InfoRequest $request
     * @return array
     * @throws \yii\db\Exception
     */
    public function actionInfo(InfoRequest $request)
    {
        return $this->success([
            'php version' => phpversion(),
            'php extensions' => array_combine(
                get_loaded_extensions(),
                array_map(function($extension) {
                    return phpversion($extension);
                }, get_loaded_extensions())
            ),
            'redis' => redis()->info('server'),
            'database' => [
                'version' => \Yii::$app->db->createCommand('select version()')->queryAll(),
            ],
        ]);
    }

    public function actionRenderModel()
    {
        return $this->success((new InfoModel())->attributes);
    }

    /**
     * @param JsonSchemaRequest $request
     * @return array
     */
    public function actionJsonSchema(JsonSchemaRequest $request)
    {
        return $this->success($request->attributes);
    }

    /**
     * @throws \Exception
     */
    public function actionException()
    {
        throw new \Exception('Unhandled exception');
    }

    /**
     * @throws \Rgen3\Exception\InvalidFieldType
     */
    public function actionTest()
    {
        $driver = new User();
        var_dump($driver->getById(3));
        die();
        $token = jwt()->getBuilder()->setIssuer('sldjfsl')->getToken();
        var_dump(jwt()->loadToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.eyJpc3MiOiJzbGRqZnNsIn0.'));
        die();
    }
}
