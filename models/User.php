<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $uid
 * @property string $first_name
 * @property string $last_name
 * @property string $photo
 * @property int|null $isAdmin
 *
 * @property-read void $authKey
 * @property-read string $userName
 * @property-read string $fullName
 * @property Chat[] $chats
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'first_name', 'last_name', 'photo'], 'required'],
            [['isAdmin'], 'integer'],
            [['uid', 'first_name', 'last_name', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * Gets query for [[Chats]].
     *
     * @return ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['user_id' => 'id']);
    }

    /**
     * Login with use VK API
     *
     * @param $uid
     * @param $first_name
     * @param $last_name
     * @param $photo
     * @param $hash
     * @return bool
     */
    public function loginFromVk($uid, $first_name, $last_name, $photo, $hash)
    {
        $user = User::findOne(['uid' => $uid]);
        if ($user && $this->checkHash($hash, $uid)) {
            return Yii::$app->user->login($user);
        } else {
            $this->uid = $uid;
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->photo = $photo;
            if ($this->checkHash($hash, $uid)) {
                $this->create();
                return Yii::$app->user->login($this);
            }
            return true;
        }
    }

    /**
     * Check vk-hash
     *
     * @param $hash
     * @param $uid
     * @return bool
     */
    public function checkHash($hash, $uid)
    {
        return md5(Yii::$app->params['vk_api_id'] . $uid . Yii::$app->params['vk_key']) == $hash;
    }

    /**
     * Create new user
     *
     * @return bool
     */
    public function create()
    {
        return $this->save(false);
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|void
     */
    public function getAuthKey()
    {

    }

    /**
     * @param string $authKey
     * @return bool|void
     */
    public function validateAuthKey($authKey)
    {

    }

    /**
     * Get user name
     * @return string
     */
    public function getUserName()
    {
        return $this->first_name;
    }

    /**
     * Get user photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Get full user name
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Check user role
     *
     * @return int|null
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Change user role
     *
     * @return bool
     */
    public function changeRole()
    {
        if (Yii::$app->user->identity->isAdmin) {
            $this->isAdmin = !$this->isAdmin;
            return $this->save(false);
        }
    }
}
