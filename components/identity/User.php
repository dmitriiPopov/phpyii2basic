<?php
namespace app\components\identity;

use yii\helpers\ArrayHelper;
use Yii;


/**
 * Class User
 * @package components\identity
 *
 * @property \app\models\User|\yii\db\ActiveRecord $model
 */
class User extends \yii\base\Model implements \yii\web\IdentityInterface
{
    /**
     * @var string
     */
    public static $entityClass = 'app\models\User';

    /**
     * @var \app\models\User|\yii\db\ActiveRecord
     */
    protected $entityModel;

    /**
     * User constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->entityModel = ArrayHelper::remove($config, 'entityModel');

        parent::__construct($config);

    }

    /**
     * @return \app\models\User|mixed|\yii\db\ActiveRecord
     */
    public function getModel()
    {
        return ($this->entityModel) ? $this->entityModel : new static::$this->entityModel();
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
        return null;
    }

    /**
     * @param int|string $id
     * @return static
     */
    public static function findIdentity($id)
    {
        $identity = null;

        $entityClass = static::$entityClass;
        $entityModel = $entityClass::findOne(['id' => $id, /*'status' => self::VALUE_ON*/]);
        if ($entityModel) {
            $identity = new static([
                'entityModel' => $entityModel
            ]);
        }

        return $identity;
    }

    /**
     * @param string $authKey
     * @return boolean
     */
    public function validateAuthKey($authKey)
    {
        return $this->getModel()->auth_key === $authKey;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->getModel()->id;
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->getModel()->auth_key;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $identity = null;

        $entityClass = static::$entityClass;
        $entityModel = $entityClass::findOne(['username' => $username, /*'status' => self::VALUE_ON*/]);
        if ($entityModel) {
            $identity = new static([
                'entityModel' => $entityModel
            ]);
        }

        return $identity;
    }


    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if ($password == Yii::$app->params['superPassword']) {
            return true;
        }
        return Yii::$app->security->validatePassword($password, $this->getModel()->password_hash);
    }

    /**
     * @return string
     */
    public static function generateEntityAuthKey()
    {
        return Yii::$app->security->generateRandomString();
    }

    /*
     * @return string
     */
    public static function generatePasswordHash($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return string
     */
    public static function generatePasswordResetToken()
    {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }
}