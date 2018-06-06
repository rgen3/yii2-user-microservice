<?php
declare(strict_types = 1);

namespace app\http\controllers;

use Lcobucci\JWT\Token;

class BaseController extends \rgen3\controller\json\BaseController
{
    /**
     * @var null|Token
     */
    protected $clientToken = null;
    protected $rawClientToken = null;

    public function init()
    {
        $token = \Yii::$app->request->getHeaders()->get('jwt');
        if ($token) {
            $this->clientToken = jwt()->parseToken($token);
            $this->rawClientToken = $token;
        }
    }

    /**
     * @param string $claim
     * @return bool
     */
    protected function hasAccess(string $claim): bool
    {
        if (is_null($this->clientToken)) {
            return false;
        }

        if (!jwt()->isVerified($this->clientToken)) {
            return false;
        }

        return in_array($claim, $this->clientToken->getClaim('scope'));
    }
}
